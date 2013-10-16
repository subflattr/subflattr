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

What works
----------
* Signup
* Creation and updating of profile
* subscription
* Flattring
* Submitting (partially)

Next?
-----
* unsubscribe
* listing of submissions
* submission thumbnail saving/checking
* date saving in Thing-Entity
* Wallpaper saving in profile
* RSS feed
* "Discover creators" page


Licence
-------

Not sure yet
