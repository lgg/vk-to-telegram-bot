<?php

class Config
{
    //VK
    private static $vk_group_id = "";

    //Telegram
    private static $telegram_key = "";
    private static $telegram_name = "";
    private static $telegram_chat = "";

    //Files
    private static $file_log = "log.txt";
    private static $file_last = "last.json";

    //Functions
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

    public static function getFileLog()
    {
        return self::$file_log;
    }

    public static function getFileLast()
    {
        return self::$file_last;
    }

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
}