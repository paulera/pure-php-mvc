#!/bin/bash

# jump to the script folder
cd $(dirname $0)

if [ ! -d "public" ]; then
    echo "public folder not found"
    exit 1
fi

cd public/..

HOST="127.0.0.1"
PORT="9091"

if [[ "$OSTYPE" =~ "darwin" ]]; then
    # OSX
    sleep 2 && open "http://$HOST:$PORT" &>/dev/null &
fi

php -S $HOST:$PORT -t .
