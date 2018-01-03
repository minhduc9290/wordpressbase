<?php
/**
 * Plugin Name: WR In Stock Alert
 * Plugin URI:  http://www.woorockets.com/
 * Description: An add-on for WooCommerce. Alert your customer when a product of her choice is available again.
 * Version:     1.0.4
 * Author:      WooRockets <admin@woorockets.com>
 * Author URI:  http://woorockets.com/
 * License:     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wr-in-stock-alert
 */

// Define plugin textdomain.
define( 'WR_ISA', 'wr-in-stock-alert' );

// Define path to plugin directory.
define( 'WR_ISA_PATH', plugin_dir_path( __FILE__ ) );

// Define URL to plugin directory.
define( 'WR_ISA_URL', plugin_dir_url( __FILE__ ) );

// Define plugin base file.
define( 'WR_ISA_BASENAME', plugin_basename( __FILE__ ) );

// Load the core class.
require_once WR_ISA_PATH . 'includes/core.php';

// Instantiate an object of the core class.
WR_In_Stock_Alert::initialize();
