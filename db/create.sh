#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE biblioteca_test;"
    psql -U postgres -c "CREATE USER biblioteca PASSWORD 'biblioteca' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists biblioteca
    sudo -u postgres dropdb --if-exists biblioteca_test
    sudo -u postgres dropuser --if-exists biblioteca
    sudo -u postgres psql -c "CREATE USER biblioteca PASSWORD 'biblioteca' SUPERUSER;"
    sudo -u postgres createdb -O biblioteca biblioteca
    sudo -u postgres psql -d biblioteca -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O biblioteca biblioteca_test
    sudo -u postgres psql -d biblioteca_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:biblioteca:biblioteca"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
