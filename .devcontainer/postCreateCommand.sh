#!/bin/bash

set -euo pipefail

if [ ! -f .env ]; then
	cp .env.example .env
fi

composer install --no-interaction
npm ci

if ! php -r 'require "vendor/autoload.php"; $app = require "bootstrap/app.php"; $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); exit(empty(config("app.key")) ? 1 : 0);'; then
	php artisan key:generate --force --no-interaction
fi

php artisan migrate --force --no-interaction
php artisan elastic:migrate --no-interaction

if php -r 'require "vendor/autoload.php"; $app = require "bootstrap/app.php"; $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); exit(App\Models\User::exists() ? 1 : 0);'; then
	php artisan db:seed --force --no-interaction
fi

npm run dev
