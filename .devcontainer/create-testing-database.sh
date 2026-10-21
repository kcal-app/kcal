#!/bin/bash

docker_process_sql <<EOSQL
CREATE DATABASE IF NOT EXISTS testing;
GRANT ALL PRIVILEGES ON testing.* TO '${MARIADB_USER}'@'%';
EOSQL
