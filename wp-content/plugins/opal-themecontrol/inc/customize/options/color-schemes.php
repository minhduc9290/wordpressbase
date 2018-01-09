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
class Opal_Themecontrol_Customize_Options_Color_Schemes {
	public static function get_options() {
		return array(
			'title'       => esc_html__( 'Color', 'opal-themecontrol' ),
			'description' => '<a target="_blank" href="http://opalthemer.com/docs/document/color"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
			'priority'    => 13,
			'sections' => array(
				'color_general' => array(
					'title'    => esc_html__( 'General', 'opal-themecontrol' ),
					'settings' => array(
						'color_profile' => array(
							'default'           => 'profile-1',
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'custom_color' => array(
							'default'           => '#ff4064',
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'content_body_color' => array(
							'default'   => array(
								'body_text'    => '#646464',
								'heading_text' => '#323232',
							),
							'transport' => 'postMessage',
						),
						'general_line_color' => array(
							'default'   => '#ebebeb',
							'transport' => 'postMessage',
						),
						'content_meta_color' => array(
							'default'   => '#ababab',
							'transport' => 'postMessage',
						),
						'general_color_heading' => array(),
						'general_bg_heading'    => array(),
						'opal_general_container_color' => array(
							'default'   => '#ffffff',
							'transport' => 'postMessage',
						),
						'opal_layout_offset_color' => array(
							'default'   => '#ffffff',
							'transport' => 'postMessage',
						),
						'opal_page_body_bg_color' => array(
							'default'   => '#ffffff',
							'transport' => 'postMessage',
						),
						'opal_layout_boxed_bg_image' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'opal_layout_boxed_size' => array(
							'default'           => 'auto',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_layout_boxed_repeat' => array(
							'default'           => 'no-repeat',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_layout_boxed_position' => array(
							'default'           => 'left top',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_layout_boxed_attachment' => array(
							'default'           => 'scroll',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_layout_boxed_parallax' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'opal_layout_boxed_bg_mask_color' => array(
							'default'   => 'rgba(0, 0, 0, 0)',
							'transport' => 'postMessage',
						),
						'general_overlay_color' => array(
							'default'   => '#f2f2f2',
							'transport' => 'postMessage',
						),
						'general_fields_bg' => array(
							'default'   => '#f9f9f9',
							'transport' => 'postMessage',
						),
						'move_to_general' => array(
							'default'   => 1,
						),
					),
					'controls' => array(
						'color_profile' => array(
							'label'   => esc_html__( 'Color Profiles', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Preset',
							'section' => 'color_general',
							'preset'  => Opal_Themecontrol_Customize::get_color_profiles(),
						),
						'general_bg_heading' => array(
							'label'   => esc_html__( 'Background', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'color_general',
						),
						'opal_page_body_bg_color' => array(
							'section' => 'color_general',
							'label'   => esc_html__( 'Outer Body BG', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'required' => array( 'opal_layout_boxed = 1' ),
						),
						'opal_general_container_color' => array(
							'section' => 'color_general',
							'label'   => esc_html__( 'Inner Body BG', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
						),
						'general_overlay_color' => array(
							'section' => 'color_general',
							'label'   => esc_html__( 'Secondary BG', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
						),
						'general_fields_bg' => array(
							'section' => 'color_general',
							'label'   => esc_html__( 'Form Fields BG', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
						),
						'opal_layout_offset_color' => array(
							'section' => 'color_general',
							'label'   => esc_html__( 'Offset BG', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'required' => array( 'opal_layout_offset != 0' ),
						),
						'opal_layout_boxed_bg_image' => array(
							'label'    => esc_html__( 'Outer Body BG Image', 'opal-themecontrol' ),
							'section'  => 'color_general',
							'type'     => 'WP_Customize_Image_Control',
							'required' => array( 'opal_layout_boxed = 1' ),
						),
						'opal_layout_boxed_size' => array(
							'label'    => esc_html__( 'BG Size', 'opal-themecontrol' ),
							'section'  => 'color_general',
							'type'     => 'select',
							'choices'  => array(
								'auto'    => esc_html__( 'Auto', 'opal-themecontrol' ),
								'cover'   => esc_html__( 'Cover', 'opal-themecontrol' ),
								'contain' => esc_html__( 'Contain', 'opal-themecontrol' ),
								'initial' => esc_html__( 'Initial', 'opal-themecontrol' ),
							),
							'required' => array(
								'opal_layout_boxed = 1',
								'opal_layout_boxed_bg_image != ""',
							),
						),
						'opal_layout_boxed_repeat' => array(
							'label'    => esc_html__( 'BG Repeat', 'opal-themecontrol' ),
							'section'  => 'color_general',
							'type'     => 'select',
							'choices'  => array(
								'no-repeat' => esc_html__( 'No Repeat', 'opal-themecontrol' ),
								'repeat'    => esc_html__( 'Repeat', 'opal-themecontrol' ),
								'repeat-x'  => esc_html__( 'Repeat X', 'opal-themecontrol' ),
								'repeat-y'  => esc_html__( 'Repeat Y', 'opal-themecontrol' ),
							),
							'required' => array(
								'opal_layout_boxed = 1',
								'opal_layout_boxed_bg_image != ""',
							),
						),
						'opal_layout_boxed_position' => array(
							'label'    => esc_html__( 'BG Position', 'opal-themecontrol' ),
							'section'  => 'color_general',
							'type'     => 'select',
							'choices'  => array(
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
							'required' => array(
								'opal_layout_boxed = 1',
								'opal_layout_boxed_bg_image != ""',
							),
						),
						'opal_layout_boxed_attachment' => array(
							'label'    => esc_html__( 'BG Attachment', 'opal-themecontrol' ),
							'section'  => 'color_general',
							'type'     => 'select',
							'choices'  => array(
								'scroll' => esc_html__( 'Scroll', 'opal-themecontrol' ),
								'fixed'  => esc_html__( 'Fixed', 'opal-themecontrol' ),
							),
							'required' => array(
								'opal_layout_boxed = 1',
								'opal_layout_boxed_bg_image != ""',
							),
						),
						'opal_layout_boxed_parallax' => array(
							'label'       => esc_html__( 'Enable Parallax', 'opal-themecontrol' ),
							'section'     => 'color_general',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'opal_layout_boxed = 1',
								'opal_layout_boxed_bg_image != ""',
							),
						),
						'opal_layout_boxed_bg_mask_color' => array(
							'section' => 'color_general',
							'label'   => esc_html__( 'Mask Overlay Color', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'required' => array(
								'opal_layout_boxed = 1',
								'opal_layout_boxed_bg_image != ""',
							),
						),
						'general_color_heading' => array(
							'label'   => esc_html__( 'Content', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'color_general',
						),
						'custom_color' => array(
							'label'    => esc_html__( 'Main', 'opal-themecontrol' ),
							'section'  => 'color_general',
							'type'     => 'Opal_Themecontrol_Customize_Control_Colors',
						),
						'content_body_color' => array(
							'section' => 'color_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'body_text'    => esc_html__( 'Text', 'opal-themecontrol' ),
								'heading_text' => esc_html__( 'Heading', 'opal-themecontrol' ),
							),
						),
						'content_meta_color' => array(
							'label'   => esc_html__( 'Entry Meta', 'opal-themecontrol' ),
							'section' => 'color_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
						),
						'general_line_color' => array(
							'section' => 'color_general',
							'label'   => esc_html__( 'Line', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
						),
						'move_to_general' => array(
							'section' => 'color_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<div class="btn-move-section"><a href="#" class="move-to-section button" data-section="layout_general">' . esc_html__( 'Edit Layout', 'opal-themecontrol' ) . '</a><a href="#" class="move-to-section button" data-section="typo_general">' . esc_html__( 'Edit Typography', 'opal-themecontrol' ) . '</a></div>',
							),
						),
					),
				),
				'color_pages' => array(
					'title'       => esc_html__( 'Page Title', 'opal-themecontrol' ),
					'description' => '',
					'settings' => array(
						'page_bg_heading' => array(),
						'opal_page_title_custom_color' => array(
							'default'   => 1,
						),
						'opal_page_title_bg_color' => array(
							'default'   => '#f2f2f2',
							'transport' => 'postMessage',
						),
						'opal_page_title_bg_image' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'opal_page_title_size' => array(
							'default'           => 'auto',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_page_title_repeat' => array(
							'default'           => 'no-repeat',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_page_title_position' => array(
							'default'           => 'left top',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_page_title_attachment' => array(
							'default'           => 'scroll',
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_page_title_parallax' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'opal_page_title_mask_color' => array(
							'default'   => 'rgba(0, 0, 0, 0)',
							'transport' => 'postMessage',
						),
						'opal_page_title_link_colors' => array(
							'default'   => array(
								'normal' => '#323232',
								'hover'  => '#ff4064',
							),
							'transport' => 'postMessage',
						),
						'page_title_heading' => array(),
						'opal_page_title_color' => array(
							'default'   => array(
								'head' => '#323232',
								'body' => '#646464',
							),
							'transport' => 'postMessage',
						),
						'move_to_page_title' => array(
							'default'   => 1,
						),
					),
					'controls' => array(
						'opal_page_title_custom_color' => array(
							'label'       => esc_html__( 'Use General Color', 'opal-themecontrol' ),
							'description' => esc_html__( 'To save time, you can use colors defined in section "General". If you want to set specific color, turn off this parameter.', 'opal-themecontrol' ),
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'section'     => 'color_pages',
							'required' => array(
								'opal_page_title = 1'
							),
						),
						'page_bg_heading' => array(
							'label'   => esc_html__( 'Background', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'color_pages',
						),
						'opal_page_title_bg_color' => array(
							'label'   => esc_html__( 'Background Color', 'opal-themecontrol' ),
							'section' => 'color_pages',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'required' => array(
								'opal_page_title_custom_color = 0',
								'opal_page_title = 1',
								'dependency_failed_action' => 'disable',
							),
						),
						'opal_page_title_bg_image' => array(
							'label'    => esc_html__( 'Background Image', 'opal-themecontrol' ),
							'section'  => 'color_pages',
							'type'     => 'WP_Customize_Image_Control',
							'required' => array(
								'opal_page_title = 1',
								'dependency_failed_action' => 'disable'
							),
						),
						'opal_page_title_size' => array(
							'label'   => esc_html__( 'Background Size', 'opal-themecontrol' ),
							'section' => 'color_pages',
							'type'    => 'select',
							'choices' => array(
								'auto'    => esc_html__( 'Auto', 'opal-themecontrol' ),
								'cover'   => esc_html__( 'Cover', 'opal-themecontrol' ),
								'contain' => esc_html__( 'Contain', 'opal-themecontrol' ),
							),
							'required' => array(
								'opal_page_title_bg_image != ""',
							),
						),
						'opal_page_title_repeat' => array(
							'label'   => esc_html__( 'Background Repeat', 'opal-themecontrol' ),
							'section' => 'color_pages',
							'type'    => 'select',
							'choices' => array(
								'no-repeat' => esc_html__( 'No Repeat', 'opal-themecontrol' ),
								'repeat'    => esc_html__( 'Repeat', 'opal-themecontrol' ),
								'repeat-x'  => esc_html__( 'Repeat X', 'opal-themecontrol' ),
								'repeat-y'  => esc_html__( 'Repeat Y', 'opal-themecontrol' ),
							),
							'required' => array(
								'opal_page_title_bg_image != ""',
							),
						),
						'opal_page_title_position' => array(
							'label'   => esc_html__( 'Background Position', 'opal-themecontrol' ),
							'section' => 'color_pages',
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
							'required' => array(
								'opal_page_title_bg_image != ""',
								'opal_page_title_parallax = 0',
							),
						),
						'opal_page_title_attachment' => array(
							'label'   => esc_html__( 'Background Attachment', 'opal-themecontrol' ),
							'section' => 'color_pages',
							'type'    => 'select',
							'choices' => array(
								'scroll' => esc_html__( 'Scroll', 'opal-themecontrol' ),
								'fixed'  => esc_html__( 'Fixed', 'opal-themecontrol' ),
							),
							'required' => array(
								'opal_page_title_bg_image != ""',
							),
						),
						'opal_page_title_parallax' => array(
							'label'    => esc_html__( 'Parallax Background', 'opal-themecontrol' ),
							'section'  => 'color_pages',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'opal_page_title_bg_image != ""',
							),
						),
						'opal_page_title_mask_color' => array(
							'section' => 'color_pages',
							'label'   => esc_html__( 'Mask Overlay Color', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'required' => array(
								'opal_page_title_bg_image != ""',
							),
						),
						'page_title_heading' => array(
							'label'   => esc_html__( 'Content', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'color_pages',
						),
						'opal_page_title_color' => array(
							'section' => 'color_pages',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'body' => esc_html__( 'Text', 'opal-themecontrol' ),
								'head' => esc_html__( 'Heading', 'opal-themecontrol' ),
							),
							'required' => array(
								'opal_page_title_custom_color = 0',
								'opal_page_title = 1',
								'dependency_failed_action' => 'disable',
							),
						),
						'opal_page_title_link_colors' => array(
							'section' => 'color_pages',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'normal' => esc_html__( 'Link', 'opal-themecontrol' ),
								'hover'  => esc_html__( 'Link Hover', 'opal-themecontrol' ),
							),
							'required' => array(
								'opal_page_title_custom_color = 0',
								'opal_page_title = 1',
								'dependency_failed_action' => 'disable',
							),
						),
						'move_to_page_title' => array(
							'section' => 'color_pages',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1' => '<div class="btn-move-section"><a href="#" class="move-to-section button" data-section="page_title">' . esc_html__( 'Edit Layout', 'opal-themecontrol' ) . '</a><a href="#" class="move-to-section button" data-section="typo_page_title">' . esc_html__( 'Edit Typography', 'opal-themecontrol' ) . '</a></div>',
							),
						),
					),
				),
				'color_button' => array(
					'title'    => esc_html__( 'Button', 'opal-themecontrol' ),
					'settings' => array(
						'btn_primary_color_heading' => array(),
						'btn_primary_bg_color' => array(
							'default' => array(
								'normal' => '#323232',
								'hover'  => '#222',
							),
							'transport' => 'postMessage',
						),
						'btn_primary_color' => array(
							'default' => array(
								'normal' => '#fff',
								'hover'  => '#fff',
							),
							'transport' => 'postMessage',
						),
						'btn_primary_border_color' => array(
							'default' => array(
								'normal' => '#323232',
								'hover'  => '#323232',
							),
							'transport' => 'postMessage',
						),
						'btn_secondary_color_heading' => array(),
						'btn_secondary_bg_color' => array(
							'default' => array(
								'normal' => 'rgba(255, 255, 255, 0)',
								'hover'  => '#222',
							),
							'transport' => 'postMessage',
						),
						'btn_secondary_color' => array(
							'default' => array(
								'normal' => '#323232',
								'hover'  => '#fff',
							),
							'transport' => 'postMessage',
						),
						'btn_secondary_border_color' => array(
							'default' => array(
								'normal' => '#323232',
								'hover'  => '#323232',
							),
							'transport' => 'postMessage',
						),
						'move_to_button' => array(
							'default'   => 1,
						),
					),
					'controls' => array(
						'btn_primary_color_heading' => array(
							'label'   => esc_html__( 'Primary', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'color_button',
						),
						'btn_primary_bg_color' => array(
							'section' => 'color_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'normal' => esc_html__( 'Background', 'opal-themecontrol' ),
								'hover' => esc_html__( 'Background Hover', 'opal-themecontrol' ),
							),
						),
						'btn_primary_color' => array(
							'section' => 'color_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'normal' => esc_html__( 'Text', 'opal-themecontrol' ),
								'hover'  => esc_html__( 'Text Hover', 'opal-themecontrol' ),
							),
						),
						'btn_primary_border_color' => array(
							'section' => 'color_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'normal' => esc_html__( 'Border', 'opal-themecontrol' ),
								'hover'  => esc_html__( 'Border Hover', 'opal-themecontrol' ),
							),
						),
						'btn_secondary_color_heading' => array(
							'label'   => esc_html__( 'Secondary', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'color_button',
						),
						'btn_secondary_bg_color' => array(
							'section' => 'color_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'normal' => esc_html__( 'Background', 'opal-themecontrol' ),
								'hover'  => esc_html__( 'Background Hover', 'opal-themecontrol' ),
							),
						),
						'btn_secondary_color' => array(
							'section' => 'color_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'normal' => esc_html__( 'Text', 'opal-themecontrol' ),
								'hover'  => esc_html__( 'Text Hover', 'opal-themecontrol' ),
							),
						),
						'btn_secondary_border_color' => array(
							'section' => 'color_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'normal' => esc_html__( 'Border', 'opal-themecontrol' ),
								'hover'  => esc_html__( 'Border Hover', 'opal-themecontrol' ),
							),
						),
						'move_to_button' => array(
							'section' => 'color_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<div class="btn-move-section"><a href="#" class="move-to-section button" data-section="layout_button">' . esc_html__( 'Edit Layout', 'opal-themecontrol' ) . '</a><a href="#" class="move-to-section button" data-section="typo_button">' . esc_html__( 'Edit Typography', 'opal-themecontrol' ) . '</a></div>',
							),
						),
					),
				),
				'color_footer' => array(
					'title'    => esc_html__( 'Footer', 'opal-themecontrol' ),
					'settings' => array(
						'footer_top_heading' => array(),
						'footer_top_bg_color' => array(
							'default'   => '#ffffff',
							'transport' => 'postMessage',
						),
						'footer_customize_color' => array(
							'default'   => 1,
						),
						'footer_top_color' => array(
							'default'   => array(
								'text'    => '#646464',
								'heading' => '#323232',
							),
							'transport' => 'postMessage',
						),
						'footer_bg_image' => array(
							'default'           => '',
						),
						'footer_bg_image_size' => array(
							'default'   => 'auto',
							'transport' => 'postMessage',
						),
						'footer_bg_image_repeat' => array(
							'default'   => 'no-repeat',
							'transport' => 'postMessage',
						),
						'footer_bg_image_position' => array(
							'default'   => 'center center',
							'transport' => 'postMessage',
						),
						'footer_bg_image_attachment' => array(
							'default'   => 'scroll',
							'transport' => 'postMessage',
						),
						'footer_top_link_color' => array(
							'default' => array(
								'normal' => '#646464',
								'hover'  => '#ff4064',
							),
							'transport' => 'postMessage',
						),
						'footer_bot_heading' => array(),
						'footer_bot_color' => array(
							'default' => array(
								'bg'   => '#f2f2f2',
								'text' => '#646464',
							),
							'transport' => 'postMessage',
						),
						'footer_bot_link_color' => array(
							'default'   => array(
								'normal' => '#646464',
								'hover'  => '#ff4064',
							),
							'transport' => 'postMessage',
						),
						'move_to_footer' => array(
							'default'   => 1,
						),
					),
					'controls' => array(
						'footer_customize_color' => array(
							'label'       => esc_html__( 'Use General Color', 'opal-themecontrol' ),
							'description' => esc_html__( 'To save time, you can use colors defined in section "General". If you want to set specific color, turn off this parameter.', 'opal-themecontrol' ),
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'section'     => 'color_footer',
						),
						'footer_top_heading' => array(
							'label'    => esc_html__( 'Footer', 'opal-themecontrol' ),
							'type'     => 'Opal_Themecontrol_Customize_Control_Heading',
							'section'  => 'color_footer',
						),
						'footer_top_bg_color' => array(
							'label'    => esc_html__( 'Background Color', 'opal-themecontrol' ),
							'section'  => 'color_footer',
							'type'     => 'Opal_Themecontrol_Customize_Control_Colors',
							'required' => array(
								'footer_customize_color = 0',
								'dependency_failed_action' => 'disable'
							),
						),
						'footer_bg_image' => array(
							'label'    => esc_html__( 'Background Image', 'opal-themecontrol' ),
							'section'  => 'color_footer',
							'type'     => 'WP_Customize_Image_Control',
							'required' => array(
								'footer_customize_color = 0',
								'dependency_failed_action' => 'disable',
							),
						),
						'footer_bg_image_size' => array(
							'label'   => esc_html__( 'Background Size', 'opal-themecontrol' ),
							'section' => 'color_footer',
							'type'    => 'select',
							'choices' => array(
								'auto'    => esc_html__( 'Auto', 'opal-themecontrol' ),
								'cover'   => esc_html__( 'Cover', 'opal-themecontrol' ),
								'contain' => esc_html__( 'Contain', 'opal-themecontrol' ),
							),
							'required' => array(
								'footer_bg_image != ""',
								'footer_customize_color = 0'
							),
						),
						'footer_bg_image_repeat' => array(
							'label'   => esc_html__( 'Background Repeat', 'opal-themecontrol' ),
							'section' => 'color_footer',
							'type'    => 'select',
							'choices' => array(
								'no-repeat' => esc_html__( 'No Repeat', 'opal-themecontrol' ),
								'repeat'    => esc_html__( 'Repeat', 'opal-themecontrol' ),
								'repeat-x'  => esc_html__( 'Repeat X', 'opal-themecontrol' ),
								'repeat-y'  => esc_html__( 'Repeat Y', 'opal-themecontrol' ),
							),
							'required' => array(
								'footer_bg_image != ""',
								'footer_customize_color = 0'
							),
						),
						'footer_bg_image_position' => array(
							'label'   => esc_html__( 'Background Position', 'opal-themecontrol' ),
							'section' => 'color_footer',
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
							'required' => array(
								'footer_bg_image != ""',
								'footer_customize_color = 0'
							),
						),
						'footer_bg_image_attachment' => array(
							'label'   => esc_html__( 'Background Attachment', 'opal-themecontrol' ),
							'section' => 'color_footer',
							'type'    => 'select',
							'choices' => array(
								'scroll' => esc_html__( 'Scroll', 'opal-themecontrol' ),
								'fixed'  => esc_html__( 'Fixed', 'opal-themecontrol' ),
							),
							'required' => array(
								'footer_bg_image != ""',
								'footer_customize_color = 0',
							),
						),
						'footer_top_color' => array(
							'section' => 'color_footer',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'text'    => esc_html__( 'Text', 'opal-themecontrol' ),
								'heading' => esc_html__( 'Heading', 'opal-themecontrol' ),
							),
							'required' => array(
								'footer_customize_color = 0',
								'dependency_failed_action' => 'disable',
							),
						),
						'footer_top_link_color' => array(
							'section' => 'color_footer',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'normal' => esc_html__( 'Link', 'opal-themecontrol' ),
								'hover'  => esc_html__( 'Link Hover', 'opal-themecontrol' ),
							),
							'required' => array(
								'footer_customize_color = 0',
								'dependency_failed_action' => 'disable',
							),
						),
						'footer_bot_heading' => array(
							'label'   => esc_html__( 'Footer Bottom', 'opal-themecontrol' ),
							'type'    => 'Opal_Themecontrol_Customize_Control_Heading',
							'section' => 'color_footer'
						),
						'footer_bot_color' => array(
							'section' => 'color_footer',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'text' => esc_html__( 'Text', 'opal-themecontrol' ),
								'bg'   => esc_html__( 'Background Color', 'opal-themecontrol' ),
							),
							'required' => array(
								'footer_customize_color = 0',
								'dependency_failed_action' => 'disable',
							),
						),
						'footer_bot_link_color' => array(
							'section' => 'color_footer',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'normal' => esc_html__( 'Link', 'opal-themecontrol' ),
								'hover'  => esc_html__( 'Link Hover', 'opal-themecontrol' ),
							),
							'required' => array(
								'footer_customize_color = 0',
								'dependency_failed_action' => 'disable',
							),
						),
						'move_to_footer' => array(
							'section' => 'color_footer',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="footer">' . esc_html__( 'Customize Footer', 'opal-themecontrol' ) . '</a></h3>',
							),
						),
					),
				),
			)
		);
	}
}
