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

    /**
     * @param $text
     * @param $link
     * @return string
     * Append "Comment in vk:" to text
     */
    public static function appendLink($text, $link)
    {
        return trim($text . " Комментировать в ВК:") . " " . $link;
    }

    /**
     * @param $text
     * @param $link
     * @return string
     * Cuts text to 140 symbols or more till the space and add "Read more:" text
     */
    public static function getTextPreview($text, $link)
    {
        $i = 139;
        if (!isset($text[$i])) {
            return trim($text . " Комментировать в ВК:") . " " . $link;
        }
        $max = strlen($text) - 1;
        while ($text[$i] != " " and $i <= $max) {
            $i++;
        }
        $text = substr($text, 0, $i);
        return $text . "... Подробнее: " . $link;
    }
}