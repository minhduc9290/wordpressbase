<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    Opal_ThemeControl
 * @author     WpOpal Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2016 http://www.opalthemer.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.opalthemer.com
 * @support  http://www.opalthemer.com/questions/
 */

/**
 * Plug Opal ThemeControl theme options into WordPress Theme Customize.
 *
 * @package  Opal_ThemeControl
 * @since    1.0
 */
class Opal_Themecontrol_Customize_Options_WooCommerce {
	public static function get_options() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
		// Check some plugins is activate
		$opal_is_cf7_activated = is_plugin_active( 'contact-form-7/wp-contact-form-7.php' );
		$opal_is_yith_wish_list_activated     = is_plugin_active( 'yith-woocommerce-wishlist/init.php' );
		$opal_is_yith_wish_list_pre_activated = is_plugin_active( 'yith-woocommerce-wishlist-premium/init.php' );
		$opal_is_yith_compare_activated     = is_plugin_active( 'yith-woocommerce-compare/init.php' );
		$opal_is_yith_compare_pre_activated = is_plugin_active( 'yith-woocommerce-compare-premium/init.php' );

		// Get all contact form 7.
		$opal_cf7_query = new WP_Query(
			array(
				'posts_per_page' => -1,
				'post_type'      => 'wpcf7_contact_form',
				'post_status'    => 'publish',
			)
		);
		$opal_cf7_list = array( '0' => '-- Select Form --' );

		if ( $opal_cf7_query->post_count ) {
			foreach( $opal_cf7_query->posts as $val ){
				$opal_cf7_list[ $val->ID ] = $val->post_title;
			}
		};

		return array(
			'title'       => esc_html__( 'WooCommerce', 'opal-themecontrol' ),
			'description' => '<a target="_blank" href="http://opalthemer.com/docs/document/woocommerce"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
			'priority'    => 40,
			'sections' => array(
				'wc_general' => array(
					'title'    => esc_html__( 'General', 'opal-themecontrol' ),
					'settings' => array(
						'wc_archive_catalog_mode' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_archive_catalog_mode_price' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_archive_catalog_mode_button' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_archive_catalog_mode_button_text' => array(
							'default'           => esc_html__( 'Call Me', 'opal-themecontrol' ),
							'sanitize_callback' => '',
						),
						'wc_archive_catalog_mode_button_action' => array(
							'default'           => 'simple',
							'sanitize_callback' => '',
						),
						'wc_archive_catalog_mode_button_action_simple' => array(
							'default'           => 'skype:your_skype?chat',
							'sanitize_callback' => '',
						),
						'wc_archive_catalog_mode_button_action_cf7' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_general_breadcrumb' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_general_compare' =>
							( ( $opal_is_yith_compare_activated || $opal_is_yith_compare_pre_activated ) ? array(
								'default'           => 1,
								'sanitize_callback' => ''
							) : array()
						),
						'wc_general_wishlist' =>
							( ( $opal_is_yith_wish_list_activated || $opal_is_yith_wish_list_pre_activated ) ? array(
								'default'           => 1,
								'sanitize_callback' => '',
							) : array()
						),
						'wc_general_quickview' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_buynow_btn' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_disable_btn_atc' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_buynow_checkout' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_buynow_payment_info' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_icon_set' => array(
							'default'           => 'set-6',
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'wc_archive_catalog_mode' => array(
							'label'       => esc_html__( 'Enable Catalog Mode', 'opal-themecontrol' ),
							'description' => esc_html__( 'Turn off all e-commerce elements and transform your eCommerce store into an online catalog.', 'opal-themecontrol' ),
							'section'     => 'wc_general',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_archive_catalog_mode_price' => array(
							'label'    => esc_html__( 'Enable Price', 'opal-themecontrol' ),
							'section'  => 'wc_general',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'wc_archive_catalog_mode == 1' ),
						),
						'wc_archive_catalog_mode_button' => array(
							'label'       => esc_html__( 'Enable Custom Button', 'opal-themecontrol' ),
							'description' => esc_html__( 'Add a custom button in single product.', 'opal-themecontrol' ),
							'section'     => 'wc_general',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array( 'wc_archive_catalog_mode == 1' ),
						),
						'wc_archive_catalog_mode_button_text' => array(
							'label'    => esc_html__( 'Button Text', 'opal-themecontrol' ),
							'section'  => 'wc_general',
							'type'     => 'text',
							'required' => array(
								'wc_archive_catalog_mode_button == 1',
								'wc_archive_catalog_mode == 1'
							),
						),
						'wc_archive_catalog_mode_button_action' => array(
							'label'    => esc_html__( 'Button Type', 'opal-themecontrol' ),
							'section'  => 'wc_general',
							'type'     => 'select',
							'choices'  =>
								( $opal_is_cf7_activated ? array(
									'simple' => esc_html__( 'Simple Text or Link', 'opal-themecontrol' ),
									'cf7'    => esc_html__( 'Contact Form 7', 'opal-themecontrol' ),
								): array(
									'simple' => esc_html__( 'Simple Text or Link', 'opal-themecontrol' ),
								) ),
							'required' => array(
								'wc_archive_catalog_mode_button == 1',
								'wc_archive_catalog_mode == 1'
							),
						),
						'wc_archive_catalog_mode_button_action_simple' => array(
							'label'    => esc_html__( 'Action For Button', 'opal-themecontrol' ),
							'section'  => 'wc_general',
							'type'     => 'text',
							'required' => array(
								'wc_archive_catalog_mode_button_action == simple',
								'wc_archive_catalog_mode_button == 1',
								'wc_archive_catalog_mode == 1'
							),
						),
						'wc_archive_catalog_mode_button_action_cf7' => array(
							'label'    => esc_html__( 'Select Form', 'opal-themecontrol' ),
							'section'  => 'wc_general',
							'type'     => 'select',
							'choices'  => $opal_cf7_list,
							'required' => array(
								'wc_archive_catalog_mode_button_action == cf7',
								'wc_archive_catalog_mode_button == 1',
								'wc_archive_catalog_mode == 1'
							),
						),
						'wc_general_breadcrumb' => array(
							'label'    => esc_html__( 'Show Breadcrumb', 'opal-themecontrol' ),
							'section'  => 'wc_general',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'wc_single_style != 5' )
						),
						'wc_general_compare' =>
							( ( $opal_is_yith_compare_activated || $opal_is_yith_compare_pre_activated ) ? array(
								'label'    => esc_html__( 'Enable Product Comparision', 'opal-themecontrol' ),
								'section'  => 'wc_general',
								'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
								'required' => array( 'wc_archive_catalog_mode == 0' )
							): array()
						),
						'wc_general_wishlist' =>
							( ( $opal_is_yith_wish_list_activated || $opal_is_yith_wish_list_pre_activated ) ? array(
								'label'   => esc_html__( 'Enable Wishlist', 'opal-themecontrol' ),
								'section' => 'wc_general',
								'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
								'required' => array( 'wc_archive_catalog_mode == 0' ),
							) : array()
						),
						'wc_general_quickview' => array(
							'label'   => esc_html__( 'Enable Quickview', 'opal-themecontrol' ),
							'section' => 'wc_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_buynow_btn' => array(
							'label'       => esc_html__( 'Enable "buy now" button', 'opal-themecontrol' ),
							'description' => esc_html__( 'The "Buy Now" button you can see on the single item of Shop Category page.', 'opal-themecontrol' ),
							'section'     => 'wc_general',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array( 'wc_archive_catalog_mode == 0' ),
						),
						'wc_disable_btn_atc' => array(
							'label'    => esc_html__( 'Disable "add to cart" button', 'opal-themecontrol' ),
							'section'  => 'wc_general',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'wc_archive_catalog_mode = 0',
								'wc_buynow_btn = 1'
							),
						),
						'wc_buynow_checkout' => array(
							'label'    => esc_html__( 'Checkout Product', 'opal-themecontrol' ),
							'section'  => 'wc_general',
							'type'     => 'select',
							'choices'  => array(
								'1' => esc_html__( 'Checkout Current Product Only', 'opal-themecontrol' ),
								'2' => esc_html__( 'Checkout All Products In Cart', 'opal-themecontrol' ),
							),
							'required' => array(
								'wc_archive_catalog_mode = 0',
								'wc_buynow_btn = 1'
							),
						),
						'wc_buynow_payment_info' => array(
							'label'       => esc_html__( 'Button Action', 'opal-themecontrol' ),
							'description' => esc_html__( 'After clicking on "Buy Now" button the user would see payment information type.', 'opal-themecontrol' ),
							'section'     => 'wc_general',
							'type'        => 'select',
							'choices'     => array(
								'1' => esc_html__( 'Show Popup Window', 'opal-themecontrol' ),
								'2' => esc_html__( 'Redirect To Checkout Page', 'opal-themecontrol' ),
							),
							'required' => array(
								'wc_archive_catalog_mode = 0',
								'wc_buynow_btn = 1'
							),
						),
						'wc_icon_set' => array(
							'label'   => esc_html__( 'Icon Set', 'opal-themecontrol' ),
							'section' => 'wc_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Select_Image',
							'choices' => array(
								'set-1'  => '',
								'set-2'  => '',
								'set-3'  => '',
								'set-4'  => '',
								'set-5'  => '',
								'set-6'  => '',
							),
						),
					),
				),
				'product_list' => array(
					'title'    => esc_html__( 'Product List', 'opal-themecontrol' ),
					'settings' => array(
						'wc_archive_general_heading' => array(),
						'wc_archive_style' => array(
							'default'           => 'grid',
							'sanitize_callback' => '',
						),
						'wc_archive_border_wrap' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_archive_layout' => array(
							'default'           => 'no-sidebar',
							'sanitize_callback' => '',
						),
						'wc_archive_custom_widget' => array(
							'default'           => 1,
						),
						'wc_archive_sidebar_sticky' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_archive_layout_column' => array(
							'default'           => 4,
							'sanitize_callback' => '',
						),
						'wc_archive_number_products' => array(
							'default'           => 12,
							'sanitize_callback' => '',
						),
						'wc_archive_style_heading' => array(),
						// 'wc_archive_pagination_type' => array(
						// 	'default'           => 'number',
						// 	'sanitize_callback' => '',
						// ),
						'wc_archive_page_title' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_archive_page_title_content' => array(
							'default'           => esc_html__( 'Welcome to My Store', 'opal-themecontrol' ),
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'wc_archive_item_heading' => array(),
						'wc_archive_item_layout' => array(
							'default'           => '1',
							'sanitize_callback' => '',
						),
						'wc_archive_item_hover_style' => array(
							'default'           => 'default',
							'sanitize_callback' => '',
						),
						'wc_archive_item_mask_color' => array(
							'default'           => 'rgba(0, 0, 0, 0.7)',
							'sanitize_callback' => '',
						),
						'wc_archive_item_transition' => array(
							'default'           => 'fade',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'wc_archive_item_animation' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_archive_full_width' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'wc_archive_general_heading' => array(
							'label'   => esc_html__( 'General', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'product_list',
						),
						'wc_archive_page_title' => array(
							'label'   => esc_html__( 'Show Page Title', 'opal-themecontrol' ),
							'section' => 'product_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_archive_page_title_content' => array(
							'label'    => esc_html__( 'Page Title Content', 'opal-themecontrol' ),
							'section'  => 'product_list',
							'type'     => 'text',
							'required' => array( 'wc_archive_page_title != 0' ),
						),
						'wc_archive_layout' => array(
							'label'       => esc_html__( 'Sidebar Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select a sidebar layout', 'opal-themecontrol' ),
							'section'     => 'product_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'left-sidebar'  => array(
									'html'  => '<div class="icon-cols icon-sidebar icon-left-sidebar"></div>',
									'title' => esc_html__( 'Sidebar on the left content', 'opal-themecontrol' ),
								),
								'no-sidebar'  => array(
									'html'  => '<div class="icon-cols icon-sidebar icon-no-sidebar"></div>',
									'title' => esc_html__( 'Without Sidebar', 'opal-themecontrol' ),
								),
								'right-sidebar'  => array(
									'html'  => '<div class="icon-cols icon-sidebar icon-right-sidebar"></div>',
									'title' => esc_html__( 'Sidebar on the right content', 'opal-themecontrol' ),
								),
							),
						),
						'wc_archive_sidebar_sticky' => array(
							'label'       => esc_html__( 'Enable Sticky Sidebar', 'opal-themecontrol' ),
							'section'     => 'product_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array( 'wc_archive_layout != no-sidebar' ),
						),
						'wc_archive_custom_widget' => array(
							'section' => 'product_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="widget_styles">' . esc_html__( 'Customize Widget Styles', 'opal-themecontrol' ) . '</a></h3>',
							),
							'required' => array( 'wc_archive_layout != no-sidebar' ),
						),
						'wc_archive_style_heading' => array(
							'label'   => esc_html__( 'Product List', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'product_list',
						),
						'wc_archive_style' => array(
							'label'       => esc_html__( 'Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select a layout for product list.', 'opal-themecontrol' ),
							'section'     => 'product_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'grid'  => array(
									'html'  => '<div class="icon-cols icon-grid"></div>',
									'title' => esc_html__( 'Grid', 'opal-themecontrol' ),
								),
								'list'  => array(
									'html' => '<div class="icon-cols icon-list"><span></span></div>',
									'title' => esc_html__( 'List', 'opal-themecontrol' ),
								),
							),
						),
						'wc_archive_border_wrap' => array(
							'label'       => esc_html__( 'Enable Border Wrap', 'opal-themecontrol' ),
							'description' => esc_html__( 'Enable border wrap to each product item.', 'opal-themecontrol' ),
							'section'     => 'product_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array(
								'wc_archive_style = grid',
								//'wc_archive_pagination_type = number'
							),
						),
						'wc_archive_layout_column' => array(
							'label'   => esc_html__( 'Number Of Columns', 'opal-themecontrol' ),
							'section' => 'product_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'2'  => array(
									'html'  => '<div class="icon-cols cols-small icon-2cols"></div>',
									'title' => esc_html__( '2 Columns', 'opal-themecontrol' ),
								),
								'3'  => array(
									'html' => '<div class="icon-cols cols-small icon-3cols"></div>',
									'title' => esc_html__( '3 Columns', 'opal-themecontrol' ),
								),
								'4'  => array(
									'html' => '<div class="icon-cols cols-small icon-4cols"></div>',
									'title' => esc_html__( '4 Columns', 'opal-themecontrol' ),
								),
								'6'  => array(
									'html' => '<div class="icon-cols cols-small icon-6cols"></div>',
									'title' => esc_html__( '6 Columns', 'opal-themecontrol' ),
								),
							),
							'required' => array( 'wc_archive_style != list' ),
						),
						'wc_archive_full_width' => array(
							'label'    => esc_html__( 'Enable Full Width', 'opal-themecontrol' ),
							'section'  => 'product_list',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_archive_item_animation' => array(
							'label'       => esc_html__( 'Enable Item Animation', 'opal-themecontrol' ),
							'description' => esc_html__( 'Enable or disable product item animation on mouse scrolling.', 'opal-themecontrol' ),
							'section'     => 'product_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_archive_number_products' => array(
							'label'       => esc_html__( 'Number of products per page', 'opal-themecontrol' ),
							'description' => esc_html__( 'Change number of products displayed per page.', 'opal-themecontrol' ),
							'section'     => 'product_list',
							'type'        => 'number',
							'input_attrs' => array(
								'min'   => 1,
								'step'  => 1,
							),
						),
						// 'wc_archive_pagination_type' => array(
						// 	'label'       => esc_html__( 'Pagination Type', 'opal-themecontrol' ),
						// 	'description' => esc_html__( 'Choose your page loading style.', 'opal-themecontrol' ),
						// 	'section'     => 'product_list',
						// 	'type'        => 'select',
						// 	'choices'     => array(
						// 		'number'   => esc_html__( 'Number', 'opal-themecontrol' ),
						// 		'loadmore' => esc_html__( 'Load More', 'opal-themecontrol' ),
						// 		'infinite' => esc_html__( 'Infinite Scroll', 'opal-themecontrol' ),
						// 	),
						// ),
						'wc_archive_item_heading' => array(
							'label'   => esc_html__( 'Product Item', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'product_list',
						),
						'wc_archive_item_layout' => array(
							'label'       => esc_html__( 'Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Choose layout for a product item.', 'opal-themecontrol' ),
							'section'     => 'product_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'1'  => array(
									'html' => '<div class="icon-item-layout icon-item-1"><span></span></div>',
									'title' => esc_html__( 'Button inside thumbnail', 'opal-themecontrol' ),
								),
								'2'  => array(
									'html' => '<div class="icon-item-layout icon-item-2"><span></span></div>',
									'title' => esc_html__( 'Button outsite thumbnail', 'opal-themecontrol' ),
								),
								'3'  => array(
									'html' => '<div class="icon-item-layout icon-item-3"></div>',
									'title' => esc_html__( 'Button slide from bottom', 'opal-themecontrol' ),
								),
								'4'  => array(
									'html' => '<div class="icon-item-layout icon-item-4"></div>',
									'title' => esc_html__( 'Button slide from bottom', 'opal-themecontrol' ),
								),
								'5'  => array(
									'html' => '<div class="icon-item-layout icon-item-5"><span></span></div>',
									'title' => esc_html__( 'Title and Button inside thumbnail', 'opal-themecontrol' ),
								),
								'6'  => array(
									'html' => '<div class="icon-item-layout icon-item-1 icon-item-6"><span></span><span></span></div>',
									'title' => esc_html__( 'Button inside thumbnail', 'opal-themecontrol' ),
								),
							),
							'required'    => array( 'wc_archive_style != list' ),
						),
						'wc_archive_item_hover_style' => array(
							'label'       => esc_html__( 'Hover Effects', 'opal-themecontrol' ),
							'description' => esc_html__( 'Pick up an animation style for product item on mouse hover', 'opal-themecontrol' ),
							'section'     => 'product_list',
							'type'        => 'select',
							'choices'     => array(
								'default'   => esc_html__( 'None', 'opal-themecontrol' ),
								'scale'     => esc_html__( 'Zoom In', 'opal-themecontrol' ),
								'mask'      => esc_html__( 'Mask Overlay', 'opal-themecontrol' ),
								'flip-back' => esc_html__( '2-nd Image Preview', 'opal-themecontrol' ),
							),
						),
						'wc_archive_item_mask_color' => array(
							'label'    => esc_html__( 'Mask Overlay Color', 'opal-themecontrol' ),
							'section'  => 'product_list',
							'type'     => 'Opal_Themecontrol_Customize_Control_Colors',
							'required' => array( 'wc_archive_item_hover_style = mask' ),
						),
						'wc_archive_item_transition' => array(
							'label'    => esc_html__( 'Transition Effects', 'opal-themecontrol' ),
							'section'  => 'product_list',
							'type'     => 'select',
							'required' => array( 'wc_archive_item_hover_style = flip-back' ),
							'choices'  => array(
								'fade'              => esc_html__( 'Fade In', 'opal-themecontrol' ),
								'slide-from-left'   => esc_html__( 'Slide From Left', 'opal-themecontrol' ),
								'slide-from-right'  => esc_html__( 'Slide From Right', 'opal-themecontrol' ),
								'slide-from-top'    => esc_html__( 'Slide From Top', 'opal-themecontrol' ),
								'slide-from-bottom' => esc_html__( 'Slide From Bottom', 'opal-themecontrol' ),
								'zoom-in'           => esc_html__( 'Zoom In', 'opal-themecontrol' ),
								'zoom-out'          => esc_html__( 'Zoom Out', 'opal-themecontrol' ),
								'flip'              => esc_html__( 'Flip', 'opal-themecontrol' ),
							),
						),
					),
				),
				'product_categories' => get_option( 'woocommerce_shop_page_display' ) || get_option( 'woocommerce_category_archive_display' ) ? array(
					'title'    => esc_html__( 'Product Categories', 'opal-themecontrol' ),
					'settings' => array(
						'wc_categories_style' => array(
							'default'           => 'grid',
							'sanitize_callback' => '',
						),
						'wc_categories_layout_column' => array(
							'default'           => 4,
							'sanitize_callback' => '',
						),
						'wc_categories_layout_column_gutter' => array(
							'default'           => 30,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'wc_categories_style' => array(
							'label'       => esc_html__( 'Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select a layout for product list.', 'opal-themecontrol' ),
							'section'     => 'product_categories',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'grid'  => array(
									'html'  => '<div class="icon-cols icon-grid"></div>',
									'title' => esc_html__( 'Grid', 'opal-themecontrol' ),
								),
								'masonry'  => array(
									'html' => '<div class="icon-cols icon-masonry"><span></span></div>',
									'title' => esc_html__( 'Masonry', 'opal-themecontrol' ),
								),
							),
						),
						'wc_categories_layout_column' => array(
							'label'   => esc_html__( 'Number Of Columns', 'opal-themecontrol' ),
							'section' => 'product_categories',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'2'  => array(
									'html'  => '<div class="icon-cols icon-2cols"></div>',
									'title' => esc_html__( '2 Columns', 'opal-themecontrol' ),
								),
								'3'  => array(
									'html' => '<div class="icon-cols icon-3cols"></div>',
									'title' => esc_html__( '3 Columns', 'opal-themecontrol' ),
								),
								'4'  => array(
									'html' => '<div class="icon-cols icon-4cols"></div>',
									'title' => esc_html__( '4 Columns', 'opal-themecontrol' ),
								),
							),
						),
						'wc_categories_layout_column_gutter' => array(
							'label'       => esc_html__( 'Column Gutter Width', 'opal-themecontrol' ),
							'description' => esc_html__( 'Space between 2 products.', 'opal-themecontrol' ),
							'section'     => 'product_categories',
							'type'        => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices'     => array(
								'min'  => 0,
								'max'  => 60,
								'step' => 1,
								'unit' => 'px',
							),
							'required' => array( 'wc_archive_style != list' ),
						),
					),
				) : array(),
				'product_single' => array(
					'title'    => esc_html__( 'Product Details', 'opal-themecontrol' ),
					'settings' => array(
						//------
						'wc_single_general' => array(),
						'wc_single_title' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_single_product_meta' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_single_social_share' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						//------
						'wc_single_product_custom_style' => array(),
						'wc_single_style' => array(
							'default'           => 2,
							'sanitize_callback' => '',
						),
						'wc_single_layout' => array(
							'default'           => 'no-sidebar',
							'sanitize_callback' => '',
						),
						'wc_single_sidebar' => array(
							'default'           => 'wc-sidebar',
							'sanitize_callback' => '',
						),
						'wc_single_sidebar_sticky' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_single_custom_widget' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						
						'wc_single_thumb_position' => array(
							'default'           => 'bottom',
							'sanitize_callback' => '',
						),
						
						'wc_single_image_zoom' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_single_image_zoom_type' => array(
							'default'           => 'window',
							'sanitize_callback' => '',
						),
						'wc_single_image_zoom_width' => array(
							'default'           => 300,
							'sanitize_callback' => '',
						),
						'wc_single_image_zoom_height' => array(
							'default'           => 300,
							'sanitize_callback' => '',
						),
						'wc_single_image_mousewheel' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_single_image_easing' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_single_single_nav' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						//------
						'wc_single_product_tab' => array(),
						'wc_single_tab_style' => array(
							'default'           => 'accordion',
							'sanitize_callback' => '',
						),
						'wc_single_tab_position' => array(
							'default'           => 'default',
							'sanitize_callback' => '',
						),
						'wc_single_product_tab_description' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_single_product_tab_info' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_single_product_tab_review' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						//------
						'wc_single_product_related_heading' => array(),
						'wc_single_product_related_layout' => array(
							'default'           => 'boxed',
							'sanitize_callback' => '',
						),
						'wc_single_product_related' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_single_product_upsell' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_single_product_recent_viewed' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						
						'wc_single_product_column' => array(
							'default'           => 4,
							'sanitize_callback' => '',
						),
						'wc_single_product_limit' => array(
							'default'           => 12,
							'sanitize_callback' => '',
						)
					),
					'controls' => array(
						//===================================
							// Main Information
						//===================================
						'wc_single_product_custom_style' => array(
							'label'    => esc_html__( 'Main Information', 'opal-themecontrol' ),
							'type'     => 'Opal_Themecontrol_Customize_Control_Heading',
							'section'  => 'product_single',
						),
						'wc_single_style' => array(
							'label'       => esc_html__( 'Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Choose the layout for a single product.', 'opal-themecontrol' ),
							'section'     => 'product_single',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'1'  => array(
									'html'  => '<div class="icon-cols icon-single-layout-1"><span></span><span></span></div>',
									'title' => esc_html__( 'Full Image', 'opal-themecontrol' ),
								),
								'2'  => array(
									'html'  => '<div class="icon-cols icon-single-layout-2"><span></span></div>',
									'title' => esc_html__( 'Small Image', 'opal-themecontrol' ),
								),
								'3'  => array(
									'html'  => '<div class="icon-cols icon-single-layout-3"><span></span></div>',
									'title' => esc_html__( 'Large Image', 'opal-themecontrol' ),
								),
								'4'  => array(
									'html'  => '<div class="icon-cols icon-single-layout-4"><span></span><span></span></div>',
									'title' => esc_html__( 'Medium Image', 'opal-themecontrol' ),
								),
								'5'  => array(
									'html'  => '<div class="icon-cols icon-single-layout-5"><span></span></div>',
									'title' => esc_html__( 'Medium Image', 'opal-themecontrol' ),
								),
							),
						),
						'wc_single_layout' => array(
							'label'       => esc_html__( 'Sidebar Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select a sidebar layout.', 'opal-themecontrol' ),
							'section'     => 'product_single',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'left-sidebar'  => array(
									'html'  => '<div class="icon-cols icon-sidebar icon-left-sidebar"></div>',
									'title' => esc_html__( 'Sidebar on the left content', 'opal-themecontrol' ),
								),
								'no-sidebar'  => array(
									'html'  => '<div class="icon-cols icon-sidebar icon-no-sidebar"></div>',
									'title' => esc_html__( 'Without Sidebar', 'opal-themecontrol' ),
								),
								'right-sidebar'  => array(
									'html'  => '<div class="icon-cols icon-sidebar icon-right-sidebar"></div>',
									'title' => esc_html__( 'Sidebar on the right content', 'opal-themecontrol' ),
								),
							),
							'required' => array(
								'wc_single_style = 2',
							),
						),
						'wc_single_sidebar' => array(
							'label'   => esc_html__( 'Sidebar Content', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'select',
							'choices' => Opal_Themecontrol_Helper::get_sidebars(),
							'required'    => array(
								'wc_single_style  = 2',
								'wc_single_layout != no-sidebar',
							),
						),
						'wc_single_sidebar_sticky' => array(
							'label'       => esc_html__( 'Enable Sticky Sidebar', 'opal-themecontrol' ),
							'section'     => 'product_single',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array(
								'wc_single_layout != no-sidebar',
								'wc_single_style  = 2',
							),
						),
						'wc_single_custom_widget' => array(
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="widget_styles">' . esc_html__( 'Customize Widget Styles', 'opal-themecontrol' ) . '</a></h3>',
							),
							'required' => array(
								'wc_single_style  = 2',
								'wc_single_layout != no-sidebar',
							),
						),
						'wc_single_thumb_position' => array(
							'label'       => esc_html__( 'Thumbnail Position', 'opal-themecontrol' ),
							'section'     => 'product_single',
							'type'        => 'select',
							'choices'     => array(
								'left'   => esc_html__( 'Left', 'opal-themecontrol' ),
								'right'  => esc_html__( 'Right', 'opal-themecontrol' ),
								'bottom' => esc_html__( 'Bottom', 'opal-themecontrol' ),
							),
							'required' => array(
								'wc_single_style = 2',
							),
						),
						'wc_single_image_zoom' => array(
							'label'    => esc_html__( 'Enable image zoom on hover', 'opal-themecontrol' ),
							'section'  => 'product_single',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'wc_single_style = 2',
							),
						),
						'wc_single_image_zoom_type' => array(
							'label'    => esc_html__( 'Zoom Type', 'opal-themecontrol' ),
							'section'  => 'product_single',
							'type'     => 'select',
							'choices'  => array(
								'window' => esc_html__( 'Window', 'opal-themecontrol' ),
								'inner'  => esc_html__( 'Inner', 'opal-themecontrol' ),
								'lens'   => esc_html__( 'Lens', 'opal-themecontrol' ),
							),
							'required' => array(
								'wc_single_image_zoom = 1',
								'wc_single_style = 2',
							),
						),
						'wc_single_image_zoom_width' => array(
							'label'   => esc_html__( 'Window Width', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 200,
								'max'  => 600,
								'step' => 50,
								'unit' => 'px',
							),
							'required' => array(
								'wc_single_image_zoom_type = window',
								'wc_single_image_zoom = 1',
								'wc_single_style = 2',
							),
						),
						'wc_single_image_zoom_height' => array(
							'label'   => esc_html__( 'Window Height', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 200,
								'max'  => 800,
								'step' => 50,
								'unit' => 'px',
							),
							'required' => array(
								'wc_single_image_zoom_type = window',
								'wc_single_image_zoom = 1',
								'wc_single_style = 2',
							),
						),
						'wc_single_image_mousewheel' => array(
							'label'   => esc_html__( 'Enable Mousewheel Zoom', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'wc_single_image_zoom = 1',
								'wc_single_style = 2',
							),
						),
						'wc_single_image_easing' => array(
							'label'   => esc_html__( 'Enable Easing', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'wc_single_image_zoom = 1',
								'wc_single_style = 2',
							),
						),
						'wc_single_single_nav' => array(
							'label'   => esc_html__( 'Enable Product Navigation', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'wc_single_style = 2',
							),
						),
						//===================================
							// General Information
						//===================================
						'wc_single_general' => array(
							'label'    => esc_html__( 'General', 'opal-themecontrol' ),
							'type'     => 'Opal_Themecontrol_Customize_Control_Heading',
							'section'  => 'product_single',
						),
						'wc_single_title' => array(
							'label'    => esc_html__( 'Show Page Title', 'opal-themecontrol' ),
							'section'  => 'product_single',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'wc_single_style = 2',
							),
						),
						'wc_single_product_meta' => array(
							'label'    => esc_html__( 'Show Product Meta', 'opal-themecontrol' ),
							'section'  => 'product_single',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'wc_single_style != 5' )
						),
						'wc_single_social_share' => array(
							'label'   => esc_html__( 'Show Social Share', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						//===================================
							// Extra Information
						//===================================
						'wc_single_product_tab' => array(
							'label'   => esc_html__( 'Extra Information', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
						),
						'wc_single_tab_style' => array(
							'label'       => esc_html__( 'Layout', 'opal-themecontrol' ),
							'section'     => 'product_single',
							'type'        => 'select',
							'choices'     => array(
								'horizontal'   => esc_html__( 'Horizontal Tabs', 'opal-themecontrol' ),
								'vertical'     => esc_html__( 'Vertical Tabs', 'opal-themecontrol' ),
								'accordion' => esc_html__( 'Accordions', 'opal-themecontrol' ),
								'fulltext' => esc_html__( 'Full Text', 'opal-themecontrol' ),
							),
							'required'    => array(
								'wc_single_style = "1|2|3"',
							),
						),
						'wc_single_tab_position' => array(
							'label'       => esc_html__( 'Position', 'opal-themecontrol' ),
							'section'     => 'product_single',
							'type'        => 'select',
							'choices'     => array(
								'default'        => esc_html__( 'Above Other Products', 'opal-themecontrol' ),
								'below_details'  => esc_html__( 'Below Product Details', 'opal-themecontrol' ),
							),
							'required'    => array(
								'wc_single_style  = 2',
								'wc_single_layout = no-sidebar',
							),
						),
						'wc_single_product_tab_description' => array(
							'label'   => esc_html__( 'Show Description', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_single_product_tab_info' => array(
							'label'   => esc_html__( 'Show Attributes', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_single_product_tab_review' => array(
							'label'   => esc_html__( 'Show Reviews', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),

						//===================================
							// Other Products
						//===================================
						'wc_single_product_related_heading' => array(
							'label'   => esc_html__( 'Other Products', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'product_single',
						),
						'wc_single_product_related_layout' => array(
							'label'       => esc_html__( 'Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'These settings can be applied only to style 1 and style 2 without sidebar', 'opal-themecontrol' ),
							'section'     => 'product_single',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'boxed'  => array(
									'html'  => '<div class="icon-wc-related icon-related-boxed"><span></span><span></span></div>',
									'title' => esc_html__( 'Boxed', 'opal-themecontrol' ),
								),
								'full'  => array(
									'html'  => '<div class="icon-wc-related icon-related-full"><span></span><span></span></div>',
									'title' => esc_html__( 'Full Width', 'opal-themecontrol' ),
								),
							),
							'required'    => array(
								'wc_single_style = "1|2|5"',
								'opal_layout_boxed = 0'
							),
						),
						'wc_single_product_related' => array(
							'label'   => esc_html__( 'Show Related Products', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_single_product_upsell' => array(
							'label'   => esc_html__( 'Show Upsell Products', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_single_product_recent_viewed' => array(
							'label'   => esc_html__( 'Show Recently Viewed Products', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_single_product_column' => array(
							'label'   => esc_html__( 'Number Column Products To Show', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 1,
								'max'  => 6,
								'step' => 1,
							),
						),

						'wc_single_product_limit' => array(
							'label'   => esc_html__( 'Limit Product', 'opal-themecontrol' ),
							'section' => 'product_single',
							'type'    => 'number',
							'input_attrs' => array(
								'min'   => 1,
								'step'  => 1,
							),
						),
					),
				),
				'wc_thankyou' => array(
					'title'    => esc_html__( 'Thank you Page', 'opal-themecontrol' ),
					'settings' => array(
						'wc_thankyou_content' => array(
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'wc_thankyou_content' => array(
							'label'       => esc_html__( 'Page content', 'opal-themecontrol' ),
							'description' => esc_html__( 'The content will be placed after "Thank You" content. HTML tags are allowed.', 'opal-themecontrol' ),
							'section'     => 'wc_thankyou',
							'type'        => 'Opal_Themecontrol_Customize_Control_Editor',
							'mode'        => 'htmlmixed',
							'button_text' => esc_html__( 'Set Content', 'opal-themecontrol' ),
							'placeholder' => esc_html__( "/**\n * Write your custom content here.\n */", 'opal-themecontrol' ),
						),
					),
				),
				'product_mobile' => array(
					'title'    => esc_html__( 'Mobile Layout', 'opal-themecontrol' ),
					'settings' => array(
						'wc_archive_mobile_general_heading' => array(),
						'wc_detail_mobile_general_heading' => array(),
						'wc_archive_mobile_categories' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_archive_mobile_style' => array(
							'default'           => 'mobile-list',
							'sanitize_callback' => '',
						),
						'wc_archive_mobile_layout_column' => array(
							'default'           => 2,
							'sanitize_callback' => '',
						),
						'wc_archive_mobile_sidebar' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'wc_archive_mobile_sidebar_content' => array(
							'default'           => 'wc-sidebar',
							'sanitize_callback' => '',
						),
						'wc_detail_mobile_sticky_cart' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'wc_archive_mobile_general_heading' => array(
							'label'   => esc_html__( 'Product Category', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'product_mobile',
						),
						'wc_archive_mobile_categories' => array(
							'label'   => esc_html__( 'Show Categories', 'opal-themecontrol' ),
							'section' => 'product_mobile',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_archive_mobile_sidebar' => array(
							'label'   => esc_html__( 'Show Sidebar', 'opal-themecontrol' ),
							'section' => 'product_mobile',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'wc_archive_mobile_sidebar_content' => array(
							'label'       => esc_html__( 'Sidebar Content', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display.', 'opal-themecontrol' ),
							'section'     => 'product_mobile',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
							'required' => array( 'wc_archive_mobile_sidebar != 0' ),
						),
						'wc_archive_mobile_style' => array(
							'label'       => esc_html__( 'Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select a layout for product list.', 'opal-themecontrol' ),
							'section'     => 'product_mobile',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'mobile-grid'  => array(
									'html'  => '<div class="icon-cols icon-grid grid-2cols"></div>',
									'title' => esc_html__( 'Grid', 'opal-themecontrol' ),
								),
								'mobile-list'  => array(
									'html' => '<div class="icon-cols icon-list"><span></span></div>',
									'title' => esc_html__( 'List', 'opal-themecontrol' ),
								),
							),
						),
						'wc_archive_mobile_layout_column' => array(
							'label'   => esc_html__( 'Number Of Columns', 'opal-themecontrol' ),
							'section' => 'product_mobile',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => array(
									'html'  => '<div class="icon-cols icon-1cols"></div>',
									'title' => esc_html__( '2 Columns', 'opal-themecontrol' ),
								),
								'2'  => array(
									'html'  => '<div class="icon-cols icon-2cols"></div>',
									'title' => esc_html__( '2 Columns', 'opal-themecontrol' ),
								),
							),
							'required' => array( 'wc_archive_mobile_style == mobile-grid' ),
						),
						'wc_detail_mobile_general_heading' => array(
							'label'   => esc_html__( 'Product Details', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'product_mobile',
						),
						'wc_detail_mobile_sticky_cart' => array(
							'label'   => esc_html__( 'Sticky Add To Cart', 'opal-themecontrol' ),
							'section' => 'product_mobile',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
					),
				),
			),
			'type'     => 'Opal_Themecontrol_Customize_Panel',
			'apply_to' => array( 'woocommerce' ),
		);
	}
}
