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
class Opal_Themecontrol_Customize_Options_Header {
	public static function get_options() {
		$theme_options = null;

		// Get all headers.
		$list_header = new WP_Query( array(
				'posts_per_page' => -1,
				'post_type'      => 'header_builder',
				'post_status'    => 'publish',
				'suppress_filters' => true,
		));

		$header_layout = array();

		// Set to normal headers default
		if ( $list_header->post_count ) {
			foreach( $list_header->posts as $val ){
				$header_layout[ $val->ID ] = $val->post_title;
			}
		};

		if ( $header_layout ) {
			$theme_options = array(
					'title'       => esc_html__( 'Header', 'opal-themecontrol' ),
					'description' => sprintf( __( 'With Theme Control plugin, you can build an unlimited amount of unique header styles. The "magic" happens via the section <b><a target="_blank" href="%1$s">Manage Headers</a></b>.', 'opal-themecontrol' ), esc_url( admin_url( 'edit.php?post_type=header_builder' ) ) ) . '<a class="link-doc-header" target="_blank" href="http://opalthemer.com/docs/document/footer"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
					'type'        => 'option',
					'priority'    => 20,
					'settings'    => array(
							'header_layout' => array(
									'default'           => 0,
									'sanitize_callback' => '',
							),
					),
					'controls' => array(
							'header_layout' => array(
									'label'   => esc_html__( 'Select Header', 'opal-themecontrol' ),
									'section' => 'header',
									'type'    => 'select',
									'choices' => $header_layout
							),
					),
			);
		} else {
			$theme_options = array(
					'title'       => esc_html__( 'Header', 'opal-themecontrol' ),
					'description' => esc_html__( 'In this area you can mark a header as default to display on all pages of your site.', 'opal-themecontrol' ),
					'type'        => 'option',
					'priority'    => 20,
					'settings'    => array(
							'no_header_found' => array(),
					),
					'controls' => array(
							'no_header_found' => array(
									'label'   => sprintf( __( 'No header was found on your site. Ready to publish your first header? <a target="_blank" href="%1$s">Get started here</a>.', 'opal-themecontrol' ), esc_url( admin_url( 'edit.php?post_type=header_builder' ) ) ),
									'section' => 'header',
									'type'    => 'Opal_Themecontrol_Customize_Control_Text',
							),
					),
			);
		}

		return $theme_options;
	}
}
