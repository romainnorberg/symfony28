sf28
====

A Symfony project created on February 3, 2016, 8:38 am.


### installation

``replace "still-ridge-85282" by your heroku app name

- heroku config:set --app still-ridge-85282
- heroku config:set --app still-ridge-85282 SYMFONY_ENV=prod

#### notes

If composer detect wrong version of Php, you can run ```composer update --ignore-platform-reqs``` to ignore environment
(If you're sure that your webserver will use proper version / https://elgg.org/discussion/view/2370609/installation-via-gitcomposer-fails-wrong-php-version#elgg-object-2370968)

### doc

- http://symfony.com/doc/current/cookbook/deployment/heroku.html
-
