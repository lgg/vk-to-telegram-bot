<?php
require_once "vendor/autoload.php";

//Get vk response
$response = VkApi::request(VkApi::getMethodUrl("wall.get", Config::getVkParams()))["response"];

//Get last posts which we have sent to Telegram
if (!file_exists(Config::getFileLast())) {
    file_put_contents(Config::getFileLast(), "[-1]");
}
$last = json_decode(file_get_contents(Config::getFileLast()), true);

//Check if we have some troubles, while reading from last.json
if (empty($last)) {
    Log::addLog("For some reason " . Config::getFileLast() . " is empty or we can't properly read from it");
    return false;
}

//Check if we have no posts
if (empty($response["items"])) {
    Log::addLog("Fail loading data from VK");
    return false;
}

//Check posts
$parsed_ids = [];
$key = count($response["items"]) - 1;
$posted = [
    "counter" => 0,
    "ids" => []
];
$telegram = new TelegramApi();
while ($key >= 0) {
    $post = $response["items"][$key];

    //If we have matches - ignore them
    if (!in_array($post["id"], $last)) {

        $message = "https://vk.com/wall" . Config::getGroupId() . "_" . $post["id"];

        //Check what type of posting we need
        if (Config::isExtended()) {

            //If we have post text - send it
            if (isset($post["text"])) {

                //If we need to append link
                if (Config::needLink()) {
                    $message = VkApi::appendLink($post["text"], $message);
                } else {
                    $message = VkApi::clearVkLinks($post["text"]);
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
            if (Config::needPostPreview()) {

                //If we have post text - send it
                if (isset($post["text"])) {
                    $message = VkApi::getTextPreview($post["text"], $message);
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

    //Add posted id to ids array
    array_push($parsed_ids, $post["id"]);
    $key--;
}

//Save log
if ($posted["counter"] > 0) {
    $log = "Add " . $posted["counter"] . " new posts: " . implode(",", $posted["ids"]) . " | from " . Config::getFileLast() . ": " . implode(",", $last);
    Log::addLog($log);

    //Save last
    $posts = array_merge($last, $posted["ids"]);
    Log::saveLast($posts);
} else {
    //addLog("No new posts");
}