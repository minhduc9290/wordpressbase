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
class Opal_Themecontrol_Customize_Options_Pages {
	public static function get_options() {
		return array(
			'title'       => esc_html__( 'Pages', 'opal-themecontrol' ),
			'description' => '<a target="_blank" href="http://opalthemer.com/docs/document/pages"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
			'priority'    => 60,
			'sections'    => array(
				'page' => array(
					'title'       => esc_html__( 'Standard Page', 'opal-themecontrol' ),
					'description' => '',
					'settings'    => array(
						'opal_page_layout' => array(
							'default'           => 'no-sidebar',
							'sanitize_callback' => '',
						),
						'opal_page_custom_widget' => array(
							'default'           => 1,
						),
						'opal_page_layout_sidebar' => array(
							'default'           => 'primary-sidebar',
							'sanitize_callback' => '',
						),
						'opal_page_layout_sidebar_width' => array(
							'default'           => 300,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_page_layout_sidebar_sticky' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'opal_page_layout' => array(
							'label'       => esc_html__( 'Sidebar Layout', 'opal-themecontrol' ),
							'description' => esc_html__( 'Pick up a sidebar layout for your pages.', 'opal-themecontrol' ),
							'section'     => 'page',
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
						'opal_page_layout_sidebar' => array(
							'label'       => esc_html__( 'Sidebar Content', 'opal-themecontrol' ),
							'description' => esc_html__( 'Select the sidebar to display on this position.', 'opal-themecontrol' ),
							'section'     => 'page',
							'type'        => 'select',
							'choices'     => Opal_Themecontrol_Helper::get_sidebars(),
							'required' => array( 'opal_page_layout != no-sidebar' ),
						),
						'opal_page_layout_sidebar_width' => array(
							'label'       => esc_html__( 'Sidebar Width', 'opal-themecontrol' ),
							'description' => esc_html__( 'Custom width for sidebar.', 'opal-themecontrol' ),
							'section'     => 'page',
							'type'        => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices'     => array(
								'min'  => 250,
								'max'  => 575,
								'step' => 5,
								'unit' => 'px',
							),
							'required' => array( 'opal_page_layout != no-sidebar' ),
						),
						'opal_page_layout_sidebar_sticky' => array(
							'label'       => esc_html__( 'Enable Sticky Sidebar', 'opal-themecontrol' ),
							'section'     => 'page',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required'    => array( 'opal_page_layout != no-sidebar' ),
						),
						'opal_page_custom_widget' => array(
							'section' => 'page',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="widget_styles">' . esc_html__( 'Customize Widget Styles', 'opal-themecontrol' ) . '</a></h3>',
							),
							'required' => array( 'opal_page_layout != no-sidebar' ),
						),
					),
				),
				'page_404' => array(
					'title'       => esc_html__( '"404" Page', 'opal-themecontrol' ),
					'description' => '<div style="margin-bottom: 40px;">' . sprintf( __( 'We have build nice "404" page for you. <a target="_blank" href="%1$s">Take a look</a>.', 'opal-themecontrol' ), esc_url( home_url( '?p=404404' ) ) ) . '</div>',
					'settings'    => array(
						'page_404_content_heading' => array(),
						'page_404_styling_heading' => array(),
						'page_404_title_font_size' => array(
							'default'           => '88',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'page_404_title_color' => array(
							'default'           => '#292929',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'page_404_bg_color' => array(
							'default'           => '#f7f7f7',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'page_404_bg_image' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'page_404_bg_image_size' => array(
							'default'           => 'auto',
							'sanitize_callback' => '',
						),
						'page_404_bg_image_repeat' => array(
							'default'           => 'no-repeat',
							'sanitize_callback' => '',
						),
						'page_404_bg_image_position' => array(
							'default'           => 'center center',
							'sanitize_callback' => '',
						),
						'page_404_bg_image_attachment' => array(
							'default'           => 'scroll',
							'sanitize_callback' => '',
						),
						'page_404_content' => array(
							'default'           => sprintf( __( '<h3>oopS! Page  not  found</h3>
<p>The page you are looking for was moved, removed, renamed or might never existed.</p>
<a href="%s" class="opal-btn opal-btn-solid mgt30">Back to homepage</a>', 'opal-themecontrol' ), esc_url( home_url()
							) ),
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'page_404_show_searchform' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'page_404_content_heading' => array(
							'label'   => esc_html__( 'Content', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'page_404',
						),
						'page_404_content' => array(
							'label'       => esc_html__( 'Main Content', 'opal-themecontrol' ),
							'section'     => 'page_404',
							'type'        => 'Opal_Themecontrol_Customize_Control_Editor',
							'mode'        => 'htmlmixed',
							'button_text' => esc_html__( 'Set Content', 'opal-themecontrol' ),
						),
						'page_404_show_searchform' => array(
							'label'    => esc_html__( 'Show Search Form', 'opal-themecontrol' ),
							'section'  => 'page_404',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'page_404_styling_heading' => array(
							'label'   => esc_html__( 'Styling', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'page_404',
						),
						'page_404_bg_color' => array(
							'label'   => esc_html__( 'Background Color', 'opal-themecontrol' ),
							'section' => 'page_404',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
						),
						'page_404_bg_image' => array(
							'label'    => esc_html__( 'Background Image', 'opal-themecontrol' ),
							'section'  => 'page_404',
							'type'     => 'WP_Customize_Image_Control',
						),
						'page_404_bg_image_size' => array(
							'label'   => esc_html__( 'Background Size', 'opal-themecontrol' ),
							'section' => 'page_404',
							'type'    => 'select',
							'choices' => array(
								'auto'    => esc_html__( 'Auto', 'opal-themecontrol' ),
								'cover'   => esc_html__( 'Cover', 'opal-themecontrol' ),
								'contain' => esc_html__( 'Contain', 'opal-themecontrol' ),
							),
							'required' => array( 'page_404_bg_image != ""' ),
						),
						'page_404_bg_image_repeat' => array(
							'label'   => esc_html__( 'Background Repeat', 'opal-themecontrol' ),
							'section' => 'page_404',
							'type'    => 'select',
							'choices' => array(
								'no-repeat' => esc_html__( 'No Repeat', 'opal-themecontrol' ),
								'repeat'    => esc_html__( 'Repeat', 'opal-themecontrol' ),
								'repeat-x'  => esc_html__( 'Repeat X', 'opal-themecontrol' ),
								'repeat-y'  => esc_html__( 'Repeat Y', 'opal-themecontrol' ),
							),
							'required' => array( 'page_404_bg_image != ""' ),
						),
						'page_404_bg_image_position' => array(
							'label'   => esc_html__( 'Background Position', 'opal-themecontrol' ),
							'section' => 'page_404',
							'type'    => 'select',
							'choices' => array(
								'left top'      => esc_html__( 'Left Top', 'opal-themecontrol' ),
								'left center'   => esc_html__( 'Left Center', 'opal-themecontrol' ),
								'left bottom'   => esc_html__( 'Left Bottom', 'opal-themecontrol' ),
								'right top'     => esc_html__( 'Right Top', 'opal-themecontrol' ),
								'right center'  => esc_html__( 'Right Center', 'opal-themecontrol' ),
								'right bottom'  => esc_html__( 'Right Bottom', 'opal-themecontrol' ),
								'center top'    => esc_html__( 'Center Top', 'opal-themecontrol' ),
								'center center' => esc_html__( 'Center Center', 'opal-themecontrol' ),
								'center bottom' => esc_html__( 'Center Bottom', 'opal-themecontrol' ),
							),
							'required' => array( 'page_404_bg_image != ""' ),
						),
						'page_404_bg_image_attachment' => array(
							'label'   => esc_html__( 'Background Attachment', 'opal-themecontrol' ),
							'section' => 'page_404',
							'type'    => 'select',
							'choices' => array(
								'scroll' => esc_html__( 'Scroll', 'opal-themecontrol' ),
								'fixed'  => esc_html__( 'Fixed', 'opal-themecontrol' ),
							),
							'required' => array( 'page_404_bg_image != ""' ),
						),
						'page_404_title_font_size' => array(
							'label'       => esc_html__( '"404" Text Size', 'opal-themecontrol' ),
							'description' => esc_html__( 'Here you can change heading size.', 'opal-themecontrol' ),
							'section'     => 'page_404',
							'type'        => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices'     => array(
								'min'  => 14,
								'max'  => 200,
								'step' => 1,
								'unit' => 'px'
							),
						),
						'page_404_title_color' => array(
							'label'   => esc_html__( '"404" Color', 'opal-themecontrol' ),
							'section' => 'page_404',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
						),
					),
				),
			),
			'type'     => 'Opal_Themecontrol_Customize_Panel',
			'apply_to' => array( 'page' ),
		);
	}
}
