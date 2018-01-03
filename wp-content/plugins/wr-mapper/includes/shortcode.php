<?php
/**
 * @version    1.0
 * @package    WR_Mapper
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

/**
 * Define class to register shortcode wr_mapper
 */
class WR_Mapper_Shortcode {
	/**
	 * Initialize.
	 *
	 * @return  void
	 */
	public static function initialize() {
		// Add shortcode
		add_shortcode( 'wr_mapper', array( __CLASS__, 'render_shortcode' ) );

		// Enqueue style and script
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts'  ) );
	}

	/**
	 * Generate HTML code based on shortcode parameters.
	 *
	 * @param   array   $atts     Shortcode parameters.
	 * @param   string  $content  Current content.
	 *
	 * @return  string
	 */
	public static function render_shortcode( $atts, $content = null ) {
		$html = '';

		// Extract shortcode parameters.
		if ( ! isset( $atts['id'] ) ) {
			return;
		}

		// Check is publish
		if( get_post_status( $atts['id'] ) != 'publish' ) {
			return;
		}

		// Get current image.
		$attachment_id = get_post_meta( $atts['id'], 'wr_mapper_image', true );

		if ( ! $attachment_id ) {
			return;
		}

		// Check extra_class if add by VC
		$extra_class = ( ! empty( $atts['extra_class'] ) ) ? $atts['extra_class'] : '';

		// Get image source.
		$image_src  = wp_get_attachment_url( $attachment_id );
		$image_data = wp_get_attachment_metadata( $attachment_id );

		// Get general settings.
		$settings = get_post_meta( $atts['id'], 'wr_mapper_settings', true );

		// Get all pins.
		$pins = get_post_meta( $atts['id'], 'wr_mapper_pins', true );

		// Generate CSS.
		$html .= self::inline_style( $atts['id'], $settings, $pins );

		// Generate HTML.
		$html .= '
		<div id="wr-mapper-' . esc_attr( $atts['id'] ) . '" class="wr-mapper ' . esc_attr( $extra_class ) . ' ' . esc_attr( $settings['tooltip-style'] ) . ' ' . esc_attr( $settings['popup-show-effect'] ) . ' ' . esc_attr( $settings['image-effect'] ) . '" data-width="' . esc_attr( $image_data['width'] ) . '" data-height="' . esc_attr( $image_data['height'] ) . '">
			<img src="' . esc_attr( $image_src ) . '" width="' . esc_attr( $image_data['width'] ) . '" height="' . esc_attr( $image_data['height'] ) . '" alt="' . esc_attr( basename( $image_src ) ) . '" />';

		if ( $settings['image-effect'] == 'mask' ) {
			$html .= '<div class="mask"></div>';
		}

		if ( $pins ) {
			foreach ( $pins as $pin ) {
				$html .= '<div id="wrm-pin-' . esc_attr( $pin['settings']['id'] ) . '" class="wrm-pin" data-top="' . esc_attr( $pin['top'] ) . '" data-left="' . esc_attr( $pin['left'] ) . '" data-position="' . esc_attr( $pin['settings']['popup-position'] ) . '">';
					if ( $pin['settings']['icon-type'] == 'icon-image' && ! empty( $pin['settings']['image-template'] ) ) {
						$image_size = getimagesize( $pin['settings']['image-template'] );
						$html .= '<img class="action-pin image-pin" src="' . esc_attr( $pin['settings']['image-template'] ) . '" alt="Pin" width="' . esc_attr( $image_size[0] ) . '" height="' . esc_attr( $image_size[1] ) . '" />';
					} else {
						$html .= '<i class="action-pin icon-pin wricon-' . esc_attr( $pin['settings']['icon'] ) . ' ' . esc_attr( $pin['settings']['icon-effect'] ) . '"></i>';
					}

					// Product Item
					if ( class_exists( 'WooCommerce' ) && $pin['settings']['pin-type'] == 'woocommerce' && ( ! empty( $pin['settings']['product'] ) ) ) {
						$product_id = $pin['settings']['product'];
						$_product = wc_get_product( $product_id );

						$html .= '<h3 class="wrm-title">' . get_the_title( $product_id ) . '</h3>';

						$html .= '<div class="wrm-popup wrm-wc ' . esc_attr( $pin['settings']['popup-position'] ) . '">';
							$html .= '<div class="wrm-popup-header">';
								$html .= '<h2><a href="' . esc_url( get_permalink( $product_id ) ) . '">' . get_the_title( $product_id ) . '</a></h2>';
								if ( $_product->get_price_html() ) {
									$html .= '<div class="wrm-wc-info">';
										$html .= '<div class="wrm-wc-price">' . $_product->get_price_html() . '</div>';
										if ( $pin['settings']['product-rate'] ) {
											$html .= '<div class="woocommerce-product-rating">';
												$html .= wc_get_rating_html( $_product->get_average_rating() );
												if ( $_product->get_rating_count() ) {
													$html .= '<div class="review-count">(';
														$html .= sprintf( __( '%s Reviews', 'wr-mapper' ), $_product->get_rating_count() );
													$html .= ')</div>';
												}
											$html .= '</div>';
										}
									$html .= '</div>';
								}
								$html .= '<a class="pa close-modal" href="javascript:void(0)"><i class="wricon-cancel"></i></a>';
							$html .= '</div>';

							$html .= '<div class="wrm-popup-main">';
								if ( $pin['settings']['product-thumbnail'] ) {
									$html .= '<div class="col-left wrm-product-thumbnail">';
										$html .= '<a href="' . esc_url( get_permalink( $product_id ) ) . '">';
											$html .= get_the_post_thumbnail( $product_id, 'wrm-wc-thumbnail' );
										$html .= '</a>';
									$html .= '</div>';
								}
								$html .= '<div class="col-right">';
									if ( $pin['settings']['product-description'] ) {
										if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
											$html .= '<p>' . wp_trim_words( $_product->post->post_excerpt, 10, '...' ) . '</p>';
										} else {
											$html .= '<p>' . wp_trim_words( $_product->get_short_description(), 10, '...' ) . '</p>';
										}
									}
								$html .= '</div>';
							$html .= '</div>';

							$html .= '<div class="wrm-popup-footer">';
								if ( $_product->is_type( 'simple' ) && ! WR_Mapper_Helper::yith_wc_product_add_ons( $product_id ) && ! WR_Mapper_Helper::check_gravityforms( $product_id ) && ! WR_Mapper_Helper::wc_measurement_price_calculator( $product_id ) ) {
									$html .= '<a href="' . esc_url( $_product->add_to_cart_url() ) . '" data-product_id="' . esc_attr( $product_id ) . '" data-quantity="1" class="ajax_add_to_cart add_to_cart_button button product_type_simple"><i class="wricon-bag"></i>' . __( 'Add To Cart', 'wr-mapper' ) . '</a>';
								} else {
									$html .= '<a href="' . esc_url( get_permalink( $product_id ) ) . '" data-product_id="' . esc_attr( $product_id ) . '" data-quantity="1" class="add_to_cart_button button product_type_simple"><i class="wricon-bag"></i>' . __( 'Select Options', 'wr-mapper' ) . '</a>';
								}
							$html .= '</div>';
						$html .= '</div>';

					// Image Item
					} elseif ( $pin['settings']['pin-type'] == 'image' ) {
						if ( ! empty( $pin['settings']['popup-title'] ) ) {
							$html .= '<h3 class="wrm-title">' . $pin['settings']['popup-title'] . '</h3>';
						} else {
							$html .= '<h3 class="wrm-title">' . __( 'Add your title in backend', 'wr-mapper' ) . '</h3>';
						}

						$html .= '<div class="wrm-popup wrm-image ' . esc_attr( $pin['settings']['popup-position'] ) . '">';
							$html .= '<div class="wrm-popup-header">';
								$html .= '<h2>' . $pin['settings']['popup-title'] . '</h2>';
								$html .= '<a class="pa close-modal" href="javascript:void(0)"><i class="wricon-cancel"></i></a>';
							$html .= '</div>';

							$html .= '<div class="wrm-popup-main">';
								if ( ! empty( $pin['settings']['image-link-to'] ) ) {
									$html .= '<a target="' . esc_attr( $pin['settings']['image-link-target'] ) . '" href="' . esc_url( $pin['settings']['image-link-to'] ) . '">';
								}
								if ( $pin['settings']['image'] ) {
									$html .= '<img src="' . esc_url( $pin['settings']['image'] ) . '"/>';
								}
								if ( ! empty( $pin['settings']['image-link-to'] ) ) {
									$html .= '</a>';
								}
							$html .= '</div>';
						$html .= '</div>';

					// Text Item
					} elseif ( $pin['settings']['pin-type'] == 'text' ) {
						if ( ! empty( $pin['settings']['popup-title'] ) ) {
							$html .= '<h3 class="wrm-title">' . $pin['settings']['popup-title'] . '</h3>';
						} else {
							$html .= '<h3 class="wrm-title">' . __( 'Add your title in backend', 'wr-mapper' ) . '</h3>';
						}

						$html .= '<div class="wrm-popup wrm-text ' . esc_attr( $pin['settings']['popup-position'] ) . '">';
							$html .= '<div class="wrm-popup-header">';
								$html .= '<h2>' . $pin['settings']['popup-title'] . '</h2>';
								$html .= '<a class="pa close-modal" href="javascript:void(0)"><i class="wricon-cancel"></i></a>';
							$html .= '</div>';

							$html .= '<div class="wrm-popup-main">';
								$html .= '<div class="content-text">';
									$html .= nl2br( do_shortcode( $pin['settings']['text'] ) );
								$html .= '</div>';
							$html .= '</div>';
						$html .= '</div>';

					// Link Item
					} elseif ( $pin['settings']['pin-type'] == 'link' ) {
						$html .= '<a class="wrm-link" target="' . esc_attr( $pin['settings']['image-link-target'] ) . '" href="' . esc_url( $pin['settings']['image-link-to'] ) . '"></a>';

						if ( ! empty( $pin['settings']['popup-title'] ) ) {
							$html .= '<h3 class="wrm-title">' . $pin['settings']['popup-title'] . '</h3>';
						} else {
							$html .= '<h3 class="wrm-title">' . __( 'Add your title in backend', 'wr-mapper' ) . '</h3>';
						}
					}
				$html .= '</div>';
			}
		}

		$html .= '
		</div>';

		return apply_filters( 'render_shortcode', force_balance_tags( $html ) );
	}

	/**
	 * Enqueue custom scripts / stylesheets.
	 *
	 * @return  void
	 */
	public static function enqueue_scripts() {
		if ( is_singular() ) {
			global $post;

			if ( has_shortcode( $post->post_content, "wr_mapper" ) || has_shortcode( $post->post_excerpt, "wr_mapper" ) ) {
				// Enqueue required assets.
				wp_enqueue_style( 'wr-mapper', WR_MAPPER_URL . 'assets/css/frontend.css' );
				wp_enqueue_script( 'wr-mapper', WR_MAPPER_URL . 'assets/js/frontend.js', array(), false, true );
			}
		}
	}

	/**
	 * Render inline style.
	 *
	 * @param   int    $id        Mapper ID.
	 * @param   array  $settings  Mapper settings.
	 * @param   array  $pins      Mapper pins.
	 *
	 * @return  void
	 */
	public static function inline_style( $id, $settings, $pins ) {
		// Generate CSS rules for general settings.
		$css = '
		<style type="text/css">
			#wr-mapper-' . $id . ' .wrm-popup {';

		if ( $settings['popup-width'] ) {
			$css .= 'width: ' . esc_attr( $settings['popup-width'] ) . 'px;';
		}

		if ( $settings['popup-height'] ) {
			$css .= 'height: ' . esc_attr( $settings['popup-height'] ) . 'px;';
		}

		if ( $settings['popup-box-shadow'] ) {
			$css .= 'box-shadow: 0px 2px 10px 0px ' . esc_attr( $settings['popup-box-shadow'] ) . ';';
		}

		if ( $settings['popup-border-radius'] ) {
			$css .= 'border-radius: ' . (int) $settings['popup-border-radius'] . 'px;';
		}

		if ( $settings['popup-border-width'] ) {
			$css .= 'border: ' . (int) $settings['popup-border-width'] . 'px solid;';
		}

		if ( $settings['popup-border-color'] ) {
			$css .= 'border-color: ' . esc_attr( $settings['popup-border-color'] ) . ';';
		}

		$css .= '}';

		if ( $settings['popup-border-radius'] ) {
			$css .= '
			#wr-mapper-' . $id . '.wr-mapper .wrm-pin .wrm-popup-footer a {border-radius: 0 0 ' . (int) $settings['popup-border-radius'] . 'px ' . (int) $settings['popup-border-radius'] . 'px;}';
		}

		if ( $settings['image-effect'] == 'mask' ) {
			$css .= '
			#wr-mapper-' . $id . ' .mask {';

			if ( $settings['mask-color'] ) {
				$css .= 'background: ' . esc_attr( $settings['mask-color'] ) . ';';
			}

			$css .= '}';
		}

		/*if ( $settings['popup-full-width'] ) {
			$css .= '
			#wr-mapper-' . get_the_ID() . ' {display: block;}
			#wr-mapper-' . get_the_ID() . ' > img {width: 100%}';
		}*/

		// Generate CSS rules for each pin.
		if ( $pins ) {
			foreach ( $pins as $pin ) {
				// Popup width & height
				$css .= '
			#wr-mapper-' . $id . ' #wrm-pin-' . esc_attr( $pin['settings']['id'] ) . ' .wrm-popup {';

				if ( isset( $pin['settings']['popup-width'] ) && (int) $pin['settings']['popup-width'] > 0 ) {
					$css .= 'width: ' . (int) $pin['settings']['popup-width'] . 'px;';
				}

				if ( isset( $pin['settings']['popup-height'] ) && (int) $pin['settings']['popup-height'] > 0 ) {
					$css .= 'height: ' . (int) $pin['settings']['popup-height'] . 'px;';
				}

				$css .= '}';

				// Pin style setting
				$css .= '
			#wr-mapper-' . $id . ' #wrm-pin-' . esc_attr( $pin['settings']['id'] ) . ' .icon-pin {';

				if ( isset( $pin['settings']['bg-color'] ) ) {
					$css .= 'background: ' . esc_attr( $pin['settings']['bg-color'] ) . ';';
				}

				if ( isset( $pin['settings']['icon-color'] ) ) {
					$css .= 'color: ' . esc_attr( $pin['settings']['icon-color'] ) . ';';
				}

				if ( isset( $pin['settings']['icon-size'] ) ) {
					$css .= 'font-size: ' . (int) esc_attr( $pin['settings']['icon-size'] ) . 'px;';
					$css .= 'width: ' . (int) esc_attr( $pin['settings']['icon-size'] ) * 1.2 . 'px;';
					$css .= 'line-height: ' . (int) esc_attr( $pin['settings']['icon-size'] ) * 1.2 . 'px;';
				}

				if ( isset( $pin['settings']['border-width'] ) && (int) $pin['settings']['border-width'] > 0 ) {
					$css .= 'box-shadow: 0 0 0 ' . (int) esc_attr( $pin['settings']['border-width'] ) . 'px ' . esc_attr( $pin['settings']['border-color'] ) . ';';
				}

				$css .= '}';

				// Pin hover setting
				$css .= '
			#wr-mapper-' . $id . ' #wrm-pin-' . esc_attr( $pin['settings']['id'] ) . ' .icon-pin:hover {';

				if ( isset( $pin['settings']['bg-color-hover'] ) ) {
					$css .= 'background: ' . esc_attr( $pin['settings']['bg-color-hover'] ) . ';';
				}
				if ( isset( $pin['settings']['icon-color-hover'] ) ) {
					$css .= 'color: ' . esc_attr( $pin['settings']['icon-color-hover'] ) . ';';
				}

				$css .= '}';
			}
		}

		$css .= '
		</style>';

		return $css;
	}
}
