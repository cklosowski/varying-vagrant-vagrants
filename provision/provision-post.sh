# Checkout, install and configure debug bar trunk
if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/debug-bar ]
then
	printf "Checking out Debug Bar trunk....\n"
	svn checkout http://plugins.svn.wordpress.org/debug-bar/trunk/ /srv/www/wordpress-trunk/wp-content/plugins/debug-bar
else
	printf "Updating Debug Bar trunk...\n"
	cd /srv/www/wordpress-trunk/wp-content/plugins/debug-bar
	svn up
fi

# Checkout, install and configure debug bar trunk
if [ ! -d /srv/www/wordpress-default/wp-content/plugins/debug-bar ]
then
	printf "Checking out Debug Bar trunk....\n"
	svn checkout http://plugins.svn.wordpress.org/debug-bar/trunk/ /srv/www/wordpress-default/wp-content/plugins/debug-bar
else
	printf "Updating Debug Bar trunk...\n"
	cd /srv/www/wordpress-default/wp-content/plugins/debug-bar
	svn up
fi

# Checkout, install and configure debug bar console trunk
if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/debug-bar-console ]
then
	printf "Checking out Debug Bar Console trunk....\n"
	svn checkout http://plugins.svn.wordpress.org/debug-bar/trunk/ /srv/www/wordpress-trunk/wp-content/plugins/debug-bar
else
	printf "Updating Debug Bar Console trunk...\n"
	cd /srv/www/wordpress-trunk/wp-content/plugins/debug-bar
	svn up
fi

# Checkout, install and configure debug bar console trunk
if [ ! -d /srv/www/wordpress-default/wp-content/plugins/debug-bar-console ]
then
	printf "Checking out Debug Bar Console trunk....\n"
	svn checkout http://plugins.svn.wordpress.org/debug-bar-console/trunk/ /srv/www/wordpress-default/wp-content/plugins/debug-bar-console
else	
	printf "Updating Debug Bar Console trunk...\n"
	cd /srv/www/wordpress-default/wp-content/plugins/debug-bar-console
	svn up
fi


# Checkout, install and configure user switching trunk
if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/debug-bar-cron ]
then
	printf "Checking out user switching trunk....\n"
	svn checkout http://plugins.svn.wordpress.org/debug-bar/trunk/ /srv/www/wordpress-trunk/wp-content/plugins/debug-bar-cron
else
	printf "Updating user switching trunk...\n"
	cd /srv/www/wordpress-trunk/wp-content/plugins/debug-bar
	svn up
fi

# Checkout, install and configure user switching trunk
if [ ! -d /srv/www/wordpress-default/wp-content/plugins/debug-bar-cron ]
then
	printf "Checking out user switching trunk....\n"
	svn checkout http://plugins.svn.wordpress.org/debug-bar-cron/trunk/ /srv/www/wordpress-default/wp-content/plugins/debug-bar-cron
else
	printf "Updating user switching trunk...\n"
	cd /srv/www/wordpress-default/wp-content/plugins/debug-bar-cron
	svn up
fi

# Checkout, install and configure user switching trunk
if [ ! -d /srv/www/wordpress-trunk/wp-content/plugins/user-switching ]
then
	printf "Checking out user switching trunk....\n"
	svn checkout http://plugins.svn.wordpress.org/debug-bar/trunk/ /srv/www/wordpress-trunk/wp-content/plugins/user-switching
else
	printf "Updating user switching trunk...\n"
	cd /srv/www/wordpress-trunk/wp-content/plugins/debug-bar
	svn up
fi

# Checkout, install and configure user switching trunk
if [ ! -d /srv/www/wordpress-default/wp-content/plugins/user-switching ]
then
	printf "Checking out user switching trunk....\n"
	svn checkout http://plugins.svn.wordpress.org/user-switching/trunk/ /srv/www/wordpress-default/wp-content/plugins/user-switching
else
	printf "Updating user switching trunk...\n"
	cd /srv/www/wordpress-default/wp-content/plugins/user-switching
	svn up
fi
