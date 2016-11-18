Symfony3 Demo with DoctrineMigrations, KnpMenu, FOSUserBundle
=======================

INSTALL (on develop machine with mysql, composer and bower already installed):

1) run "git clone https://github.com/harpcio/sf3-demo.git"

2) run "composer install"

3) run "bower install"

4) configure database in /app/config/parameters.yml

5) run "php bin/console doctrine:migrations:migrate"

6) run "php bin/console fos:user:create" and create "admin"

7) run "php bin/console fos:user:promote" and add to "admin" role "ROLE_ADMIN"


INSTALL (on develop machine with docker only installed):

1) run "git clone https://github.com/harpcio/sf3-demo.git"

2) run "docker-compose up -d"

3) run "make composer install"

4) run "make bower install"

5) configure database in /app/config/parameters.yml

6) run "make console doctrine:migrations:migrate"

7) run "make console fos:user:create" and create "admin"

8) run "make console fos:user:promote" and add to "admin" role "ROLE_ADMIN"

Have fun!