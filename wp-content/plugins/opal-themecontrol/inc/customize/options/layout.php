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
class Opal_Themecontrol_Customize_Options_Layout {
	public static function get_options() {
		return array(
			'title'       => esc_html__( 'Layout', 'opal-themecontrol' ),
			'description' => '<a target="_blank" href="http://opalthemer.com/docs/document/layout"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
			'priority'    => 11,
			'sections'    => array(
				'layout_general' => array(
					'title'       => esc_html__( 'General', 'opal-themecontrol' ),
					'description' => '',
					'settings' => array(
						'opal_layout_offset' => array(
							'default'           => 0,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_layout_content_width_unit' => array(
							'default'           => 'pixel',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_layout_content_width' => array(
							'default'           => 1170,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_layout_content_width_percentage' => array(
							'default'           => 100,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_layout_gutter_width' => array(
							'default'           => 30,
							'sanitize_callback' => '',
						),
						'opal_layout_boxed' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'general_custom_color' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'opal_preview' => array(
							'default'           => 'desktop',
							'transport'         => 'postMessage',
						),
					),
					'controls' => array(
						'opal_layout_offset' => array(
							'label'       => esc_html__( 'Offset Width', 'opal-themecontrol' ),
							'description' => esc_html__( 'Add a border around body', 'opal-themecontrol' ),
							'section'     => 'layout_general',
							'type'        => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 100,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'opal_layout_content_width_unit' => array(
							'label'       => esc_html__( 'Content Width', 'opal-themecontrol' ),
							'description' => esc_html__( 'Set the maximum allowed width for content', 'opal-themecontrol' ),
							'section'     => 'layout_general',
							'type'        => 'radio',
							'choices'  => array(
								'pixel'      => esc_html__( 'px', 'opal-themecontrol' ),
								'percentage' => esc_html__( '%', 'opal-themecontrol' ),
							),
						),
						'opal_layout_content_width' => array(
							'section' => 'layout_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 760,
								'max'  => 1920,
								'step' => 10,
								'unit' => 'px',
							),
							'required' => array( 'opal_layout_content_width_unit == pixel' ),
						),
						'opal_layout_content_width_percentage' => array(
							'section' => 'layout_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 20,
								'max'  => 100,
								'step' => 1,
								'unit' => '%',
							),
							'required' => array( 'opal_layout_content_width_unit == percentage' ),
						),
						'opal_layout_gutter_width' => array(
							'label'       => esc_html__( 'Gutter Width', 'opal-themecontrol' ),
							'description' => esc_html__( 'The width of the space between columns', 'opal-themecontrol' ),
							'section'     => 'layout_general',
							'type'        => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 20,
								'max'  => 60,
								'step' => 10,
								'unit' => 'px',
							),
						),
						'opal_layout_boxed' => array(
							'label'   => esc_html__( 'Enable Boxed Layout', 'opal-themecontrol' ),
							'section' => 'layout_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'general_custom_color' => array(
							'section' => 'layout_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1' => '<div class="btn-move-section"><a href="#" class="move-to-section button" data-section="color_general">' . esc_html__( 'Edit Color', 'opal-themecontrol' ) . '</a><a href="#" class="move-to-section button" data-section="typo_general">' . __( 'Edit Typography', 'opal-themecontrol' ) . '</a></div>',
							),
						),
						'opal_preview' => array(
							'section' => 'layout_general',
							'type'    => 'hidden',
						),
					)
				),
				'page_title' => array(
					'title'    => esc_html__( 'Page Title', 'opal-themecontrol' ),
					'settings'    => array(
						'opal_page_title' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'opal_page_title_layout' => array(
							'default'           => 'layout-1',
							'sanitize_callback' => '',
						),
						'opal_page_title_fullscreen' => array(
							'default'           => 0,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_page_title_breadcrumbs' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'opal_page_title_padding_top' => array(
							'default'           => 80,
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'opal_page_title_padding_bottom' => array(
							'default'           => 80,
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'opal_page_title_heading_min_height' => array(
							'default'           => 214,
							'sanitize_callback' => '',
						),
						'page_title_custom_color' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'opal_page_title' => array(
							'label'   => esc_html__( 'Show Page Title', 'opal-themecontrol' ),
							'section' => 'page_title',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'opal_page_title_fullscreen' => array(
							'label'    => esc_html__( 'Enable Full Width', 'opal-themecontrol' ),
							'section'  => 'page_title',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'opal_page_title = 1' ),
						),
						'opal_page_title_layout' => array(
							'label'       => esc_html__( 'Layout', 'opal-themecontrol' ),
							'section'     => 'page_title',
							'type'        => 'Opal_Themecontrol_Customize_Control_Select_Image',
							'choices'     => array(
								'layout-1'  => esc_html__( 'Layout 1', 'opal-themecontrol' ),
								'layout-2'  => esc_html__( 'Layout 2', 'opal-themecontrol' ),
								'layout-3'  => esc_html__( 'Layout 3', 'opal-themecontrol' ),
								'layout-4'  => esc_html__( 'Layout 4', 'opal-themecontrol' ),
								'layout-5'  => esc_html__( 'Layout 5', 'opal-themecontrol' ),
							),
							'required' => array( 'opal_page_title = 1' ),
						),
						'opal_page_title_breadcrumbs' => array(
							'label'    => esc_html__( 'Show Breadcrumb', 'opal-themecontrol' ),
							'section'  => 'page_title',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'opal_page_title = 1' ),
						),
						'opal_page_title_padding_top' => array(
							'label'    => esc_html__( 'Padding Top', 'opal-themecontrol' ),
							'section'  => 'page_title',
							'type'     => 'Opal_Themecontrol_Customize_Control_Slider',
							'required' => array( 'opal_page_title = 1' ),
							'choices' => array(
								'min'  => 0,
								'max'  => 500,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'opal_page_title_padding_bottom' => array(
							'label'    => esc_html__( 'Padding Bottom', 'opal-themecontrol' ),
							'section'  => 'page_title',
							'type'     => 'Opal_Themecontrol_Customize_Control_Slider',
							'required' => array( 'opal_page_title = 1' ),
							'choices' => array(
								'min'  => 0,
								'max'  => 500,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'opal_page_title_heading_min_height' => array(
							'label'   => esc_html__( 'Min Height', 'opal-themecontrol' ),
							'section' => 'page_title',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 1000,
								'step' => 5,
								'unit' => 'px',
							),
							'required' => array( 'opal_page_title = 1' ),
						),
						'page_title_custom_color' => array(
							'section' => 'page_title',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<div class="btn-move-section"><a href="#" class="move-to-section button" data-section="color_pages">' . esc_html__( 'Edit Color', 'opal-themecontrol' ) . '</a><a href="#" class="move-to-section button" data-section="typo_page_title">' . __( 'Edit Typography', 'opal-themecontrol' ) . '</a></div>',
							),
							'required' => array( 'opal_page_title = 1' ),
						),
					),
				),
				'layout_button' => array(
					'title'    => esc_html__( 'Button', 'opal-themecontrol' ),
					'settings' => array(
						'btn_border_width' => array(
							'default'           => 2,
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'btn_border_radius' => array(
							'default'           => 2,
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'btn_padding' => array(
							'default'           => 20,
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'button_custom_color' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'btn_padding' => array(
							'label'   => esc_html__( 'Padding ( Left + Right )', 'opal-themecontrol' ),
							'section' => 'layout_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 5,
								'max'  => 50,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'btn_border_radius' => array(
							'label'   => esc_html__( 'Border Radius', 'opal-themecontrol' ),
							'section' => 'layout_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 50,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'btn_border_width' => array(
							'label'       => esc_html__( 'Border Width', 'opal-themecontrol' ),
							'section'     => 'layout_button',
							'type'        => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices'     => array(
								'min'  => 1,
								'max'  => 10,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'button_custom_color' => array(
							'section' => 'layout_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<div class="btn-move-section"><a href="#" class="move-to-section button" data-section="color_button">' . esc_html__( 'Edit Color', 'opal-themecontrol' ) . '</a><a href="#" class="move-to-section button" data-section="typo_button">' . esc_html__( 'Edit Typography', 'opal-themecontrol' ) . '</a></div>',
							),
						),
					),
				),
			)
		);
	}
}
