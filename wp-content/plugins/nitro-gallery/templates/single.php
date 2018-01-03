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

if ( class_exists( 'WR_Nitro' ) ) {
	$wr_nitro_options = WR_Nitro::get_options();
} else {
	$wr_nitro_options = '';
}

// Get layout
$layout      = $wr_nitro_options['gallery_single_layout'];
$fullwidth   = $wr_nitro_options['gallery_single_fullwidth'];
$fullscreen  = $wr_nitro_options['gallery_single_fullscreen'];
$thumb_style = $wr_nitro_options['gallery_single_thumb_style'];
$thumb_nav   = $wr_nitro_options['gallery_single_thumb_nav'];
$columns     = $wr_nitro_options['gallery_single_columns'];
$space       = $wr_nitro_options['gallery_single_gutter'];

// Get all image of gallery.
$photos_large      = Nitro_Gallery_Post_Type::get_multiple_image();
$photos_square     = Nitro_Gallery_Post_Type::get_multiple_image( '450x450' );
$photos_vertical   = Nitro_Gallery_Post_Type::get_multiple_image( '420x521' );
$photos_horizontal = Nitro_Gallery_Post_Type::get_multiple_image( '585x400' );
$photos_small      = Nitro_Gallery_Post_Type::get_multiple_image( '60x60' );

// Related gallery
$related = $wr_nitro_options['gallery_single_related'];

$data = $data_attr = $html = '';

// Render carousel
$data  = 'data-owl-options=\'{"autoplay": "true", "items": "1", "dots": "true", "autoHeight": "true", "autoplayTimeout": "8000"' . ( $wr_nitro_options['rtl'] ? ',"rtl": "true"' : '' ) . '}\'';

// Set image width base container & columns
if ( 'grid' == $layout || 'masonry' == $layout ) {
	$w = intval( 1170 / $columns ) * 2;
}

get_header();
?>
	<?php
		if ( ! ( 'slider' == $layout && 'full' ==  $fullscreen ) ) {
			WR_Nitro_Render::get_template( 'common/page', 'title' );
		}
	?>
	<div class="<?php echo ( $fullwidth || 'horizontal' == $layout || ( 'slider' == $layout && 'full' == $fullscreen ) ? 'single-full' : 'container' ) . ( is_customize_preview() ? ' customizable customize-section-gallery_single' : '' ); ?>">
		<div class="single-gallery mgt60 mgb60">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( $layout ); ?>>
					<?php if ( ! ( 'slider' == $layout && 'full' ==  $fullscreen ) ) : ?>
						<div class="gallery-content mgb50">
							<?php the_content(); ?>
						</div><!-- .gallery-content -->
					<?php endif; ?>
					<?php if ( 'slider' == $layout ) {
						echo '<div class="gallery-single-slider">';
							if ( ! empty( $photos_large ) ) {

								if ( 'full' == $fullscreen ) {

									echo '<div class="actions pa">';
									$previous     = get_adjacent_post();
									$next = get_adjacent_post( false, '', false );

									if ( $previous ) {
										printf( '<a href="%1$s" class="dib pr ts-03 hover-primary"><i class="fa fa-chevron-left"></i><span class="tooltip ab">' . __( 'Previous gallery', 'nitro' ) . '</span></a>', esc_url( get_permalink( $previous->ID ) ) );
									} else {
										echo '<a href="javascript:void(0);" class="dib pr ts-03 hover-primary"><i class="fa fa-chevron-left"></i><span class="tooltip ab">' . __( 'No gallery previous', 'nitro' ) . '</span></a>';
									}

									echo '<a href="' . get_post_type_archive_link( 'nitro-gallery' ) . '" class="dib pr ts-03 hover-primary"><i class="fa fa-th"></i><span class="tooltip ab">' . __( 'Back to galleries', 'nitro' ) . '</span></a>';
									if ( $next ) {
										printf( '<a href="%1$s" class="dib pr ts-03 hover-primary"><i class="fa fa-chevron-right"></i><span class="tooltip ab">' . __( 'Next gallery', 'nitro' ) . '</span></a>', esc_url( get_permalink( $next->ID ) ) );
									} else {
										echo '<a href="javascript:void(0);" class="dib pr ts-03 hover-primary"><i class="fa fa-chevron-right"></i><span class="tooltip ab">' . __( 'No gallery next', 'nitro' ) . '</span></a>';
									}

									echo '</div>';
									if ( $thumb_nav ) {
										$html .= '<div class="nav-thumb">';
										$html .= '<div class="wr-nitro-carousel exclude-carousel gallery-thumb pr">';
											foreach ( $photos_small as $photo ) {
												$html .= '<img class="ts-03" src="' . esc_url( $photo[0] ) . '" alt="' . esc_attr( get_the_title() ) . '"  width="60" height="60" />';
											}
										$html .= '</div>';
										$html .= '</div>';
									}
									$html .= '<div class="wr-nitro-carousel exclude-carousel gallery-cover">';
								} else {
									$html .= '<div class="wr-nitro-carousel" ' . $data . '>';
								}
								foreach ( $photos_large as $photo ) {
									if ( 'full' == $fullscreen ) {
										$html .= '<div class="item" style="background-image: url(' . esc_url( $photo[0] ) . ')"></div>';
									} else {
										$html .= '<a data-lightbox="nivo" data-lightbox-gallery="' . get_the_ID() . '" href="' . esc_url( $photo[0] ) . '"><img class="ts-03" src="' . esc_url( $photo[0] ) . '" alt="' . esc_attr( get_the_title() ) . '"  width="' . esc_attr( $photo[1] ) . '" height="' . esc_attr( $photo[2] ) . '" /></a>';
									}
								}
								$html .= '</div>';

								echo $html;

							} else {
								the_post_thumbnail();
							}
						echo '</div>';
					} elseif ( 'horizontal' == $layout ) {

						if ( get_theme_mod( 'gallery_single_autoplay', 0 ) ) {
							$attr[] = '"autoplay": "true"';
						}
						if ( get_theme_mod( 'gallery_single_dots', 0 ) ) {
							$attr[] = '"dots": "true"';
						}
						if ( get_theme_mod( 'gallery_single_mousewheel', 0 ) ) {
							$attr[] = '"mousewheel": "true"';
						}
						$attr[] = '"loop": "true"';

						if ( ! empty( $attr ) ) {
							$data_attr = 'data-owl-options=\'{' . esc_attr( implode( ', ', $attr ) ) . '}\'';
						}
						$html .= '<div class="gallery-list wr-nitro-horizontal wr-nitro-carousel exclude-carousel pdb30" ' . $data_attr . '>';
							if ( ! empty( $photos_large ) ) {
								foreach ( $photos_large as $photo ) {
									$html .= '<div class="item pr">';
									$html .= '<a data-lightbox="nivo" data-lightbox-gallery="' . get_the_ID() . '" href="' . esc_url( $photo[0] ) . '"><img class="ts-03" src="' . esc_url( $photo[0] ) . '" alt="' . esc_attr( get_the_title() ) . '"  width="' . esc_attr( $photo[1] ) . '" height="' . esc_attr( $photo[2] ) . '" /></a>';
									$html .= '</div>';
								}
							} else {
								// Get thumbnail link
								$image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
								the_post_thumbnail();
							}
						$html .= '</div>';

						echo $html;
					} elseif ( 'grid' == $layout ) {

						echo '<div class="gallery-list gallery-grid row columns-' . esc_attr( $columns ) . '">';

							if ( ! empty( $photos_large ) ) {
								foreach ( $photos_large as $key => $photo ) {
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

									$html .= '<div class="item fl pr">';
										$html .= '<a data-lightbox="nivo" data-lightbox-gallery="' . get_the_ID() . '" href="' . esc_url( $photo[0] ) . '"><img class="ts-03 gallery_thumb" src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( get_the_title() ) . '"  width="' . esc_attr( $img[1] ) . '" height="' . esc_attr( $img[2] ) . '" /></a>';
									$html .= '</div>';

								}
								echo $html;

							} else {
								// Get thumbnail link
								$image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
								the_post_thumbnail();
							}
						echo '</div>';
					} elseif ( 'masonry' == $layout ) {

						echo '<div class="gallery-list wr-nitro-masonry row columns-' . esc_attr( $columns ) . '" data-masonry=\'{"selector":".item","columnWidth":".grid-sizer"}\'>';
							echo '<div class="grid-sizer"></div>';

							if ( ! empty( $photos_large ) ) {
								foreach ( $photos_large as $photo ) {
									$html .= '<div class="item fl pr">';
									$html .= '<a data-lightbox="nivo" data-lightbox-gallery="' . get_the_ID() . '" href="' . esc_url( $photo[0] ) . '"><img class="ts-03" src="' . esc_url( $photo[0] ) . '" alt="' . esc_attr( get_the_title() ) . '"  width="' . esc_attr( $photo[1] ) . '" height="' . esc_attr( $photo[2] ) . '" /></a>';
									$html .= '</div>';
								}
								echo $html;

							} else {
								// Get thumbnail link
								$image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
								the_post_thumbnail();
							}
						echo '</div>';
					} ?>
				</article>

				<?php if ( $related && ! ( 'slider' == $layout && 'full' == $fullscreen ) && 'horizontal' != $layout ) Nitro_Gallery_Post_Type::related(); ?>

			<?php endwhile; wp_reset_postdata(); ?>
		</div><!-- .single-gallery -->
	</div>

<?php
get_footer();