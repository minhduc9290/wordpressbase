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
 * Define core class.
 */
class Nitro_Gallery_Shortcodes {
	/**
	 * Initialize.
	 *
	 * @return  void
	 */
	public static function initialize() {
		// Add map for vc
		if ( class_exists( 'Vc_Manager' ) ) {
			add_action( 'init', array( __CLASS__, 'map' ) );
		}

		// Add shortcode
		add_shortcode( 'nitro_gallery', array( __CLASS__, 'shortcode_gallery' ) );

		// Add shortcode
		add_shortcode( 'nitro_gallery_single', array( __CLASS__, 'shortcode_gallery_single' ) );

		// Enqueue script
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
	}

	/**
	 * Map new parameters and elements.
	 *
	 * @since  1.0
	 * @see    https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524332
	 */
	public static function map() {
		$order_by_values = array(
			'',
			__( 'Date', 'nitro' )          => 'date',
			__( 'ID', 'nitro' )            => 'ID',
			__( 'Author', 'nitro' )        => 'author',
			__( 'Title', 'nitro' )         => 'title',
			__( 'Modified', 'nitro' )      => 'modified',
			__( 'Random', 'nitro' )        => 'rand',
			__( 'Comment count', 'nitro' ) => 'comment_count',
			__( 'Menu order', 'nitro' )    => 'menu_order',
		);
		$order_way_values = array(
			'',
			__( 'Descending', 'nitro' ) => 'DESC',
			__( 'Ascending', 'nitro' )  => 'ASC',
		);

		// Get all terms of gallery
		$gallery_cat = array(
			__( 'All', 'nitro' ) => '',
		);
		$terms = get_terms( 'gallery_cat' );
		if ( $terms && ! isset( $terms->errors ) ) {
			foreach ( $terms as $key => $value ) {
				$gallery_cat[$value->name] = $value->term_id;
			}
		}

		// Map new Gallery element.
		vc_map(
			array(
				'name'     => __( 'Nitro Gallery', 'nitro' ),
				'base'     => 'nitro_gallery',
				'icon'     => 'fa fa-picture-o',
				'category' => __( 'Nitro Elements', 'nitro' ),
				'params'   => array(
					array(
						'heading'     => __( 'Category', 'nitro' ),
						'param_name'  => 'cat_id',
						'type'        => 'dropdown',
						'value'       => $gallery_cat,
						'admin_label' => true,
					),
					array(
						'param_name'  => 'style',
						'heading'     => __( 'Gallery Style', 'nitro' ),
						'type'        => 'dropdown',
						'admin_label' => true,
						'value'       => array(
							__( 'Grid', 'nitro' )     => 'grid',
							__( 'Masonry', 'nitro' )  => 'masonry',
						),
						'edit_field_class' => 'vc_col-xs-6 mgt20 vc_column',
					),
					array(
						'param_name'  => 'thumb_shape',
						'heading'     => __( 'Thumbnail Shape', 'nitro' ),
						'type'        => 'dropdown',
						'admin_label' => true,
						'value'       => array(
							__( 'Square', 'nitro' )               => 'square',
							__( 'Rectangle Horizontal', 'nitro' ) => 'rec-horizontal',
							__( 'Rectangle Vertical', 'nitro' )   => 'rec-vertical',
						),
						'dependency' => array(
							'element' => 'style',
							'value'   => 'grid'
						),
						'std' => 'square',
						'edit_field_class' => 'vc_col-xs-6 mgt20 vc_column',
					),
					array(
						'param_name'  => 'columns',
						'heading'     => __( 'Number Of Columns', 'nitro' ),
						'type'        => 'dropdown',
						'admin_label' => true,
						'value'       => array(
							__( '2 Columns', 'nitro' ) => '2',
							__( '3 Columns', 'nitro' ) => '3',
							__( '4 Columns', 'nitro' ) => '4',
							__( '5 Columns', 'nitro' ) => '5',
							__( '6 Columns', 'nitro' ) => '6',
						),
						'std' => '3',
						'edit_field_class' => 'vc_col-xs-6 mgt20 vc_column',
					),
					array(
						'param_name' => 'hover_effect',
						'heading'    => __( 'Hover Effect', 'nitro' ),
						'type'       => 'dropdown',
						'value'      => array(
							__( 'Display info of gallery items on mouse hovering', 'nitro' ) => 'inside',
							__( 'Always show info of gallery items', 'nitro' )               => 'outside',
						),
						'edit_field_class' => 'vc_col-xs-6 mgt20 vc_column',
					),
					array(
						'param_name' => 'space',
						'heading'    => __( 'Enter space value (<i>Unit: pixel</i>)', 'nitro' ),
						'type'       => 'textfield',
						'value'      => 30,
						'std'        => 30,
						'edit_field_class' => 'vc_col-xs-6 vc_column mgt20',
					),
					array(
						'param_name' => 'slider',
						'heading'    => __( 'Enable Slider For Thumbnail', 'nitro' ),
						'type'       => 'checkbox',
						'value'      => array( __( 'Yes', 'nitro' ) => 'yes' ),
						'dependency' => array(
							'element' => 'style',
							'value'   => 'grid'
						),
						'edit_field_class' => 'vc_col-xs-4 mgt20 vc_column',
					),
					array(
						'param_name' => 'excerpt',
						'heading'    => __( 'Show Excerpt', 'nitro' ),
						'type'       => 'checkbox',
						'value'      => array( __( 'Yes', 'nitro' ) => 'yes' ),
						'dependency' => array(
							'element' => 'hover_effect',
							'value'   => 'outside',
						),
					),
					array(
						'param_name' => 'excerpt_length',
						'heading'    => __( 'Excerpt Length', 'nitro' ),
						'type'       => 'textfield',
						'value'      => 10,
						'dependency' => array(
							'element' => 'excerpt',
							'value'   => 'yes',
						),
					),
					array(
						'param_name' => 'animation',
						'heading'    => __( 'Enable Animation for each item?', 'nitro' ),
						'type'       => 'checkbox',
					),
					array(
						'param_name' => 'filter',
						'heading'    => __( 'Enable Filter?', 'nitro' ),
						'type'       => 'checkbox',
						'value'      => array( __( 'Yes', 'nitro' ) => 'yes' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => __( 'Filter Alignment', 'nitro' ),
						'param_name' => 'align',
						'value'      => array(
							__( 'Left', 'nitro' ) 	=> 'tl',
							__( 'Center', 'nitro' ) => 'tc',
							__( 'Right', 'nitro' )	=> 'tr',
						),
						'std'        => 'tl',
						'dependency' => array(
							'element' => 'filter',
							'value'   => 'yes',
						),
					),
					array(
						'param_name'  => 'limit',
						'heading'     => __( 'Number Of Items To Show Per Page', 'nitro' ),
						'description' => __( 'Number only, -1 to show all posts', 'nitro' ),
						'type'        => 'textfield',
						'value'       => '12',
					),
					array(
						'type'        => 'autocomplete',
						'heading'     => __( 'Items', 'nitro' ),
						'description' => __( 'Input gallery ID or product title to see suggestions', 'nitro' ),
						'param_name'  => 'ids',
						'settings' => array(
							'multiple'      => true,
							'sortable'      => true,
							'unique_values' => true,
						),
						'save_always' => true,
					),
					array(
						'type'       => 'dropdown',
						'heading'    => __( 'Order by', 'nitro' ),
						'param_name' => 'orderby',
						'value'      => $order_by_values,
						'std'        => 'date',
						'save_always' => true,
						'description' => sprintf( __( 'Select how to sort retrieved gallerys. More at %s. Default by Title', 'nitro' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank" rel="noopener noreferrer">WordPress codex page</a>' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => __( 'Sort order', 'nitro' ),
						'param_name' => 'order',
						'value'      => $order_way_values,
						'std'        => 'ASC',
						'save_always' => true,
						'description' => sprintf( __( 'Designates the ascending or descending order. More at %s. Default by ASC', 'nitro' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank" rel="noopener noreferrer">WordPress codex page</a>' ),
					),
					array(
						'param_name'       => 'gallery_custom_id',
						'heading'          => __( 'Hidden ID', 'nitro' ),
						'type'             => 'textfield',
						'value'            => 1122334455,
						'edit_field_class' => 'hidden',
					),
				)
			)
		);

		// Map single gallery for masonry layout.
		vc_map(
			array(
				'name'     => __( 'Gallery', 'nitro' ),
				'base'     => 'nitro_gallery_single',
				'icon'     => 'fa fa-picture-o',
				'category' => __( 'Nitro Elements', 'nitro' ),
				'as_child' => array( 'only' => 'nitro_masonry' ),
				'params'   => array(
					array(
						'param_name' => 'gallery_id',
						'heading'    => __( 'Display gallery by ID', 'nitro' ),
						'type'       => 'textfield',
					),
				)
			)
		);
	}

	/**
	 * Add shortcode gallery.
	 *
	 * @since  1.0
	 */
	public static function shortcode_gallery( $atts, $content = null ) {
		$html = $attr_parent = $attr_child = '';

		// Extract shortcode parameters.
		extract(
			shortcode_atts(
				array(
					'cat_id'              => '',
					'style'               => 'grid',
					'slider'              => '',
					'excerpt'             => '',
					'excerpt_length'      => 10,
					'thumb_shape'         => 'square',
					'columns'             => '3',
					'hover_effect'        => 'inside',
					'space'               => 30,
					'animation'           => '',
					'filter'              => '',
					'align'               => 'tl',
					'ids'                 => '',
					'limit'               => '12',
					'orderby'             => 'date',
					'order'               => 'asc',
				),
				$atts
			)
		);

		// Generate custom ID
		$id = uniqid( 'nitro_custom_css_' );

		// Get gallery style
		if ( $style ) {
			$classes[] = $style;
		}

		if ( 'masonry' == $style || ( 'grid' == $style && $filter ) ) {
			$classes[] = 'nitro-gallery-masonry';
		}

		// Get gallery columns
		if ( $columns ) {
			$classes[] = 'columns-' . $columns;
		}

		// Get gallery hover effect
		if ( $hover_effect ) {
			$classes[] = $hover_effect;
		}

		// Get gallery column
		if ( $space ) {
			$attr_parent = 'style="margin: 0 -' . ( is_numeric( trim( $space / 2 ) ) ? trim( $space / 2 ) . 'px' : trim( $space / 2 ) ) . '"';
			$attr_child  = 'style="padding: ' . ( is_numeric( trim( $space / 2 ) ) ? trim( $space / 2 ) . 'px' : trim( $space / 2 ) ) . '"';
		} else {
			$attr_child  = 'style="padding: 0"';
		}

		// Filter gallery post type
		$args = array(
			'post_type'      => 'nitro-gallery',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'tax_query'      => array(),
			'orderby'        => $orderby,
			'order'          => $order,
		);

		if ( ! empty( $cat_id ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'gallery_cat',
				'field'    => 'term_id',
				'terms'    => array_map( 'trim', explode( ',', $cat_id ) ),
			);
		}

		if ( ! empty( $ids ) ) {
			$args['post__in'] = array_map( 'trim', explode( ',', $ids ) );
		}

		// Get query object.
		$query = new WP_Query( $args );

		// Retrieve the categories follow settings
		$cat_args = array(
			'taxonomy' => 'gallery_cat',
		);

		if ( ! empty( $cat_id ) ) {
			$cat_args['child_of'] = $cat_id;
		}

		$filter_cat = get_terms( $cat_args );

		// Generate HTML code.
		$html .= '<div id="' . esc_attr( $id ) . '" class="sc-gallery galleries">';

			// Filter
			if ( $filter_cat && $filter ) {
				$html .= '<a class="filter-on-mobile" href="javascript:void(0);"><i class="fa fa-align-justify"></i><span>' . __( 'All', 'nitro' ) . '</span></a>';
				$html .= '<nav class="gallery-cat filters ' . esc_attr( $align ) . '">';
					$html .= '<a data-filter="*" class="selected body_color hover-main">' . __( 'All', 'nitro' ) . '</a>';

					foreach ( $filter_cat as $category ) {
						$html .= '<a data-filter=".' . esc_attr( $category->slug ) . '" class="body_color hover-main">' . esc_html( $category->name ) . '</a>';
					}
				$html .= '</nav>';
			}

			$html .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" ' . $attr_parent . ' data-layout="' . esc_attr( $style ) . '">';

				if ( 'masonry' == $style ) {
					$html .= '<div class="grid-sizer cl-4 cs-6 cxs-12 cm-' . (int) 12 / $columns . '"></div>';
				}

				while ( $query->have_posts() ) {
					$query->the_post();

					// Get gallery image
					$photos = Nitro_Gallery_Post_Type::get_multiple_image();
					$photos_square     = Nitro_Gallery_Post_Type::get_multiple_image( '450x450' );
					$photos_vertical   = Nitro_Gallery_Post_Type::get_multiple_image( '420x521' );
					$photos_horizontal = Nitro_Gallery_Post_Type::get_multiple_image( '585x400' );

					// Get gallery category
					$categories = wp_get_post_terms( get_the_ID(), 'gallery_cat' );

					// Get gallert type
					$type = get_post_meta( get_the_ID(), 'gallery_type', true );

					if ( 'external' == $type ) {
						$gallery_url = get_post_meta( get_the_ID(), 'external_url', true );
					} else {
						$gallery_url = get_permalink();
					}

					$button_text = get_post_meta( get_the_ID(), 'external_button', true );
					if ( empty( $button_text ) ) {
						$button_text = __( 'View Detail', 'nitro' );
					}

					$items = array( 'hentry' );

					if ( ! empty( $type ) ) {
						$items[] = 'gallery-type-' . esc_attr( $type );
					}

					if ( $categories ) {
						foreach ( $categories as $category ) {
							$items[] = "{$category->slug}";
						}
					}

					if ( ! empty( $size ) ) {
						$items[ ] = $size;
					}

					if ( $columns ) {
						$items[] = 'cl-4 cs-6 cxs-12 cm-' . (int) 12 / $columns;
					}

					$html .= '<figure class="' . implode( ' ', get_post_class( $items ) ) . '" ' . $attr_child . '>';
						$html .= '<div class="pr">';

							if ( $animation && ! $filter ) {
								$html .= '<div class="wr-item-animation">';
							}
							$html .= '<div class="entry-thumb pr">';
							if ( 'external' == $type && $gallery_url ) {
								$html .= '<a href="' . esc_url( $gallery_url ) . '" target="_blank" rel="noopener noreferrer" class="external_link">' . esc_html( $button_text ) . '</a>';
							}

							// Set image width
							if ( $slider && 'masonry' != $style && 'external' != $type ) {
								$html .= '<div class="mask wr-nitro-carousel" data-owl-options=\'{"autoplay": "true", "items": "1", "dots": "false", "animateIn": "fadeIn", "animateOut": "fadeOut"}\'>';
								foreach ( $photos as $key => $photo ) {
									if ( 'grid' == $style ) {
										switch ( $thumb_shape ) {
											case 'rec-horizontal':
												$img = $photos_horizontal[$key];
												break;

											case 'rec-vertical':
												$img = $photos_vertical[$key];
												break;

											default:
												$img = $photos_square[$key];
												break;
										}

									} else {
										$img = $photo;
									}
									$html .= '<div class="gallery-item">';
										$html .= '<a href="' . esc_url( $gallery_url ) . '"><img class="ts-03" src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( get_the_title() ) . '"  width="' . esc_attr( $img[1] ) . '" height="' . esc_attr( $img[2] ) . '" ></a>';
									$html .= '</div>';
									if( $key == 5 ) break;
								}
								$html .= '</div>';

							} else {
								if ( has_post_thumbnail() ) {
									if ( 'grid' == $style ) {
										switch ( $thumb_shape ) {
											case 'rec-horizontal':
												$size = '585x400';
												break;
											case 'rec-vertical':
												$size = '420x521';
												break;
											default:
												$size = '450x450';
												break;
										}
									} else {
										$size = 'full';
									}

									$img = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
									// Render image
									$html .= '<div class="mask pr">';
										if ( $gallery_url ) {
											$html .= '<a href="' . esc_url( $gallery_url ) . '">';
										}
										$html .='<img src="' . esc_url( $img[0] ) . '" width="' . esc_attr( $img[1] ) . '" height="' . esc_attr( $img[2] ) . '" alt="' . get_the_title() . '" class="gallery_thumb" />';
										if ( $gallery_url ) {
											$html .= '</a>';
										}
									$html .= '</div>';
								} else {
									if ( $photos ) {
										foreach ( $photos as $key => $photo ) {
											if ( 'grid' == $style ) {
												switch ( $thumb_shape ) {
													case 'rec-horizontal':
														$img = $photos_horizontal[$key];
														break;

													case 'rec-vertical':
														$img = $photos_vertical[$key];
														break;

													default:
														$img = $photos_square[$key];
														break;
												}
											} else {
												$img = $photo;
											}
											$html .= '<div class="mask pr">';
												$html .= '<a href="' . esc_url( $gallery_url ) . '"><img class="ts-03" src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( get_the_title() ) . '"  width="' . esc_attr( $img[1] ) . '" height="' . esc_attr( $img[2] ) . '" ></a>';
											$html .= '</div>';
											if( $key == 0 ) break;
										}
									} else {
										$html .= '<div class="mask pr">';
											if ( $gallery_url ) {
												$html .= '<a href="' . esc_url( $gallery_url ) . '">';
											}
											$html .= '<img class="ts-03 placeholder" src="' . NITRO_GALLERY_URL . 'assets/img/placeholder.png" alt="' . esc_attr( get_the_title() ) . '"  width="1" height="1" >';
											if ( $gallery_url ) {
												$html .= '</a>';
											}
										$html .= '</div>';
									}
								}
							}

							$html .= '</div><!-- .entry-thumb -->';

							$html .= '<figcaption>';
								$html .= '<div class="title ts-03">';
									$html .= '<h5><a href="' . esc_url( $gallery_url ) . '" class="hover-primary">' . get_the_title() . '</a></h5>';

									if ( $categories && 'external' != $type ) {
										$html .= '<div class="cat pr">';
											$html .= get_the_term_list( get_the_ID(), 'gallery_cat', '', ', ' );
										$html .= '</div>';
									}

								$html .= '</div>';

							if ( $excerpt && 'outside' == $hover_effect ) {
								$html .= '<p>' . Nitro_Gallery_Post_Type::get_excerpt( $excerpt_length, '...' ) . '</p>';
							}

							$html .= '</figcaption>';

							if ( $animation && ! $filter ) {
								$html .= '</div>';
							}

						$html .= '</div>';
					$html .= '</figure>';
				}

			$html .= '</div><!-- $classes -->';
		$html .= '</div><!-- .sc-gallery -->';

		wp_reset_postdata();

		return apply_filters( 'nitro_shortcode_gallery', force_balance_tags( $html ) );
	}

	/**
	 * Add shortcode gallery.
	 *
	 * @since  1.0
	 */
	public static function shortcode_gallery_single( $atts, $content = null ) {
		$html = $css = '';

		// Extract shortcode parameters.
		extract(
			shortcode_atts(
				array(
					'gallery_id' => '',
				),
				$atts
			)
		);

		// Filter gallery post type
		$args = array(
			'post_type'      => 'nitro-gallery',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'p'              => $gallery_id
		);

		// Get query object.
		$query = new WP_Query( $args );

		// Generate HTML code.
		$html .= '<div class="sc-gallery galleries">';
			$html .= '<div class="grid inside">';

			while ( $query->have_posts() ) {
				$query->the_post();

				// Get gallery category
				$categories = wp_get_post_terms( get_the_ID(), 'gallery_cat' );

				$items = array( 'hentry pr' );

				if ( $categories ) {
					foreach ( $categories as $category ) {
						$items[] = "{$category->slug}";
					}
				}

				$html .= '<figure class="' . implode( ' ', get_post_class( $items ) ) . '">';
					$html .= '<div class="pr">';
						if ( has_post_thumbnail() ) {
							// Thumbnail link
							$thumb_link = wp_get_attachment_image_src( get_post_thumbnail_id(), '450x450' );

							$html .= '<div class="mask pr">';
								$html .= '<a href="' . get_permalink() . '"><img src="' . esc_url( $thumb_link[0] ) . '" width="450" height="450" alt="' . get_the_title() . '" /></a>';
							$html .= '</div>';
						} else {
							$html .= '<div class="mask pr">';
								$html .= '<a href="' . esc_url( get_permalink() ) . '"><img class="ts-03 placeholder" src="' . NITRO_GALLERY_URL . 'assets/img/placeholder.png" alt="' . esc_attr( get_the_title() ) . '"  width="1" height="1" ></a>';
							$html .= '</div>';
						}
					$html .= '</div>';

					$html .= '<figcaption">';
						$html .= '<div class="title ts-03">';
							$html .= '<h5><a href="' . esc_url( get_permalink() ) . '" class="hover-primary">' . get_the_title() . '</a></h5>';

							if ( $categories ) {
								$html .= '<div class="cat pr">';
									$html .= get_the_term_list( get_the_ID(), 'gallery_cat', '', ', ' );
								$html .= '</div>';
							}
						$html .= '</div>';
					$html .= '</figcaption>';
				$html .= '</figure>';
			}

			$html .= '</div>';
		$html .= '</div>';

		wp_reset_postdata();

		return apply_filters( 'nitro_shortcode_gallery_single', force_balance_tags( $html ) );
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @return  void
	 */
	public static function enqueue_scripts() {
		if ( is_singular() ) {
			global $post;

			if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'nitro_gallery' ) ) {
				// Isotope
				wp_enqueue_script( 'isotope', NITRO_GALLERY_URL . 'assets/vendors/nivo-lightbox/nivo-lightbox.min.js', array(), false, true );

				// Nivo lightbox
				wp_enqueue_script( 'nivo-lightbox', NITRO_GALLERY_URL . 'assets/vendors/nivo-lightbox/nivo-lightbox.min.js', array(), false, true );
				wp_enqueue_style( 'nivo-lightbox', NITRO_GALLERY_URL . 'assets/vendors/nivo-lightbox/nivo-lightbox.css' );

				// Owl carousel
				wp_enqueue_script( 'owl-carousel', NITRO_GALLERY_URL . 'assets/vendors/owl-carousel/owl.carousel.min.js', array(), false, true );
				wp_enqueue_style( 'owl-carousel', NITRO_GALLERY_URL . 'assets/vendors/owl-carousel/owl.carousel.min.css' );
			}
		}
	}
}
