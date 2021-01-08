#!/bin/bash

SCRIPT_DIR="$(dirname "$(which "$0")")"

source ${SCRIPT_DIR}/setEnvVars.sh

cd ${SCRIPT_DIR}/../../
docker-compose -p $PROJECT_NAME down --rmi "all"
cd -
