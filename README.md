# DiceChat.Team.Tools

Simple chat application featuring:
- Rolling dice
- Chat rooms
- Sharing chat rooms

## APIs

Rooms
```
/api/rooms
```

Chat room messages
```
/api/room/{room_hash}/messages
```

## Project commands

```
php artisan serve
```

## Git

Two origins have been set up

1. `git@github.com:proochster/laravel-dicer.git` hosted on git.

    push using `git push`

2. `production ssh://root@35.205.148.124/var/repo/dicechat.git` hosted on GC.

    push using `git push production master`

You may need to add `root` user ssh key to the keychain.

```
eval $(ssh-agent -s)
ssh-add ~/.ssh/id_rsa_root
```

## Google Cloud installation

Your domain should be pointing to `/public` folder

Run `sudo composer install --no-dev`

If you get 500 error check permissions

`sudo chgrp -R www-data storage bootstrap/cache`
`sudo chmod -R ug+rwx storage bootstrap/cache`

Run `sudo npm install`

Run `npm run prod` to compile CSS and JS as they are not uploaded as part of the git push.

Migrate DB `sude php artisan migrate`

HTTPS needs to be updated in:
-   ~/etc/apache2/sites-available/dicechat.team.tool.conf
-   [laravel]... .env
-   [laravel]... /config/app.php

Granting permissions MySQL:

`GRANT ALL PRIVILEGES ON database_name.* TO 'username'@'localhost';`

In the `/etc/apache2/sites-available/dicechat.tema.tools.conf` added:

```
<Directory /var/www/dicechat/public/>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

## Git hook

Location: `/var/repo/hooks/dicechat.git/post-receive`
``` sh
#!/bin/sh
# Transfer the files
git --work-tree=/var/www/dicechat --git-dir=/var/repo/dicechat.git checkout -f
# Maintenance mode on
cd /var/www/dicechat
php artisan down
# Install Composer dependencies
sudo composer install --no-dev
# Install npm dependencies
npm install --only=prod
# Migrate DB
php artisan migrate --force
# Compile CSS and JS
npm run prod
# Turn the app online
php artisan up
```

## SSL certificate

To extend the certificate run this command in the root:
```
sudo ./certbot-auto certonly --webroot -w /var/www/dicechat/ -d dicechat.team.tools -d www.dicechat.team.
tools
```
