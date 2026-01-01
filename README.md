# DiceChat.Team.Tools

Simple chat application featuring:

-   Rolling dice
-   Chat rooms
-   Sharing chat rooms

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

Migrate DB `sudo php artisan migrate`

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

```sh
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
sudo ./certbot-auto certonly --webroot -w /var/www/dicechat/public/ -d dicechat.team.tools -d www.dicechat.team.
tools
```

## Server maintenance

### File size maintenance

List size of top folders

```
sudo du -shc /*
```

List size of all folders including subfolders

```
sudo du -sh /*
```

Snaps files can pile up and take a significant amount of space.
Run this to check the snaps size:

```
sudo du -shc /var/lib/snapd/snaps/*
```

Read more here: https://www.linuxuprising.com/2019/04/how-to-remove-old-snap-versions-to-free.html

    "There is a snap option (starting with snapd version 2.34), called refresh.retain, to set the maximum number of a snap's revisions stored by the system after the next refresh, which can be set to a number between 2 and 20"

Set kept snaps to 2. This step was already applied.

```
sudo snap set system refresh.retain=2
```

STEPS TO RUN

**Remove unused packages**

```
sudo apt-get autoremove
```

or with the `-f` flag if if the previous command didn't work:

```
sudo apt-get -f autoremove
```

**Remove unused snaps**

Snaps locations:

/snap/ /var/snap/ /var/lib/snapd/ /home/username/snap/

List all snaps

```
snap list --all
```

Remove old snaps using a custom script located in `./clean_snap.sh`

```
sudo ./clean_snap.sh
```

## Logs size

You can check the log size with this command:

```
journalctl --disk-usage
```

Logs location:

```
/var/log
```

## NVM

To install on Windows run: https://github.com/coreybutler/nvm-windows/releases

```
nvm -v
```
