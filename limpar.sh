#!/bin/bash
sudo chown www-data:douglas -R /var/www/html/local-coberturas.com/*
sudo chmod 777 -R /var/www/html/local-coberturas.com/*
rm -Rf /var/www/html/local-coberturas.com/var/*
rm -Rf /var/www/html/local-coberturas.com/var/*

php bin/console cache:clear --no-warmup

php bin/console assets:install --symlink --relative

echo 'flush_all' | nc localhost 11211 && php bin/console doctrine:cache:clear-query


sudo chown www-data:douglas -R /var/www/html/local-coberturas.com/*
sudo chmod 777 -R /var/www/html/local-coberturas.com/*

