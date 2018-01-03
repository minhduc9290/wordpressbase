<?php
/**
 * @version    1.0
 * @package    WR_Custom_Attributes
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

/**
 * Define core class.
 */
class WR_Custom_Attributes {
	/**
	 * Variable to hold class prefix supported for autoloading.
	 *
	 * @var  string
	 */
	protected static $prefix = 'WR_Custom_Attributes_';

	/**
	 * Variable to hold supported custom attribute types.
	 *
	 * @var  array
	 */
	public static $types;

	/**
	 * Initialize.
	 *
	 * @return  void
	 */
	public static function initialize() {
		// Register class autoloader.
		spl_autoload_register( array( __CLASS__, 'autoload' ) );

		// Load plugin textdomain.
		add_action( 'init', array( __CLASS__, 'load_textdomain' ) );

		// Register action to enqueue necessary assets.
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_backend_assets'  ) );
		add_action( 'wp_enqueue_scripts'   , array( __CLASS__, 'enqueue_frontend_assets' ) );

		// Register action to show confirmation before deactivating WR Custom Attribute.
		add_action( 'plugin_action_links_' . WR_CA_BASENAME, array( __CLASS__, 'confirm_deactivation' ) );

		// Register action to convert all custom attributes to <select> type when WR Custom Attribute is being deactivated.
		add_action( 'deactivate_' . WR_CA_BASENAME, array( __CLASS__, 'deactivate_plugin' ) );

		// Define supported custom attribute types.
		self::$types = array(
			'color picker' => __( 'Color Picker', 'wr-custom-attributes' ),
			'image select' => __( 'Image Select', 'wr-custom-attributes' ),
			'text label'   => __( 'Text Label'  , 'wr-custom-attributes' ),
		);

		// Initialize custom attribute types for WooCommerce.
		WR_Custom_Attributes_Hook::initialize();

		// Initialize meta boxes for adding product variation gallery images.
		WR_Custom_Attributes_Meta_Box::initialize();
	}

	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.1
	 */
	public static function load_textdomain() {
		load_plugin_textdomain( 'wr-custom-attributes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Method to enqueue necessary assets for the screen to add/edit product.
	 *
	 * @return  void
	 */
	public static function enqueue_backend_assets() {
		global $pagenow, $post_type;

		if ( 'post.php' == $pagenow && 'product' == $post_type ) {
			// Enqueue stylesheet.
			wp_enqueue_style( WR_CA, WR_CA_URL . 'assets/css/back-end.css' );

			// Enqueue script.
			wp_enqueue_script( WR_CA, WR_CA_URL . 'assets/js/back-end.js', array( 'jquery' ) );

			wp_localize_script( WR_CA, 'wr_custom_attribute', array(
				'refresh_tip' => __(
					"If you don't see meta boxes for selecting product variation images at the right side, click to refresh the page.",
					'wr-custom-attributes'
				)
			) );
		}
	}

	/**
	 * Method to enqueue necessary assets for rendering custom attribute types in front-end.
	 *
	 * @return  void
	 */
	public static function enqueue_frontend_assets() {
		global $post;

		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() || ( isset( $post->post_content ) && ( has_shortcode( $post->post_content, 'nitro_product' ) || has_shortcode( $post->post_content, 'nitro_products' ) ) ) ) {
			// Enqueue stylesheet.
			wp_enqueue_style( WR_CA, WR_CA_URL . 'assets/css/front-end.css' );

			// Enqueue script.
			wp_enqueue_script( WR_CA, WR_CA_URL . 'assets/js/front-end.js', array( 'jquery' ) );
		}
	}

	/**
	 * Confirm before deactivating WR Custom Attribute.
	 *
	 * @param   string  $links  Current plugin's action links.
	 *
	 * @return  array
	 */
	public static function confirm_deactivation( $links ) {
		$links['deactivate'] = preg_replace(
			'/(href=["\'][^"\']+["\'])/',
			'onclick="if ( ! wr_custom_attribute_confirm_deactivation() ) return false;" \\1',
			$links['deactivate']
		) . '
		<script type="text/javascript">
			window.wr_custom_attribute_confirm_deactivation = function() {
				return confirm("' . __(
					'If WR Custom Attribute is deactivated, custom attributes created using the plugin will no longer work. So, the plugin will automatically convert all custom attributes to <select> type before deactivating. Are you sure you want to continue?',
					'wr-custom-attributes'
				) . '");
			};
		</script>
		';

		return $links;
	}

	/**
	 * Convert all custom attributes to <select> type before deactivating WR Custom Attribute.
	 *
	 * @return  void
	 */
	public static function deactivate_plugin() {
		// Get all custom attributes.
		global $wpdb;

		$attributes = $wpdb->get_results(
			"SELECT attribute_id FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
			"WHERE attribute_type IN ('" . implode( "', '", array_keys( self::$types ) ) . "')",
			ARRAY_N
		);

		if ( count( $attributes ) ) {
			// Convert all custom attributes to <select> type.
			$wpdb->query(
				"UPDATE {$wpdb->prefix}woocommerce_attribute_taxonomies SET attribute_type = 'select'" .
				"WHERE attribute_id IN (" . implode( ', ', array_map( 'current', $attributes ) ) . ")"
			);
		}

		delete_transient( 'wc_attribute_taxonomies' );
	}

	/**
	 * Method to autoload class declaration file.
	 *
	 * @param   string  $class_name  Name of class to load declaration file for.
	 *
	 * @return  mixed
	 */
	public static function autoload( $class_name ) {
		// Verify class prefix.
		if ( 0 !== strpos( $class_name, self::$prefix ) ) {
			return false;
		}

		// Generate file path from class name.
		$base = WR_CA_PATH . 'includes/';
		$path = strtolower( str_replace( '_', '/', substr( $class_name, strlen( self::$prefix ) ) ) );

		// Check if class file exists.
		$standard    = $path . '.php';
		$alternative = $path . '/' . basename( $path ) . '.php';

		while ( true ) {
			// Check if file exists in standard path.
			if ( @is_file( $base . $standard ) ) {
				$exists = $standard;

				break;
			}

			// Check if file exists in alternative path.
			if ( @is_file( $base . $alternative ) ) {
				$exists = $alternative;

				break;
			}

			// If there is no more alternative file, quit the loop.
			if ( false === strrpos( $standard, '/' ) || 0 === strrpos( $standard, '/' ) ) {
				break;
			}

			// Generate more alternative files.
			$standard    = preg_replace( '#/([^/]+)$#', '-\\1', $standard );
			$alternative = dirname( $standard ) . '/' . substr( basename( $standard ), 0, -4 ) . '/' . basename( $standard );
		}

		// Include class declaration file if exists.
		if ( isset( $exists ) ) {
			return include_once $base . $exists;
		}

		return false;
	}
}
