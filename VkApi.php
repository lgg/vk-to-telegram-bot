<?php

class VkApi
{
    private static $api_ver = "5.50";

    public static function getMethodUrl($method, $params)
    {
        return "https://api.vk.com/method/$method?v=" . self::$api_ver . "&" . http_build_query($params);
    }

    public static function request($url)
    {
        return json_decode(file_get_contents($url), true);
    }
}