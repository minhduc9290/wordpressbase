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
class Opal_Themecontrol_Customize_Options_Team {
	public static function get_options() {
		return apply_filters( 'opalthemer_filter_customize_options_team',array(
			'title'       => esc_html__( 'Team', 'opal-themecontrol' ),
			'description' => '<a target="_blank" href="http://opalthemer.com/docs/document/team"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
			'priority'    => 50,
			'sections'    => array(
				'team_list' => array(
					'title'    => esc_html__( 'Team List', 'opal-themecontrol' ),
					'settings' => array(
						'team_layout' => array(
							'default'           => 'grid',
							'sanitize_callback' => '',
						),
						'team_sidebar_layout' => array(
							'default'           => 'right-sidebar',
							'sanitize_callback' => '',
						),
						'team_sidebar_sticky' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'team_custom_widget' => array(
							'default'           => 1,
						),
						'team_sidebar' => array(
							'default'           => 'sidebar-default',
							'sanitize_callback' => '',
						),
						'team_column' => array(
							'default'           => 4,
							'sanitize_callback' => 	'',
						),
						'team_enable_job' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'team_enable_social' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'team_enable_readmore' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'team_enable_description'    => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'team_max_char'    => array(
							'default'           => 10,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'team_layout' => array(
							'label'       => esc_html__( 'Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'These settings can be applied only to style 1 and style 2 without sidebar', 'opal-themecontrol' ),
							'section'     => 'team_list',
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
						'team_sidebar_layout' => array(
							'label'       => esc_html__( 'Sidebar layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select a sidebar layout for your team list.', 'opal-themecontrol' ),
							'section'     => 'team_list',
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
						'team_sidebar' => array(
							'label'       => esc_html__( 'Sidebar Content', 'opal-themecontrol' ),
							'description' => esc_html__( 'Pick up a default sidebar.', 'opal-themecontrol' ),
							'section'     => 'team_list',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
							'required' => array( 'team_sidebar_layout != no-sidebar' ),
						),
						'team_sidebar_sticky' => array(
							'label'       => esc_html__( 'Enable Sticky Sidebar', 'opal-themecontrol' ),
							'section'     => 'team_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array( 'team_sidebar_layout != no-sidebar' ),
						),
						'team_custom_widget' => array(
							'section' => 'team_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="widget_styles">' . esc_html__( 'Customize Widget Styles', 'opal-themecontrol' ) . '</a></h3>',
							),
							'required' => array( 'team_sidebar_layout != no-sidebar' ),
						),
						'team_column' => array(
							'label'   => __( 'Columns', 'opal-themecontrol' ),
							'section' => 'team_list',
							'type'    => 'select',
							'choices' => array(
								'2' => __( '2 Columns', 'opal-themecontrol' ),
								'3' => __( '3 Columns', 'opal-themecontrol' ),
								'4' => __( '4 Columns', 'opal-themecontrol' ),
								'5' => __( '5 Columns', 'opal-themecontrol' ),
								'6' => __( '6 Columns', 'opal-themecontrol' ),
							),
							'required' => array( 'team_layout != list' ),
						),
						'team_enable_job' => array(
							'label'   => esc_html__( 'Show Job', 'opal-themecontrol' ),
							'section' => 'team_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'team_enable_social' => array(
							'label'   => esc_html__( 'Show Social Sharing', 'opal-themecontrol' ),
							'section' => 'team_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'team_enable_readmore' => array(
							'label'   => esc_html__( 'Show Read More', 'opal-themecontrol' ),
							'section' => 'team_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'team_enable_description' => array(
							'label'   => esc_html__( 'Show Description Info', 'opal-themecontrol' ),
							'section' => 'team_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'team_max_char' => array(
							'label'       => esc_html__( 'Desctiption Max Char', 'opal-themecontrol' ),
							'description' => esc_html__( 'Number character for description.', 'opal-themecontrol' ),
							'section'     => 'team_list',
							'type'        => 'number',
							'input_attrs' => array(
								'min'   => 1,
								'step'  => 1,
							),
							'required' => array( 'team_enable_description == 1' ),
						),
					),
				),
				'team_single' => array(
					'title'    => esc_html__( 'Single Post', 'opal-themecontrol' ),
					'settings' => array(
						'team_single_sidebar_layout' => array(
							'default'           => 'no-sidebar',
							'sanitize_callback' => '',
						),
						'team_single_custom_widget' => array(
							'default'           => 1,
						),
						'team_single_sidebar' => array(
							'default'           => 'sidebar-default',
							'sanitize_callback' => '',
						),
						'team_single_sidebar_sticky' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'team_single_social_share' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'team_single_info'    => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'team_single_heading' => array(
							'label'   => esc_html__( 'Post Content', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'team_single',
						),
						'team_single_sidebar_layout' => array(
							'label'       => esc_html__( 'Sidebar Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Choose global layout settings: Left sidebar, No sidebar, Right sidebar.', 'opal-themecontrol' ),
							'section'     => 'team_single',
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
						'team_single_sidebar' => array(
							'label'       => esc_html__( 'Sidebar Content', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select the sidebar to display on this position.', 'opal-themecontrol' ),
							'section'     => 'team_single',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
							'required' => array( 'team_single_sidebar_layout != no-sidebar' ),
						),
						'team_single_sidebar_sticky' => array(
							'label'       => esc_html__( 'Enable Sticky Sidebar', 'opal-themecontrol' ),
							'section'     => 'team_single',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array( 'team_single_sidebar_layout != no-sidebar' ),
						),
						'team_single_custom_widget' => array(
							'section' => 'team_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="widget_styles">' . esc_html__( 'Customize Widget Styles', 'opal-themecontrol' ) . '</a></h3>',
							),
							'required' => array( 'team_single_sidebar_layout != no-sidebar' ),
						),
						'team_single_social_share' => array(
							'label'   => esc_html__( 'Show Social Sharing', 'opal-themecontrol' ),
							'section' => 'team_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'team_single_info' => array(
							'label'   => esc_html__( 'Show Author Info', 'opal-themecontrol' ),
							'section' => 'team_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
					),
				),
			),
			'type'     => 'Opal_Themecontrol_Customize_Panel',
			'apply_to' => array( 'team' ),
		));
	}
}
