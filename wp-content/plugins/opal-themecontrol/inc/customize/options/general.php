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
class Opal_Themecontrol_Customize_Options_General {
	public static function get_options() {
		return array(
			'title'       => esc_html__( 'General', 'opal-themecontrol' ),
			'description' => '<a target="_blank" href="http://opalthemer.com/docs/document/general"><span class="fa fa-question-circle has-tip" title="View Documentation for this section"></span></a>',
			'priority'    => 10,
			'sections'    => array(
				'site_identity' => array(
					'title' => esc_html__( 'Site Identity', 'opal-themecontrol' ),
				),
				'social' => array(
					'title'    => esc_html__( 'Social', 'opal-themecontrol' ),
					'settings' => array(
						'facebook' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'twitter' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'instagram' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'linkedin' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'pinterest' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'dribbble' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'behance' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'flickr' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'google-plus' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'medium' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'skype' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'slack' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'tumblr' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'vimeo' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'yahoo' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'youtube' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
						'rss' => array(
							'default'           => '',
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'facebook' => array(
							'label'       => esc_html__( 'Facebook', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link To Facebook', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'twitter' => array(
							'label'       => esc_html__( 'Twitter', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Twitter.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'instagram' => array(
							'label'       => esc_html__( 'Instagram', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link To Instagram', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'linkedin' => array(
							'label'       => esc_html__( 'Linkedin', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Linkedin.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'pinterest' => array(
							'label'       => esc_html__( 'Pinterest', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Pinterest.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'dribbble' => array(
							'label'       => esc_html__( 'Dribbble', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Dribbble.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'behance' => array(
							'label'       => esc_html__( 'Behance', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Behance.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'flickr' => array(
							'label'       => esc_html__( 'Flickr', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Flickr.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'google-plus' => array(
							'label'       => esc_html__( 'Google Plus', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Google Plus.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'medium' => array(
							'label'       => esc_html__( 'Medium', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Medium.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'skype' => array(
							'label'       => esc_html__( 'Skype', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Skype.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'slack' => array(
							'label'       => esc_html__( 'Slack', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Slack.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'tumblr' => array(
							'label'       => esc_html__( 'Tumblr', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Tumblr.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'vimeo' => array(
							'label'       => esc_html__( 'Vimeo', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Vimeo.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'yahoo' => array(
							'label'       => esc_html__( 'Yahoo', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Yahoo.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'youtube' => array(
							'label'       => esc_html__( 'Youtube', 'opal-themecontrol' ),
							'description' => esc_html__( 'Link to Youtube.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
						'rss' => array(
							'label'       => esc_html__( 'Rss', 'opal-themecontrol' ),
							'description' => esc_html__( 'Rss link.', 'opal-themecontrol' ),
							'section'     => 'social',
							'type'        => 'text',
						),
					),
				),
				'page_loader' => array(
					'title' => esc_html__( 'Page Loading Effect', 'opal-themecontrol' ),
					'settings' => array(
						'page_loader' => array(
							'sanitize_callback' => '',
							'default'           => 'none',
						),
						'page_loader_css' => array(
							'sanitize_callback' => '',
							'default'           => '1',
						),
						'page_loader_image' => array(
							'sanitize_callback' => '',
							'default'           => '',
						),
						'content_loader_color' => array(
							'default'   => array(
								'icon' => '#fff',
								'bg'   => 'rgba(0, 0, 0, 0.7)',
							),
						),
					),
					'controls' => array(
						'page_loader' => array(
							'label'       => esc_html__( 'Effect Type', 'opal-themecontrol' ),
							'description' => esc_html__( 'Use preloading effects to keep user on site while waiting the content.', 'opal-themecontrol' ),
							'section'     => 'page_loader',
							'type'        => 'radio',
							'choices'     => array(
								'none'  => esc_html__( 'None', 'opal-themecontrol' ),
								'css'   => esc_html__( 'CSS Animation', 'opal-themecontrol' ),
								'image' => esc_html__( 'Image', 'opal-themecontrol' ),
							),
						),
						'page_loader_css' => array(
							'label'   => esc_html__( 'Animation Type', 'opal-themecontrol' ),
							'section' => 'page_loader',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<div class="opal-loader-1"><div class="opal-loader"></div></div>',
								'2'  => '<div class="opal-loader-2"><div class="opal-loader"></div></div>',
								'3'  => '<div class="opal-loader-3"><div class="opal-loader"></div></div>',
								'4'  => '<div class="opal-loader-4"><div class="opal-loader"></div></div>',
								'5'  => '<div class="opal-loader-5"><div class="opal-loader"></div></div>',
								'6'  => '<div class="opal-loader-6"><div class="opal-loader"></div></div>',
								'7'  => '<div class="opal-loader-7"><div class="opal-loader"></div></div>',
								'8'  => '<div class="opal-loader-8"><div class="opal-loader"></div></div>',
								'9'  => '<div class="opal-loader-9"><div class="opal-loader"></div><div class="opal-loader opal-loader-inner-2"></div><div class="opal-loader opal-loader-inner-3"></div><div class="opal-loader opal-loader-inner-4"></div></div>',
								'10' => '<div class="opal-loader-10"><div class="opal-loader"></div><div class="opal-loader opal-loader-inner-2"></div></div>',
								'11' => '<div class="opal-loader-11"><div class="opal-loader"></div><div class="opal-loader opal-loader-inner-2"></div><div class="opal-loader opal-loader-inner-3"></div><div class="opal-loader opal-loader-inner-4"></div><div class="opal-loader opal-loader-inner-5"></div><div class="opal-loader opal-loader-inner-6"></div><div class="opal-loader opal-loader-inner-7"></div><div class="opal-loader opal-loader-inner-8"></div><div class="opal-loader opal-loader-inner-9"></div></div>',
								'12' => '<div class="opal-loader-12"><div class="opal-loader"></div><div class="opal-loader opal-loader-inner-2"></div></div>',
							),
							'required' => array( 'page_loader == css' ),
						),
						'page_loader_image' => array(
							'label'    => esc_html__( 'Image', 'opal-themecontrol' ),
							'section'  => 'page_loader',
							'type'     => 'WP_Customize_Image_Control',
							'required' => array( 'page_loader == image' ),
						),
						'content_loader_color' => array(
							'section' => 'page_loader',
							'type'    => 'Opal_Themecontrol_Customize_Control_Colors',
							'choices' => array(
								'icon' => esc_html__( 'Icon', 'opal-themecontrol' ),
								'bg'   => esc_html__( 'Overlay Background', 'opal-themecontrol' ),
							),
							'required' => array(
								'page_loader == css',
							),
						),
					),
				),
				'widget_styles' => array(
					'title'    => esc_html__( 'Widget Styles', 'opal-themecontrol' ),
					'settings' => array(
						'w_style' => array(
							'default'           => '1',
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
						'w_style_bg' => array(
							'default'           => 1,
							'transport'         => 'postMessage',
						),
						'w_style_border' => array(
							'default'           => 1,
							'transport'         => 'postMessage',
						),
						'w_style_divider' => array(
							'default'           => 1,
							'transport'         => 'postMessage',
						),
						'move_to_general_color' => array(
							'default'           => 1,
						),
					),
					'controls' => array(
						'w_style' => array(
							'label'   => esc_html__( 'Choose Style', 'opal-themecontrol' ),
							'section' => 'widget_styles',
							'type'    => 'select',
							'choices' => array(
								'1' => esc_html__( 'Style 1', 'opal-themecontrol' ),
								'2' => esc_html__( 'Style 2', 'opal-themecontrol' ),
								'3' => esc_html__( 'Style 3', 'opal-themecontrol' ),
								'4' => esc_html__( 'Style 4', 'opal-themecontrol' ),
							)
						),
						'w_style_bg' => array(
							'label'    => esc_html__( 'Enable Background', 'opal-themecontrol' ),
							'section'  => 'widget_styles',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'w_style != 3' ),
						),
						'w_style_border' => array(
							'label'    => esc_html__( 'Enable Border', 'opal-themecontrol' ),
							'section'  => 'widget_styles',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'w_style != 4' ),
						),
						'w_style_divider' => array(
							'label'    => esc_html__( 'Enable Divider For Widget Title', 'opal-themecontrol' ),
							'section'  => 'widget_styles',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'w_style = "1|2"' ),
						),
						'move_to_general_color' => array(
							'section' => 'widget_styles',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="color_general">' . esc_html__( 'Customize Color', 'opal-themecontrol' ) . '</a></h3>',
							),
						),
					),
				),
				'pagination' => array(
					'title'    => esc_html__( 'Pagination Style', 'opal-themecontrol' ),
					'settings' => array(
						'pagination_style' => array(
							'default'           => 'style-1',
							'sanitize_callback' => '',
							'transport'         => 'postMessage',
						),
					),
					'controls' => array(
						'pagination_style' => array(
							'label'   => esc_html__( 'Pagination Style', 'opal-themecontrol' ),
							'section' => 'pagination',
							'type'    => 'Opal_Themecontrol_Customize_Control_Select_Image',
							'choices' => array(
								'style-1'  => '',
								'style-2'  => '',
								'style-3'  => '',
							),
						),
					),
				),
				'back_to_top' => array(
					'title'    => esc_html__( 'Back To Top Button', 'opal-themecontrol' ),
					'settings' => array(
						'back_top' => array(
							'default'           => 1,
						),
						'back_top_type' => array(
							'default'           => 'square',
							'transport'         => 'postMessage',
						),
						'back_top_style' => array(
							'default'           => 'light',
							'transport'         => 'postMessage',
						),
						'back_top_size' => array(
							'default'           => 32,
							'transport'         => 'postMessage',
						),
						'back_top_icon_size' => array(
							'default'           => 14,
							'transport'         => 'postMessage',
						),
						'back_top_general_color' => array(
							'default'           => 1,
						),
					),
					'controls' => array(
						'back_top' => array(
							'label'    => esc_html__( 'Enable', 'opal-themecontrol' ),
							'section'  => 'back_to_top',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'back_top_type' => array(
							'label'   => esc_html__( 'Shape', 'opal-themecontrol' ),
							'section' => 'back_to_top',
							'type'    => 'select',
							'choices' => array(
								'square'  => esc_html__( 'Square', 'opal-themecontrol' ),
								'circle'  => esc_html__( 'Circle', 'opal-themecontrol' ),
								'rounded' => esc_html__( 'Rounded', 'opal-themecontrol' ),
							),
							'required' => array( 'back_top = 1' ),
						),
						'back_top_style' => array(
							'label'   => esc_html__( 'Style', 'opal-themecontrol' ),
							'section' => 'back_to_top',
							'type'    => 'select',
							'choices' => array(
								'light'  => esc_html__( 'Light', 'opal-themecontrol' ),
								'dark'   => esc_html__( 'Dark', 'opal-themecontrol' ),
							),
							'required' => array( 'back_top = 1' ),
						),
						'back_top_size' => array(
							'label'   => esc_html__( 'Button Size', 'opal-themecontrol' ),
							'section' => 'back_to_top',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 20,
								'max'  => 60,
								'step' => 1,
								'unit' => 'px',
							),
							'required' => array( 'back_top = 1' ),
						),
						'back_top_icon_size' => array(
							'label'   => esc_html__( 'Icon Size', 'opal-themecontrol' ),
							'section' => 'back_to_top',
							'type'    => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 10,
								'max'  => 50,
								'step' => 1,
								'unit' => 'px',
							),
							'required' => array( 'back_top = 1' ),
						),
						'back_top_general_color' => array(
							'section' => 'back_to_top',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'1'  => '<h3 class="btn-move-section"><a href="#" class="move-to-section button" data-section="color_general">' . esc_html__( 'Customize Color', 'opal-themecontrol' ) . '</a></h3>',
							),
							'required' => array( 'back_top = 1' ),
						),
					),
				),
			)
		);
	}
}
