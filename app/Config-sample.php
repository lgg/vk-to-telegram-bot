<?php

class Config
{
    private static $configs = [
        [
            //VK
            "vk" => "",
            "vk_token" => "",
            //Telegram
            "t_key" => "",
            "t_name" => "",
            "t_chat" => "",
            //Bot manager settings
            "isExtended" => true,
            "needLink" => true,
            "needPostPreview" => true,
        ],
    ];

    //Files
    private static $file_log = "log.txt";
    private static $file_last = "last.json";

    public static function getConfigs(){
        return self::$configs;
    }

    public static function getVkParams($vk_id, $vk_token)
    {
        return [
            "access_token" => $vk_token,
            "owner_id" => $vk_id,
            "count" => 5
        ];
    }

    //Functions files
    public static function getFileLog()
    {
        return self::$file_log;
    }

    public static function getFileLast()
    {
        return self::$file_last;
    }
}