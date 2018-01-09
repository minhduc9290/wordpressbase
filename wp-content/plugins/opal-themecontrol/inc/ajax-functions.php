<?php 
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opal-themecontrol
 * @author     Opal  Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2016 opalthemer.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.opalthemer.com
 * @support  http://www.opalthemer.com/support/forum.html
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
*	Func Process acction Activate addons in admin tabs
*   @param key
*	@action 
*/
if (!function_exists('opal_themecontrol_process_activate_addons')) {
	function opal_themecontrol_process_activate_addons() {

		if( isset($_POST['action']) && $_POST['action'] == 'do_activate_addons' && isset($_POST['checkbox']) && isset($_POST['key']) ){
			$status = trim($_POST['checkbox']);
			$key = trim($_POST['key']);

			$options = array();
			if($status == 'activate'){
				opalthemecontrol_update_option($key,'on');
				// $options[$key] = 'on';
				// update_option( 'opalthemecontrol_settings', $options);
				$return = array( 'status' => 'activate');
			} else {
				opalthemecontrol_update_option($key,'');
				$return = array( 'status' => 'deactivate');
			}

		echo json_encode($return); die();
		}
	}
}
// add acction ajax
add_action( 'wp_ajax_do_activate_addons', 'opal_themecontrol_process_activate_addons' );
add_action( 'wp_ajax_nopriv_do_activate_addons', 'opal_themecontrol_process_activate_addons' );
