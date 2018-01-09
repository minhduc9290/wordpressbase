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
class Opal_Themecontrol_Customize_Options_System {
	public static function get_options() {
		return array(
			'title'       => esc_html__( 'System', 'opal-themecontrol' ),
			'description' => '<a target="_blank" href="http://opalthemer.com/docs/document/system"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
			'type'        => 'option',
			'priority' => 90,
			'settings' => array(
				'custom_css' => array(
					'sanitize_callback' => '',
				),
				'custom_js' => array(
					'sanitize_callback' => '',
				),
				'rtl' => array(
					'sanitize_callback' => '',
					'transport'         => 'postMessage',
				),
				'under_construction' => array(
					'sanitize_callback' => '',
				),
				'under_construction_style' => array(
					'default'           => 1,
					'transport'         => 'postMessage',
					'sanitize_callback' => '',
				),
				'under_construction_bg_color' => array(
					'default'           => '#f7f8fa',
					'transport'         => 'postMessage',
					'sanitize_callback' => '',
				),
				'under_construction_bg_image' => array(
					'default'           => get_template_directory_uri() . '/assets/woorockets/images/bg-construction.png',
					'sanitize_callback' => '',
				),
				'under_construction_bg_image_size' => array(
					'default'           => 'auto',
					'sanitize_callback' => '',
				),
				'under_construction_bg_image_repeat' => array(
					'default'           => 'no-repeat',
					'sanitize_callback' => '',
				),
				'under_construction_bg_image_position' => array(
					'default'           => 'right bottom',
					'sanitize_callback' => '',
				),
				'under_construction_bg_image_attachment' => array(
					'default'           => 'scroll',
					'sanitize_callback' => '',
				),
				'under_construction_title' => array(
					'sanitize_callback' => '',
					'transport'         => 'postMessage',
					'default'           => sprintf( __( '<h2>%1$s</h2> is coming soon', 'opal-themecontrol' ), 'Our website' ),
				),
				'under_construction_message' => array(
					'sanitize_callback' => '',
					'transport'         => 'postMessage',
					'default'           => esc_html__( 'Our website is offline now, but we will be back soon.', 'opal-themecontrol' ),
				),
				'under_construction_timer' => array(
					'sanitize_callback' => '',
					'default'           => '',
				),
				'compress_js' => array(
					'default'           => 0,
					'sanitize_callback' => 'sanitize_key',
				),
				'compress_css' => array(
					'default'           => 0,
					'sanitize_callback' => 'sanitize_key',
				),
				'max_compression_size' => array(
					'default'           => 200,
					'sanitize_callback' => array( __CLASS__, 'sanitize_max_compression_size' ),
				),
				'expert_mode' => array(
					'default'           => 0,
					'sanitize_callback' => 'sanitize_key',
				),
				'backup_restore' => array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				),
			),
			'controls' => array(
				'custom_css' => array(
					'label'           => esc_html__( 'Custom CSS', 'opal-themecontrol' ),
					'description'     => esc_html__( 'Paste your CSS code here. Do not place any &lt;style&gt; tags in these areas as they are already added for your convenience', 'opal-themecontrol' ),
					'section'         => 'system',
					'type'            => 'Opal_Themecontrol_Customize_Control_Editor',
					'mode'            => 'css',
					'placeholder'     => esc_html__( "/**\n * Write your custom CSS code here.\n */", 'opal-themecontrol' ),
					'confirm_message' => esc_html__( 'The custom CSS code has been changed. Are you sure you want to cancel?', 'opal-themecontrol' ),
				),
				'custom_js' => array(
					'label'           => esc_html__( 'Custom JS', 'opal-themecontrol' ),
					'description'     => esc_html__( 'Paste your JS code here. Do not place any &lt;script&gt; tags in these areas as they are already added for your convenience', 'opal-themecontrol' ),
					'section'         => 'system',
					'type'            => 'Opal_Themecontrol_Customize_Control_Editor',
					'mode'            => 'javascript',
					'placeholder'     => esc_html__( "/**\n * Write your custom Javascript code here.\n */", 'opal-themecontrol' ),
					'confirm_message' => esc_html__( 'The custom JS code has been changed. Are you sure you want to cancel?', 'opal-themecontrol' ),
				),
				'rtl' => array(
					'label'   => esc_html__( 'Enable Right To Left', 'opal-themecontrol' ),
					'section' => 'system',
					'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
				),
				'under_construction' => array(
					'label'   => esc_html__( 'Maintenance Mode', 'opal-themecontrol' ),
					'section' => 'system',
					'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
				),
				'under_construction_style' => array(
					'label'   => esc_html__( 'Choose Style', 'opal-themecontrol' ),
					'section' => 'system',
					'type'    => 'select',
					'choices' => array(
						'1' => esc_html__( 'Style 1', 'opal-themecontrol' ),
						'2' => esc_html__( 'Style 2', 'opal-themecontrol' ),
					),
					'required' => array(
						'under_construction = 1',
					),
				),
				'under_construction_bg_color' => array(
					'label'    => esc_html__( 'Background Color', 'opal-themecontrol' ),
					'section'  => 'system',
					'type'     => 'Opal_Themecontrol_Customize_Control_Colors',
					'required' => array(
						'under_construction = 1',
					),
				),
				'under_construction_bg_image' => array(
					'label'    => esc_html__( 'Background Image', 'opal-themecontrol' ),
					'section'  => 'system',
					'type'     => 'WP_Customize_Image_Control',
					'required' => array(
						'under_construction = 1',
					),
				),
				'under_construction_bg_image_size' => array(
					'label'   => esc_html__( 'Background Size', 'opal-themecontrol' ),
					'section' => 'system',
					'type'    => 'select',
					'choices' => array(
						'auto'    => esc_html__( 'Auto', 'opal-themecontrol' ),
						'cover'   => esc_html__( 'Cover', 'opal-themecontrol' ),
						'contain' => esc_html__( 'Contain', 'opal-themecontrol' ),
					),
					'required' => array(
						'under_construction = 1',
						'under_construction_bg_image != ""',
					),
				),
				'under_construction_bg_image_repeat' => array(
					'label'   => esc_html__( 'Background Repeat', 'opal-themecontrol' ),
					'section' => 'system',
					'type'    => 'select',
					'choices' => array(
						'no-repeat' => esc_html__( 'No Repeat', 'opal-themecontrol' ),
						'repeat'    => esc_html__( 'Repeat', 'opal-themecontrol' ),
						'repeat-x'  => esc_html__( 'Repeat X', 'opal-themecontrol' ),
						'repeat-y'  => esc_html__( 'Repeat Y', 'opal-themecontrol' ),
					),
					'required' => array(
						'under_construction = 1',
						'under_construction_bg_image != ""',
					),
				),
				'under_construction_bg_image_position' => array(
					'label'   => esc_html__( 'Background Position', 'opal-themecontrol' ),
					'section' => 'system',
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
						'under_construction = 1',
						'under_construction_bg_image != ""',
					),
				),
				'under_construction_bg_image_attachment' => array(
					'label'    => esc_html__( 'Background Attachment', 'opal-themecontrol' ),
					'section'  => 'system',
					'type'     => 'select',
					'choices'  => array(
						'scroll' => esc_html__( 'Scroll', 'opal-themecontrol' ),
						'fixed'  => esc_html__( 'Fixed', 'opal-themecontrol' ),
					),
					'required' => array(
						'under_construction = 1',
						'under_construction_bg_image != ""',
					),
				),
				'under_construction_title' => array(
					'label'    => esc_html__( 'Page Heading', 'opal-themecontrol' ),
					'section'  => 'system',
					'type'     => 'text',
					'required' => array( 'under_construction = 1' ),
				),
				'under_construction_message' => array(
					'label'       => esc_html__( 'Message', 'opal-themecontrol' ),
					'description' => esc_html__( 'Your away message. You may use these HTML tags and attributes to produce your own maintenance mode page', 'opal-themecontrol' ),
					'section'     => 'system',
					'type'        => 'textarea',
					'required'    => array( 'under_construction = 1' ),
				),
				'under_construction_timer' => array(
					'label'       => esc_html__( 'Countdown timer (Format: M D, Y)', 'opal-themecontrol' ),
					'description' => esc_html__( 'Set countdown timer for website launch', 'opal-themecontrol' ),
					'section'     => 'system',
					'type'        => 'date',
					'required'    => array( 'under_construction = 1' ),
				),
				'compress_js' => array(
					'label'   => esc_html__( 'Compress JS', 'opal-themecontrol' ),
					'section' => 'system',
					'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
				),
				'compress_css' => array(
					'label'   => esc_html__( 'Compress CSS', 'opal-themecontrol' ),
					'section' => 'system',
					'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
				),
				'max_compression_size' => array(
					'label'       => esc_html__( 'Max compression size', 'opal-themecontrol' ),
					'description' => esc_html__( 'Split compression file if file size is greater than the max compression size defined here.', 'opal-themecontrol' ),
					'section'     => 'system',
					'type'        => 'Opal_Themecontrol_Customize_Control_Slider',
					'choices'     => array(
						'min'  => 50,
						'max'  => 1000,
						'step' => 50,
						'unit' => ' KB',
					),
					'required' => array(
						'compress_js = 1',
						'compress_css = 1',
						'logical_operator' => 'OR',
					),
				),
				'expert_mode' => array(
					'label'       => esc_html__( 'Enable Expert Mode', 'opal-themecontrol' ),
					'description' => esc_html__( 'With `Expert Mode` turned off, all parameters that don`t affect current page will be disabled. If you want to edit those parameters anyway, turn on the `Expert Mode`.', 'opal-themecontrol' ),
					'section'     => 'system',
					'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
				),
				'backup_restore' => array(
					'label'       => '',
					'description' => '',
					'section'     => 'system',
					'type'        => 'Opal_Themecontrol_Customize_Control_Backup_Restore',
				),
			),
		);
	}

	/**
	 * Sanitize canvas sidebar widgets.
	 *
	 * @param   array  $value  Canvas sidebar widgets data.
	 *
	 * @return  array
	 */
	public static function sanitize_max_compression_size( $value ) {
		// Sanitize new value.
		$value = absint( $value );

		// Get current value.
		$current = get_theme_mod( 'max_compression_size' );

		// Clear all compression files if value is changed.
		if ( $value != $current && ( $path = Opal_Themecontrol_Assets::get_location() ) ) {
			global $wp_filesystem;

			$wp_filesystem->rmdir( $path, true );
		}

		return $value;
	}
}
