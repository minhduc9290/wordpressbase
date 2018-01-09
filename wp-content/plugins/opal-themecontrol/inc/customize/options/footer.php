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
class Opal_Themecontrol_Customize_Options_Footer {
	public static function get_options() {
		return array(
			'title'       => esc_html__( 'Footer', 'opal-themecontrol' ),
			'description' => '<a target="_blank" href="http://opalthemer.com/docs/document/footer"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
			'type'        => 'option',
			'priority'    => 80,
			'settings'    => array(
				'footer_fullwidth' => array(
					'default'           => 0,
					'transport'         => 'postMessage',
					'sanitize_callback' => '',
				),
				'footer_layout' => array(
					'default'           => 'layout-7',
					'sanitize_callback' => '',
				),
				'footer_sidebar_1' => array(
					'default'           => 'footer-1',
					'sanitize_callback' => '',
				),
				'footer_sidebar_2' => array(
					'default'           => 'footer-2',
					'sanitize_callback' => '',
				),
				'footer_sidebar_3' => array(
					'default'           => 'footer-3',
					'sanitize_callback' => '',
				),
				'footer_sidebar_4' => array(
					'default'           => 'footer-4',
					'sanitize_callback' => '',
				),
				'footer_sidebar_5' => array(
					'default'           => 'footer-5',
					'sanitize_callback' => '',
				),
				'footer_bot_text' => array(
					'default'           =>  esc_html__( '&copy;2016 Nitro. Made with &hearts; by WooRockets team using WordPress & WooCommerce.', 'opal-themecontrol' ),
					'transport'         => 'postMessage',
					'sanitize_callback' => '',
				),
				'footer_custom_color' => array(
					'default'           => 1,
					'sanitize_callback' => '',
				),
			),
			'controls' => array(
				'footer_fullwidth' => array(
					'label'   => esc_html__( 'Enable Full Width', 'opal-themecontrol' ),
					'section' => 'footer',
					'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
				),
				'footer_layout' => array(
					'label'       => esc_html__( 'Sidebar Layout', 'opal-themecontrol' ),
					'description' => sprintf( __( 'Select the layout type for the footer. The content is added via Appearance <a target="_blank" href="%s">Widgets</a>.', 'opal-themecontrol' ), admin_url( 'widgets.php' ) ),
					'section'     => 'footer',
					'type'        => 'Opal_Themecontrol_Customize_Control_Select_Image',
					'choices'     => array(
						'layout-1'  => '',
						'layout-2'  => '',
						'layout-3'  => '',
						'layout-4'  => '',
						'layout-5'  => '',
						'layout-6'  => '',
						'layout-7'  => '',
						'layout-8'  => '',
						'layout-9'  => '',
						'layout-10' => '',
						'layout-11' => '',
						'layout-12' => '',
					),
				),
				'footer_sidebar_1' => array(
					'label'   => esc_html__( 'Sidebar "1" Content', 'opal-themecontrol' ),
					'section' => 'footer',
					'type'    => 'select',
					'choices' => Opal_Themecontrol_Helper::get_sidebars(),
				),
				'footer_sidebar_2' => array(
					'label'    => esc_html__( 'Sidebar "2" Content', 'opal-themecontrol' ),
					'section'  => 'footer',
					'type'     => 'select',
					'choices'  => Opal_Themecontrol_Helper::get_sidebars(),
					'required' => array( 'footer_layout != layout-1' ),
				),
				'footer_sidebar_3' => array(
					'label'    => esc_html__( 'Sidebar "3" Content', 'opal-themecontrol' ),
					'section'  => 'footer',
					'type'     => 'select',
					'choices'  => Opal_Themecontrol_Helper::get_sidebars(),
					'required' => array( 'footer_layout = "layout-3|layout-5|layout-7|layout-8|layout-10|layout-11|layout-12"' ),
				),
				'footer_sidebar_4' => array(
					'label'    => esc_html__( 'Sidebar "4" Content', 'opal-themecontrol' ),
					'section'  => 'footer',
					'type'     => 'select',
					'choices'  => Opal_Themecontrol_Helper::get_sidebars(),
					'required' => array( 'footer_layout = "layout-7|layout-11|layout-12"' ),
				),
				'footer_sidebar_5' => array(
					'label'    => esc_html__( 'Sidebar "5" Content', 'opal-themecontrol' ),
					'section'  => 'footer',
					'type'     => 'select',
					'choices'  => Opal_Themecontrol_Helper::get_sidebars(),
					'required' => array( 'footer_layout = "layout-11|layout-12"' ),
				),
				'footer_bot_text' => array(
					'label'       => esc_html__( 'Copyright Text', 'opal-themecontrol' ),
					'section'     => 'footer',
					'type'        => 'Opal_Themecontrol_Customize_Control_Editor',
					'mode'        => 'htmlmixed',
					'button_text' => esc_html__( 'Set Content', 'opal-themecontrol' ),
				),
				'footer_custom_color' => array(
					'section' => 'footer',
					'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
					'choices' => array(
						'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="color_footer">' . esc_html__( 'Customize Color', 'opal-themecontrol' ) . '</a></h3>',
					),
				),
			),
		);
	}
}
