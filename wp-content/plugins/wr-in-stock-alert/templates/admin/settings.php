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
?>
<style type="text/css">
	textarea.regular-text {
		width: 25em;
		height: 16em;
	}
</style>
<div class="wrap">
	<h2><?php _e( 'In Stock Alert Settings' ); ?></h2>

	<?php if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) : ?>
	<div class="error">
		<p><?php _e( 'This plugin requires the following plugin: <strong>WooCommerce</strong>', 'wr-in-stock-alert' ); ?></p>
	</div>
	<?php endif; ?>

	<?php if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['saved'] ) ) : ?>
	<div class="notice notice-<?php if ( $_POST['saved'] ) echo 'success'; else echo 'error'; ?> is-dismissible">
		<p><?php
			if ( $_POST['saved'] )
				_e( 'Settings saved successfully!', 'wr-in-stock-alert' );
			else
				_e( 'Saving settings failed!', 'wr-in-stock-alert' );
		?></p>
	</div>
	<?php endif; ?>

	<form method="POST">
		<?php
		settings_fields( WR_ISA . '-settings' );
		do_settings_sections( WR_ISA . '-settings' );
		submit_button();
		?>
	</form>
</div>
