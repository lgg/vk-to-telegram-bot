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
            "messageSend" => [
                "disable_web_page_preview" => false,
                "disable_notification" => false
            ],
            //Bot-manager settings
            //Bot-manager reposting params(modes)
            "extended" => [
                "active" => true,
                "needLink" => true,
                "resendAttachments" => true,
            ],
            "needPostPreview" => true,
            //Bot-manager internal functions params
            "language" => "ru",
            "textCutter" => [
                "aggressive" => false,
                "limit" => 3
            ],
            "vkLinks" => [
                "show" => false,
                "symbols" => [
                    "open" => "[",
                    "close" => "]"
                ]
            ]
        ],
    ];

    //Files
    private static $file_log = "log.txt";
    private static $file_last = "last.json";

    public static function getConfigs()
    {
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