<?php

/**
 * Notifies the user if they don't have the core Pushover Notifications for WordPress plugin installed
 * @return void Adds the admin notice
 */
function ckpn_ite_missing_core_nag() {
	add_settings_error( 'ckpn-ite-notices', 'ckpn-core-missing', __( 'To use Pushover Notifications for iThemes Exchnage you need to install and activate iThemes Exchnage and Pushover Notifications for WordPress.', CKPN_TEXT_DOMAIN ) );
	
	settings_errors( 'ckpn-ite-notices' );
}

/**
 * Notifies the user if they don't have a current enough version of the core Pushover Notifications for WordPress plugin installed
 * @return void Adds the admin notice
 */
function ckpn_ite_core_out_of_date_nag() {
	add_settings_error( 'ckpn-ite-notices', 'core-out-of-date', sprintf( __( 'Your Pushover Notifications core plugin is out of date. Please update to at least version 1.7.4 in order to use Pushover Notifiations for iThemes Exchange. <a href="%s">Update</a>', CKPN_TEXT_DOMAIN ), admin_url( 'update-core.php' ) ) );
	
	settings_errors( 'ckpn-ite-notices' );
}

/**
 * Add The Settings Field to the Pushover Notifications for WordPress settings page
 * @return Void Outputs the settings for this extension
 */
function ckpn_ite_add_settings_fields() {
	$current = ckpn_get_options();
	?>
	<tr>
		<th scope="row"><?php _e( 'iThemes Exchange Settings', CKPN_ITE_TEXT_DOAMIN ); ?></th>
		<td>
			<input type="checkbox" name="ckpn_pushover_notifications_settings[ite_complete_purchase]" value="1" <?php checked( $current['ite_complete_purchase'], '1', true); ?> /> <?php _e( 'New Sales', CKPN_ITE_TEXT_DOAMIN ); ?> 
			<?php ckpn_ite_additional_key_dropdown( 'ite_complete_purchase' ); ?>
			<br />
			<input type="checkbox" name="ckpn_pushover_notifications_settings[ite_daily_sales]" value="1" <?php checked( $current['ite_daily_sales'], '1', true ); ?> /> <span><?php _e( 'Daily Sales Report', CKPN_ITE_TEXT_DOAMIN ); ?></span> <sup>&dagger;</sup>&nbsp;&nbsp;<?php ckpn_ite_additional_key_dropdown( 'ite_daily_sales' ); ?><br />
		</td>
	</tr>
	<?php
}

/**
 * Add the WP eCommerce License Key to the list of licenses
 * @param  array $licenses The existing licenses
 * @return array           The licenses array with the WP eCommerce field added
 */
function ckpn_ite_add_license_key_option( $licenses ) {
	$licenses[] = '_ite_ckpn_license_key';

	return $licenses;
}

/**
 * Adds the license key field.
 * @return void Outputs the license key field for the WP eCommerce Extension
 */
function ckpn_ite_add_license_field() {
	$current_key = get_option( '_ite_ckpn_license_key' );
	if ( !$current_key )
		$current_key = '';
	?>
	<tr valign="top">
		<th scope="row"><?php _e( 'Pushover Notifications for iThemes Exchange', CKPN_ITE_TEXT_DOAMIN ); ?></th>
		<td>
			<input type="text" name="_ite_ckpn_license_key" placeholder="<?php _e( 'Enter Pushover Notifications for iThemes Exchange Key', CKPN_ITE_TEXT_DOAMIN ); ?>" size="50" value="<?php echo $current_key; ?>" />
		</td>
	</tr>
	<?php
}

/**
 * Wrapper for the Multiple Keys dropdown additions
 * @param  string $setting_name The name of the setting
 * @return void                 Simply forwards the setting name to the core plugin for the display of the mulitple key dropdown
 */
function ckpn_ite_additional_key_dropdown( $setting_name = NULL ) {
	if ( !function_exists( 'ckpn_display_application_key_dropdown' ) || $setting_name == NULL )
		return false;

	ckpn_display_application_key_dropdown( $setting_name );
}