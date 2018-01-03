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
 * Define core class.
 */
class WR_In_Stock_Alert {
	/**
	 * Variable to hold class prefix supported for autoloading.
	 *
	 * @var  string
	 */
	protected static $prefix = 'WR_In_Stock_Alert_';

	/**
	 * Initialize.
	 *
	 * @return  void
	 */
	public static function initialize() {
		// Register class autoloader.
		spl_autoload_register( array( __CLASS__, 'autoload' ) );

		// Check if the URL to unsubscribe from receiving in stock alert is requested.
		if ( preg_match( '#^(.+)\?action=unsubscribe-in-stock-alert&product=(\d+)&email=(.+)$#', $_SERVER['REQUEST_URI'], $match ) ) {
			// Store data to cookie.
			$data = array(
				'product' => $match[2],
				'email'   => $match[3],
			);

			setcookie( WR_ISA . '_unsubscribe', json_encode( $data ) );

			// Redirect to product details page.
			header( 'Location: ' . $match[1] );
			exit;
		}

		// Register action to initialize the plugin.
		add_action( 'wp', array( __CLASS__, 'hook' ) );

		// Initialize custom post type to store subscriptions.
		add_action( 'init', array( 'WR_In_Stock_Alert_Post_Type', 'initialize' ) );

		// Initialize settings for the plugin.
		add_action( 'init', array( 'WR_In_Stock_Alert_Settings', 'initialize' ) );

		// Register filter to track stock status change.
		add_filter( 'update_post_metadata', array( __CLASS__, 'track' ), 999999, 4 );

		// Register Ajax action to send notification emails.
		add_action( 'wp_ajax_product-back-in-stock-notification'       , array( __CLASS__, 'send_mails' ) );
		add_action( 'wp_ajax_nopriv_product-back-in-stock-notification', array( __CLASS__, 'send_mails' ) );

		// Load plugin textdomain.
		add_action( 'init', array( __CLASS__, 'load_textdomain' ) );
	}

	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.1
	 */
	public static function load_textdomain() {
		load_plugin_textdomain( 'wr-in-stock-alert', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Initialize the plugin.
	 *
	 * @return  void
	 */
	public static function hook() {
		// Check if product details page is requested.
		if ( ! is_admin() && is_singular( 'product' ) ) {
			global $post, $product;

			// Prepare current product.
			if ( ! $product || is_scalar( $product ) ) {
				$product = wc_get_product( $post );
			}

			// Register action to show subscription form if current product is out of stock.
			add_action( "woocommerce_{$product->get_type()}_add_to_cart", array( __CLASS__, 'check' ) );
		}
	}

	/**
	 * Method to show subscription form if current product is out of stock.
	 *
	 * @return  void
	 */
	public static function check() {
		global $product;

		// Check if the URL to unsubscribe from receiving in stock alert is requested.
		if ( isset( $_COOKIE[ WR_ISA . '_unsubscribe' ] ) ) {
			// Get subscription.
			if ( $subscription = json_decode( str_replace( '\\', '', $_COOKIE[ WR_ISA . '_unsubscribe' ] ) ) ) {
				$subscription = get_posts( array(
					'post_type'   => 'in_stock_alert',
					'post_parent' => ( int ) $subscription->product,
					'meta_query'  => array(
						array(
							'key'   => 'email',
							'value' => $subscription->email,
						),
					)
				) );

				if ( count( $subscription ) ) {
					// Remove subscription.
					$unsubscribed = wp_delete_post( $subscription[0]->ID, true );

					// Include template to print HTML to confirm unsubscription.
					$enqueue_assets = true;

					include_once WR_ISA_PATH . 'templates/shop/popup.php';
				}
			}
		}

		if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
			$stock_status = $product->stock_status;
		} else {
			$stock_status = $product->get_stock_status();
		}
		// Check if current product is out of stock.
		if ( 'outofstock' == $stock_status ) {
			// Include template to print HTML for subscription form.
			$enqueue_assets = true;

			include_once WR_ISA_PATH . 'templates/shop/simple.php';
		}

		if ( $product->is_type( 'variable' ) ) {
			// Check if there is any product variation currently out of stock.
			$out_of_stock_variations = array();

			foreach( $product->get_available_variations() as $variation ) {
				if ( ! $variation['is_in_stock'] ) {
					$out_of_stock_variations[ $variation['variation_id'] ] = $variation['attributes'];
				}
			}

			if ( count( $out_of_stock_variations ) ) {
				// Include template to print HTML for subscription form.
				$enqueue_assets = true;

				include_once WR_ISA_PATH . 'templates/shop/variable.php';
			}
		}

		// Enqueue necessary assets.
		if ( isset( $enqueue_assets ) && $enqueue_assets ) {
			wp_enqueue_style(  WR_ISA, WR_ISA_URL . 'assets/css/frontend.css' );
			wp_enqueue_script( WR_ISA, WR_ISA_URL . 'assets/js/frontend.js'   );

			wp_localize_script( WR_ISA, 'wr_in_stock_alert', array(
				'product_type' => $product->get_type(),
				'out_of_stock' => ( isset( $out_of_stock_variations ) && count( $out_of_stock_variations ) ) ? $out_of_stock_variations : '',
				'server_error' => __( 'Server not responding. Please try again later!', 'wr-in-stock-alert' ),
			) );
		}
	}

	/**
	 * Method to track stock status update.
	 *
	 * @param   null|bool  $check       Whether to allow updating metadata for the given type.
	 * @param   int        $object_id   Object ID.
	 * @param   string     $meta_key    Meta key.
	 * @param   mixed      $meta_value  Meta value. Must be serializable if non-scalar.
	 *
	 * @return  void
	 */
	public static function track( $check, $object_id, $meta_key, $meta_value ) {
		if ( null === $check ) {
			// Check if '_stock_status' meta data is being updated.
			$updated = false;

			if ( '_stock_status' == $meta_key ) {
				// Get product.
				if ( $product = wc_get_product( $object_id ) ) {
					// Check if stock status is changed.
					if ( 'outofstock' == $product->stock_status && 'instock' == $meta_value ) {
						$updated = true;
					}
				}
			}

			if ( $updated ) {
				// Send notification emails.
				self::send_mails( $object_id );
			}
		}

		return $check;
	}

	/**
	 * Method to send out notification emails.
	 *
	 * @param   int  $product_id  ID of product to notify about.
	 *
	 * @return  void
	 */
	public static function send_mails( $product_id = null ) {
		// Check if this is a background request.
		if ( isset( $_GET['action'] ) && 'product-back-in-stock-notification' == $_GET['action'] ) {
			// Verify parameters.
			if ( ! isset( $_GET['product_id'] ) || ! isset( $_GET['nonce'] ) ) {
				wp_send_json_error( __( 'Missing parameters.', 'wr-in-stock-alert' ) );
			}

			// Get product.
			$product = wc_get_product( absint( $_GET['product_id'] ) );

			if ( ! $product ) {
				wp_send_json_error( __( 'Failed to get product data.', 'wr-in-stock-alert' ) );
			}

			// Verify nonce.
			$nonce = get_transient( "{$_GET['product_id']}_back_in_stock" );

			if ( ! $nonce || $nonce != $_GET['nonce'] ) {
				wp_send_json_error( __( 'Nonce verification fails.', 'wr-in-stock-alert' ) );
			}

			// Prepare WordPress file system object.
			global $wp_filesystem;

			if ( ! $wp_filesystem ) {
				if ( ! function_exists( 'WP_Filesystem' ) ) {
					include_once ABSPATH . 'wp-admin/includes/file.php';
				}

				WP_Filesystem();
			}

			// Get settings.
			$settings = WR_In_Stock_Alert_Settings::get();

			// Prepare email headers.
			$headers = array(
				"From: {$settings['from_name']} <{$settings['from_email']}>",
				'Content-Type: text/html',
			);

			// Prepare email subject.
			$subject = str_replace( '%PRODUCT%', $product->get_title(), $settings['email_subject'] );

			// Prepare email message.
			if ( 'WC_Product_Variation' == get_class( $product ) ) {
				// Get all custom attributes of the variable product.
				$product_attributes = array_filter( ( array ) get_post_meta( $product->get_id(), '_product_attributes', true ) );

				// Generate attribute data.
				$variation_info = array();

				foreach ( $product->get_variation_attributes() as $key => $value ) {
					$key = str_replace( 'attribute_', '', $key );

					if ( taxonomy_exists( $key ) ) {
						$html  = wc_attribute_label( $key ) . ': ';
						$terms = wc_get_product_terms( $product->get_id(), $key, array( 'fields' => 'all' ) );

						foreach ( $terms as $term ) {
							if ( $term->slug == $value ) {
								$html .= $term->name;
							}
						}
					} elseif ( isset( $product_attributes[ $key ] ) ) {
						$html = "{$product_attributes[ $key ]['name']}: {$value}";
					}

					$variation_info[] = $html;
				}

				if ( count( $variation_info ) ) {
					$message = str_replace(
						'%PRODUCT%',
						sprintf(
							__( '<a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a> (%3$s)<br>Price: %4$s<br>Link: %5$s', 'wr-in-stock-alert' ),
							get_permalink( $product->get_id() ),
							$product->get_title(),
							implode( ' - ', $variation_info ),
							html_entity_decode( strip_tags( $product->get_price_html() ) ),
							get_permalink( $product->get_id() )
						),
						$settings['email_message']
					);
				} else {
					$message = str_replace(
						'%PRODUCT%',
						sprintf(
							__( '<a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a><br>Price: %3$s<br>Link: %4$s', 'wr-in-stock-alert' ),
							get_permalink( $product->get_id() ),
							$product->get_title(),
							html_entity_decode( strip_tags( $product->get_price_html() ) ),
							get_permalink( $product->get_id() )
						),
						$settings['email_message']
					);
				}
			} else {
				$message = str_replace(
					'%PRODUCT%',
					sprintf(
						__( '<a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a><br>Price: %3$s<br>Link: %4$s', 'wr-in-stock-alert' ),
						get_permalink( $product->get_id() ),
						$product->get_title(),
						html_entity_decode( strip_tags( $product->get_price_html() ) ),
						get_permalink( $product->get_id() )
					),
					$settings['email_message']
				);
			}

			// Get all subscriptions for current product.
			$subscriptions = get_posts( array(
				'post_type'      => 'in_stock_alert',
				'post_parent'    => 'WC_Product_Variation' == get_class( $product ) ? $product->variation_id : $product->get_id(),
				'posts_per_page' => -1,
				'nopaging'       => true,
			) );

			// Loop thru subscriptions to send personalized notification email.
			$logs = $wp_filesystem->is_file( WR_ISA_PATH . 'logs.txt' ) ? $wp_filesystem->get_contents( WR_ISA_PATH . 'logs.txt' ) : '';
			$fail = false;

			foreach ( $subscriptions as $subscription ) {
				// Get subscriber's name and email.
				$name  = get_post_meta( $subscription->ID, 'name' , true );
				$email = get_post_meta( $subscription->ID, 'email', true );

				// Personalize email message.
				$_message = str_replace( '%NAME%', $name, $message );

				// Generate link to unsubscribe.
				$unsubscribe = add_query_arg(
					array(
						'action'  => 'unsubscribe-in-stock-alert',
						'product' => 'WC_Product_Variation' == get_class( $product ) ? $product->variation_id : $product->get_id(),
						'email'   => $email,
					),
					get_permalink( $product->get_id() )
				);

				// Insert URL to unsubscribe.
				$_message = str_replace( '%UNSUBSCRIBE%', $unsubscribe, $_message );

				// Send notification email.
				if ( ! wp_mail( $email, $subject, $_message, $headers ) ) {
					if ( ! empty( $logs ) ) {
						$logs .= "\n--------------------------------------------------------------------------------\n";
					}

					$logs .= sprintf(
						__( "Failed to send notification email to %s <%s>:\n\nSubject: %s\nMessage: %s", 'wr-in-stock-alert' ),
						$name,
						$email,
						$subject,
						$_message
					);

					$fail || ( $fail = true );
				}
			}

			// Store logs if has error.
			if ( $fail ) {
				$wp_filesystem->put_contents( WR_ISA_PATH . 'logs.txt', $logs );
			}
		}

		// Send background request.
		elseif ( ! empty( $product_id ) ) {
			// Generate nonce.
			$nonce = wp_create_nonce( "{$product_id}_back_in_stock" );

			// Store nonce to transient to verify later.
			set_transient( "{$product_id}_back_in_stock", $nonce, 5 * MINUTE_IN_SECONDS );

			// Generate URL to send background request.
			$url = admin_url( "admin-ajax.php?action=product-back-in-stock-notification&product_id={$product_id}&nonce={$nonce}" );

			// Parse URL.
			$parts = parse_url( $url );

			// Open new socket connection.
			$fp = fsockopen( $parts['host'], isset( $parts['port'] ) ? $parts['port'] : 80, $errno, $errstr, 30 );

			if ( ! $fp ) {
				return false;
			}

			// Create request header.
			$request  = "GET {$parts['path']}?{$parts['query']} HTTP/1.1\r\n";
			$request .= "Host: {$parts['host']}\r\n";
			$request .= "Content-Type: text/html\r\n";
			$request .= "Connection: Close\r\n\r\n";

			// Send background request.
			fwrite( $fp, $request );

			// Close socket connection.
			fclose( $fp );
		}
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
		$base = WR_ISA_PATH . 'includes/';
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
