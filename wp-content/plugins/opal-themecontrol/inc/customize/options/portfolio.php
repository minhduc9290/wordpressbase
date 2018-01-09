<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    Opal_ThemeControl
 * @author     WpOpal Portfolio <opalwordpress@gmail.com>
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
class Opal_Themecontrol_Customize_Options_Portfolio {
	public static function get_options() {
		return apply_filters( 'opalthemer_filter_customize_options_portfolio',array(
			'title'       => esc_html__( 'Portfolio', 'opal-themecontrol' ),
			'description' => '<a target="_blank" href="http://opalthemer.com/docs/document/portfolio"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
			'priority'    => 50,
			'sections'    => array(
				'portfolio_list' => array(
					'title'    => esc_html__( 'Portfolio List', 'opal-themecontrol' ),
					'settings' => array(
						'portfolio_layout' => array(
							'default'           => 'grid',
							'sanitize_callback' => '',
						),
						'portfolio_sidebar_layout' => array(
							'default'           => 'right-sidebar',
							'sanitize_callback' => '',
						),
						'portfolio_sidebar_sticky' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'portfolio_custom_widget' => array(
							'default'           => 1,
						),
						'portfolio_sidebar' => array(
							'default'           => 'sidebar-default',
							'sanitize_callback' => '',
						),
						'portfolio_column' => array(
							'default'           => 4,
							'sanitize_callback' => 	'',
						),
						'portfolio_enable_job' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
	
						'portfolio_enable_readmore' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'portfolio_enable_description'    => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'portfolio_max_char'    => array(
							'default'           => 10,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'portfolio_layout' => array(
							'label'       => esc_html__( 'Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'These settings can be applied only to style 1 and style 2 without sidebar', 'opal-themecontrol' ),
							'section'     => 'portfolio_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'grid'  => array(
									'html'  => '<div class="icon-wc-related icon-related-boxed"><span></span><span></span></div>',
									'title' => esc_html__( 'Grid Boxed', 'opal-themecontrol' ),
								),
								'list'  => array(
									'html' => '<div class="icon-cols icon-blog-simple"><span></span></div>',
									'title' => esc_html__( 'List', 'opal-themecontrol' ),
								),
							),
						),
						'portfolio_sidebar_layout' => array(
							'label'       => esc_html__( 'Sidebar layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select a sidebar layout for your portfolio list.', 'opal-themecontrol' ),
							'section'     => 'portfolio_list',
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
						'portfolio_sidebar' => array(
							'label'       => esc_html__( 'Sidebar Content', 'opal-themecontrol' ),
							'description' => esc_html__( 'Pick up a default sidebar.', 'opal-themecontrol' ),
							'section'     => 'portfolio_list',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
							'required' => array( 'portfolio_sidebar_layout != no-sidebar' ),
						),
						'portfolio_sidebar_sticky' => array(
							'label'       => esc_html__( 'Enable Sticky Sidebar', 'opal-themecontrol' ),
							'section'     => 'portfolio_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array( 'portfolio_sidebar_layout != no-sidebar' ),
						),
						'portfolio_custom_widget' => array(
							'section' => 'portfolio_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="widget_styles">' . esc_html__( 'Customize Widget Styles', 'opal-themecontrol' ) . '</a></h3>',
							),
							'required' => array( 'portfolio_sidebar_layout != no-sidebar' ),
						),
						'portfolio_column' => array(
							'label'   => __( 'Columns', 'opal-themecontrol' ),
							'section' => 'portfolio_list',
							'type'    => 'select',
							'choices' => array(
								'2' => __( '2 Columns', 'opal-themecontrol' ),
								'3' => __( '3 Columns', 'opal-themecontrol' ),
								'4' => __( '4 Columns', 'opal-themecontrol' ),
								'5' => __( '5 Columns', 'opal-themecontrol' ),
								'6' => __( '6 Columns', 'opal-themecontrol' ),
							),
							'required' => array( 'portfolio_layout != list' ),
						),
						'portfolio_enable_job' => array(
							'label'   => esc_html__( 'Show Job', 'opal-themecontrol' ),
							'section' => 'portfolio_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'portfolio_enable_readmore' => array(
							'label'   => esc_html__( 'Show Read More', 'opal-themecontrol' ),
							'section' => 'portfolio_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'portfolio_enable_description' => array(
							'label'   => esc_html__( 'Show Description Info', 'opal-themecontrol' ),
							'section' => 'portfolio_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'portfolio_max_char' => array(
							'label'       => esc_html__( 'Desctiption Max Char', 'opal-themecontrol' ),
							'description' => esc_html__( 'Number character for description.', 'opal-themecontrol' ),
							'section'     => 'portfolio_list',
							'type'        => 'number',
							'input_attrs' => array(
								'min'   => 1,
								'step'  => 1,
							),
							'required' => array( 'portfolio_enable_description == 1' ),
						),
					),
				),
				'portfolio_single' => array(
					'title'    => esc_html__( 'Single Post', 'opal-themecontrol' ),
					'settings' => array(
						'portfolio_single_sidebar_layout' => array(
							'default'           => 'no-sidebar',
							'sanitize_callback' => '',
						),
						'portfolio_single_custom_widget' => array(
							'default'           => 1,
						),
						'portfolio_single_sidebar' => array(
							'default'           => 'sidebar-default',
							'sanitize_callback' => '',
						),
						'portfolio_single_sidebar_sticky' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'portfolio_single_related' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'portfolio_single_related_column'    => array(
							'default'           => 4,
							'sanitize_callback' => '',
						),
						'portfolio_single_related_limit'    => array(
							'default'           => 12,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'portfolio_single_heading' => array(
							'label'   => esc_html__( 'Post Content', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'portfolio_single',
						),
						'portfolio_single_sidebar_layout' => array(
							'label'       => esc_html__( 'Sidebar Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Choose global layout settings: Left sidebar, No sidebar, Right sidebar.', 'opal-themecontrol' ),
							'section'     => 'portfolio_single',
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
						'portfolio_single_sidebar' => array(
							'label'       => esc_html__( 'Sidebar Content', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select the sidebar to display on this position.', 'opal-themecontrol' ),
							'section'     => 'portfolio_single',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
							'required' => array( 'portfolio_single_sidebar_layout != no-sidebar' ),
						),
						'portfolio_single_sidebar_sticky' => array(
							'label'       => esc_html__( 'Enable Sticky Sidebar', 'opal-themecontrol' ),
							'section'     => 'portfolio_single',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array( 'portfolio_single_sidebar_layout != no-sidebar' ),
						),
						'portfolio_single_custom_widget' => array(
							'section' => 'portfolio_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="widget_styles">' . esc_html__( 'Customize Widget Styles', 'opal-themecontrol' ) . '</a></h3>',
							),
							'required' => array( 'portfolio_single_sidebar_layout != no-sidebar' ),
						),
						'portfolio_single_related' => array(
							'label'   => esc_html__( 'Show Related Portfolio', 'opal-themecontrol' ),
							'section' => 'portfolio_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),

						'portfolio_single_related_column' => array(
							'label'   => __( 'Columns', 'opal-themecontrol' ),
							'section' => 'portfolio_single',
							'type'    => 'select',
							'choices' => array(
								'2' => __( '2 Columns', 'opal-themecontrol' ),
								'3' => __( '3 Columns', 'opal-themecontrol' ),
								'4' => __( '4 Columns', 'opal-themecontrol' ),
								'5' => __( '5 Columns', 'opal-themecontrol' ),
								'6' => __( '6 Columns', 'opal-themecontrol' ),
							),
							'required' => array( 'portfolio_single_related == 1' ),
						),
						'portfolio_single_related_limit' => array(
							'label'       => __( 'Limit Related Item', 'opal-themecontrol' ),
							'section'     => 'portfolio_single',
							'type'        => 'number',
							'input_attrs' => array(
								'min'   => 1,
								'step'  => 1,
							),
							'required' => array( 'portfolio_single_related == 1' ),
						),
					),
				),
			),
			'type'     => 'Opal_Themecontrol_Customize_Panel',
			'apply_to' => array( 'portfolio' ),
		));
	}
}
