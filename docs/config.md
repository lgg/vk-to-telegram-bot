# Config.php

## Content

* [Variations of posting](#variations-of-posting)
* [Parameters types](#parameters-types)
* [Basic info](#basic-info)
* [VK parameters](#vk)
* [Telegram parameters](#telegram)
* [Bot modes](#bot-modes)
* [Post cutting parameters](#post-cutting)
* [Parsing internal VK links](#parsing-internal-vk-links)
* [i18n](#i18n)
* [Logging](#logging)

## Variations of posting

@TODO: describe every point
* one VK - one Telegram
* one VK - few Telegram channels
* few VK - one Telegram
* few VK - few Telegram channels

For examples of configuration [check this](./examples/vop/)

## Parameters types

## Basic info

* $configs - array of settings arrays
* Files:
    * $file_log - file to save logs
    * $file_last - file to save last posts

## VK

## Telegram

## Bot modes

//add block scheme
//add table???

* Extended
    * Send full post text, all photos and other attachments
* Simple, depends on settings and content(is there text in the post):
    * Send text preview 
    * Send only link to vk post

## Post Cutting

## Parsing internal VK links

## i18n

*soon*

## Logging

---

### Config.php

private static $configs = [
        [
            //VK
            "vk" => "",
            "vk_token" => "",
            //Telegram
            "t_key" => "",
            "t_name" => "",
            "t_chat" => "",
            //Bot-manager settings
            //Bot-manager reposting params(modes)
            "extended" => [
                "active" => true,
                "needLink" => true,
            ],
            "needPostPreview" => true,
            //Bot-manager internal functions params
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

* $configs - array of arrays
    * VK:
        * vk - id of vk user or group to parse(!IMPORTANT! for users you should set only numbers, for groups -numbers(e.g. "1" is id1, "-1" is club1))
        * vk_token - VK service token([read more here](https://vk.com/dev/service_token))
    * Telegram:
        * $t_key - bot api key
        * $t_name - bot name
        * $t_chat - chat id/url (e.g. myawesomechannel) (without @)
    * Bot manager:
        * isExtended - use Extended or Simple version of bot
        * needLink - need to append link in extended mode
        * needPostPreview - need to send text preview in simple mode
