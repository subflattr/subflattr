Subflattr
=========

small prototype project for flattr.com

Dependencies
------------

php5, php-mysql, gearman-server

the gearman pecl extension

a mysql server (change settings in web/index.php)

How to run
----------

[Download/Install composer](http://getcomposer.org)

run the database.sql on your mysql server

Run `composer install` to install dependencies

Go into `web` directory and run `php -S localhost:8080` and point your browser there (or install php server of your taste)

start gearman server with `gearman --verbose=INFO` or run as daemon.

start gearman worker with `php worker.php`

TODO
----
* "My subscriptions" menu
* "My subscriptions" in dashboard
* unsubscribe
* Wallpaper saving in profile
* RSS feed
* "Discover creators" page


Licence
-------

Not sure yet
