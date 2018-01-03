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
	#in-stock-alert {
		position: fixed;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		z-index: 9;
		background: rgba(0, 0, 0, .25);
	}
	#in-stock-alert-form {
		position: fixed;
		top: 50%;
		left: 50%;
		border-radius: 8px;
		padding: .75em 1.5em;
		overflow: auto;
		background: #fff;
	}
	#in-stock-alert-form form {
		text-align: center;
	}
</style>
<div id="in-stock-alert" class="hidden">
	<div id="in-stock-alert-form">
		<h3>
			<?php _e( 'Export subscriptions to CSV format', 'wr-in-stock-alert' ); ?>
		</h3>
		<p class="status"></p>
		<form target="wr-in-stock-alert-export-iframe" method="POST" action="<?php echo
			esc_url( admin_url( 'admin-ajax.php?action=export-in-stock-alert-subscriptions-to-csv' ) );
		?>">
			<?php wp_nonce_field( 'export-in-stock-alert-subscriptions-to-csv' ); ?>
			<div id="subscription_ids" class="hidden"></div>
			<input type="button" class="button action export" value="<?php _e( 'Export', 'wr-in-stock-alert' ); ?>">
			<input type="button" class="button action close" value="<?php _e( 'Close', 'wr-in-stock-alert' ); ?>">
		</form>
		<iframe id="wr-in-stock-alert-export-iframe" name="wr-in-stock-alert-export-iframe" src="about:blank" class="hidden"></iframe>
	</div>
</div>
<script type="text/javascript">
	jQuery(function($) {
		// Add Export action to bulk actions select box.
		$('#bulk-action-selector-top, #bulk-action-selector-bottom').children('option[value="trash"]').before(
			'<option value="export"><?php _e( 'Export', 'wr-in-stock-alert' ); ?></option>'
		);

		// Setup export action.
		$('#doaction, #doaction2').click(function() {
			if ($(this).parent().children('select').val() == 'export') {
				// Get checked items.
				var items = $('input[id^="cb-select-"]:checked').filter('[name^="post"]');

				if (!items.length) {
					$('#in-stock-alert-form > p.status').text(
						'<?php _e( 'You have not selected any subscription yet. Do you want to export all subscriptions that match current filters to CSV file?', 'wr-in-stock-alert' ); ?>'
					);
				} else {
					$('#in-stock-alert-form > p.status').text(
						'<?php _e( 'Are you sure you want to export the %SELECTED% selected subscriptions to CSV file?', 'wr-in-stock-alert' ); ?>'
							.replace('%SELECTED%', items.length)
					);
				}

				// Make sure export button is enabled.
				$('#in-stock-alert-form input.action.export').removeAttr('disabled').removeClass('hidden');

				// Show popup.
				$('#in-stock-alert').removeClass('hidden');

				// Resize popup to fit window.
				$(window).trigger('resize');

				// Prevent form submission.
				this.form.export_action_selected = true;
			}
		});

		// Setup popup handler.
		$('#in-stock-alert').click(function(event) {
			if (!$(event.target).closest('#in-stock-alert-form').length) {
				$('#in-stock-alert').addClass('hidden');
			}
		}).appendTo(document.body);

		$(window).resize(function() {
			$('#in-stock-alert-form')
				.css('width', $(window).width() / 4)
				.css({
					'margin-top': '-' + ($('#in-stock-alert-form').height() / 2 + ($(window).height() / 2 - $(window).height() / 3)) + 'px',
					'margin-left': '-' + ($(window).width() / 8) + 'px',
				});
		});

		$('#in-stock-alert-form input.action').click(function() {
			if ($(this).hasClass('close')) {
				return $('#in-stock-alert').addClass('hidden');
			}

			// Set processing status.
			$('#in-stock-alert-form > p.status').text('<?php _e( 'Your download will start shortly...', 'wr-in-stock-alert' ); ?>');

			// Disable export button.
			$(this).attr('disabled', 'disabled');

			// Handle iframe load event.
			$('#wr-in-stock-alert-export-iframe').load(function() {
				// Parse response.
				var response;

				try {
					response = $.parseJSON($(this).contents().find('body').text());

					if (response && response.data) {
						response = response.data;
					}
				} catch (e) {
					response = $(this).contents().find('body').text();
				}

				// Show error message.
				$('#in-stock-alert-form > p.status').text(response);

				// Hide export button.
				$('#in-stock-alert-form input.action.export').addClass('hidden');
			});

			// Prepare form to export subscriptions to CSV file.
			$('#in-stock-alert-form #subscription_ids').empty().append(
				$('#posts-filter input[name="s"], #posts-filter select[name="m"], #posts-filter select[name="post_parent"]').clone()
			).append(
				$('input[id^="cb-select-"]:checked').filter('[name^="post"]').clone()
			);

			// Submit form to export subscriptions to CSV file.
			$('#in-stock-alert-form > form').submit();
		});

		// Handle form submission.
		$('#posts-filter').submit(function(event) {
			if (this.export_action_selected) {
				// Prevent form submission.
				event.preventDefault();

				return (this.export_action_selected = false);
			}
		});
	});
</script>
