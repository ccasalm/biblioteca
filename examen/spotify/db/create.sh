#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE mar2019_test;"
    psql -U postgres -c "CREATE USER mar2019 PASSWORD 'mar2019' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists mar2019
    sudo -u postgres dropdb --if-exists mar2019_test
    sudo -u postgres dropuser --if-exists mar2019
    sudo -u postgres psql -c "CREATE USER mar2019 PASSWORD 'mar2019' SUPERUSER;"
    sudo -u postgres createdb -O mar2019 mar2019
    sudo -u postgres psql -d mar2019 -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O mar2019 mar2019_test
    sudo -u postgres psql -d mar2019_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:mar2019:mar2019"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
