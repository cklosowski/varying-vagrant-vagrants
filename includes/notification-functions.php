<?php
/**
 * Hooks into iThemes exchange upon transaction status update
 * @param  object $transaction          The transaction object
 * @param  string $old_status           The Old status of the transaction
 * @param  string $old_status_cleared   The old status cleared
 * @return void                      	No Return value, executes the notificaitons
 */
function ckpn_ite_send_new_sale_notification( $transaction, $old_status, $old_status_cleared ) {
	$options = ckpn_get_options();

	if ( is_plugin_active( 'pushover-notifications/pushover-notifications.php' ) && $options['ite_complete_purchase'] ) {
		if ( $old_status != 'paid' || $transaction->get_status() == 'paid' ) {
			
			$order_total = $transaction->cart_details->total;

			$title = sprintf( __( '%s: New Payment', CKPN_ITE_TEXT_DOAMIN ), get_bloginfo( 'name' ) );
			$message = '';

			foreach ( $transaction->cart_details->products as $item ) {
				$message .= $item['count'] . ' - ' . $item['product_name'] . ' @ ' . it_exchange_format_price( $item['product_subtotal'] ) . "\n";
			}

			$message .= sprintf( __( 'Total Sale: %s', CKPN_ITE_TEXT_DOAMIN ), it_exchange_format_price( $order_total ) );

			$args = array( 'title' => $title, 'message' => $message, 'sound' => 'cashregister' );

			if ( $options['multiple_keys'] )
				$args['token'] = ckpn_get_application_key_by_setting( 'ite_complete_purchase' );

			ckpn_send_notification( $args );
			
		}
	}
}

/**
 * Send the daily orders notifications
 * @return void
 */
function ckpn_ite_send_daily_sales_report() {
	global $wpdb;
	$options = ckpn_get_options();
	if ( !isset( $options['ite_daily_sales'] ) || !$options['ite_daily_sales'] )
		return;

	$defaults = array(
		'start_time' => strtotime( 'today' ),
		'end_time'   => current_time( 'timestamp' ),
	);
	$ite_options = ITUtility::merge_defaults( $options, $defaults );

	// Set GLOBALS for the WHERE filter
	$GLOBALS['it_exchange']['where_start'] = date_i18n( 'Y-m-d H:i:s', $ite_options['start_time'], false );
	$GLOBALS['it_exchange']['where_end']   = date_i18n( 'Y-m-d H:i:s', $ite_options['end_time'], false );

	// Add the filter
	add_filter( 'posts_where', 'it_exchange_filter_where_clause_for_all_queries' );

	$total = 0;
	$earnings = 0;
	// Grab transactions
	if ( $transactions = it_exchange_get_transactions( array( 'posts_per_page' => -1, 'suppress_filters' => false ) ) ) {
		// Loop through transactions and sum the totals if they are cleared for delivery
		foreach( $transactions as $transaction ) {
			if ( it_exchange_transaction_is_cleared_for_delivery( $transaction ) ) {
				$earnings += it_exchange_get_transaction_total( $transaction, false );
				$total++;
			}
		}
	}

	$earnings = ( empty( $earnings ) ) ? it_exchange_format_price( '0' ) : it_exchange_format_price( $earnings );

	// Unset GLOBALS
	unset( $GLOBALS['it_exchange']['where_start'] );
	unset( $GLOBALS['it_exchange']['where_end'] );

	// Remove Filter
	remove_filter( 'posts_where', 'it_exchange_filter_where_clause_for_all_queries' );

	$day = date_i18n( 'j' ); $month = date_i18n( 'm' );
	$title = sprintf( __( '%s: Earnings Report %s', CKPN_ITE_TEXT_DOAMIN ), get_bloginfo( 'name' ), date_i18n( get_option( 'date_format' ), strtotime( $month . '/' . $day ) ) );
	$message = sprintf( __( 'Earnings: %s %sOrders: %d', CKPN_ITE_TEXT_DOAMIN ), $earnings, "\n", $total );

	$args = array( 'title' => $title, 'message' => $message );
	var_dump($args);

	$notification_users = ckpn_ite_get_users_to_alert();

	$options = ckpn_get_options();

	if ( $options['multiple_keys'] )
		$args['token'] = ckpn_get_application_key_by_setting( 'ite_daily_sales' );

	foreach ( $notification_users as $user ) {
		$args['user'] = $user;
		ckpn_send_notification( $args );
	}
}

/**
 * Get the list of users to alert
 * @return array An array of Pushover User Keys
 */
function ckpn_ite_get_users_to_alert() {
	$users = get_users( array( 'fields' => 'ID' ) );

	$options = ckpn_get_options();

	// Add the default admin key from settings
	$user_keys = array( $options['api_key'] );

	$alert_capability = apply_filters( 'ckpn_ite_sales_alert_capability', 'administrator' );

	// Find the users who can view_shop_reports and have a user key
	foreach ( $users as $user ) {
		if ( !user_can( $user, $alert_capability ) )
			continue;

		$user_key = get_user_meta( $user, 'ckpn_user_key', true );
		if ( $user_key )
			$user_keys[] = $user_key;
	}

	return array_unique( apply_filters( 'ckpn_ite_users_to_alert_keys', $user_keys ) );
}