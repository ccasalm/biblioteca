#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U mar2019 -d mar2019 < $BASE_DIR/mar2019.sql
fi
psql -h localhost -U mar2019 -d mar2019_test < $BASE_DIR/mar2019.sql
