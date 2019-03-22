#!/usr/bin/env sh

set -e

/usr/local/bin/docker-compose-wait && composer run test-ci

exit $?
