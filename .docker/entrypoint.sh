#!/bin/bash
if [ ! -f "composer-install" ]; then
   composer config --global github-protocols https
   composer config --global preferred-install dist
   if [ ! -f "fxp-composer" ]; then
      composer global require "fxp/composer-asset-plugin:^1.3.1"
      echo "fxp-compose" > fxp-compose
   fi
   composer install -vvv
   echo "composer-install" > composer-install
fi
php yii migrate --interactive=0
php createDbTest.php
cd tests/bin
php yii migrate --interactive=0
php yii migrate --migrationPath=@app/migrations/seed_test/ --interactive=0
source /etc/apache2/envvars
exec apache2 -D FOREGROUND