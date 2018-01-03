<?php
/**
 * @version    1.0
 * @package    WR_Custom_Attributes
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */
?>
<ul class="wr-custom-attribute color-picker oh">
	<?php
	if ( $options ):
		//Get unique color
		foreach ( $variations as $variation => $key ) {
			$wr_variation[ $key['attributes']['attribute_' . $attribute_name] ] = array (
				'color' => $key['attributes']['attribute_' . $attribute_name],
				'image' => wp_get_attachment_image_src( $key['image_id'], 'shop_catalog' )
			);
		}

		foreach ( $options as $term ) :
			$color   = get_woocommerce_term_meta( $term->term_id, 'wr_color'   );
			
			foreach ( $wr_variation as $key => $value ) :
				// Get custom data.
				if ( $term->slug == $key ) :
					?>
						<li>
							<a href="javascript:void(0)"
								data-image="<?php echo esc_url( $value['image'][0] ); ?>"
								style="background-color: <?php echo esc_attr( $color ); ?>">
							</a>
						</li>
					<?php
				endif;
			endforeach;
		endforeach;
	endif;
	?>
</ul>
