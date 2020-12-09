#!/usr/bin/env bash

basepath=$(cd `dirname $0`; pwd);

cd ${basepath};

git pull
sudo chmod -R 0777 var/cache
composer install
sudo chmod -R 0777 var/cache
