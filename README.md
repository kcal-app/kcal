# kcal – the personal food nutrition journal
[![CI Status](https://github.com/kcal-app/kcal/actions/workflows/ci.yml/badge.svg)](https://github.com/kcal-app/kcal/actions/workflows/ci.yml)
[![Coverage Status](https://coveralls.io/repos/github/kcal-app/kcal/badge.svg)](https://coveralls.io/github/kcal-app/kcal)

## Deployment

### Heroku

[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)

The default username and password for a Heroku deployment is `kcal`/`kcal`.

#### Using Heroku CLI

For a manual deploy using Heroku CLI, execute the following after initial deployment:

    heroku run php artisan migrate
    heroku run php artisan user:add
    heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)

#### Search drivers

See the [Search](#search-mag) section for information about supported drivers. Additional
environment variable configuration is necessary when using any search driver other
than the default ("null").

#### Redis Add-on

The [Heroku Redis](https://elements.heroku.com/addons/heroku-redis) add-on can be
added to the app and will work without any configuration changes. It is left out
of the default build only because it takes a very long time to provision.

## Search :mag:

The "ingredient" (food or recipe) search for journal entries and recipe ingredients
supports three different backends using the `SCOUT_DRIVER` environment variable.
In all cases, always ensure that the `SCOUT_DRIVER` environment variable is only
set once in kcal's `.env` file.

Currently, the food and recipe *list* searches do not take advantage of these
search drivers. Support for those searches will be added if the Laravel JSON:API
adds support for Scout (see: laravel-json-api/laravel#32).

### Algolia (`algolia`)

1. [Create and/or log in](https://www.algolia.com/users/sign_in) to an Algolia account.

1. Create an application for kcal.

1. Navigate to the application's "API Keys" section.

1. Using the **Application ID** and **Admin API Key** values, update kcal's `.env` file:

        SCOUT_DRIVER=algolia
        ALGOLIA_APP_ID=<APPLICATION_ID>
        ALGOLIA_SECRET=<ADMIN_API_KEY>

### ElasticSearch (`elastic`)

1. Determine the host and port for your ElasticSearch service.

1. Update kcal's `.env` file.

        SCOUT_DRIVER=elastic
        ELASTIC_HOST=<HOST:PORT>
        ELASTIC_PORT=<PORT>

   Note: The `ELASTIC_PORT` variable is a convenience option specifically for
   Docker Compose configurations and is not strictly required.
   
1. Run Elastic's migrations.

        php artisan elastic:migrate

### Fallback (`null`)

The fallback driver is a simple `WHERE ... LIKE` clause search on a couple of key
fields. Results will not be ordered by relevance, and some fields will not be
searched (e.g. the tags fields). Using one of the other options is highly recommended.

Set `SCOUT_DRIVER=null` in kcal's `.env` file to use the fallback driver.

## Development

### Laravel Sail

#### Prerequisites

- [Composer](https://getcomposer.org/download/)
- [Docker](https://docs.docker.com/get-docker/)
- [Docker compose](https://docs.docker.com/compose/install/)

1. Clone the repository.

        git clone https://github.com/kcal-app/kcal.git

1. Move in to the cloned folder.

        cd kcal

1. Install development dependencies.

        composer install

1. Create a local `.env` file.

        cp .env.local.example .env

   Note: the default `APP_URL` setting is `http://127.0.0.1`. If you have
   [dnsmasq](https://thekelleys.org.uk/dnsmasq/doc.html) or something similar
   configured for the `test` domain you can change this to `http://kcal.test`.

1. Generate an app key.

        touch .env
        php artisan key:generate

1. Run it! :sailboat:

        vendor/bin/sail up -d

1. (On first run) Run migrations.

        vendor/bin/sail artisan migrate
        vendor/bin/sail artisan elastic:migrate

1. (On first run) Create the initial user.

        vendor/bin/sail artisan db:seed --class UserSeeder

    The default username and password is `admin@kcal.test`.

Once the application finishes starting, navigate to [http://127.0.0.1:8080](http://127.0.0.1:8080)
(or [http://kcal.test:8080](http://kcal.test:8080) if configured).
