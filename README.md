#BDTLN

BDTLN is a website, witch will allow to a researcher workers team to manage it members, projects and researches

##1. Installing
###1.1 Installing of Webserver

You have to get a web server, the following block help you to install it. If you already have a web server, you can skip this.

####On Linux/Unix

You have to get a webserver. If you're using Linux, execute the following command :
 * sudo apt-get install apache2 php5 mysql-server libapache2-mod-php5 php5-mysql

It will install apache, php5, mysql, and the integration modules.

####On Windows
The easier way is installing [Wampserver](http://wampserver.com)


###1.2 Installing of Git

###On Linux

According to your distribution, follow the commands on [git-scm](https://git-scm.herokuapp.com/download/linux)

###On Windows

This project is managed on Github, so you can install [Github for Windows](https://windows.github.com/)

###1.3 Download BDTLN

 * On page [BDTLN repository] click on "Download as ZIP"
 * Download it into your webserver, in the www/ folder
   (On Windows it will probably be C:\wamp\www\ and on Linux in /var/www/ or /var/www/html/)
 * Rename "BDTLN-master" to "BDTLN"
 * Delete folder BDTLN/vendor if it exists
 * In BDTLN/app/config copy parameters.yml.dist and name the copy parameters.yml
 * Open BDTLN/app/config/parameters.yml with an editor, set your login and password for MySQL, and set the database name (BDTLN is better than symfony)

Note for Windows :
-----------------
You have to **add Git and PHP into the PATH**. On Linux PHP and Git are already in.
The path you should add for php looks like to C:\wamp\bin\php<version>\

#####How to add a command to the path ?
Click right->properties on "Computer". Then, click on "advanced settings", on the top/left of the window. Then click on "environment variables", and in the list double click on "path". You can see some path, **don't delete them**. Just add at the end, the two paths you need, for PHP and Git.
Click on OK or validate, done.

###Installing BDTLN

Once those commands are in the path, you can execute the following commande.
Just before, open CMD, and move into the BDTLN folder.

Execute following commands :
+ php ./composer.phar update
+ php app/console doctrine:database:create
+ php app/console doctrine:schema:update --force
+ php app/console doctrine:fixtures:load


Two users are already created, a simple user and a super admin.
For super admin the login is "admin" and password too, for user the login is "user" ans password too.

If BDTLN folder is in www/ folder, you can open website at the following url :
http://localhost/BDTLN/web/app_dev.php/fr/


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
