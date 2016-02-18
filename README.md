Images album
========================

Used technologies:
 - Symfony 2.8
 - Marionette 2.4.4
 - Require JS

Install
=======================

Prepare MySQL database and Apache2 host. After it run:

```bash
git clone https://github.com/ThePeton/albums.git
cd albums
composer install
php app/console doctrine:migrations:migrate
php app/console doctrine:fixtures:load
php app/console assets:install --symlink
```

Run tests
========================

To run the unit tests create a database with the same name as the main one and with postfix: `_unit_test`.
After the database is created you can run the tests using following command in shell:

```bash
bin/phpunit -c app
```