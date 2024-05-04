#!/bin/bash

echo alias sail=\'sh $([ -f sail ] && echo sail || echo vendor/bin/sail)\' >> ~/.bash_aliases
chown -R 1000:1000 /var/www/html
composer install
cp .env.example .env
php artisan key:generate --force -n