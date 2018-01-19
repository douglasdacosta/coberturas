#!/bin/bash
sudo chown www-data:douglas -R /var/www/html/local-coberturas.com/
sudo chmod 775 -R /var/www/html/local-coberturas.com/
echo -e "\e[93m Limpando o var/cache/* ............ \e[0m";
rm -Rf /var/www/html/local-coberturas.com/var/*

echo -e "\e[93m Limpando o var/session/* ............ \e[0m";
rm -Rf /var/www/html/local-coberturas.com/var/session/*


echo -e "\e[93m Limpando web/asset/pfcorecancun ....... \e[0m";
rm -Rf /var/www/html/local-coberturas.com/web/asset/*
rm -Rf /var/www/html/local-coberturas.com/web/bundles/*

echo -e "\e[93m Executando cache:clear ............ \e[0m";
php bin/console cache:clear --no-warmup

echo -e "\e[93m Assets:install ............ \e[0m";
php bin/console assets:install

#echo -e "\e[93m Assetic:dump ............ \e[0m";

#php bin/console assetic:dump

echo -e "\e[93m Owner/Group ............ \e[0m";
sudo chown www-data:douglas -R /var/www/html/local-coberturas.com/var/

echo -e "\e[93m Permissions ............ \e[0m";
sudo chmod 775 -R /var/www/html/local-coberturas.com/var/

echo -e "\e[93m Owner/Group web/asset/pfcorecancun............ \e[0m";
sudo chown www-data:douglas -R /var/www/html/local-coberturas.com/web/asset/
sudo chown www-data:douglas -R /var/www/html/local-coberturas.com/web/bundles/

echo -e "\e[93m Permissions web/asset/pfcorecancun............ \e[0m";
sudo chmod 775 -R /var/www/html/local-coberturas.com/web/asset/
sudo chmod 775 -R /var/www/html/local-coberturas.com/web/bundles/
sudo chown www-data:douglas -R /var/www/html/local-coberturas.com/*
sudo chmod 775 -R /var/www/html/local-coberturas.com/*
NOW=$(date + "%T")
echo -e "\e[93m Finished at:".$NOW." \e[0m";


