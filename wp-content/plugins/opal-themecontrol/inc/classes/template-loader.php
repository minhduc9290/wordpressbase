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
if( !class_exists("Opal_Themecontrol_Template_Loader") ){
class Opal_Themecontrol_Template_Loader {
	/**
	 * Initialize template loader
	 *
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'template_include', array( __CLASS__, 'templates' ) );
	}

	/**
	 * Default templates
	 *
	 * @access public
	 * @param $template
	 * @return string
	 * @throws Exception
	 */
	public static function templates( $template ) {
		$post_type = get_post_type();
		$custom_post_types = array( 'team','portfolio','gallery');

		if ( in_array( $post_type, $custom_post_types ) ) {
			if ( is_single() ) {
				return self::locate( 'single-' . $post_type );
			}
			if ( is_archive() ) {
				return self::locate( 'archive-' . $post_type );
			}
			
		}
		return $template;
	}

	/**
	 * Gets template path
	 *
	 * @access public
	 * @param $name
	 * @param $plugin_dir
	 * @return string
	 * @throws Exception
	 */
	public static function locate( $name, $plugin_dir = OPAL_THEMECONTROL_PLUGIN_DIR ) {
		$template = '';

		// Current theme base dir
		if ( ! empty( $name ) ) {
			$template = locate_template( "{$name}.php" );
		}

		// Child theme
		if ( ! $template && ! empty( $name ) && file_exists( get_stylesheet_directory() . "/opalthemer/templates/{$name}.php" ) ) {
			$template = get_stylesheet_directory() . "/opalthemer/templates/{$name}.php";
		}

		// Original theme
		if ( ! $template && ! empty( $name ) && file_exists( get_template_directory() . "/opalthemer/templates/{$name}.php" ) ) {
			$template = get_template_directory() . "/opalthemer/templates/{$name}.php";
		}

		// Plugin
		if ( ! $template && ! empty( $name ) && file_exists( $plugin_dir . "/templates/{$name}.php" ) ) {
			$template = $plugin_dir . "/templates/{$name}.php";
		}

		// Nothing found
		if ( empty( $template ) ) {
			throw new Exception( "Template /templates/{$name}.php in plugin dir {$plugin_dir} not found." );
		}

		return $template;
	}

	
	/**
	 * Loads template content
	 *
	 * @param string $name
	 * @param array  $args
	 * @param string $plugin_dir
	 * @return string
	 * @throws Exception
	 */
	public static function get_template_part( $name, $args = array(), $plugin_dir = OPAL_THEMECONTROL_PLUGIN_DIR ) {
		if ( is_array( $args ) && count( $args ) > 0 ) {
			extract( $args, EXTR_SKIP );
		}

		$path = self::locate( $name, $plugin_dir );
		ob_start();
		include $path;
		$result = ob_get_contents();
		ob_end_clean();
		return $result;
	}
}
}

Opal_Themecontrol_Template_Loader::init();
