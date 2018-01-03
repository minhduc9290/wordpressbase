<?php
/**
 * @version    1.0
 * @package    Nitro_Toolkit
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

// Get thumbnail shape
$thumb_style    = get_theme_mod( 'gallery_thumb_style', 'square' );
$fullwidth      = get_theme_mod( 'gallery_fullwidth', 0 );
$limit          = get_theme_mod( 'gallery_limit', 12 );
$excerpt        = get_theme_mod( 'gallery_excerpt', 0 );
$excerpt_length = get_theme_mod( 'gallery_excerpt_length', 10 );

get_header(); ?>
	<?php WR_Nitro_Render::get_template( 'common/page', 'title' ); ?>
	<div class="<?php echo ( $fullwidth ? 'full-width pdr30 pdl30' : 'container' ) . ( is_customize_preview() ? ' customizable customize-section-gallery_archive' : '' ); ?>">
		<div class="galleries mgt60">
			<?php
				// Filter gallery post type
				$args = array(
					'post_type'           => 'nitro-gallery',
					'post_status'         => 'publish',
					'posts_per_page'      => $limit,
					'ignore_sticky_posts' => 1,
				);

				if ( is_tax( 'gallery_cat' ) ) {
					$args['tax_query'][] = array(
						'taxonomy' => 'gallery_cat',
						'field'    => 'slug',
						'terms'    =>  get_query_var( 'gallery_cat' ),
					);
				}

				if ( is_tax( 'gallery_tag' ) ) {
					$args['tax_query'][] = array(
						'taxonomy' => 'gallery_tag',
						'field'    => 'slug',
						'terms'    =>  get_query_var( 'gallery_tag' ),
					);
				}

				$classes = array( 'row' );

				// Get gallery style
				$style = get_theme_mod( 'gallery_layout', 'grid' );
				if ( $style ) {
					$classes[] = $style;
				}

				// Get gallery columns
				$columns = get_theme_mod( 'gallery_column', 4 );

				// Get hover effect
				$hover = get_theme_mod( 'gallery_style', 'inside' );
				if ( $hover ) {
					$classes[] = $hover;
				}

				// Spacing between item
				$space = get_theme_mod( 'gallery_gutter', 30 );

				// Gallery thumbnail slider
				$thumb_slider = get_theme_mod( 'gallery_thumbnail_slide', 0 );

				// Filter
				$filter = get_theme_mod( 'gallery_filter', 1 );
				$filter_align = get_theme_mod( 'gallery_filter_align', 'tl' );

				// Item animation
				$animation = get_theme_mod( 'gallery_item_animation', 1 );

				if ( 'masonry' == $style || ( 'grid' == $style && $filter ) ) {
					$classes[] = 'nitro-gallery-masonry';
				}

				// Retrieve all the categories
				$terms = get_terms( 'gallery_cat' );

				// The query
				$query = new WP_Query( $args );

				if ( $terms && $filter ) {
					echo '<a class="filter-on-mobile" href="javascript:void(0);"><i class="fa fa-align-justify"></i><span>' . __( 'Show All', 'nitro' ) . '</span></a>'; ?>
					<nav class="gallery-cat filters clear <?php echo esc_attr( $filter_align );?>">
						<a data-filter="*" class="selected body_color hover-main"><?php _e( 'Show All', 'nitro' ); ?></a>
						<?php foreach ( $terms as $term ) : ?>
							<a data-filter=".<?php esc_attr_e( $term->slug ); ?>" class="body_color hover-main"><?php esc_html_e( $term->name ); ?></a>
						<?php endforeach; ?>
					</nav>
				<?php }
			?>

			<div class="<?php esc_attr_e( implode( ' ', $classes ) ); ?>" data-layout="<?php echo esc_attr( $style ); ?>">
				<?php
					if ( 'masonry' == $style ) {
						echo '<div class="grid-sizer cl-4 cs-6 cxs-12 cm-' . (int) 12 / $columns . '"></div>';
					}

					while ( $query->have_posts() ) : $query->the_post();

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

						$items = array();
						if ( $categories ) {
							foreach ( $categories as $category ) {
								$items[] = "{$category->slug}";
							}
						}

						if ( ! empty( $type ) ) {
							$items[] = 'gallery-type-' . esc_attr( $type );
						}

						$items[] = 'cs-6 cxs-12 cm-' . (int) 12 / $columns;
						if ( '2' < $columns ) {
							$items[] = 'cl-4';
						} else {
							$items[] = 'cl-6';
						}
				?>

					<figure id="post-<?php the_ID(); ?>" <?php post_class( implode( ' ', $items ) ); ?>>
						<?php echo $animation && ! $filter ? '<div class="wr-item-animation">' : ''; ?>
							<?php
								echo '<div class="entry-thumb pr">';
								if ( 'external' == $type && $gallery_url ) {
									echo '<a href="' . esc_url( $gallery_url ) . '" target="_blank" rel="noopener noreferrer" class="external_link">' . esc_html( $button_text ) . '</a>';
								}
								// Set image width
								if ( $thumb_slider && 'masonry' != $style && 'external' != $type ) {
									echo '<div class="mask wr-nitro-carousel" data-owl-options=\'{"autoplay": "true", "items": "1", "dots": "false", "animateIn": "fadeIn", "animateOut": "fadeOut"}\'>';
										if ( $photos ) {
											foreach ( $photos as $key => $photo ) {
												if ( 'grid' == $style ) {
													switch ( $thumb_style ) {
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
												echo '<div class="gallery-item">';
													echo '<a href="' . esc_url( $gallery_url ) . '"><img class="ts-03" src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( get_the_title() ) . '"  width="' . esc_attr( $img[1] ) . '" height="' . esc_attr( $img[2] ) . '" ></a>';
												echo '</div>';
												if ( $key == 5 ) break;
											}
										} elseif ( has_post_thumbnail() ) {
											if ( 'grid' == $style ) {
												switch ( $thumb_style ) {
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

											echo '<div class="gallery-item">';
												echo '<a href="' . esc_url( $gallery_url ) . '"><img class="ts-03" src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( get_the_title() ) . '"  width="' . esc_attr( $img[1] ) . '" height="' . esc_attr( $img[2] ) . '" ></a>';
											echo '</div>';
										}
									echo '</div>';

								} else {
									if ( has_post_thumbnail() ) {
										if ( 'grid' == $style ) {
											switch ( $thumb_style ) {
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
										echo '<div class="mask pr">';
											if ( $gallery_url ) {
												echo '<a href="' . esc_url( $gallery_url ) . '">';
											}
											echo '<img src="' . esc_url( $img[0] ) . '" width="' . esc_attr( $img[1] ) . '" height="' . esc_attr( $img[2] ) . '" alt="' . get_the_title() . '" class="gallery_thumb" />';
											if ( $gallery_url ) {
												echo '</a>';
											}
										echo '</div>';
									} else {
										if ( $photos ) {
											foreach ( $photos as $key => $photo ) {
												if ( 'grid' == $style ) {
													switch ( $thumb_style ) {
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
												echo '<div class="gallery-item">';
													echo '<a href="' . esc_url( $gallery_url ) . '"><img class="ts-03" src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( get_the_title() ) . '"  width="' . esc_attr( $img[1] ) . '" height="' . esc_attr( $img[2] ) . '" ></a>';
												echo '</div>';
												if ( $key == 0 ) break;
											}
										} else {
											echo '<div class="mask pr">';
												if ( $gallery_url ) {
													echo '<a href="' . esc_url( $gallery_url ) . '">';
												}
												echo '<img class="ts-03 placeholder" src="' . NITRO_GALLERY_URL . 'assets/img/placeholder.png" alt="' . esc_attr( get_the_title() ) . '"  width="1" height="1">';
												if ( $gallery_url ) {
													echo '</a>';
												}
											echo '</div>';
										}
									}
								}
								echo '</div><!-- .entry-thumb -->';
							?>
							<figcaption>
								<div class="title ts-03">
									<h5><a href="<?php esc_url( the_permalink() ); ?>" class="db" title="<?php echo esc_attr( the_title() ); ?>" class="hover-primary"><?php the_title(); ?></a></h5>
									<?php
										if ( $categories && 'external' != $type ) {
											echo '<div class="cat pr">';
												echo get_the_term_list( $post->ID, 'gallery_cat', '', ', ' );
											echo '</div>';
										}
									?>
								</div><!-- .title -->
								<?php if ( $excerpt && 'outside' == $hover ) :
									echo '<p> ' . Nitro_Gallery_Post_Type::get_excerpt( $excerpt_length, '...' ) . '</p>';
								endif; ?>
							</figcaption>
						<?php echo $animation && ! $filter ? '</div>' : ''; ?>
					</figure>

				<?php endwhile; ?>
			</div><!-- .p-grid -->
		</div><!-- .port-grid -->
	</div><!-- .container -->

<?php get_footer(); ?>
