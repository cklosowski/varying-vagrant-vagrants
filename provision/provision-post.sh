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

if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/mp6 ]
then
	wp plugin install mp6 --activate
else
	wp plugin update mp6
fi

if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/pods ]
then
	wp plugin install pods
else
	wp plugin update pods
fi

if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/pods-2.x ]
then
	wp plugin install https://github.com/pods-framework/pods/archive/2.x.zip
else
	wp plugin update pods-2.x
fi

if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/pods-unit-tests-master ]
then
	wp plugin install https://github.com/pods-framework/pods-unit-tests/archive/master.zip --activate
else
	wp plugin update pods-unit-tests-master
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

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/mp6 ]
then
	wp plugin install mp6 --activate
else
	wp plugin update mp6
fi

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/pods ]
then
	wp plugin install pods
else
	wp plugin update pods
fi

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/pods-2.x ]
then
	wp plugin install https://github.com/pods-framework/pods/archive/2.x.zip
else
	wp plugin update pods-2.x
fi

if [ ! -d /srv/www/wordpress-default/wp-content/plugins/pods-unit-tests-master ]
then
	wp plugin install https://github.com/pods-framework/pods-unit-tests/archive/master.zip --activate
else
	wp plugin update pods-unit-tests-master
fi
