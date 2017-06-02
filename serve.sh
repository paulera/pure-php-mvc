#!/bin/bash

# jump to the script folder
cd $(dirname $0)

if [ ! -d "public" ]; then
    echo "public folder not found"
    exit 1
fi

cd public

php -S 127.0.0.1:9091 -t .
