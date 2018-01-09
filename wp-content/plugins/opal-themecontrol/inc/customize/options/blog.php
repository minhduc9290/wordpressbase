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
class Opal_Themecontrol_Customize_Options_Blog {
	public static function get_options() {
		return array(
			'title'       => esc_html__( 'Blog', 'opal-themecontrol' ),
			'description' => '<a target="_blank" href="http://opalthemer.com/docs/document/blog"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
			'priority'    => 50,
			'sections'    => array(
				'blog_list' => array(
					'title'    => esc_html__( 'Blog List', 'opal-themecontrol' ),
					'settings' => array(
						'blog_style' => array(
							'default'           => 'classic',
							'sanitize_callback' => '',
						),
						'blog_full_width' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'blog_color' => array(
							'default'           => 'boxed',
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'blog_masonry_column' => array(
							'default'           => '3',
							'sanitize_callback' => '',
						),
						'blog_sidebar_layout' => array(
							'default'           => 'right-sidebar',
							'sanitize_callback' => '',
						),
						'blog_sidebar_sticky' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'blog_custom_widget' => array(
							'default'           => 1,
						),
						'blog_sidebar' => array(
							'default'           => 'blog-sidebar-right',
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'blog_style' => array(
							'label'       => esc_html__( 'Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select a layout for your blog list.', 'opal-themecontrol' ),
							'section'     => 'blog_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'classic'  => array(
									'html' => '<div class="icon-cols icon-blog-classic"><span></span></div>',
									'title' => esc_html__( 'Classic', 'opal-themecontrol' ),
								),
								'simple'  => array(
									'html' => '<div class="icon-cols icon-blog-simple"><span></span></div>',
									'title' => esc_html__( 'Simple', 'opal-themecontrol' ),
								),
								'zigzag'  => array(
									'html' => '<div class="icon-cols icon-blog-zigzag"><span></span></div>',
									'title' => esc_html__( 'Zigzag', 'opal-themecontrol' ),
								),
								'masonry'  => array(
									'html' => '<div class="icon-cols icon-masonry"><span></span></div>',
									'title' => esc_html__( 'Masonry', 'opal-themecontrol' ),
								),
							),
						),
						'blog_masonry_column' => array(
							'label'       => esc_html__( 'Number of Columns', 'opal-themecontrol' ),
							'description' => esc_html__( 'Number of columns to show.', 'opal-themecontrol' ),
							'section'     => 'blog_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
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
							'required' => array( 'blog_style = masonry' ),
						),
						'blog_color' => array(
							'label'       => esc_html__( 'Item style', 'opal-themecontrol' ),
							'section'     => 'blog_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'default'  => array(
									'html' => '<div class="icon-cols icon-blog-classic"><span></span></div>',
									'title' => esc_html__( 'Default', 'opal-themecontrol' ),
								),
								'boxed'  => array(
									'html' => '<div class="icon-cols icon-blog-boxed icon-blog-classic"><span><span></span></span></div>',
									'title' => esc_html__( 'Boxed', 'opal-themecontrol' ),
								),
							),
							'required' => array( 'blog_style != zigzag' ),
						),
						'blog_full_width' => array(
							'label'    => esc_html__( 'Enable Full Width', 'opal-themecontrol' ),
							'section'  => 'blog_list',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'blog_sidebar_layout' => array(
							'label'       => esc_html__( 'Sidebar layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select a sidebar layout for your blog list.', 'opal-themecontrol' ),
							'section'     => 'blog_list',
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
						'blog_sidebar' => array(
							'label'       => esc_html__( 'Sidebar Content', 'opal-themecontrol' ),
							'description' => esc_html__( 'Pick up a default sidebar.', 'opal-themecontrol' ),
							'section'     => 'blog_list',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
							'required' => array( 'blog_sidebar_layout != no-sidebar' ),
						),
						'blog_sidebar_sticky' => array(
							'label'       => esc_html__( 'Enable Sticky Sidebar', 'opal-themecontrol' ),
							'section'     => 'blog_list',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array( 'blog_sidebar_layout != no-sidebar' ),
						),
						'blog_custom_widget' => array(
							'section' => 'blog_list',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="widget_styles">' . esc_html__( 'Customize Widget Styles', 'opal-themecontrol' ) . '</a></h3>',
							),
							'required' => array( 'blog_sidebar_layout != no-sidebar' ),
						),
					),
				),
				'blog_single' => array(
					'title'    => esc_html__( 'Single Post', 'opal-themecontrol' ),
					'settings' => array(
						'blog_single_title_heading' => array(),
						'blog_single_sidebar_layout' => array(
							'default'           => 'no-sidebar',
							'sanitize_callback' => '',
						),
						'blog_single_custom_widget' => array(
							'default'           => 1,
						),
						'blog_single_sidebar' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'blog_single_sidebar_sticky' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'blog_single_title_style' => array(
							'default'           => '1',
							'sanitize_callback' => '',
						),
						'blog_single_title_font_size' => array(
							'default'           => 45,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'blog_single_title_padding_top' => array(
							'default'           => 100,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'blog_single_title_padding_bottom' => array(
							'default'           => 100,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'blog_single_title_full_screen' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'blog_single_heading' => array(),
						'blog_single_social_share' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'blog_single_author'    => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'blog_single_navigation' => array(
							'default'            => 1,
							'sanitize_callback'  => '',
						),
						'blog_single_comment' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'blog_single_related' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'blog_single_related_column' => array(
							'default'           => 3,
							'sanitize_callback' => '',
						),
						'blog_single_related_limit' => array(
							'default'           => 12,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'blog_single_title_heading' => array(
							'label'   => esc_html__( 'Post Title', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'blog_single',
						),
						'blog_single_title_style' => array(
							'label'   => esc_html__( 'Layout', 'opal-themecontrol' ),
							'section' => 'blog_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => array(
									'html' => '<div class="icon-item-layout icon-blog-title-1"><span></span></div>',
									'title' => esc_html__( 'Title outside post thumbnail', 'opal-themecontrol' ),
								),
								'2'  => array(
									'html' => '<div class="icon-item-layout icon-blog-title-2"><span></span></div>',
									'title' => esc_html__( 'Title inside post thumbnail', 'opal-themecontrol' ),
								),
							),
						),
						'blog_single_title_font_size' => array(
							'label'   => esc_html__( 'Font Size', 'opal-themecontrol' ),
							'section' => 'blog_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 12,
								'max'  => 80,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'blog_single_title_padding_top' => array(
							'label'   => esc_html__( 'Padding Top', 'opal-themecontrol' ),
							'section' => 'blog_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 500,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'blog_single_title_padding_bottom' => array(
							'label'   => esc_html__( 'Padding Bottom', 'opal-themecontrol' ),
							'section' => 'blog_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 500,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'blog_single_title_full_screen' => array(
							'label'    => esc_html__( 'Enable Full Screen', 'opal-themecontrol' ),
							'section'  => 'blog_single',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'blog_single_title_style = 2' ),
						),
						'blog_single_heading' => array(
							'label'   => esc_html__( 'Post Content', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'blog_single',
						),
						'blog_single_sidebar_layout' => array(
							'label'       => esc_html__( 'Sidebar Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Choose global layout settings: Left sidebar, No sidebar, Right sidebar.', 'opal-themecontrol' ),
							'section'     => 'blog_single',
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
						'blog_single_sidebar' => array(
							'label'       => esc_html__( 'Sidebar Content', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select the sidebar to display on this position.', 'opal-themecontrol' ),
							'section'     => 'blog_single',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
							'required' => array( 'blog_single_sidebar_layout != no-sidebar' ),
						),
						'blog_single_sidebar_sticky' => array(
							'label'       => esc_html__( 'Enable Sticky Sidebar', 'opal-themecontrol' ),
							'section'     => 'blog_single',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array( 'blog_single_sidebar_layout != no-sidebar' ),
						),
						'blog_single_custom_widget' => array(
							'section' => 'blog_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="widget_styles">' . esc_html__( 'Customize Widget Styles', 'opal-themecontrol' ) . '</a></h3>',
							),
							'required' => array( 'blog_single_sidebar_layout != no-sidebar' ),
						),
						'blog_single_social_share' => array(
							'label'   => esc_html__( 'Show Social Sharing', 'opal-themecontrol' ),
							'section' => 'blog_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'blog_single_author' => array(
							'label'   => esc_html__( 'Show Author Info', 'opal-themecontrol' ),
							'section' => 'blog_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'blog_single_navigation' => array(
							'label'   => esc_html__( 'Show Post Navigation', 'opal-themecontrol' ),
							'section' => 'blog_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'blog_single_comment' => array(
							'label'   => esc_html__( 'Show Comment Area', 'opal-themecontrol' ),
							'section' => 'blog_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'blog_single_related' => array(
							'label'   => esc_html__( 'Show Related', 'opal-themecontrol' ),
							'section' => 'blog_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'blog_single_related_column' => array(
							'label'   => esc_html__( 'Related Column', 'opal-themecontrol' ),
							'section' => 'blog_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 1,
								'max'  => 6,
								'step' => 1,
							),
						),
						'blog_single_related_limit' => array(
							'label'   => esc_html__( 'Related Limit', 'opal-themecontrol' ),
							'section' => 'blog_single',
							'type'    => 'number',
							'input_attrs' => array(
								'min'   => 1,
								'step'  => 1,
							),
						),
					),
				),
			),
			'type'     => 'Opal_Themecontrol_Customize_Panel',
			'apply_to' => array( 'blog' ),
		);
	}
}
