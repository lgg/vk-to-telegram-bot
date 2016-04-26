# VK to Telegram auto-posting Bot 

## Info

* [Vote for next feature to release here](https://github.com/littleguga/vk-to-telegram-bot/issues/1)
* Bot manager with posting to few channels from few groups/users can be found in master branch
* Bot posting only links can be found in link branch
* Bot posting full posts(text and images) can be found in extended branch
* Also you can find answers and help [here](./faq.md)

## Requirements:

* composer require longman/telegram-bot - [sources](https://github.com/akalongman/php-telegram-bot)

## Installation [production]

* !IMPORTANT! you need SSL certificate on your server
* `composer install --no-dev --optimize-autoloader`
* `composer dump-autoload`
* rename Config-sample.php to Config.php
* then configure Config.php
* !IMPORTANT! watch repository for 'config' updates
* add task to cron(usually you have crontab on your server)
    * if you have crontab - run ```crontab -e``` from web user(usually webadmin or www-data)
    * add ```*/5 * * * * cd /var/www/console/telegrambot && php index.php >> /dev/null 2>&1```
    * you should change cd command to path where your bot is located
    * this will run bot every 5 minutes, if you need every minute check - replace ```*/5``` to ```*```
* if you want to clear your logs add task for clear.php with ```php clear.php?clear

## Configuration:

* $configs - array of arrays
    * VK:
        * vk - id of vk user or group to parse(!IMPORTANT! for users you should set only numbers, for groups -numbers(e.g. "1" is id1, "-1" is club1))
    * Telegram:
        * $t_key - bot api key
        * $t_name - bot name
        * $t_chat - chat id/url (e.g. myawesomechannel) (without @)
    * Bot manager:
        * isExtended - use Extended or Simple version of bot
        * needLink - need to append link in extended mode
        * needPostPreview - need to send text preview in simple mode
* Files:
    * $file_log - file to save logs
    * $file_last - file to save last posts
    
## Links and Copyrights:

* LICENSE: MIT
* Author: [littleguga](https://github.com/littleguga)
* Thanks to [akalongman](https://github.com/akalongman) for [php-telegram-bot](https://github.com/akalongman/php-telegram-bot)