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

        if (isset($post["text"])) {
            $message = VkApi::getTextPreview($post["text"]) . $message;
        }

        $telegram->sendMessageAsUrl($message);

        $posted["counter"]++;
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