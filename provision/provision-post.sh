cd /srv/www/wordpress-trunk/
# Add Plugins
if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/debug-bar ]
then
	wp plugin install debug-bar --activate --allow-root
else
	wp plugin update debug-bar  --allow-root
fi

if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/debug-bar-console ]
then
	wp plugin install debug-bar-console --activate --allow-root
else
	wp plugin update debug-bar-console --allow-root
fi

if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/debug-bar-cron ]
then
	wp plugin install debug-bar-cron --activate --allow-root
else
	wp plugin update debug-bar-cron --allow-root
fi

if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/tdd-debug-bar-post-meta ]
then
	wp plugin install tdd-debug-bar-post-meta --activate --allow-root
else
	wp plugin update tdd-debug-bar-post-meta --allow-root
fi

if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/user-switching ]
then
	wp plugin install user-switching --activate --allow-root
else
	wp plugin update user-switching --allow-root
fi

cd /srv/www/wordpress-default/
# Add Plugins
if [ ! -d /srv/www/wordpress-default/wp-content/plugins/debug-bar ]
then
	wp plugin install debug-bar --activate --allow-root
else
	wp plugin update debug-bar --allow-root
fi

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/debug-bar-console ]
then
	wp plugin install debug-bar-console --activate --allow-root
else
	wp plugin update debug-bar-console --allow-root
fi

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/debug-bar-cron ]
then
	wp plugin install debug-bar-cron --activate --allow-root
else
	wp plugin update debug-bar-cron --allow-root
fi

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/tdd-debug-bar-post-meta ]
then
	wp plugin install tdd-debug-bar-post-meta --activate --allow-root
else
	wp plugin update tdd-debug-bar-post-meta --allow-root
fi

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/user-switching ]
then
	wp plugin install user-switching --activate --allow-root
else
	wp plugin update user-switching --allow-root
fi