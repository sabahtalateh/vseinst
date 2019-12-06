#!/usr/bin/env bash

vendor/bin/doctrine orm:schema-tool:drop --force \
    && vendor/bin/doctrine orm:schema-tool:create \
    && vendor/bin/phpunit tests --colors --bootstrap src/config/bootstrap.php
