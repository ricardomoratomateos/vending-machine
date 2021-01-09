#!/bin/bash
# Script for run dockers and execute tests inside them

case "$1" in
    "unit")
        docker-compose -f docker-compose.test.yml run phpunit --testsuit unit
        ;;
    "integration")
        docker-compose -f docker-compose.test.yml run phpunit --testsuit integration
        ;;
    "code:style")
        docker-compose -f docker-compose.test.yml run phpcs --standard=PSR12 --colors ./src
        ;;
    "fix:code:style")
        docker-compose -f docker-compose.test.yml run phpcbf --standard=PSR12 --colors ./src
        ;;
    *)
        docker-compose -f docker-compose.test.yml run phpunit
        ;;
    esac
