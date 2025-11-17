#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS ${MAUTIC_DB_DATABASE:-mautic};
    GRANT ALL PRIVILEGES ON \`${MAUTIC_DB_DATABASE:-mautic}\`.* TO '$MYSQL_USER'@'%';
EOSQL

