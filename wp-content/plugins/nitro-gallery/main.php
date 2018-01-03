<?php
/**
 * Plugin Name: Nitro Gallery
 * Plugin URI:  http://www.woorockets.com
 * Description: The best responsive WordPress gallery plugin. It's easy and powerful.
 * Version:     1.0.4
 * Author:      WooRockets <admin@woorockets.com>
 * Author URI:  http://www.woorockets.com
 * License:     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: nitro-gallery
 */

// Define path to plugin directory.
define( 'NITRO_GALLERY_PATH', plugin_dir_path( __FILE__ ) );

// Define URL to plugin directory.
define( 'NITRO_GALLERY_URL', plugin_dir_url( __FILE__ ) );

// Load the core class.
require_once NITRO_GALLERY_PATH . 'includes/core.php';

// Instantiate an object of the core class.
Nitro_Gallery::initialize();