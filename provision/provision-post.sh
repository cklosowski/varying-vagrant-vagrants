cd /srv/www/wordpress-trunk/
# Add Plugins
if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/debug-bar ]
then
	wp plugin install debug-bar --activate
else
	wp plugin update debug-bar 
fi

if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/debug-bar-console ]
then
	wp plugin install debug-bar-console --activate
else
	wp plugin update debug-bar-console
fi

if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/debug-bar-cron ]
then
	wp plugin install debug-bar-cron --activate
else
	wp plugin update debug-bar-cron
fi

if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/user-switching ]
then
	wp plugin install user-switching --activate
else
	wp plugin update user-switching
fi

cd /srv/www/wordpress-default/
# Add Plugins
if [ ! -d /srv/www/wordpress-default/wp-content/plugins/debug-bar ]
then
	wp plugin install debug-bar --activate
else
	wp plugin update debug-bar 
fi

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/debug-bar-console ]
then
	wp plugin install debug-bar-console --activate
else
	wp plugin update debug-bar-console
fi

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/debug-bar-cron ]
then
	wp plugin install debug-bar-cron --activate
else
	wp plugin update debug-bar-cron
fi

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/user-switching ]
then
	wp plugin install user-switching --activate
else
	wp plugin update user-switching
fi

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/pods ]
then
	wp plugin install pods --activate
else
	wp plugin update pods
fi
