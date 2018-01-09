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
class Opal_Themecontrol_Customize_Options_Sidebar {
	public static function get_options() {
		return array(
			'title'       => esc_html__( 'Sidebar', 'opal-themecontrol' ),
			'priority'    => 105,
			'sections'    => array(
				'sidebar_page' => array(
					'title'    => esc_html__( 'Page', 'opal-themecontrol' ),
					'settings' => array(
						'sidebar_after_page_title' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_before_page_content' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_after_page_content' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_page_move_to_widget' => array(
							'default'   => 1,
						),
					),
					'controls' => array(
						'sidebar_after_page_title' => array(
							'label'       => esc_html__( 'Sidebar Below Page Title', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display below page title.', 'opal-themecontrol' ),
							'section'     => 'sidebar_page',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_before_page_content' => array(
							'label'       => esc_html__( 'Sidebar Above Page Content', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display above page content.', 'opal-themecontrol' ),
							'section'     => 'sidebar_page',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_after_page_content' => array(
							'label'       => esc_html__( 'Sidebar Below Page Content', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display below page content.', 'opal-themecontrol' ),
							'section'     => 'sidebar_page',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_page_move_to_widget' => array(
							'section' => 'sidebar_page',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-panel button" data-section="widgets">' . esc_html__( 'Edit Widget Content', 'opal-themecontrol' ) . '</a></h3>',
							),
						),
					),
				),
				'sidebar_blog' => array(
					'title'    => esc_html__( 'Blog', 'opal-themecontrol' ),
					'settings' => array(
						'sidebar_blog_list_heading' => array(),
						'sidebar_before_blog_content' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_after_blog_content' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_blog_single_heading' => array(),
						'blog_single_before_post' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'blog_single_before_author' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'blog_single_after_comment' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_blog_move_to_widget' => array(
							'default' => 1,
						),
					),
					'controls' => array(
						'sidebar_blog_list_heading' => array(
							'label'   => esc_html__( 'Blog List', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'sidebar_blog',
						),
						'sidebar_before_blog_content' => array(
							'label'       => esc_html__( 'Sidebar Above Blog', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display above blog content.', 'opal-themecontrol' ),
							'section'     => 'sidebar_blog',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_after_blog_content' => array(
							'label'       => esc_html__( 'Sidebar Below Blog', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display below blog content.', 'opal-themecontrol' ),
							'section'     => 'sidebar_blog',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_blog_single_heading' => array(
							'label'   => esc_html__( 'Blog Detail', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'sidebar_blog',
						),
						'blog_single_before_post' => array(
							'label'       => esc_html__( 'Sidebar above post', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display above post.', 'opal-themecontrol' ),
							'section'     => 'sidebar_blog',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'blog_single_before_author' => array(
							'label'       => esc_html__( 'Sidebar below post', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display below post.', 'opal-themecontrol' ),
							'section'     => 'sidebar_blog',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'blog_single_after_comment' => array(
							'label'       => esc_html__( 'Sidebar below comment area', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display comment area.', 'opal-themecontrol' ),
							'section'     => 'sidebar_blog',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_blog_move_to_widget' => array(
							'section' => 'sidebar_blog',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-panel button" data-section="widgets">' . esc_html__( 'Edit Widget Content', 'opal-themecontrol' ) . '</a></h3>',
							),
						),
					),
				),
				'sidebar_wc' => array(
					'title'    => esc_html__( 'WooCommerce', 'opal-themecontrol' ),
					'settings' => array(
						'sidebar_wc_heading_product_cat' => array(),
						'wc_archive_content_before' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_archive_content_after' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_wc_heading_product_details' => array(),
						'wc_single_content_before' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_single_content_after' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_wc_heading_cart' => array(),
						'wc_cart_content_before' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_cart_content_after' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_wc_heading_checkout' => array(),
						'wc_checkout_content_before' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'wc_checkout_content_after' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_wc_heading_mobile_layout' => array(),
						'wc_archive_mobile_content_before' => array(
							'default'           => '0',
							'sanitize_callback' => '',
						),
						'wc_archive_mobile_content_after' => array(
							'default'           => '0',
							'sanitize_callback' => '',
						),
						'sidebar_wc_to_widget' => array(
							'default' => 1,
						),
					),
					'controls' => array(
						'sidebar_wc_heading_product_cat' => array(
							'label'   => esc_html__( 'Product Category', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'sidebar_wc',
						),
						'wc_archive_content_before' => array(
							'label'       => esc_html__( 'Sidebar Above Product List', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display above product list.', 'opal-themecontrol' ),
							'section'     => 'sidebar_wc',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'wc_archive_content_after' => array(
							'label'       => esc_html__( 'Sidebar Below Product List', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display below product list.', 'opal-themecontrol' ),
							'section'     => 'sidebar_wc',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_wc_heading_product_details' => array(
							'label'   => esc_html__( 'Product Details', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'sidebar_wc',
						),
						'wc_single_content_before' => array(
							'label'       => esc_html__( 'Sidebar Above Product Details', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display above product details.', 'opal-themecontrol' ),
							'section'     => 'sidebar_wc',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'wc_single_content_after' => array(
							'label'       => esc_html__( 'Sidebar Below Product Details', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display below product details.', 'opal-themecontrol' ),
							'section'     => 'sidebar_wc',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_wc_heading_cart' => array(
							'label'   => esc_html__( 'Cart Page', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'sidebar_wc',
						),
						'wc_cart_content_before' => array(
							'label'       => esc_html__( 'Sidebar Above Cart Page', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display above cart page.', 'opal-themecontrol' ),
							'section'     => 'sidebar_wc',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'wc_cart_content_after' => array(
							'label'       => esc_html__( 'Sidebar Below Cart Page', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display below cart page.', 'opal-themecontrol' ),
							'section'     => 'sidebar_wc',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_wc_heading_checkout' => array(
							'label'   => esc_html__( 'Checkout Page', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'sidebar_wc',
						),
						'wc_checkout_content_before' => array(
							'label'       => esc_html__( 'Sidebar Above Checkout Form', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display above checkout page.', 'opal-themecontrol' ),
							'section'     => 'sidebar_wc',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'wc_checkout_content_after' => array(
							'label'       => esc_html__( 'Sidebar Below Checkout Form', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display below checkout page.', 'opal-themecontrol' ),
							'section'     => 'sidebar_wc',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_wc_heading_mobile_layout' => array(
							'label'   => esc_html__( 'Mobile Layout', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'sidebar_wc',
						),
						'wc_archive_mobile_content_before' => array(
							'label'       => esc_html__( 'Sidebar Above Product List', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display above product list.', 'opal-themecontrol' ),
							'section'     => 'sidebar_wc',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'wc_archive_mobile_content_after' => array(
							'label'       => esc_html__( 'Sidebar Below Product List', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display below product list.', 'opal-themecontrol' ),
							'section'     => 'sidebar_wc',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_wc_to_widget' => array(
							'section' => 'sidebar_wc',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-panel button" data-section="widgets">' . esc_html__( 'Edit Widget Content', 'opal-themecontrol' ) . '</a></h3>',
							),
						),
					),
				),
				'sidebar_footer' => array(
					'title'    => esc_html__( 'Footer', 'opal-themecontrol' ),
					'settings' => array(
						'sidebar_before_footer_widget' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_after_footer_widget' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'sidebar_footer_to_widget' => array(
							'default' => 1,
						),
					),
					'controls' => array(
						'sidebar_before_footer_widget' => array(
							'label'       => esc_html__( 'Sidebar Above Footer Widget', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display above footer widget.', 'opal-themecontrol' ),
							'section'     => 'sidebar_footer',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_after_footer_widget' => array(
							'label'       => esc_html__( 'Sidebar Below Footer Widget', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select sidebar to display below footer widget.', 'opal-themecontrol' ),
							'section'     => 'sidebar_footer',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
						),
						'sidebar_footer_to_widget' => array(
							'section' => 'sidebar_footer',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-panel button" data-section="widgets">' . esc_html__( 'Edit Widget Content', 'opal-themecontrol' ) . '</a></h3>',
							),
						),
					),
				),
			),
			'type' => 'Opal_Themecontrol_Customize_Panel',
		);
	}
}
