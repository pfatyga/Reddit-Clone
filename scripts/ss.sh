#!/bin/bash
php -S 0.0.0.0:8000 -c config/php.ini -t web/ web/routing.php
