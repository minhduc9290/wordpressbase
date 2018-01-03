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
?>
<p class="form-submit">
	<button id="in-stock-alert-link" class="button" type="button">
		<?php echo wp_kses_post( $settings['inline_button_text'] ); ?>
	</button>
</p>
<?php
// Load popup form.
include_once dirname( __FILE__ ) . '/popup.php';
