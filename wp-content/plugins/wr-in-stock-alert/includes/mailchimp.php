<?php
/**
 * @version    1.0
 * @package    WR_In_Stock_Alert
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

/**
 * Define class to export subscription to MailChimp.
 */
class WR_In_Stock_Alert_Mailchimp {
	/**
	 * Initialize.
	 *
	 * @return  void
	 */
	public static function initialize() {
		// Register action to export subscription to MailChimp.
		add_action( 'saved_in_stock_alert_subscription', array( __CLASS__, 'export' ) );
	}

	/**
	 * Export subscription to MailChimp.
	 *
	 * @param   array  $data  Subscription data.
	 *
	 * @return  void
	 */
	public static function export( $data ) {
		// Extract data.
		extract( $data );

		// Get current settings.
		$settings = WR_In_Stock_Alert_Settings::get();

		// Prepare parameters for requesting MailChimp API.
		@list( $first_name, $last_name ) = explode( ' ', $name, 2 );

		$data_center = substr( $settings['mailchimp_api_key'], strpos( $settings['mailchimp_api_key'], '-' ) + 1 );
		$end_point   = "https://{$data_center}.api.mailchimp.com/3.0/lists/{$settings['mailchimp_list_id']}/members/";

		$post_fields = json_encode( array(
			'email_address' => $email,
			'status'        => 'subscribed',
			'location'      => array( 'gmtoff' => 0 - ( $timezone / 60 ) ),
			'merge_fields'  => array(
				'FNAME' => $first_name,
				'LNAME' => isset( $last_name ) ? $last_name : '',
			),
		) );

		// Send request to add subscription to MailChimp list.
		$ch = curl_init( $end_point );

		curl_setopt( $ch, CURLOPT_USERPWD       , "{$settings['mailchimp_username']}:{$settings['mailchimp_api_key']}" );
		curl_setopt( $ch, CURLOPT_HTTPHEADER    , array( 'Content-Type: application/json' )                            );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true                                                                 );
		curl_setopt( $ch, CURLOPT_TIMEOUT       , 10                                                                   );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false                                                                );
		curl_setopt( $ch, CURLOPT_POSTFIELDS    , $post_fields                                                         );

		curl_exec( $ch );
	}
}
