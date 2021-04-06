# kcal – the personal food nutrition journal
[![CI Status](https://github.com/kcal-app/kcal/actions/workflows/ci.yml/badge.svg)](https://github.com/kcal-app/kcal/actions/workflows/ci.yml)
[![Coverage Status](https://coveralls.io/repos/github/kcal-app/kcal/badge.svg)](https://coveralls.io/github/kcal-app/kcal)

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
