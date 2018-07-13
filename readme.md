# astolfo.rocks

[![Build Status](https://travis-ci.org/Kaishiyoku/astolfo.rocks.svg?branch=master)](https://travis-ci.org/Kaishiyoku/astolfo.rocks)

Source code of the astolo.rocks website https://astolfo.rocks

Table of contents
=================
* [About](#about)
* [Features](#features)
* [Installation](#installation)
* [License](#license)
* [Author](#author)

About
=====
**The source code of the site https://astolfo.rocks**

Features
========
* image crawling from http://unlimitedastolfo.works
* random image on landing page

Installation
============
1. Download the latest release: https://github.com/Kaishiyoku/astolfo.rocks/releases/latest
2. run `composer install --no-dev`
3. run `php artisan migrate`
4. run `npm install`
5. run `npm run prod`
6. copy the .env.example file and fill in the necessary values:
```@php -r \"file_exists('.env') || copy('.env.example', '.env');\"```
7. Setup the cronjob for the image scrawler:
```
$ sudo crontab -e -u www-data
```
Add the cronjob (please adjust the path if necessary):
```
* * * * * php /var/www/html/astolfo.rocks/artisan schedule:run 2>&1
```

License
=======
MIT (https://github.com/Kaishiyoku/astolfo.rocks/blob/master/LICENSE)


Author
======
Twitter: [@kaishiyoku](https://twitter.com/kaishiyoku)  
Website: www.andreas-wiedel.de  
MAL: [kaishiyoku](https://myanimelist.net/profile/Kaishiyoku)
