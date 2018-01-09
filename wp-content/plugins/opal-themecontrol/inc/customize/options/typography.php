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
class Opal_Themecontrol_Customize_Options_Typography {
	public static function get_options() {
		return array(
			'title'       => esc_html__( 'Typography', 'opal-themecontrol' ),
			'description' => '<a target="_blank" href="http://opalthemer.com/docs/document/typography"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
			'priority'    => 12,
			'sections' => array(
				'typo_general' => array(
					'title'    => esc_html__( 'General', 'opal-themecontrol' ),
					'settings' => array(
						'body_font_heading' => array(),
						'body_font_type' => array(
							'default'           => 'google',
							'sanitize_callback' => 'sanitize_key',
						),
						'body_custom_font' => array(
							'default'           => '',
							'sanitize_callback' => 'esc_url_raw',
						),
						'body_google_font' => array(
							'default' => array(
								'family'     => 'Lato',
								'fontWeight' => 400,
							),
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'body_standard_font' => array(
							'default'           => 'Verdana',
							'sanitize_callback' => '',
						),
						'body_font_size' => array(
							'default'           => 100,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'body_line_height' => array(
							'default'           => 24,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'body_letter_spacing' => array(
							'default'           => 0,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'heading_font_heading' => array(),
						'heading_font_type' => array(
							'default'           => 'google',
							'sanitize_callback' => '',
						),
						'heading_google_font' => array(
							'default' => array(
								'family'     => 'Lato',
								'italic'     => 0,
								'underline'  => 0,
								'uppercase'  => 0,
								'fontWeight' => 400,
							),
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'heading_custom_font' => array(
							'default'           => '',
							'sanitize_callback' => 'esc_url_raw',
						),
						'heading_standard_font' => array(
							'default'           => 'Verdana',
							'sanitize_callback' => '',
						),
						'heading_font_size' => array(
							'default'           => 16,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'heading_line_height' => array(
							'default'           => 18,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'heading_letter_spacing' => array(
							'default'           => 0,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'typo_general_custom_color' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'body_font_heading' => array(
							'label'       => esc_html__( 'Body Font', 'opal-themecontrol' ),
							'description' => esc_html__( 'Customize the typography style of main body.', 'opal-themecontrol' ),
							'type'        => 'Opal_Themecontrol_Customize_Control_Heading',
							'section'     => 'typo_general',
						),
						'body_font_type' => array(
							'label'   => esc_html__( 'Body Font Type', 'opal-themecontrol' ),
							'section' => 'typo_general',
							'type'    => 'select',
							'choices' => array(
								'standard' => esc_html__( 'Standard Fonts', 'opal-themecontrol' ),
								'google'   => esc_html__( 'Google Fonts', 'opal-themecontrol' ),
								'custom'   => esc_html__( 'Custom Fonts', 'opal-themecontrol' ),
							),
						),
						'body_custom_font' => array(
							'section'  => 'typo_general',
							'type'     => 'Opal_Themecontrol_Customize_Control_Upload_Font',
							'required' => array( 'body_font_type = custom' ),
						),
						'body_google_font' => array(
							'section' => 'typo_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Typography',
							'choices' => array(
								'family', 'fontWeight'
							),
							'required' => array( 'body_font_type = google' ),
						),
						'body_standard_font' => array(
							'section' => 'typo_general',
							'type'    => 'select',
							'choices' => array(
								'Verdana'      => 'Verdana',
								'Georgia'      => 'Georgia',
								'Courier New'  => 'Courier New',
								'Arial'        => 'Arial',
								'Tahoma'       => 'Tahoma',
								'Trebuchet MS' => 'Trebuchet MS'
							),
							'required' => array( 'body_font_type = standard' ),
						),
						'body_font_size' => array(
							'label'   => esc_html__( 'Body Text Size', 'opal-themecontrol' ),
							'section' => 'typo_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 50,
								'max'  => 250,
								'step' => 5,
								'unit' => '%',
							),
						),
						'body_line_height' => array(
							'label'   => esc_html__( 'Body Line Height', 'opal-themecontrol' ),
							'section' => 'typo_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 10,
								'max'  => 60,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'body_letter_spacing' => array(
							'label'   => esc_html__( 'Body Letter Spacing', 'opal-themecontrol' ),
							'section' => 'typo_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 10,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'heading_font_heading' => array(
							'label'       => esc_html__( 'Heading Font', 'opal-themecontrol' ),
							'description' => esc_html__( 'Customize the typography style of heading area. You can see changes on Page Title area.', 'opal-themecontrol' ),
							'type'        => 'Opal_Themecontrol_Customize_Control_Heading',
							'section'     => 'typo_general',
						),
						'heading_font_type' => array(
							'label'   => esc_html__( 'Heading Font Type', 'opal-themecontrol' ),
							'section' => 'typo_general',
							'type'    => 'select',
							'choices' => array(
								'standard' => esc_html__( 'Standard Fonts', 'opal-themecontrol' ),
								'google'   => esc_html__( 'Google Fonts', 'opal-themecontrol' ),
								'custom'   => esc_html__( 'Custom Fonts', 'opal-themecontrol' ),
							),
						),
						'heading_google_font' => array(
							'section'     => 'typo_general',
							'type'        => 'Opal_Themecontrol_Customize_Control_Typography',
							'choices'     => array(
								'family', 'fontWeight', 'italic', 'underline', 'uppercase',
							),
							'required' => array( 'heading_font_type = google' ),
						),
						'heading_custom_font' => array(
							'section'  => 'typo_general',
							'type'     => 'Opal_Themecontrol_Customize_Control_Upload_Font',
							'required' => array( 'heading_font_type = custom' ),
						),
						'heading_standard_font' => array(
							'section' => 'typo_general',
							'type'    => 'select',
							'choices' => array(
								'Verdana'      => 'Verdana',
								'Georgia'      => 'Georgia',
								'Courier New'  => 'Courier New',
								'Arial'        => 'Arial',
								'Tahoma'       => 'Tahoma',
								'Trebuchet MS' => 'Trebuchet MS'
							),
							'required' => array( 'heading_font_type = standard' ),
						),
						'heading_font_size' => array(
							'label'   => esc_html__( 'Heading Base Size', 'opal-themecontrol' ),
							'section' => 'typo_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 10,
								'max'  => 30,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'heading_line_height' => array(
							'label'   => esc_html__( 'Heading Line Height', 'opal-themecontrol' ),
							'section' => 'typo_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 10,
								'max'  => 60,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'heading_letter_spacing' => array(
							'label'   => esc_html__( 'Heading Letter Spacing', 'opal-themecontrol' ),
							'section' => 'typo_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 10,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'typo_general_custom_color' => array(
							'section' => 'typo_general',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<div class="btn-move-section"><a href="#" class="move-to-section button" data-section="color_general">' . esc_html__( 'Edit Color', 'opal-themecontrol' ) . '</a><a href="#" class="move-to-section button" data-section="layout_general">' . esc_html__( 'Edit Layout', 'opal-themecontrol' ) . '</a></div>',
							),
						),
					),
				),
				'typo_page_title' => array(
					'title'    => esc_html__( 'Page Title', 'opal-themecontrol' ),
					'settings'    => array(
						'opal_page_title_heading_font' => array(
							'default' => array(
								'italic'     => 0,
								'underline'  => 0,
								'uppercase'  => 0,
							),
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_page_title_heading_font_size' => array(
							'default'           => 44,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_page_title_heading_line_height' => array(
							'default'           => 44,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'opal_page_title_heading_letter_spacing' => array(
							'default'           => 0,
							'transport'         => 'postMessage',
							'sanitize_callback' => '',
						),
						'typo_page_title_custom_color' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'opal_page_title_heading_font' => array(
							'label'   => esc_html__( 'Heading Style', 'opal-themecontrol' ),
							'section' => 'typo_page_title',
							'type'    => 'Opal_Themecontrol_Customize_Control_Typography',
							'choices' => array(
								'italic', 'underline', 'uppercase',
							),
							'required' => array( 'opal_page_title = 1' ),
						),
						'opal_page_title_heading_font_size' => array(
							'label'   => esc_html__( 'Heading Text Size', 'opal-themecontrol' ),
							'section' => 'typo_page_title',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 10,
								'max'  => 100,
								'step' => 1,
								'unit' => 'px',
							),
							'required' => array( 'opal_page_title = 1' ),
						),
						'opal_page_title_heading_line_height' => array(
							'label'   => esc_html__( 'Heading Line Height', 'opal-themecontrol' ),
							'section' => 'typo_page_title',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 10,
								'max'  => 100,
								'step' => 1,
								'unit' => 'px',
							),
							'required' => array( 'opal_page_title = 1' ),
						),
						'opal_page_title_heading_letter_spacing' => array(
							'label'   => esc_html__( 'Heading Letter Spacing', 'opal-themecontrol' ),
							'section' => 'typo_page_title',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 10,
								'step' => 1,
								'unit' => 'px',
							),
							'required' => array( 'opal_page_title = 1' ),
						),
						'typo_page_title_custom_color' => array(
							'section' => 'typo_page_title',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<div class="btn-move-section"><a href="#" class="move-to-section button" data-section="color_pages">' . esc_html__( 'Edit Color', 'opal-themecontrol' ) . '</a><a href="#" class="move-to-section button" data-section="page_title">' . esc_html__( 'Edit Layout', 'opal-themecontrol' ) . '</a></div>',
							),
						),
					),
				),
				'typo_button' => array(
					'title'    => esc_html__( 'Button', 'opal-themecontrol' ),
					'settings' => array(
						'btn_font' => array(
							'default' => array(
								'italic'     => 0,
								'underline'  => 0,
								'uppercase'  => 1,
							),
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'btn_font_size' => array(
							'default'           => 13,
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'btn_line_height' => array(
							'default'           => 45,
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'btn_letter_spacing' => array(
							'default'           => 0,
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'typo_button_custom_color' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'btn_font' => array(
							'section' => 'typo_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Typography',
							'choices' => array(
								'italic', 'underline', 'uppercase',
							),
						),
						'btn_font_size' => array(
							'label'   => esc_html__( 'Text Size', 'opal-themecontrol' ),
							'section' => 'typo_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 10,
								'max'  => 24,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'btn_line_height' => array(
							'label'   => esc_html__( 'Line Height', 'opal-themecontrol' ),
							'section' => 'typo_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 30,
								'max'  => 100,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'btn_letter_spacing' => array(
							'label'   => esc_html__( 'Letter Spacing', 'opal-themecontrol' ),
							'section' => 'typo_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 10,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'typo_button_custom_color' => array(
							'section' => 'typo_button',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<div class="btn-move-section"><a href="#" class="move-to-section button" data-section="color_button">' . esc_html__( 'Edit Color', 'opal-themecontrol' ) . '</a><a href="#" class="move-to-section button" data-section="layout_button">' . esc_html__( 'Edit Layout', 'opal-themecontrol' ) . '</a></div>',
							),
						),
					),
				),
				'typo_quotes' => array(
					'title'    => esc_html__( 'Quotes', 'opal-themecontrol' ),
					'settings' => array(
						'quotes_font' => array(
							'default' => array(
								'family'     => 'Lato',
								'italic'     => 0,
								'underline'  => 0,
								'uppercase'  => 0,
								'fontWeight' => 400,
							),
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
					),
					'controls' => array(
						'quotes_font' => array(
							'section'     => 'typo_quotes',
							'type'        => 'Opal_Themecontrol_Customize_Control_Typography',
							'choices'     => array(
								'family', 'fontWeight', 'italic', 'underline', 'uppercase',
							),
						),
					),
				),
			)
		);
	}
}
