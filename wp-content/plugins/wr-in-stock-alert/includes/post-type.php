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
 * Define class to register and manage custom post type to store subscription.
 */
class WR_In_Stock_Alert_Post_Type {
	/**
	 * Initialize.
	 *
	 * @return  void
	 */
	public static function initialize() {
		// Register `in_stock_alert` custom post type for storing subscription.
		register_post_type( 'in_stock_alert', array(
			'public'              => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'rewrite'             => false,
			'can_export'          => true,
			'delete_with_user'    => false,
			'labels'              => array(
				'name'      => __( 'In Stock Alert Subscriptions', 'wr-in-stock-alert' ),
				'menu_name' => __( 'In Stock Alert', 'wr-in-stock-alert' ),
				'all_items' => __( 'All Subscriptions', 'wr-in-stock-alert' ),
			),
		) );

		// Register action to remove submenu page to add new custom post type item.
		add_action( 'admin_menu', array( __CLASS__, 'remove_submenu_page' ) );

		// Register necessary actions / filters to customize All Items screen.
		global $pagenow;

		if ( 'edit.php' == $pagenow && isset( $_REQUEST['post_type'] ) && 'in_stock_alert' == $_REQUEST['post_type'] ) {
			add_filter( 'bulk_actions-edit-in_stock_alert', array( __CLASS__, 'bulk_actions'   ) );
			add_action( 'restrict_manage_posts'           , array( __CLASS__, 'filter_actions' ) );

			add_filter( 'posts_where', array( __CLASS__, 'filter_by_product' ) );

			add_filter( 'manage_in_stock_alert_posts_columns', array( __CLASS__, 'register_columns' )        );
			add_action( 'manage_posts_custom_column'         , array( __CLASS__, 'display_columns'  ), 10, 2 );

			add_action( 'admin_head'  , array( __CLASS__, 'hide_add_new_button' ) );
			add_action( 'admin_footer', array( __CLASS__, 'setup_export_action' ) );
		}

		// Register Ajax action to store subscription.
		add_action( 'wp_ajax_in-stock-alert-form-submission'       , array( __CLASS__, 'save' ) );
		add_action( 'wp_ajax_nopriv_in-stock-alert-form-submission', array( __CLASS__, 'save' ) );

		// Register Ajax action to export subscriptions to CSV file.
		add_action( 'wp_ajax_export-in-stock-alert-subscriptions-to-csv', array( __CLASS__, 'export' ) );
	}

	/**
	 * Remove submenu page to add new custom post type item.
	 *
	 * @return  void
	 */
	public static function remove_submenu_page() {
		// Remove submenu page to add new custom post type item.
		remove_submenu_page( 'edit.php?post_type=in_stock_alert', 'post-new.php?post_type=in_stock_alert' );
	}

	/**
	 * Setup bulk actions for All Items screen.
	 *
	 * @param   array  $actions  Current actions.
	 *
	 * @return  array
	 */
	public static function bulk_actions( $actions ) {
		// Remove edit action.
		unset( $actions['edit'] );

		return $actions;
	}

	/**
	 * Add support to filter subscriptions by product.
	 *
	 * @param   string  $post_type  Post type slug.
	 *
	 * @return  void
	 */
	public static function filter_actions( $post_type = null ) {
		if ( 'in_stock_alert' == $post_type ) {
			// Get all products that have subscriptions.
			global $wpdb;

			$products = $wpdb->get_results( "SELECT post_parent FROM {$wpdb->posts} WHERE post_type = 'in_stock_alert' GROUP BY post_parent" );

			if ( count( $products ) ) {
				// Get current filter.
				$product_filter = isset( $_REQUEST['post_parent'] ) ? absint( $_REQUEST['post_parent'] ) : 0;
				?>
				<label for="filter-by-product" class="screen-reader-text"><?php _e( 'Filter by product', 'wr-in-stock-alert' ); ?></label>
				<select name="post_parent" id="filter-by-product">
					<option value=""><?php _e( 'All products', 'wr-in-stock-alert' ); ?></option>
					<?php
					foreach ( $products as $product ) :

					// Get product.
					$product = wc_get_product( $product->post_parent );
					if ( $product ) :
					?>
					<option value="<?php echo esc_attr( $product->get_id() ); ?>" <?php selected( $product->get_id(), $product_filter ); ?>>
						<?php printf( __( '%1$s - %2$s', 'wr-in-stock-alert' ), $product->get_title(), $product->get_price_html() ); ?>
					</option>
					<?php
					endif;
					
					endforeach; ?>
				</select>
				<?php
			}
		}
	}

	/**
	 * Method to filter subscriptions by product.
	 *
	 * @param   string  $where  Current where statement.
	 *
	 * @return  string
	 */
	public static function filter_by_product( $where ) {
		// Get current filter.
		$product_filter = isset( $_REQUEST['post_parent'] ) ? absint( $_REQUEST['post_parent'] ) : 0;

		if ( $product_filter ) {
			$where .= " AND post_parent = {$product_filter}";
		}

		return $where;
	}

	/**
	 * Register columns for All Items screen.
	 *
	 * @param   array  $columns  Current columns.
	 *
	 * @return  array
	 */
	public static function register_columns( $columns ) {
		$columns = array(
			'cb'      => '<input type="checkbox" />',
			'name'    => __( 'Name', 'wr-in-stock-alert' ),
			'email'   => __( 'Email', 'wr-in-stock-alert' ),
			'product' => __( 'Product', 'wr-in-stock-alert' ),
			'time'    => __( 'Subscribed at', 'wr-in-stock-alert' ),
		);

		return $columns;
	}

	/**
	 * Display columns for All Items screen.
	 *
	 * @param   array  $column   Column to display content for.
	 * @param   int    $post_id  Post ID to display content for.
	 *
	 * @return  array
	 */
	public static function display_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'name' :
				echo esc_html( get_post_meta( $post_id, 'name', true ) );
			break;

			case 'email' :
				echo esc_html( get_post_meta( $post_id, 'email', true ) );
			break;

			case 'product' :
				// Get product.
				if ( $post = get_post( $post_id ) ) {
					if ( $product = wc_get_product( $post->post_parent ) ) {
						echo '<div class="clearfix">';

						// Get product ID.
						$product_id = 'WC_Product_Variation' == get_class( $product ) ? $product->parent->id : $product->get_id();

						// Get product thumbnail.
						if ( $thumb = $product->get_image() ) {
							echo '<div style="float: left;">';
							echo '<a href="' . get_edit_post_link( $product_id ) . '" target="_blank" rel="noopener noreferrer">';
							echo $thumb . '</a></div>';
						}

						// Show product info.
						echo '<div style="float: left;">';
						echo '<a href="' . get_edit_post_link( $product_id ) . '" target="_blank" rel="noopener noreferrer">';
						echo '<strong>' . esc_html( $product->get_title() ) . '</strong></a>';
						echo '<p>' . $product->get_price_html() . '</p></div>';

						echo '</div>';
					} else {
						printf( __( 'Failed to get info for product ID %d', 'wr-in-stock-alert' ), $post->post_parent );
					}
				} else {
					_e( 'Failed to get linked product.', 'wr-in-stock-alert' );
				}
			break;

			case 'time' :
				// Get subscription.
				if ( $post = get_post( $post_id ) ) {
					$zone = get_post_meta( $post_id, 'timezone', true );
					$time = strtotime( $post->post_date ) + ( $zone * HOUR_IN_SECONDS );

					echo date( 'D, d M Y H:i:s', $time ) . ' GMT' . ( $zone >= 0 ? '+' : '-' ) . absint( $zone );
				} else {
					_e( 'Failed to get subscription time.', 'wr-in-stock-alert' );
				}
			break;
		}
	}

	/**
	 * Hide Add New button in All Subscriptions screen.
	 *
	 * @return  void
	 */
	public static function hide_add_new_button() {
		?>
		<style type="text/css">
			.wrap h1 a.page-title-action, .wrap .row-actions { display: none; visibility: hidden; }
		</style>
		<?php
	}

	/**
	 * Setup export to CSV action.
	 *
	 * @return  void
	 */
	public static function setup_export_action() {
		// Include template to print HTML for export to CSV action.
		include WR_ISA_PATH . 'templates/admin/export.php';
	}

	/**
	 * Method to save subscription.
	 *
	 * @return  void
	 */
	public static function save() {
		// Get settings.
		$settings = WR_In_Stock_Alert_Settings::get();

		// Get request variables.
		$name     = isset( $_REQUEST['name'    ] ) ? sanitize_text_field( $_REQUEST['name'    ] ) : null;
		$email    = isset( $_REQUEST['email'   ] ) ? sanitize_text_field( $_REQUEST['email'   ] ) : null;

		$product  = isset( $_REQUEST['product' ] ) ? absint( $_REQUEST['product' ] ) : null;
		$timezone = isset( $_REQUEST['timezone'] ) ? intval( $_REQUEST['timezone'] ) : null;

		if ( ( $settings['show_name_field'] && ! $name ) || ! $email || ! $product ) {
			wp_send_json_error( __( 'Missing required data!', 'wr-in-stock-alert' ) );
		}

		if ( ! is_email( $email ) ) {
			wp_send_json_error( __( 'Invalid email address!', 'wr-in-stock-alert' ) );
		}

		// Check if request is saved before.
		$subscriptions = get_posts( array(
			'post_type'   => 'in_stock_alert',
			'post_parent' => ( int ) $product,
			'meta_query'  => array(
				array(
					'key'   => 'email',
					'value' => $email,
				),
			)
		) );

		if ( count( $subscriptions ) ) {
			wp_send_json_success( __( 'You already subscribed to receive in stock alert for this product before.', 'wr-in-stock-alert' ) );
		}

		// Store subscription to database.
		$id = wp_insert_post( array(
			'post_type'   => 'in_stock_alert',
			'post_parent' => ( int ) $product,
			'post_status' => 'publish',
			'post_title'  => sanitize_text_field( sprintf(
				__( '%1$s (%2$s) subscription for product ID %3$d', 'wr-in-stock-alert' ),
				$name,
				$email,
				$product
			) ),
		) );

		if ( $id && ! is_wp_error( $id ) ) {
			// Store name and email to post meta.
			update_post_meta( $id, 'name'    , $name                  );
			update_post_meta( $id, 'email'   , $email                 );
			update_post_meta( $id, 'timezone', 0 - ( $timezone / 60 ) );

			// Do an action to allow custom hook from outside.
			do_action( 'saved_in_stock_alert_subscription', array(
				'id'         => $id,
				'name'       => $name,
				'email'      => $email,
				'product_id' => $product,
				'timezone'   => $timezone,
			) );

			// Send response back.
			wp_send_json_success(
				'<img src="' . esc_url( WR_ISA_URL . 'assets/images/success.png' ) . '" alt="' . __( 'Success', 'wr-in-stock-alert' ) . '">
				<br>' . wp_kses_post( nl2br( $settings['thank_you_message'] ) )
			);
		}

		wp_send_json_error( __( 'We failed to store your subscription to our database. Please try again later!', 'wr-in-stock-alert' ) );
	}

	/**
	 * Export subscriptions to CSV file.
	 *
	 * @return  void
	 */
	public static function export() {
		// Get request variables.
		$ids     = isset( $_REQUEST['post'       ] ) ? array_map( 'absint', $_REQUEST['post'       ] ) : null;
		$search  = isset( $_REQUEST['s'          ] ) ? sanitize_text_field( $_REQUEST['s'          ] ) : null;
		$month   = isset( $_REQUEST['m'          ] ) ? sanitize_text_field( $_REQUEST['m'          ] ) : null;
		$product = isset( $_REQUEST['post_parent'] ) ? sanitize_text_field( $_REQUEST['post_parent'] ) : null;
		$nonce   = isset( $_REQUEST['_wpnonce'   ] ) ? sanitize_text_field( $_REQUEST['_wpnonce'   ] ) : null;

		// Verify nonce.
		if ( empty( $nonce ) || ! wp_verify_nonce( $nonce, 'export-in-stock-alert-subscriptions-to-csv' ) ) {
			wp_send_json_error( __( 'Nonce varification failed.', 'wr-in-stock-alert' ) );
		}

		// Get subscriptions to export.
		$args = array(
			'post_type'      => 'in_stock_alert',
			'posts_per_page' => -1,
			'nopaging'       => true,
		);

		if ( count( $ids ) ) {
			$args['post__in'] = $ids;
		} else {
			if ( ! empty( $search ) ) {
				$args['s'] = $search;
			}

			if ( ! empty( $month ) ) {
				$args['m'] = $month;
			}

			if ( ! empty( $product ) ) {
				$args['post_parent'] = $product;
			}
		}

		$subscriptions = get_posts( $args );

		if ( ! count( $subscriptions ) ) {
			wp_send_json_error( __( 'Not found any subscription to export.', 'wr-in-stock-alert' ) );
		}

		// Generate CSV data.
		$csv[] = implode( ',', array(
			__( 'Name', 'wr-in-stock-alert' ),
			__( 'Email', 'wr-in-stock-alert' ),
			__( 'Product ID', 'wr-in-stock-alert' ),
			__( 'Product Title', 'wr-in-stock-alert' ),
			__( 'Product Price', 'wr-in-stock-alert' ),
		) );

		foreach ( $subscriptions as $subscription ) {
			// Get product.
			if ( ! isset( $products ) || ! isset( $products[ $subscription->post_parent ] ) ) {
				$products[ $subscription->post_parent ] = wc_get_product( $subscription->post_parent );
			}

			// Store CSV data.
			$csv[] = implode( ',', array(
				get_post_meta( $subscription->ID, 'name' , true ),
				get_post_meta( $subscription->ID, 'email', true ),
				$products[ $subscription->post_parent ]->id,
				$products[ $subscription->post_parent ]->get_title(),
				html_entity_decode( strip_tags( $products[ $subscription->post_parent ]->get_price_html() ) ),
			) );
		}

		// Force inline download.
		header( 'Content-Type: application/csv' );
		header( 'Content-Disposition: attachment; filename=' . ( time() + rand( -999999, 999999 ) ) . '.csv' );
		header( 'Pragma: no-cache' );

		echo implode( "\r\n", $csv );

		exit;
	}
}
