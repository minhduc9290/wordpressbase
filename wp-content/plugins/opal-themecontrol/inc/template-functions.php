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
* |----------------------------------------
* | Single Portfolio
* |----------------------------------------
*/ 
/**
 * Single related template functions
 */
if (!function_exists('opal_controlpanel_related_teamplate')) {
function opal_controlpanel_related_teamplate(){
	$enable_related = opal_themecontrol_get_options('portfolio_single_related', 1) ;
	if($enable_related) {
		echo Opal_Themecontrol_Template_Loader::get_template_part('portfolio/related');
	}
}
}//endif
add_action('opal_themecontrol_after_single_portfolio_summary','opal_controlpanel_related_teamplate',10);

/**
 * Gender portfolio infomation
 */
if (!function_exists('opal_controlpanel_portfolio_information')) {
function opal_controlpanel_portfolio_information(){
	echo Opal_Themecontrol_Template_Loader::get_template_part( 'portfolio/information');
}
}//endif
