#!/bin/bash
# Script for run dockers and execute tests inside them

docker-compose -p 'vending-machine-test' -f docker-compose.test.yml up -d

case "$1" in
    "unit")
        docker-compose -p 'vending-machine-test' exec -T php ./vendor/bin/phpunit --testsuit unit
        ;;
    "integration")
        docker-compose -p 'vending-machine-test' exec -T php ./vendor/bin/phpunit --testsuit integration
        ;;
    "coverage")
        docker-compose -p 'vending-machine-test' exec -T php ./vendor/bin/phpunit --coverage-text
        ;;
    "code:style")
        docker-compose -p 'vending-machine-test' exec -T php ./vendor/bin/phpcs --standard=PSR12 --colors ./src
        ;;
    "fix:code:style")
        docker-compose -p 'vending-machine-test' exec -T php ./vendor/bin/phpcbf --standard=PSR12 --colors ./src
        ;;
    *)
        docker-compose -p 'vending-machine-test' exec -T php ./vendor/bin/phpunit
        ;;
    esac

docker-compose -p 'vending-machine-test' stop