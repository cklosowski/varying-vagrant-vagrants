<?php
if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'PODS_DEBUG' ) && PODS_DEBUG ) {
    @ini_set( 'display_errors', 'on' );
    @error_reporting( E_ALL | E_STRICT );
}
