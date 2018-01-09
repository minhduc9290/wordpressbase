<?php 
/**
 * Install Opal Restaurant
 *
 * @package     Opal Restaurant
 * @subpackage  Uninstall
 * @copyright   Copyright (c) 2016, Wopal
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

function opalthemecontrol_install(){
	

	global $opalthemecontrol_options;

	// Clear the permalinks
	flush_rewrite_rules( false );

	// Add Upgraded From Option
	$current_version = get_option( 'opalthemecontrol_version' );
	if ( $current_version ) {
		update_option( 'opalthemecontrol_version_upgraded_from', $current_version );
	}

	// Setup some default options
	$options = array();

	// -- end create home page 
	//Fresh Install? Setup Test Mode, Base Country (US), Test Gateway, Currency
	if ( empty( $current_version ) ) {
	
		$options['test_mode']          = 1;
		$options['currency']           = 'USD';
		$options['currency_position']  = 'before';
		
	}

	// Populate some default values
	update_option( 'opalthemecontrol_settings', array_merge( $opalthemecontrol_options, $options ) );
	update_option( 'opalthemecontrol_version', OPAL_THEMECONTROL_VERSION );

	// Add a temporary option to note that Give pages have been created
	set_transient( '_opalthemecontrol_installed', $options, 30 );

 
	// Bail if activating from network, or bulk
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}
	// Add the transient to redirect
	set_transient( '_opalthemecontrol_activation_redirect', true, 30 );

}	
?>