BDTLN
======

BDTLN is a website, witch will allow to a researcher workers team to manage it members, projects and researches

1) Installing
--------------

Clone this repository onto your web server
Execute following commands :
+ php app/console doctrine:database:create
+ php app/console doctrine:schema:update --force

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
