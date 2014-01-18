<?php
/*
Plugin Name: Pushover Notifications for iThemes Exchange
Plugin URI: http://wp-push.com
Description: Adds iThemes Exchange support to Pushover Notifications for WordPress
Version: 1.0
Author: Chris Klosowski
Author URI: http://wp-push.com
Text Domain: ckpn_ite
*/

// Define the plugin path
define( 'CKPN_ITE_PATH', plugin_dir_path( __FILE__ ) );

define( 'CKPN_ITE_TEXT_DOAMIN' , 'ckpn-ite' );
// plugin version
define( 'CKPN_ITE_VERSION', '1.0' );

// Define the URL to the plugin folder
define( 'CKPN_ITE_FOLDER', dirname( plugin_basename( __FILE__ ) ) );
define( 'CKPN_ITE_URL', plugins_url( 'pushover-notifications-ite-ext', 'pushover-notifications-ite.php' ) );

if ( !defined( 'WP_PUSH_SL_STORE_API_URL' ) )
	define( 'WP_PUSH_SL_STORE_API_URL', 'https://wp-push.com' );

define( 'WP_PUSH_ITE_PRODUCT_NAME', 'Pushover Notifications for iThemes Exchange' );

if ( !class_exists( 'EDD_SL_Plugin_Updater' ) )
	include CKPN_ITE_PATH . '/includes/EDD_SL_Plugin_Updater.php';

include_once ABSPATH . 'wp-admin/includes/plugin.php';

class CKPushoverNotificationsITE {
	private static $ckpn_ite_instance;

	private function __construct() {
		if ( !$this->checkCoreVersion() ) {
			include_once( CKPN_ITE_PATH . '/includes/admin/admin-functions.php' );
			add_action( 'admin_notices', 'ckpn_ite_core_out_of_date_nag' );
		} else {
			include_once( CKPN_ITE_PATH . '/includes/notification-functions.php' );

			// Unify with the settings
			add_filter( 'ckpn_options_defaults', array( $this, 'add_defaults' ), 1 );
			
			// Admin Hooks
			add_action( 'admin_init', array( $this, 'admin_hooks' ), 99 );
			add_action( 'admin_init', array( $this, 'wp_push_activate' ) );

			// Non-Admin Hooks
			add_action( 'init', array( $this, 'wp_push_updates' ) );
			add_action( 'init', array( $this, 'load_text_domain' ) );

			// General iThemes Exchange hooks
			add_action( 'it_exchange_update_transaction_status', 'ckpn_ite_send_new_sale_notification', 10, 3 );
		}
	}

	public static function getInstance() {
		if ( !self::$ckpn_ite_instance ) {
			self::$ckpn_ite_instance = new CKPushoverNotificationsITE;
		}

		return self::$ckpn_ite_instance;
	}

	private function checkCoreVersion() {
		// Make sure we have the required version of Pushover Notifications core plugin
		$plugin_folder = get_plugins( '/pushover-notifications' );
		$plugin_file = 'pushover-notifications.php';
		$core_version = $plugin_folder[$plugin_file]['Version'];
		$requires = '1.7.4';

		if ( version_compare( $core_version, $requires ) >= 0 ) {
			return true;
		}

		return false;
	}

	private function getOptions() {
		static $options = NULL;

		if ( $options !== NULL )
			return $options;

		if ( !function_exists( 'ckpn_get_options' ) )
			return $options;

		$options = ckpn_get_options();

		return $options;
	}

	public function load_text_domain() {
		load_plugin_textdomain( CKPN_ITE_TEXT_DOAMIN, false, '/pushover-notifications-ite-ext/languages/' );
	}

	/**
	 * Hooks run from WP Admin
	 * @return void Just using actions and filters to execute items in admin
	 */
	public function admin_hooks() {
		if ( is_plugin_active( 'pushover-notifications/pushover-notifications.php' ) && is_plugin_active( 'ithemes-exchange/init.php' ) ) {
			include_once( CKPN_ITE_PATH . '/includes/admin/admin-functions.php' );
			$this->determine_cron_schedule();
			add_action( 'ckpn_notification_licenses_page', 'ckpn_ite_add_license_field' );
			add_action( 'ckpn_notification_checkbox_filter', 'ckpn_ite_add_settings_fields', 99 );
			add_filter( 'ckpn_licenses_array', 'ckpn_ite_add_license_key_option', 10, 1 );
		} else {
			add_action( 'admin_notices', 'ckpn_ite_missing_core_nag' );
		}
	}

	/**
	 * Determines when the cron should run for the daily sales reports
	 * @return void
	 */
	private function determine_cron_schedule() {
		$current_options = ckpn_get_options();
		if ( $current_options['ite_daily_sales'] ) {
			if ( !wp_next_scheduled( 'ckpn_ite_daily_sales' ) ) {
				$next_run = strtotime( '23:00' ) + ( -( get_option('gmt_offset') * 60 * 60 ) ); // Calc for the WP timezone

				if ( (int)date_i18n( 'G' ) >= 23 )
					$next_run = strtotime( 'next day 23:00' ) + ( -( get_option('gmt_offset') * 60 * 60 ) ); // Calc for the WP timezone;

				wp_schedule_event( $next_run, 'daily', 'ckpn_ite_daily_sales' );
			}
			add_action( 'ckpn_ite_daily_sales', 'ckpn_ite_send_daily_sales_report' );
		}
	}

	/**
	 * Adds the WP eCommerce Extension settings to the array
	 * @param array $defaults The default options on the filter
	 *
	 * @return array The $defaults merged with the WPEC settings
	 */
	public function add_defaults( $defaults ) {
		$ckpn_ite_defaults = array(
			'ite_complete_purchase'  => false,
			'ite_daily_sales'        => false
		);

		return array_merge( $defaults, $ckpn_ite_defaults );
	}
	
	/**
	 * Checks for updates
	 * @return void Uses the bundeled class to check WPPush for extension updates
	 */
	public function wp_push_updates() {
		$key = get_option( '_ite_ckpn_license_key' );
		$license_key = isset( $key ) ? trim( $key ) : '';

		// setup the updater
		$edd_updater = new EDD_SL_Plugin_Updater( WP_PUSH_SL_STORE_API_URL, __FILE__, array(
				'version'  => CKPN_ITE_VERSION,    // current version number
				'license'  => $license_key,   // license key ( used get_option above to retrieve from DB )
				'item_name'  => WP_PUSH_ITE_PRODUCT_NAME,  // name of this plugin
				'author'  => 'Chris Klosowski'    // author of this plugin
			)
		);
	}


	/**
	 * Run the activation check when the license key page is loaded
	 * @return mixed Void if successful, false if  unsuccessful
	 */
	public function wp_push_activate() {
		if ( !isset( $_REQUEST['page'] ) || ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] !== 'pushover-notifications' ) )
			return;

		if ( !isset( $_REQUEST['tab'] ) || ( isset( $_REQUEST['tab'] ) && $_REQUEST['tab'] !== 'licenses' ) )
			return;

		if ( !isset( $_REQUEST['action'] ) || ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] !== 'update' ) )
			return;

		$current_options = $this->getOptions();
		if ( isset( $current_options['ckpn_ite_active'] ) && $current_options['ckpn_ite_active'] == 'valid' )
			return;

		$license = sanitize_text_field( get_option( '_ite_ckpn_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'  => $license,
			'item_name'  => urlencode( WP_PUSH_ITE_PRODUCT_NAME ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, WP_PUSH_SL_STORE_API_URL ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		$current_options['ckpn_ite_active'] = $license_data->license;
		update_option( 'ckpn_pushover_notifications_settings', $current_options );
	}
}

$ckpn_ite_loaded = CKPushoverNotificationsITE::getInstance();
