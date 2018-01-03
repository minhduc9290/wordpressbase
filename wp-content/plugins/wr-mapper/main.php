<?php
/**
 * Plugin Name: WR Mapper
 * Plugin URI:  http://www.woorockets.com/
 * Description: Display WooCommerce Products in style Add Pins to images.
 * Version:     1.0.8
 * Author:      WooRockets <admin@woorockets.com>
 * Author URI:  http://woorockets.com/
 * License:     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wr-mapper
 */

// Define plugin textdomain.
define( 'WR_MAPPER', 'wr-mapper' );

// Define path to plugin directory.
define( 'WR_MAPPER_PATH', plugin_dir_path( __FILE__ ) );

// Define URL to plugin directory.
define( 'WR_MAPPER_URL', plugin_dir_url( __FILE__ ) );

// Define plugin base file.
define( 'WR_MAPPER_BASENAME', plugin_basename( __FILE__ ) );

// Load the core class.
require_once WR_MAPPER_PATH . 'includes/core.php';

// Instantiate an object of the core class.
WR_Mapper::initialize();
