<?php

use Longman\TelegramBot\Request;

class TelegramApi
{
    private $telegram;
    private $chat;

    public function __construct($key, $botName, $chat)
    {
        $this->telegram = new Longman\TelegramBot\Telegram($key, $botName);
        $this->chat = "@" . $chat;
    }

    /**
     * @param string $message
     * Send message with URL to the post
     */
    public function sendMessage($message)
    {
        $result = Request::sendMessage(
            [
                'chat_id' => $this->chat,
                'text' => $message
            ]
        );
    }

    /**
     * @param $link
     * Send photo to channel
     */
    public function sendPhoto($link)
    {
        //Load file
        $filename = __DIR__ . DIRECTORY_SEPARATOR . time() . ".jpg";
        file_put_contents($filename, fopen($link, 'r'));

        //Send file
        $result = Request::sendPhoto(
            [
                'chat_id' => $this->chat,
            ],
            $filename
        );

        //Delete file
        unlink($filename);
    }
}