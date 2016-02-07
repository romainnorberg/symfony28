sf28
====

A Symfony 2.8 test project

### Demo
Go to https://still-ridge-85282.herokuapp.com/

#### Hosting
hosted on Heroku free plan (sleeps after 30 mins of inactivity and must sleep 6 hours in a 24 hour period)

### Installation

``replace "still-ridge-85282" by your heroku app name

- heroku config:set --app still-ridge-85282
- heroku config:set --app still-ridge-85282 SYMFONY_ENV=prod

#### Warning
Dev environment is public (by app_dev.php), secure or ignore this file if your project is for production

#### Heroku configuration
Heroku linked with github for automatic deployment
![alt text](https://dl.dropboxusercontent.com/u/128971213/still-ridge-85282_Heroku_dashboard.png "Deploys happen automatically")

#### Notes

If composer detect wrong version of Php, you can run ```composer update --ignore-platform-reqs``` to ignore environment
(If you're sure that your webserver will use proper version / https://elgg.org/discussion/view/2370609/installation-via-gitcomposer-fails-wrong-php-version#elgg-object-2370968)

### doc

* http://symfony.com/doc/current/cookbook/deployment/heroku.html
* https://www.vagrantup.com/docs/synced-folders/nfs.html
