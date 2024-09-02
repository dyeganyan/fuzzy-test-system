#!/bin/bash

composer install
./bin/console doctrine:database:create --no-interaction --if-not-exists
./bin/console doctrine:migrations:migrate --no-interaction
./bin/console doctrine:fixtures:load --no-interaction --purge-with-truncate

exec "$@"
