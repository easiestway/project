#!/bin/sh
if [ $1 ]; then
php app/console doctrine:database:create

php app/console doctrine:schema:update --force

php app/console fos:user:create $1 --super-admin

php app/console fos:user:promote $1 ROLE_SUPER_ADMIN

php app/console assets:install

mkdir web/uploads
chmod 0777 web/uploads/
else
echo "use install.sh username";
fi;
