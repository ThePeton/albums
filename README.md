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
$ git clone https://github.com/ThePeton/albums.git
$ cd albums
$ composer install
$ php app/console doctrine:migrations:migrate
$ php app/console doctrine:fixtures:load
$ php app/console assets:install --symlink
```
