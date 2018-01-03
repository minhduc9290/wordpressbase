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
 * Define class to display and save settings for the plugin.
 */
class WR_In_Stock_Alert_Settings {
	/**
	 * Initialize.
	 *
	 * @return  void
	 */
	public static function initialize() {
		// Register action to add settings.
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );

		// Register action to add admin page.
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );

		// Get current settings.
		$settings = self::get();

		// Initialize MailChimp integration if enabled.
		if ( $settings['enable_mailchimp'] ) {
			WR_In_Stock_Alert_Mailchimp::initialize();
		}
	}

	/**
	 * Register settings for In Stock Alert.
	 *
	 * @return  void
	 */
	public static function admin_init() {
		// Check if settings form is submitted?
		global $pagenow;

		if ( 'edit.php' == $pagenow && 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			if ( 'in_stock_alert' == $_REQUEST['post_type'] && WR_ISA . '-settings' == $_REQUEST['page'] ) {
				// Save settings.
				self::save();
			}
		}

		// Get current settings.
		$settings = self::get();

		// Define setting fields for In Stock Alert.
		$fields = array(
			'mailchimp_section' => array(
				'title'    => __( 'MailChimp Integration', 'wr-in-stock-alert' ),
				'settings' => array(
					array(
						'id'       => 'enable_mailchimp',
						'title'    => __( 'Enable?', 'wr-in-stock-alert' ),
						'type'     => 'checkbox',
						'children' => 'input[name^="mailchimp_"]',
					),
					array(
						'id'    => 'mailchimp_username',
						'title' => __( 'MailChimp Username', 'wr-in-stock-alert' ),
						'class' => $settings['enable_mailchimp'] ? '' : 'hidden',
						'type'  => 'text',
					),
					array(
						'id'    => 'mailchimp_api_key',
						'title' => __( 'MailChimp API Key', 'wr-in-stock-alert' ),
						'class' => $settings['enable_mailchimp'] ? '' : 'hidden',
						'type'  => 'text',
					),
					array(
						'id'    => 'mailchimp_list_id',
						'title' => __( 'MailChimp List ID', 'wr-in-stock-alert' ),
						'class' => $settings['enable_mailchimp'] ? '' : 'hidden',
						'type'  => 'text',
					),
				),
			),
			'notification_section' => array(
				'title'    => __( 'Notification Settings', 'wr-in-stock-alert' ),
				'settings' => array(
					array(
						'id'          => 'from_name',
						'title'       => __( 'From Name', 'wr-in-stock-alert' ),
						'type'        => 'text',
						'placeholder' => __( 'Shop Admin', 'wr-in-stock-alert' ),
					),
					array(
						'id'          => 'from_email',
						'title'       => __( 'From Email', 'wr-in-stock-alert' ),
						'type'        => 'text',
						'placeholder' => __( 'admin@shop.com', 'wr-in-stock-alert' ),
					),
					array(
						'id'    => 'email_subject',
						'title' => __( 'Email Subject', 'wr-in-stock-alert' ),
						'type'  => 'text',
					),
					array(
						'id'    => 'email_message',
						'title' => __( 'Email Message', 'wr-in-stock-alert' ),
						'type'  => 'textarea',
					),
				),
			),
			'frontend_section' => array(
				'title'    => __( 'Frontend Settings', 'wr-in-stock-alert' ),
				'settings' => array(
					array(
						'id'    => 'inline_button_text',
						'title' => __( 'Inline Button Text', 'wr-in-stock-alert' ),
						'type'  => 'text',
					),
					array(
						'id'       => 'show_popup_title',
						'title'    => __( 'Show Popup Title?', 'wr-in-stock-alert' ),
						'type'     => 'checkbox',
						'children' => 'input[name="popup_title"]',
					),
					array(
						'id'    => 'popup_title',
						'title' => __( 'Popup Title', 'wr-in-stock-alert' ),
						'class' => $settings['show_popup_title'] ? '' : 'hidden',
						'type'  => 'text',
					),
					array(
						'id'    => 'popup_message',
						'title' => __( 'Popup Message', 'wr-in-stock-alert' ),
						'type'  => 'textarea',
					),
					array(
						'id'       => 'show_name_field',
						'title'    => __( 'Show Name Field?', 'wr-in-stock-alert' ),
						'type'     => 'checkbox',
						'children' => 'input[name="name_field_label"]',
					),
					array(
						'id'    => 'name_field_label',
						'title' => __( 'Name Field Label', 'wr-in-stock-alert' ),
						'class' => $settings['show_name_field'] ? '' : 'hidden',
						'type'  => 'text',
					),
					array(
						'id'    => 'email_field_label',
						'title' => __( 'Email Field Label', 'wr-in-stock-alert' ),
						'type'  => 'text',
					),
					array(
						'id'    => 'popup_button_text',
						'title' => __( 'Submit Button Text', 'wr-in-stock-alert' ),
						'type'  => 'text',
					),
					array(
						'id'    => 'thank_you_message',
						'title' => __( 'Thank You Message', 'wr-in-stock-alert' ),
						'type'  => 'textarea',
					),
				),
			),
		);

		// Register setting fields with WordPress.
		foreach ( $fields as $section => $define ) {
			// Add settings section.
			add_settings_section( $section, $define['title'], '__return_null', WR_ISA . '-settings' );

			// Add settings.
			foreach ( $define['settings'] as $field ) {
				// Generate field arguments.
				$args = array(
					'id'        => $field['id'],
					'value'     => $settings[ $field['id'] ],
					'label_for' => $field['id'],
				);

				if ( isset( $field['class'] ) && ! empty( $field['class'] ) ) {
					$args['class'] = $field['class'];
				}

				if ( isset( $field['children'] ) && ! empty( $field['children'] ) ) {
					$args['children'] = $field['children'];
				}

				if ( isset( $field['placeholder'] ) && ! empty( $field['placeholder'] ) ) {
					$args['placeholder'] = $field['placeholder'];
				}

				// Generate call-back function.
				$callback = ( isset( $field['type'] ) ? "display_{$field['type']}_field" : "display_{$field['id']}_field" );

				// Register setting field.
				add_settings_field(
					$field['id'],
					$field['title'],
					array( __CLASS__, $callback ),
					WR_ISA . '-settings',
					$section,
					$args
				);
			}
		}
	}

	/**
	 * Add admin page to configure the plugin.
	 *
	 * @return  void
	 */
	public static function admin_menu() {
		add_submenu_page(
			'edit.php?post_type=in_stock_alert',
			__( 'In Stock Alert Settings', 'wr-in-stock-alert' ),
			__( 'Settings', 'wr-in-stock-alert' ),
			'manage_woocommerce',
			WR_ISA . '-settings',
			array( __CLASS__, 'display' )
		);
	}

	/**
	 * Get current settings.
	 *
	 * @return  array
	 */
	public static function get() {
		// Get saved settings.
		$settings = get_option( str_replace( '-', '_', WR_ISA ) );

		// Define default setting values.
		$default = array(
			'enable_mailchimp'   => 0,
			'mailchimp_username' => '',
			'mailchimp_api_key'  => '',
			'mailchimp_list_id'  => '',

			'from_name'     => 'WordPress',
			'email_subject' => __( 'The product %PRODUCT% is get in stock now', 'wr-in-stock-alert' ),
			'email_message' => __(
				'
Hello %NAME%,

You&#39;ve subscribed to get notification when the following product get back in stock.

%PRODUCT%

We want to let you know that the product you interested in is in stock now.

Thank you for your patience and support!

----------

Click the following link to <a href="%UNSUBSCRIBE%" target="_blank" rel="noopener noreferrer">stop receiving notification</a> about the stock status of this product:

%UNSUBSCRIBE%
				',
				'wr-in-stock-alert'
			),

			'inline_button_text' => __( 'Email me when this product back in stock', 'wr-in-stock-alert' ),
			'show_popup_title'   => 1,
			'popup_title'        => __( 'In Stock Alert', 'wr-in-stock-alert' ),
			'popup_message'      => __( 'Are you interested in the product but it&#39;s out of stock? Fill in the form below to be notified when the product back in stock...', 'wr-in-stock-alert' ),
			'show_name_field'    => 1,
			'name_field_label'   => __( 'Your name', 'wr-in-stock-alert' ),
			'email_field_label'  => __( 'Your email', 'wr-in-stock-alert' ),
			'popup_button_text'  => __( 'Submit', 'wr-in-stock-alert' ),
			'thank_you_message'  => __( 'Your subscription has been saved successfully. Thank you for your interest!', 'wr-in-stock-alert' ),
		);

		// Set default from email.
		$sitename = strtolower( $_SERVER['SERVER_NAME'] );

		$default['from_email'] = 'wordpress@' . ( substr( $sitename, 0, 4 ) == 'www.' ? substr( $sitename, 4 ) : $sitename );

		// Apply default setting values.
		foreach ( $default as $setting => $value ) {
			if ( ! isset( $settings[ $setting ] ) || empty( $settings[ $setting ] ) ) {
				$settings[ $setting ] = $value;
			}
		}

		// Prepare setting values.
		foreach ( $settings as $setting => $value ) {
			if ( 'enable_mailchimp' == $setting ) {
				$settings[ $setting ] = intval( $settings[ $setting ] );
			} else {
				$settings[ $setting ] = str_replace(
					array( '\r\n', '\r', '\n', "\r\n", "\r", "\n", '\\' ),
					array( '<br>', '<br>', '<br>', '<br>', '<br>', '<br>', '' ),
					$settings[ $setting ]
				);
			}
		}

		return $settings;
	}

	/**
	 * Display settings form.
	 *
	 * @return  void
	 */
	public static function display() {
		// Include template to print HTML for the settings screen.
		include WR_ISA_PATH . 'templates/admin/settings.php';
	}

	/**
	 * Display checkbox field.
	 *
	 * @param   array  $args  Field arguments.
	 *
	 * @return  void
	 */
	public static function display_checkbox_field( $args ) {
		?>
		<input type="checkbox" value="1" id="<?php
			esc_attr_e( $args['id'] );
		?>" name="<?php
			esc_attr_e( $args['id'] );
		?>" <?php
			checked( $args['value'], 1 );
		?>>
		<?php if  ( isset( $args['children'] ) ) : ?>
		<script type="text/javascript">
			(function($) {
				$('#<?php esc_attr_e( $args['id'] ); ?>').change(function() {
					var action = this.checked ? 'remove' : 'add';

					$(this).closest('tr').siblings().find('<?php echo '' . $args['children']; ?>').closest('tr')[action + 'Class']('hidden');
				});
			})(jQuery);
		</script>
		<?php endif;
	}

	/**
	 * Display text field.
	 *
	 * @param   array  $args  Field arguments.
	 *
	 * @return  void
	 */
	public static function display_text_field( $args ) {
		?>
		<input type="text" class="regular-text" id="<?php
			esc_attr_e( $args['id'] );
		?>" name="<?php
			esc_attr_e( $args['id'] );
		?>" value="<?php
			esc_attr_e( $args['value'] );
		?>" placeholder="<?php
			isset( $args['placeholder'] ) ? esc_attr_e( $args['placeholder'] ) : '';
		?>">
		<?php
	}

	/**
	 * Display textarea field.
	 *
	 * @param   array  $args  Field arguments.
	 *
	 * @return  void
	 */
	public static function display_textarea_field( $args ) {
		?>
		<textarea class="regular-text" id="<?php
			esc_attr_e( $args['id'] );
		?>" name="<?php
			esc_attr_e( $args['id'] );
		?>" placeholder="<?php
			isset( $args['placeholder'] ) ? esc_attr_e( $args['placeholder'] ) : '';
		?>"><?php
			echo wp_kses_post( str_replace( array( '<br>', '\\' ), array( "\r\n", '' ), $args['value'] ) );
		?></textarea>
		<?php
	}

	/**
	 * Save settings.
	 *
	 * @return  void
	 */
	protected static function save() {
		// Get current settings.
		$settings = self::get();

		// Loop thru settings to update.
		$changed = false;

		foreach ( $settings as $setting => $value ) {
			if ( ! isset( $_POST[ $setting ] ) ) {
				$settings[ $setting ] = 0;

				$changed || ( $changed = true );
			}

			else {
				$_POST[ $setting ] = esc_sql( str_replace( '\\', '', trim( $_POST[ $setting ] ) ) );

				if ( $value != $_POST[ $setting ] ) {
					$settings[ $setting ] = $_POST[ $setting ];

					$changed || ( $changed = true );
				}
			}
		}

		// Save new settings.
		if ( $changed ) {
			$_POST['saved'] = update_option( str_replace( '-', '_', WR_ISA ), $settings );
		} else {
			$_POST['saved'] = true;
		}
	}
}
