#!/usr/bin/env bash

basepath=$(cd `dirname $0`; pwd);

cd ${basepath};

git pull
sudo chmod -R 777 var
composer install
sudo chmod -R 777 var

php ./bin/console doctrine:schema:update --force