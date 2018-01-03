<?php
/**
 * @version    1.0
 * @package    WR_In_Stock_Alert
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

// Get current product.
global $product;

// Get In Stock Alert settings.
$settings = WR_In_Stock_Alert_Settings::get();

// Check if the URL to unsubscribe from receiving in stock alert is requested.
$unsubscribed = ( isset( $unsubscribed ) && false !== $unsubscribed );
?>
<div id="in-stock-alert" class="<?php if ( $unsubscribed ) echo 'unsubscribed'; ?>">
	<div id="in-stock-alert-form">
		<div class="form">
			<?php if ( $settings['show_popup_title'] ) : ?>
			<h3>
				<?php echo wp_kses_post( $settings['popup_title'] ); ?>
			</h3>
			<?php endif; ?>
			<p>
				<?php echo wp_kses_post( $settings['popup_message'] ); ?>
			</p>
			<form action="<?php echo esc_url( admin_url( 'admin-ajax.php?action=in-stock-alert-form-submission' ) ); ?>">
				<?php if ( $settings['show_name_field'] ) : ?>
				<input type="text" name="name" value="" placeholder="<?php echo esc_attr( $settings['name_field_label'] ); ?>" required>
				<br>
				<?php endif; ?>
				<input type="email" name="email" value="" placeholder="<?php echo esc_attr( $settings['email_field_label'] ); ?>" required>
				<br>
				<input type="hidden" name="product" value="<?php esc_attr_e( $product->get_id() ); ?>">
				<button type="submit">
					<?php echo wp_kses_post( $settings['popup_button_text'] ); ?>
				</button>
				<span class="loading hidden">
					<div class="wr-isa-loading"></div>
				</span>
				<span class="close"></span>
			</form>
		</div>
		<div class="message hidden">
			<p class="message-content"><?php
				if ( $unsubscribed )
					_e( 'You&#39;ve successfully unsubscribed from receiving in stock alert notification for this product.', 'wr-in-stock-alert' );
			?></p>
			<span class="close"></span>
		</div>
	</div>
</div>
