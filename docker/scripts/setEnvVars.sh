#!/bin/bash

SCRIPT_DIR="$(dirname "$(which "$0")")"

cd ${SCRIPT_DIR}/../../
# Read and export .env variables ignoring lines that start with #
export $(grep -v '^#' .env | xargs)
cd -
