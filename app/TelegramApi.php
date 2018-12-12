<?php

use Longman\TelegramBot\Request;

class TelegramApi
{
    private $telegram;
    private $chat;

    public function __construct($key, $botName, $chat)
    {
        try {
            // Create Telegram API object
            $this->telegram = new Longman\TelegramBot\Telegram($key, $botName);
            $this->chat = "@" . $chat;
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            // log telegram errors
            echo $e->getMessage();
        }
    }

    /**
     * @param string $message
     * @param array $data
     * Send message with URL to the post
     */
    public function sendMessage($message, $data)
    {
        //array of allowed parameters, see more: https://core.telegram.org/bots/api#sendmessage
        $allowed = [
            'disable_web_page_preview', // Bool, Disables link previews for links in this message
            'disable_notification', // Bool, Sends the message silently. Users will receive a notification with no sound.
            'parse_mode', // String 'HTML' or 'Markdown'
        ];

        $params = [
            'chat_id' => $this->chat,
            'text' => $message
        ];

        foreach ($allowed as $a) {
            if (isset($data[$a])) {
                $params[$a] = $data[$a];
            }
        }

        $result = Request::sendMessage($params);
    }

    /**
     * @param $link
     * Send photo to channel
     */
    public function sendPhoto($link)
    {
        //Load file
        $filename = __DIR__ . DIRECTORY_SEPARATOR . uniqid() . ".jpg";
        file_put_contents($filename, fopen($link, 'r'));

        //Send file
        $result = Request::sendPhoto(
            [
                'chat_id' => $this->chat,
                'photo' => Request::encodeFile($filename),
            ]
        );

        //Delete file
        unlink($filename);
    }
}