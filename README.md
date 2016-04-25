# VK to Telegram auto-posting Bot 

## Info

* Bot posting only links could be found in master branch
* Bot posting full posts(text and images) could be found in extended branch

## Requirements:

* composer require longman/telegram-bot - [sources](https://github.com/akalongman/php-telegram-bot)

## Installation [production]

* `composer install --no-dev --optimize-autoloader`
* `composer dump-autoload`
* rename Config-sample.php to Config.php
* then configure Config.php
* !IMPORTANT! watch repository for 'config' updates

## Configuration:

* VK:
    * $vk_group_id - id of vk group to parse (only numbers)
* Telegram:
    * $telegram_key - bot api key
    * $telegram_name - bot name
    * $telegram_chat - chat id (e.g. myawesomechannel) (without @)
* Files:
    * $file_log - file to save logs
    * $file_last - file to save last posts
    
## Links and Copyrights:

* LICENSE: MIT
* Author: [littleguga](https://github.com/littleguga)
* Thanks to [akalongman](https://github.com/akalongman) for [php-telegram-bot](https://github.com/akalongman/php-telegram-bot)