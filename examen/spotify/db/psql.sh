#!/bin/sh

[ "$1" = "test" ] && BD="_test"
psql -h localhost -U mar2019 -d mar2019$BD
