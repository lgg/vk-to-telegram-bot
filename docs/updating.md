# Updating bot

## Update steps

* stop your cron job (comment it)
* backup your `Config.php`
* `git pull`
* `composer dump-autoload`
* `cp app/Config-sample.php app/Config.php`
* edit `Config.php` for your settings

**each time attentively check Config params names and structure, it may be changed**
