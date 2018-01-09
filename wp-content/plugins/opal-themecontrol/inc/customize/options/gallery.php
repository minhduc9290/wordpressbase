<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    Opal_ThemeControl
 * @author     WpOpal Gallery <opalwordpress@gmail.com>
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
class Opal_Themecontrol_Customize_Options_Gallery {
	public static function get_options() {
		return apply_filters( 'opalthemer_filter_customize_options_gallery',array(
			'title'       => __( 'Gallery', 'opal-themecontrol' ),
			'description' => __( 'In this panel, you can customize all setings for Gallery. Please install Nitro Toolkit plugin first to see all modifications on this panel.', 'opal-themecontrol' ),
			'priority'    => 50,
			'sections' => array(
				'gallery_archive' => array(
					'title'    => __( 'Archive Gallery', 'opal-themecontrol' ),
					'settings' => array(
						'gallery_slug' => array(
							'default'           => 'galleries',
							'sanitize_callback' => '',
						),
						'gallery_layout' => array(
							'default'           => 'grid',
							'sanitize_callback' => '',
						),
						'gallery_thumb_style' => array(
							'default'           => 'square',
							'sanitize_callback' => '',
						),
						'gallery_column' => array(
							'default'           => '4',
							'sanitize_callback' => '',
						),
						'gallery_limit' => array(
							'default'           => 12,
							'sanitize_callback' => '',
						),
						'gallery_gutter' => array(
							'default'           => 30,
							'sanitize_callback' => '',
						),
						'gallery_fullwidth' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'gallery_style' => array(
							'default'           => 'inside',
							'sanitize_callback' => '',
						),
						'gallery_excerpt' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'gallery_excerpt_length' => array(
							'default'           => 10,
							'sanitize_callback' => '',
						),
						'gallery_thumbnail_slide' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'gallery_filter' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'gallery_filter_align' => array(
							'default'           => 'tl',
							'sanitize_callback' => '',
						),
						'gallery_item_animation' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'gallery_slug' => array(
							'label'       => __( 'Gallery Slug', 'opal-themecontrol' ),
							'description' => __( 'This option changes the permalink when you use the permalink type as %postname%. Make sure to regenerate permalinks.', 'opal-themecontrol' ),
							'section'     => 'gallery_archive',
							'type'        => 'text',
						),
						'gallery_layout' => array(
							'label'       => __( 'Layout', 'opal-themecontrol' ),
							'section'     => 'gallery_archive',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'grid'  => array(
									'html'  => '<div class="icon-cols icon-grid"></div>',
									'title' => __( 'Grid', 'opal-themecontrol' ),
								),
								'masonry'  => array(
									'html' => '<div class="icon-cols icon-masonry"><span></span></div>',
									'title' => __( 'Masonry', 'opal-themecontrol' ),
								),
							),
						),
						'gallery_thumb_style' => array(
							'label'       => __( 'Thumbnail Shape', 'opal-themecontrol' ),
							'section'     => 'gallery_archive',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'square'  => array(
									'html'  => '<div class="icon-cols icon-square"></div>',
									'title' => __( 'Square', 'opal-themecontrol' ),
								),
								'rec-horizontal'  => array(
									'html'  => '<div class="icon-cols icon-rec-horizontal"></div>',
									'title' => __( 'Horizontal Rectangle', 'opal-themecontrol' ),
								),
								'rec-vertical'  => array(
									'html'  => '<div class="icon-cols icon-rec-vertical"></div>',
									'title' => __( 'Vertical Rectangle', 'opal-themecontrol' ),
								),
							),
							'required' => array( 'gallery_layout == grid' ),
						),
						'gallery_column' => array(
							'label'   => __( 'Columns', 'opal-themecontrol' ),
							'section' => 'gallery_archive',
							'type'    => 'select',
							'choices' => array(
								'2' => __( '2 Columns', 'opal-themecontrol' ),
								'3' => __( '3 Columns', 'opal-themecontrol' ),
								'4' => __( '4 Columns', 'opal-themecontrol' ),
								'5' => __( '5 Columns', 'opal-themecontrol' ),
								'6' => __( '6 Columns', 'opal-themecontrol' ),
							),
						),
						'gallery_limit' => array(
							'label'       => __( 'Number of item per page', 'opal-themecontrol' ),
							'section'     => 'gallery_archive',
							'type'        => 'number',
							'input_attrs' => array(
								'min'   => 1,
								'step'  => 1,
							),
						),
						'gallery_gutter' => array(
							'label'       => __( 'Space Between Items', 'opal-themecontrol' ),
							'description' => __( 'The width of the space between columns', 'opal-themecontrol' ),
							'section'     => 'gallery_archive',
							'type'        => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 60,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'gallery_style' => array(
							'label'   => __( 'Style', 'opal-themecontrol' ),
							'section' => 'gallery_archive',
							'type'    => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices' => array(
								'inside'  => array(
									'html'  => '<div class="icon-cols icon-blog-classic"><span></span></div>',
									'title' => __( 'Inside thumbnail', 'opal-themecontrol' ),
								),
								'outside'  => array(
									'html'  => '<div class="icon-cols icon-carousel-dot"></div>',
									'title' => __( 'Outside thumbnail', 'opal-themecontrol' ),
								),
							),
						),
						'gallery_excerpt' => array(
							'label'   => __( 'Show Excerpt', 'opal-themecontrol' ),
							'section' => 'gallery_archive',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'gallery_style == "outside"' ),
						),
						'gallery_excerpt_length' => array(
							'label'       => __( 'Excerpt Length', 'opal-themecontrol' ),
							'section'     => 'gallery_archive',
							'type'        => 'Opal_Themecontrol_Customize_Control_Slider',
							'choices' => array(
								'min'  => 5,
								'max'  => 50,
								'step' => 1,
							),
							'required' => array(
								'gallery_style   == "outside"',
								'gallery_excerpt = 1',
							),
						),
						'gallery_thumbnail_slide' => array(
							'label'   => __( 'Enable Slider For Thumbnail', 'opal-themecontrol' ),
							'section' => 'gallery_archive',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'gallery_layout != "masonry"' ),
						),
						'gallery_fullwidth' => array(
							'label'    => __( 'Enable Full Width', 'opal-themecontrol' ),
							'section'  => 'gallery_archive',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'gallery_filter' => array(
							'label'   => __( 'Enable Filter', 'opal-themecontrol' ),
							'section' => 'gallery_archive',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
						),
						'gallery_filter_align' => array(
							'label'   => __( 'Filter Alignment', 'opal-themecontrol' ),
							'section' => 'gallery_archive',
							'type'    => 'select',
							'choices' => array(
								'tl' => __( 'Left', 'opal-themecontrol' ),
								'tc' => __( 'Center', 'opal-themecontrol' ),
								'tr' => __( 'Right', 'opal-themecontrol' ),
							),
							'required' => array( 'gallery_filter == 1' ),
						),
						'gallery_item_animation' => array(
							'label'    => __( 'Enable Item Animation', 'opal-themecontrol' ),
							'section'  => 'gallery_archive',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'gallery_filter == 0' ),
						),
					),
				),
				'gallery_single' => array(
					'title'    => __( 'Single Gallery', 'opal-themecontrol' ),
					'settings' => array(
						'gallery_single_layout' => array(
							'default'           => 'grid',
							'sanitize_callback' => '',
						),
						'gallery_single_fullwidth' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'gallery_single_fullscreen' => array(
							'default'           => 'full',
							'sanitize_callback' => '',
						),
						'gallery_single_autoplay' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'gallery_single_mousewheel' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'gallery_single_dots' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'gallery_single_thumb_nav' => array(
							'default'           => 1,
							'sanitize_callback' => '',
						),
						'gallery_single_space' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
						'gallery_single_columns' => array(
							'default'           => '4',
							'sanitize_callback' => '',
						),

						'gallery_single_related' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'gallery_single_layout' => array(
							'label'       => __( 'Layout', 'opal-themecontrol' ),
							'section'     => 'gallery_single',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => apply_filters('opalthemer-filter-gallery-single-layout',array(
								'grid'  => array(
									'html'  => '<div class="icon-cols icon-grid"></div>',
									'title' => __( 'Grid', 'opal-themecontrol' ),
								),
								'split-screen'  => array(
									'html'  => '<div class="icon-cols icon-sidebar icon-left-sidebar"><span></span></div>',
									'title' => __( 'Split Screen', 'opal-themecontrol' ),
								),
								'kenburns'  => array(
									'html'  => '<div class="icon-cols icon-sidebar icon-no-sidebar"><span></span></div>',
									'title' => __( 'Kenburns', 'opal-themecontrol' ),
								),
								'slider'  => array(
									'html'  => '<div class="icon-cols icon-slider-nav"><span></span></div>',
									'title' => __( 'Slider', 'opal-themecontrol' ),
								),
							)),
						),
						'gallery_single_fullwidth' => array(
							'label'    => __( 'Enable Full Width', 'opal-themecontrol' ),
							'section'  => 'gallery_single',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'gallery_single_layout != slider',
								'gallery_single_layout != horizontal',
								'gallery_single_layout != split-screen',
								'gallery_single_layout != kenburns',
								'opal_layout_boxed = 0'
							),
						),
						'gallery_single_fullscreen' => array(
							'label'       => __( 'Slider Type', 'opal-themecontrol' ),
							'section'     => 'gallery_single',
							'type'        => 'Opal_Themecontrol_Customize_Control_HTML',
							'choices'     => array(
								'full'  => array(
									'html'  => '<div class="icon-cols icon-slider-nav icon-slider-thumb"><span></span></div>',
									'title' => __( 'Full screen', 'opal-themecontrol' ),
								),
								'carousel'  => array(
									'html'  => '<div class="icon-cols icon-carousel-dot"></div>',
									'title' => __( 'Carousel', 'opal-themecontrol' ),
								),
							),
							'required' => array( 'gallery_single_layout == slider' ),
						),
						'gallery_single_autoplay' => array(
							'label'    => __( 'Enable Autoplay', 'opal-themecontrol' ),
							'section'  => 'gallery_single',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'gallery_single_layout == horizontal' ),
						),
						'gallery_single_mousewheel' => array(
							'label'    => __( 'Enable Mousewheel Scrolling', 'opal-themecontrol' ),
							'section'  => 'gallery_single',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'gallery_single_layout == horizontal' ),
						),
						'gallery_single_dots' => array(
							'label'    => __( 'Enable Pagination', 'opal-themecontrol' ),
							'section'  => 'gallery_single',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array( 'gallery_single_layout == horizontal' ),
						),
						'gallery_single_thumb_nav' => array(
							'label'    => __( 'Enable Thumbnail Navigation', 'opal-themecontrol' ),
							'section'  => 'gallery_single',
							'type'     => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'gallery_single_layout     == slider',
								'gallery_single_fullscreen == full',
							),
						),
						'gallery_single_space' => array(
							'label'       => __( 'Space Items', 'opal-themecontrol' ),
							'section'     => 'gallery_single',
							'type'        => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'gallery_single_layout != slider',
								'gallery_single_layout != kenburns',
							),
						),
						'gallery_single_columns' => array(
							'label'   => __( 'Columns', 'opal-themecontrol' ),
							'section' => 'gallery_single',
							'type'    => 'select',
							'choices' => array(
								'2' => __( '2 Columns', 'opal-themecontrol' ),
								'3' => __( '3 Columns', 'opal-themecontrol' ),
								'4' => __( '4 Columns', 'opal-themecontrol' ),
								'5' => __( '5 Columns', 'opal-themecontrol' ),
							),
							'required' => array(
								'gallery_single_layout != slider',
								'gallery_single_layout != horizontal',
								'gallery_single_layout != split-screen',
								'gallery_single_layout != kenburns',
							),
						),

						'gallery_single_related' => array(
							'label'   => __( 'Show Related Gallery', 'opal-themecontrol' ),
							'section' => 'gallery_single',
							'type'    => 'Opal_Themecontrol_Customize_Control_Toggle',
							'required' => array(
								'gallery_single_layout != horizontal',
								'gallery_single_fullscreen == carousel'
							),
						),
					),
				),
			),
			'type'     => 'Opal_Themecontrol_Customize_Panel',
			'apply_to' => array( 'gallery' ),
		));
	}
}
