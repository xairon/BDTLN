BDTLN
======

BDTLN is a website, witch will allow to a researcher workers team to manage it members, projects and researches

1) Installing
--------------

- Clone this repository onto your web server
- Delete the folder "vendor"
- Install a webserver, Wampserver if you're using Windows for example
- Copy parameters.yml.dist in the same folder, and rename the copy as parameters.yml
- Set your paramaters in app/config/parameters.yml, the username and password for database, and the database's name (BDTLN is better)

Execute following commands :
+ php ./composer.phar update
+ php app/console doctrine:database:create
+ php app/console doctrine:schema:update --force
+ php app/console doctrine:fixtures:load

Note : If you're using Windows, add "php" to the PATH

Two users are already created, a simple user and a super admin.
For super admin the login is "admin" and password too, for user the login is "user" ans password too.

2) Checking your System Configuration for Symfony2
---------------------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

The script returns a status code of `0` if all mandatory requirements are met,
`1` otherwise.

Access the `config.php` script from a browser:

    http://localhost/path-to-project/web/config.php

If you get any warnings or recommendations, fix them before moving on.
