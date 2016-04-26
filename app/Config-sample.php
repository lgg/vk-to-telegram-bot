<?php

class Config
{
    //Bot manager settings
    private static $isExtended = true;
    private static $needLink = true;
    private static $needPostPreview = true;

    //VK
    private static $vk_group_id = "";

    //Telegram
    private static $telegram_key = "";
    private static $telegram_name = "";
    private static $telegram_chat = "";

    //Files
    private static $file_log = "log.txt";
    private static $file_last = "last.json";

    //Functions Bot manager settings
    public static function isExtended(){
        return self::$isExtended;
    }

    public static function needLink(){
        return self::$needLink;
    }

    public static function needPostPreview(){
        return self::$needPostPreview;
    }

    //Functions VK
    public static function getGroupId()
    {
        return "-" . self::$vk_group_id;
    }

    public static function getVkParams()
    {
        return [
            "owner_id" => self::getGroupId(),
            "count" => 5
        ];
    }

    //Functions Telegram
    public static function getTelegramKey()
    {
        return self::$telegram_key;
    }

    public static function getTelegramName()
    {
        return self::$telegram_name;
    }

    public static function getTelegramChat()
    {
        return "@" . self::$telegram_chat;
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