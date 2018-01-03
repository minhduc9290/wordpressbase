<?php
/**
 * @version    1.0
 * @package    Nitro_Gallery
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

/**
 * Define option on customize to config gallery.
 */
class Nitro_Gallery_Customize {
	/**
	 * Initialize.
	 *
	 * @return  void
	 */
	public static function initialize() {
		add_filter( 'wr_nitro_theme_options_definition', array( __CLASS__, 'options' ) );
	}

	/**
	 * Initialize plugin options.
	 *
	 * @param   object  $wp_customize  The core customize object of WordPress.
	 *
	 * @return  void
	 */
	public static function options( $theme_options ) {
		$theme_options['gallery'] = array(
			'title'       => __( 'Gallery', 'nitro' ),
			'description' => __( 'In this panel, you can customize all setings for Gallery. Please install Nitro Toolkit plugin first to see all modifications on this panel.', 'nitro' ),
			'priority'    => 70,
			'sections' => array(
				'gallery_archive' => array(
					'title'    => __( 'Archive Gallery', 'nitro' ),
					'settings' => array(
						'gallery_archive_title' => array(
							'default'           => 'Nitro Gallery',
							'sanitize_callback' => '',
						),
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
						'gallery_archive_title' => array(
							'label'   => __( 'Gallery Archive Title', 'nitro' ),
							'section' => 'gallery_archive',
							'type'    => 'text',
						),
						'gallery_slug' => array(
							'label'       => __( 'Gallery Slug', 'nitro' ),
							'description' => __( 'This option changes the permalink when you use the permalink type as %postname%. Make sure to regenerate permalinks.', 'nitro' ),
							'section'     => 'gallery_archive',
							'type'        => 'text',
						),
						'gallery_layout' => array(
							'label'       => __( 'Layout', 'nitro' ),
							'section'     => 'gallery_archive',
							'type'        => 'WR_Nitro_Customize_Control_HTML',
							'choices'     => array(
								'grid'  => array(
									'html'  => '<div class="icon-cols icon-grid"></div>',
									'title' => __( 'Grid', 'nitro' ),
								),
								'masonry'  => array(
									'html' => '<div class="icon-cols icon-masonry"><span></span></div>',
									'title' => __( 'Masonry', 'nitro' ),
								),
							),
						),
						'gallery_thumb_style' => array(
							'label'       => __( 'Thumbnail Shape', 'nitro' ),
							'section'     => 'gallery_archive',
							'type'        => 'WR_Nitro_Customize_Control_HTML',
							'choices'     => array(
								'square'  => array(
									'html'  => '<div class="icon-cols icon-square"></div>',
									'title' => __( 'Square', 'nitro' ),
								),
								'rec-horizontal'  => array(
									'html'  => '<div class="icon-cols icon-rec-horizontal"></div>',
									'title' => __( 'Horizontal Rectangle', 'nitro' ),
								),
								'rec-vertical'  => array(
									'html'  => '<div class="icon-cols icon-rec-vertical"></div>',
									'title' => __( 'Vertical Rectangle', 'nitro' ),
								),
							),
							'required' => array( 'gallery_layout == grid' ),
						),
						'gallery_column' => array(
							'label'   => __( 'Columns', 'nitro' ),
							'section' => 'gallery_archive',
							'type'    => 'select',
							'choices' => array(
								'2' => __( '2 Columns', 'nitro' ),
								'3' => __( '3 Columns', 'nitro' ),
								'4' => __( '4 Columns', 'nitro' ),
								'5' => __( '5 Columns', 'nitro' ),
								'6' => __( '6 Columns', 'nitro' ),
							),
						),
						'gallery_limit' => array(
							'label'       => __( 'Number of item per page', 'nitro' ),
							'section'     => 'gallery_archive',
							'type'        => 'number',
							'input_attrs' => array(
								'min'   => 1,
								'step'  => 1,
							),
						),
						'gallery_gutter' => array(
							'label'       => __( 'Space Between Items', 'nitro' ),
							'description' => __( 'The width of the space between columns', 'nitro' ),
							'section'     => 'gallery_archive',
							'type'        => 'WR_Nitro_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 60,
								'step' => 1,
								'unit' => 'px',
							),
						),
						'gallery_style' => array(
							'label'   => __( 'Style', 'nitro' ),
							'section' => 'gallery_archive',
							'type'    => 'WR_Nitro_Customize_Control_HTML',
							'choices' => array(
								'inside'  => array(
									'html'  => '<div class="icon-cols icon-blog-classic"><span></span></div>',
									'title' => __( 'Inside thumbnail', 'nitro' ),
								),
								'outside'  => array(
									'html'  => '<div class="icon-cols icon-carousel-dot"></div>',
									'title' => __( 'Outside thumbnail', 'nitro' ),
								),
							),
						),
						'gallery_excerpt' => array(
							'label'   => __( 'Show Excerpt', 'nitro' ),
							'section' => 'gallery_archive',
							'type'    => 'WR_Nitro_Customize_Control_Toggle',
							'required' => array( 'gallery_style == "outside"' ),
						),
						'gallery_excerpt_length' => array(
							'label'       => __( 'Excerpt Length', 'nitro' ),
							'section'     => 'gallery_archive',
							'type'        => 'WR_Nitro_Customize_Control_Slider',
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
							'label'   => __( 'Enable Slider For Thumbnail', 'nitro' ),
							'section' => 'gallery_archive',
							'type'    => 'WR_Nitro_Customize_Control_Toggle',
							'required' => array( 'gallery_layout != "masonry"' ),
						),
						'gallery_fullwidth' => array(
							'label'    => __( 'Enable Full Width', 'nitro' ),
							'section'  => 'gallery_archive',
							'type'     => 'WR_Nitro_Customize_Control_Toggle',
						),
						'gallery_filter' => array(
							'label'   => __( 'Enable Filter', 'nitro' ),
							'section' => 'gallery_archive',
							'type'    => 'WR_Nitro_Customize_Control_Toggle',
						),
						'gallery_filter_align' => array(
							'label'   => __( 'Filter Alignment', 'nitro' ),
							'section' => 'gallery_archive',
							'type'    => 'select',
							'choices' => array(
								'tl' => __( 'Left', 'nitro' ),
								'tc' => __( 'Center', 'nitro' ),
								'tr' => __( 'Right', 'nitro' ),
							),
							'required' => array( 'gallery_filter == 1' ),
						),
						'gallery_item_animation' => array(
							'label'    => __( 'Enable Item Animation', 'nitro' ),
							'section'  => 'gallery_archive',
							'type'     => 'WR_Nitro_Customize_Control_Toggle',
							'required' => array( 'gallery_filter == 0' ),
						),
					),
				),
				'gallery_single' => array(
					'title'    => __( 'Single Gallery', 'nitro' ),
					'settings' => array(
						'gallery_single_layout' => array(
							'default'           => 'grid',
							'sanitize_callback' => '',
						),
						'gallery_single_thumb_style' => array(
							'default'           => 'square',
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
						'gallery_single_columns' => array(
							'default'           => '4',
							'sanitize_callback' => '',
						),
						'gallery_single_gutter' => array(
							'default'           => 30,
							'sanitize_callback' => '',
						),
						'gallery_single_related' => array(
							'default'           => 0,
							'sanitize_callback' => '',
						),
					),
					'controls' => array(
						'gallery_single_layout' => array(
							'label'       => __( 'Layout', 'nitro' ),
							'section'     => 'gallery_single',
							'type'        => 'WR_Nitro_Customize_Control_HTML',
							'choices'     => array(
								'grid'  => array(
									'html'  => '<div class="icon-cols icon-grid"></div>',
									'title' => __( 'Grid', 'nitro' ),
								),
								'masonry'  => array(
									'html' => '<div class="icon-cols icon-masonry"><span></span></div>',
									'title' => __( 'Masonry', 'nitro' ),
								),
								'horizontal'  => array(
									'html'  => '<div class="icon-cols icon-carousel-dot"><span></span></div>',
									'title' => __( 'Horizontal', 'nitro' ),
								),
								'slider'  => array(
									'html'  => '<div class="icon-cols icon-slider-nav"><span></span></div>',
									'title' => __( 'Slider', 'nitro' ),
								),
							),
						),
						'gallery_single_thumb_style' => array(
							'label'       => __( 'Thumbnail Shape', 'nitro' ),
							'section'     => 'gallery_single',
							'type'        => 'WR_Nitro_Customize_Control_HTML',
							'choices'     => array(
								'square'  => array(
									'html'  => '<div class="icon-cols icon-square"></div>',
									'title' => __( 'Square', 'nitro' ),
								),
								'rec-horizontal'  => array(
									'html'  => '<div class="icon-cols icon-rec-horizontal"></div>',
									'title' => __( 'Horizontal Rectangle', 'nitro' ),
								),
								'rec-vertical'  => array(
									'html'  => '<div class="icon-cols icon-rec-vertical"></div>',
									'title' => __( 'Vertical Rectangle', 'nitro' ),
								),
							),
							'required' => array( 'gallery_single_layout == grid' ),
						),
						'gallery_single_fullwidth' => array(
							'label'    => __( 'Enable Full Width', 'nitro' ),
							'section'  => 'gallery_single',
							'type'     => 'WR_Nitro_Customize_Control_Toggle',
							'required' => array(
								'gallery_single_layout != slider',
								'gallery_single_layout != horizontal',
								'wr_layout_boxed = 0'
							),
						),
						'gallery_single_fullscreen' => array(
							'label'       => __( 'Slider Type', 'nitro' ),
							'section'     => 'gallery_single',
							'type'        => 'WR_Nitro_Customize_Control_HTML',
							'choices'     => array(
								'full'  => array(
									'html'  => '<div class="icon-cols icon-slider-nav icon-slider-thumb"><span></span></div>',
									'title' => __( 'Full screen', 'nitro' ),
								),
								'carousel'  => array(
									'html'  => '<div class="icon-cols icon-carousel-dot"></div>',
									'title' => __( 'Carousel', 'nitro' ),
								),
							),
							'required' => array( 'gallery_single_layout == slider' ),
						),
						'gallery_single_autoplay' => array(
							'label'    => __( 'Enable Autoplay', 'nitro' ),
							'section'  => 'gallery_single',
							'type'     => 'WR_Nitro_Customize_Control_Toggle',
							'required' => array( 'gallery_single_layout == horizontal' ),
						),
						'gallery_single_mousewheel' => array(
							'label'    => __( 'Enable Mousewheel Scrolling', 'nitro' ),
							'section'  => 'gallery_single',
							'type'     => 'WR_Nitro_Customize_Control_Toggle',
							'required' => array( 'gallery_single_layout == horizontal' ),
						),
						'gallery_single_dots' => array(
							'label'    => __( 'Enable Pagination', 'nitro' ),
							'section'  => 'gallery_single',
							'type'     => 'WR_Nitro_Customize_Control_Toggle',
							'required' => array( 'gallery_single_layout == horizontal' ),
						),
						'gallery_single_thumb_nav' => array(
							'label'    => __( 'Enable Thumbnail Navigation', 'nitro' ),
							'section'  => 'gallery_single',
							'type'     => 'WR_Nitro_Customize_Control_Toggle',
							'required' => array(
								'gallery_single_layout     == slider',
								'gallery_single_fullscreen == full',
							),
						),
						'gallery_single_columns' => array(
							'label'   => __( 'Columns', 'nitro' ),
							'section' => 'gallery_single',
							'type'    => 'select',
							'choices' => array(
								'2' => __( '2 Columns', 'nitro' ),
								'3' => __( '3 Columns', 'nitro' ),
								'4' => __( '4 Columns', 'nitro' ),
								'5' => __( '5 Columns', 'nitro' ),
								'6' => __( '6 Columns', 'nitro' ),
							),
							'required' => array(
								'gallery_single_layout != slider',
								'gallery_single_layout != horizontal'
							),
						),
						'gallery_single_gutter' => array(
							'label'       => __( 'Space Between Items', 'nitro' ),
							'description' => __( 'The width of the space between columns', 'nitro' ),
							'section'     => 'gallery_single',
							'type'        => 'WR_Nitro_Customize_Control_Slider',
							'choices' => array(
								'min'  => 0,
								'max'  => 60,
								'step' => 1,
								'unit' => 'px',
							),
							'required' => array( 'gallery_single_layout != slider' ),
						),
						'gallery_single_related' => array(
							'label'   => __( 'Show Related Gallery', 'nitro' ),
							'section' => 'gallery_single',
							'type'    => 'WR_Nitro_Customize_Control_Toggle',
							'required' => array(
								'gallery_single_layout != horizontal',
								'gallery_single_fullscreen == carousel'
							),
						),
					),
				),
			),
			'type'     => 'WR_Nitro_Customize_Panel',
			'apply_to' => array( 'gallery' ),
		);

		return $theme_options;
	}
}