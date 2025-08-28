#!/bin/bash

addr=$(ipconfig getifaddr en0)

if [ -z "$addr" ]; then
    addr="127.0.0.1"
fi

php artisan serve --host=$addr
