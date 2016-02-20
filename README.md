sf28
====

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9e7b7243-a885-469d-b915-a59140a757dc/big.png)](https://insight.sensiolabs.com/projects/9e7b7243-a885-469d-b915-a59140a757dc)

A Symfony 2.8 test project

### Demo
Go to https://still-ridge-85282.herokuapp.com/

#### Hosting
hosted on Heroku free plan (sleeps after 30 mins of inactivity and must sleep 6 hours in a 24 hour period)

config variables:

* http://bezhermoso.github.io/2014/08/19/handling-parameters-for-heroku-deploy-in-symfony2/
* https://coderwall.com/p/qpitzq/deploing-symfony-project-using-mysql-to-heroku

sf2.session_name = sf28heroku

### Installation

``replace "still-ridge-85282" by your heroku app name

- heroku config:set --app still-ridge-85282
- heroku config:set --app still-ridge-85282 SYMFONY_ENV=prod

#### Warning
Dev environment is public (by app_dev.php), secure or ignore this file if your project is for production
In composer.json, move "sensio/generator-bundle": "~3.0" to "require-dev" section, only for development

#### Heroku configuration
Heroku linked with github for automatic deployment
![alt text](https://dl.dropboxusercontent.com/u/128971213/still-ridge-85282_Heroku_dashboard.png "Deploys happen automatically")

#### Notes

If composer detect wrong version of Php, you can run ```composer update --ignore-platform-reqs``` to ignore environment
(If you're sure that your webserver will use proper version / https://elgg.org/discussion/view/2370609/installation-via-gitcomposer-fails-wrong-php-version#elgg-object-2370968)

### doc

* http://symfony.com/doc/current/cookbook/deployment/heroku.html
* https://www.vagrantup.com/docs/synced-folders/nfs.html

### help

* http://blog.insight.sensiolabs.com/2014/12/22/making-symfony-bootable-with-dbal-2-5.html
