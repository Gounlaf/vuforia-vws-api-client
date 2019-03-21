#!/usr/bin/env sh

set -e

wait && composer run test-ci

exit $?
