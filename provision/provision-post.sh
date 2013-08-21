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

# Appending to the PHP config for xdebug
echo "Verifying Xdebug Install"

echo "Installing xdebug"

# Install XDEBUG for cache grinding
sudo pecl install xdebug

# Create a directory to grind to
if [ ! -d /srv/www/profiling ]
then
	mkdir /srv/www/profiling
fi

XDEBUG_CONFIG='zend_extension="xdebug.so"
xdebug.profiler_enable = 0
xdebug.profiler_output_dir = /srv/www/profiling
xdebug.profiler_enable_trigger = 1
xdebug.profiler_output_name = callgrind.out.%p'

if ! grep -q "$XDEBUG_CONFIG" /etc/php5/fpm/php.ini
then echo "$XDEBUG_CONFIG" >> /etc/php5/fpm/php.ini
fi