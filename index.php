<?php
require_once "vendor/autoload.php";
require_once "Config.php";
require_once "functions.php";
require_once "VkApi.php";

//Get vk response
$response = VkApi::request(VkApi::getMethodUrl("wall.get", Config::getVkParams()))["response"];

//Get last posts which we have sent to Telegram
if (!file_exists(Config::getFileLast())) {
    file_put_contents(Config::getFileLast(), "[]");
}
$last = json_decode(file_get_contents(Config::getFileLast()), true);

//Check if we have some troubles, while reading from last.json
if(empty($last)){
    addLog("For some reason ".Config::getFileLast()." is empty or we can't properly read from it");
    return false;
}

//Check if we have no posts
if(empty($response["items"])){
    addLog("Fail loading data from VK");
    return false;
}

//Check posts
$parsed_ids = [];
$key = count($response["items"]) - 1;
$posted = [
    "counter" => 0,
    "ids" => []
];
while ($key >= 0) {
    $post = $response["items"][$key];
    //If we have matches - ignore them
    if (!in_array($post["id"], $last)) {

        $message = "https://vk.com/wall" . Config::getGroupId() . "_" . $post["id"];

        if (isset($post["text"])) {
            $message = getTextPreview($post["text"]) . $message;
        }

        sendMessageAsUrl($message);

        $posted["counter"]++;
        array_push($posted["ids"], $post["id"]);
    }

    //Add posted id to ids array
    array_push($parsed_ids, $post["id"]);
    $key--;
}

//Save log
if ($parsed_ids == $last) {
    //addLog("No new posts");
} else {
    $log = "Add $posted new posts: " . implode(",", $posted["ids"]) . " | from last.json: " . implode(",", $last);
    addLog($log);

    //Save last
    saveLast($parsed_ids);
}
