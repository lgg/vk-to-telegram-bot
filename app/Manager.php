<?php

class Manager
{
    private $configs;
    private $last;

    /**
     * Loads configs and check files
     */
    public function __construct()
    {
        //Load configs
        $this->loadConfigs();

        //Check last files
        $this->checkFileLast();
    }

    /**
     * Loads configs from Config.php
     */
    private function loadConfigs()
    {
        $this->configs = Config::getConfigs();
    }

    /**
     * Checks last.json file, if error - close bot
     */
    private function checkFileLast()
    {
        //Check if file exists
        if (!file_exists(Config::getFileLast())) {

            //Create new file with default name
            $content = [
                $this->configs[0]["t_name"] . "_" . $this->configs[0]["vk"] => -1
            ];
            $file = json_encode($content);
            file_put_contents(Config::getFileLast(), $file);
        }

        //Load file content
        $last = json_decode(file_get_contents(Config::getFileLast()), true);

        //Check if we have some troubles, while reading from last.json
        if (empty($last)) {
            Log::addLog("For some reason " . Config::getFileLast() . " is empty or we can't properly read from it");

            //Close bot manager
            $this->close();
        }

        //If okay write last posts to object
        $this->last = $last;
    }

    /**
     * Starts bot and run every config
     */
    public function start()
    {
        //Run every config
        foreach ($this->configs as $configIndex => $config) {
            //Get VK response
            $response = $this->getVk($config["vk"], $config["vk_token"]);

            //If we have good response
            if ($response) {

                //Create Telegram API
                $telegram = new TelegramApi($config["t_key"], $config["t_name"], $config["t_chat"]);

                //Load last.json
                $key_save = $config["t_chat"] . "_" . $config["vk"];
                if (isset($this->last[$key_save])) {
                    $last = $this->last[$key_save];
                } else {
                    $last = [-1];
                }

                //Send messages
                $posted = $this->send($response, $telegram, $last, $config, $configIndex);

                //Save log
                if ($posted["counter"] > 0) {
                    $log = "Add " . $posted["counter"] . " new posts: " . implode(",", $posted["ids"]) . " | from " . Config::getFileLast() . ": " . implode(",", $last);
                    Log::addLog($log);

                    //Update last
                    $posts = array_merge($last, $posted["ids"]);
                    $this->last[$key_save] = $posts;
                }
            }
        }

        //Save updated posts
        $this->savePosts();
    }

    /**
     * @param $vk_id string - id of vk user/group
     * @param $vk_token string - vk service token
     * @return bool|mixed - return false if failed to load vk, return vk response if ok
     * Loads VK, if have errors - log them
     */
    private function getVk($vk_id, $vk_token)
    {
        //Get vk response
        $vk_response = VkApi::request(VkApi::getMethodUrl("wall.get", Config::getVkParams($vk_id, $vk_token)));
        $response = $vk_response["response"];

        //Check if we have no posts
        if (empty($response["items"])) {
            Log::addLog("Fail loading data from VK: " . $vk_id . " More info: " . json_encode($vk_response));
            return false;
        }

        return $response;
    }

    /**
     * @param $response - response from VK
     * @param $telegram - telegram API object
     * @param $last - last posted ids
     * @param $config - config for this entity
     * @param $configIndex - index of current $config
     * @return array - $posted object(counter + posted ids array)
     * Sends messages to Telegram, if have new posts
     */
    private function send($response, $telegram, $last, $config, $configIndex)
    {
        //Check posts
        $key = count($response["items"]) - 1;
        $posted = [
            "counter" => 0,
            "ids" => []
        ];
        while ($key >= 0) {
            $post = $response["items"][$key];

            //If we have matches or post[id] equals 0 or -1(vk api bad responses) => ignore them
            if (!in_array($post["id"], $last) || $post["id"] == 0 || $post["id"] == -1) {

                $message = "https://vk.com/wall" . $config["vk"] . "_" . $post["id"];

                //   TODO optimize this
                $postText = false;
                if (isset($post["text"])) {
                    $postText = VkLinksParser::parseInternalLinks($post["text"], $configIndex);
                }

                //Check what type of posting we need
                if ($config["isExtended"]) {

                    //If we have post text - send it
                    if ($postText) {

                        //If we need to append link
                        if ($config["needLink"]) {
                            $message = VkApi::appendLink($postText, $message);
                        } else {
                            $message = $postText;
                        }

                        //Send message
                        $telegram->sendMessage($message);
                    }


                    //If we have attachments - check them
                    if (isset($post["attachments"])) {

                        //Scan all attachments for photos
                        foreach ($post["attachments"] as $attach) {
                            if ($attach["type"] == "photo") {
                                $telegram->sendPhoto(VkApi::findMaxSizeLink($attach["photo"]));
                            }
                        }
                    }
                } else {

                    //Check if need to append post preview
                    if ($config["needPostPreview"]) {

                        //If we have post text - send it
                        if ($postText) {
                            $message = TextCutter::getTextPreview($postText, $message, $configIndex);
                        }
                    }

                    //Send message
                    $telegram->sendMessage($message);
                }

                //Increase posted counter
                $posted["counter"]++;

                //Save posted id
                array_push($posted["ids"], $post["id"]);
            }

            $key--;
        }

        //Return posted info
        return $posted;
    }

    /**
     * Saves last posted ids to last.json
     */
    private function savePosts()
    {
        Log::saveLast($this->last);
    }

    /**
     * Closes the script
     */
    private function close()
    {
        die();
    }
}