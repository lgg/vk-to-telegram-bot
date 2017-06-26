# Installation

## You will need

* Server with installed SSL certificate
* VK service token
* Telegram bot and it's api key
* Telegram Channel(of course you will need to add bot to administrators of your channel)

## About security

* It's highly recommended to hide your bot from web. 
(e.g you site.com directory is /var/www/site.com, so don't place bot in that directory 
place it in /var/www/console/)

## Installation [production]

* **!IMPORTANT!** you need SSL certificate on your server
* `git clone https://github.com/lgg/vk-to-telegram-bot && cd vk-to-telegram-bot`
* `composer install --no-dev --optimize-autoloader`
* `composer dump-autoload`
* rename Config-sample.php to Config.php
* then configure Config.php
* **!IMPORTANT!** watch repository for 'config' updates
* add task to cron(usually you have crontab on your server)
    * if you have crontab - run `crontab -e` from web user(usually webadmin or www-data)
    * add `*/5 * * * * cd /var/www/console/vk-to-telegram-bot && php index.php >> /dev/null 2>&1`
    * you should change cd command to path where your bot is located
    * this will run bot every 5 minutes, if you need every minute check - replace `*/5` to `*`
* if you want to clear your logs add task for clear.php with `php clear.php?clear`
