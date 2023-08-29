#!/usr/bin/env bash
/usr/bin/php bin/console messenger:consume async -vv
/usr/bin/php /var/www/html/bin/console cache:warmup -vvv
