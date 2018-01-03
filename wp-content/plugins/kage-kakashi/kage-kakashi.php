<?php
/**
 * Plugin Name: Hokage Kakashi
 * Plugin URI:  http://www.kakashi.com
 * Description: The best responsive WordPress Kakashi plugin. It's easy and powerful.
 * Version:     1.0.0
 * Author:      Mr-DucPham <minhduc9290@gmail.com>
 * Author URI:  http://www.ducpham.info
 * License:     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kage-kakashi
 */

 // Define path to plugin directory.
 define( 'KAGE_KAKASHI_PATH', plugin_dir_path( __FILE__ ) );

 // Define URL to plugin directory.
 define( 'KAGE_KAKASHI_URL', plugin_dir_url( __FILE__ ) );

 // Load the core class.
 require_once KAGE_KAKASHI_PATH . 'inc/core.php';

 // Instantiate an object of the core class.
 Kage_Kakashi::initialize();
 ?>
