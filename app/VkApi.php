<?php

class VkApi
{
    private static $api_ver = "5.65";

    /**
     * @param $method
     * @param $params
     * @return string
     * Return url of method to request
     */
    public static function getMethodUrl($method, $params)
    {
        return "https://api.vk.com/method/$method?v=" . self::$api_ver . "&" . http_build_query($params);
    }

    /**
     * @param $url
     * @return mixed
     * Return array of vk response
     */
    public static function request($url)
    {
        return json_decode(file_get_contents($url), true);
    }

    /**
     * @param $photo
     * @return bool|string
     * Returns url of max sized available photo
     */
    public static function findMaxSizeLink($photo)
    {
        $prefix = "photo_";
        $sizes = [2560, 1280, 807, 604, 130, 75];

        foreach ($sizes as $size) {
            if (isset($photo[$prefix . $size])) {
                return urldecode($photo[$prefix . $size]);
            }
        }

        return false;
    }
}