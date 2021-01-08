#!/bin/bash

SCRIPT_DIR="$(dirname "$(which "$0")")"

cd ${SCRIPT_DIR}/../
case $1 in
    docker:run)
        ./docker/scripts/run.sh
        ;;
    docker:build)
        ./docker/scripts/build.sh
        ;;
    docker:destroy)
        ./docker/scripts/destroy.sh
        ;;
    docker:stop)
        ./docker/scripts/stop.sh
        ;;
    *)
        echo "ERROR: Command not found"
        exit 1
        ;;
esac

cd -
