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

global $post;

// Get current image.
$attachment_id = get_post_meta( $post->ID, 'wr_mapper_image', true );

if ( $attachment_id ) {
	// Get image source.
	$image_src = wp_get_attachment_url( $attachment_id );
}

// Get general settings.
$settings = get_post_meta( $post->ID, 'wr_mapper_settings', true );

// Get all pins.
$pins = get_post_meta( $post->ID, 'wr_mapper_pins', true );
?>
<script type="text/html" id="wr_mapper_tmpl">
	<form name="post" action="post.php" method="post" id="post" autocomplete="off">
		<div class="wr-mapper bdgr bgw">
			<div class="wr-mapper-top fc aic jcsb pd__20">
				<h1 class="fc aic">
					<span><?php _e( 'Mapping builder', 'wr-mapper' ); ?></span>
					<a class="button" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=wr_mapper' ) ); ?>">
						<?php _e( 'Add New', 'wr-mapper' ); ?>
					</a>
				</h1>

				<div class="publish-action">
					<button id="save" type="submit" class="button button-primary"><?php _e( 'Save', 'wr-mapper' ); ?></button>
				</div>
			</div><!-- .wr-mapper-top -->

			<div class="wr-mapper-mid fc aic jcsb pd__20 bggr">
				<div class="title">
					<input type="text" name="post_title" class="input-text" placeholder="<?php
						_e( 'Enter Title Here', 'wr-mapper' );
					?>" value="<?php
						esc_attr_e( $post->post_title );
					?>">
				</div>

				<div class="global-setting fc aic">
					<div id="general-settings">
						<a href="javascript:void(0)" class="btn br__3 dib">
							<i class="wricon-cog mr__5"></i>
							<?php _e( 'General Settings', 'wr-mapper' ); ?>
						</a>

						<div class="setting-box general-setting br__3 bgw bdgr">
							<h4 class="mg__0 pr">
								<?php _e( 'General Settings', 'wr-mapper' ); ?>
								<i class="close-box pa wricon-cancel"></i>
							</h4>

							<ul class="nav mg__0 fc">
								<li data-nav="style" class="mg__0 active"><?php _e( 'Style Settings', 'wr-mapper' ); ?></li>
								<!-- <li data-nav="image-effect" class="mg__0"><?php _e( 'Image Effect', 'wr-mapper' ); ?></li> -->
							</ul>

							<div class="tab-content">
								<div data-tab="style" class="tab-item">
									<label class="db mb__10"><?php _e( 'Popup size', 'wr-mapper' ); ?></label>
									<div class="row mb__25">
										<div class="cm-4">
											<label class="db mb__10"><?php _e( 'Width', 'wr-mapper' ); ?></label>
											<div class="input-unit pr">
												<input type="number" name="popup-width" class="input-text input-large" value="305">
												<span class="pa tc">px</span>
											</div>
										</div>
										<div class="cm-4">
											<label class="db mb__10"><?php _e( 'Height', 'wr-mapper' ); ?></label>
											<div class="input-unit pr">
												<input type="number" name="popup-height" min="50" class="input-text input-large" value="314">
												<span class="pa tc">px</span>
											</div>
										</div>
										<!--
										<div class="cm-4">
											<div class="item-styled no-label">
												<label class="pr">
													<input type="hidden" name="popup-full-width" value="">
													<input type="checkbox" onchange="jQuery(this).prev().val(this.checked ? 1 : 0);">
													<span></span>
													<?php _e( 'Full width image', 'wr-mapper' ); ?>
												</label>
											</div>
										</div>
										-->
									</div>

									<div class="row">
										<div class="cm-4">
											<label class="db mb__10"><?php _e( 'Tooltip style', 'wr-mapper' ); ?></label>
											<div class="select-styled pr">
												<select name="tooltip-style" class="slt select-large">
													<option value="light"><?php _e( 'Light', 'wr-mapper' ); ?></option>
													<option value="dark"><?php _e( 'Dark', 'wr-mapper' ); ?></option>
												</select>
											</div>
										</div>
										<div class="cm-4">
											<label class="db mb__10"><?php _e( 'Popup box shadow', 'wr-mapper' ); ?></label>
											<div class="picker-styled pr">
												<input type="text" name="popup-box-shadow" class="color-picker" data-default-color="#f0f0f0" value="#f0f0f0">
											</div>
										</div>
										<div class="cm-4">
											<label class="db mb__10"><?php _e( 'Popup show fffect', 'wr-mapper' ); ?></label>
											<div class="select-styled pr">
												<select name="popup-show-effect" class="slt select-large">
													<option value="fade"><?php _e( 'Fade In', 'wr-mapper' ); ?></option>
													<option value="slide-left"><?php _e( 'Slide From Left', 'wr-mapper' ); ?></option>
													<option value="slide-right"><?php _e( 'Slide From Right', 'wr-mapper' ); ?></option>
													<option value="slide-top"><?php _e( 'Slide From Top', 'wr-mapper' ); ?></option>
													<option value="slide-bottom"><?php _e( 'Slide From Bottom', 'wr-mapper' ); ?></option>
												</select>
											</div>
										</div>
									</div>

									<hr>

									<div class="row">
										<div class="cm-4">
											<label class="db mb__10"><?php _e( 'Popup border radius', 'wr-mapper' ); ?></label>
											<div class="input-unit pr">
												<input type="number" name="popup-border-radius" class="input-text input-large" value="3">
												<span class="pa tc">px</span>
											</div>
										</div>
										<div class="cm-4">
											<label class="db mb__10"><?php _e( 'Popup border width', 'wr-mapper' ); ?></label>
											<div class="input-unit pr">
												<input type="number" name="popup-border-width" class="input-text input-large" value="0">
												<span class="pa tc">px</span>
											</div>
										</div>
										<div class="cm-4">
											<label class="db mb__10"><?php _e( 'Popup border color', 'wr-mapper' ); ?></label>
											<div class="picker-styled pr setting-border-color-picker">
												<input type="text" name="popup-border-color" class="color-picker" data-default-color="#dfdfdf" value="#dfdfdf">
											</div>
										</div>
									</div>

									<hr>

									<div class="row">
										<div class="cm-4">
											<label class="db mb__10"><?php _e( 'Image effect', 'wr-mapper' ); ?></label>
											<div class="select-styled pr">
												<select name="image-effect" class="slt select-large">
													<option value="none"><?php _e( 'None', 'wr-mapper' ); ?></option>
													<option value="blur"><?php _e( 'Blur', 'wr-mapper' ); ?></option>
													<option value="gray"><?php _e( 'Gray', 'wr-mapper' ); ?></option>
													<option value="mask"><?php _e( 'Mask Overlay', 'wr-mapper' ); ?></option>
												</select>
											</div>
										</div>
										<div class="cm-4" data-image-effect="mask">
											<label class="db mb__10"><?php _e( 'Mask color', 'wr-mapper' ); ?></label>
											<div class="picker-styled pr">
												<input type="text" name="mask-color" class="color-picker" data-default-color="rgba(0, 0, 0, 0.5)" value="rgba(0, 0, 0, 0.5)">
											</div>
										</div>
									</div>
								</div>

								<div data-tab="image-effect" class="tab-item hidden"></div>
							</div>
						</div>
					</div>
					<a id="copy-shortcode-syntax" href="javascript:void(0)" class="btn br__3 dib" data-clipboard-target="#shortcode-syntax">
						<i class="wricon-code mr__5"></i>
						<span class="message" data-success-text="<?php
							_e( 'Copied to clipboard', 'wr-mapper' );
						?>" data-error-text="<?php
							_e( 'Press Ctrl+C to copy', 'wr-mapper' );
						?>">
							<?php _e( 'Copy Shortcode', 'wr-mapper' ); ?>
						</span>
						<span class="copy-shortcode">
							<input id="shortcode-syntax" value='[wr_mapper id="<?php echo absint( $post->ID ); ?>"]'>
						</span>
					</a>
				</div>
			</div><!-- .wr-mapper-mid -->

			<div class="wr-mapper-bot pr aic fc jcc <?php if ( $attachment_id ) echo 'pr'; ?>">
				<input type="hidden" id="wr_mapper_image" name="wr_mapper_image" value="<?php echo absint( $attachment_id ); ?>">

				<?php if ( $attachment_id ) : ?>
				<div class="edit-image pr">
					<a id="change-image" href="#" class="btn-change-image pa db br__3">
						<i class="wricon-camera mr__5"></i><?php _e( 'Change Image', 'wr-mapper' ); ?>
					</a>

					<div class="image-wrap">
						<img src="<?php echo esc_url( $image_src ); ?>">
					</div>
				</div>
				<?php else : ?>
				<div class="add-image">
					<a href="#" class="btn-add-image db tc"><i class="wricon-plus"></i></a>
					<span class="empty-mapper"><?php _e( 'Add your image mapping', 'wr-mapper' ); ?></span>
				</div>
				<?php endif; ?>
			</div><!-- .wr-mapper-bot -->
		</div><!-- .wr-mapper -->

	</form>
</script>

<script type="text/html" id="wr_mapper_image_tmpl">
	<div class="edit-image pr">
		<a id="change-image" href="#" class="btn-change-image pa db br__3">
			<i class="wricon-camera mr__5"></i><?php _e( 'Change Image', 'wr-mapper' ); ?>
		</a>

		<div class="image-wrap">
			<img src="%URL%">
		</div>
	</div>
</script>

<script type="text/html" id="wr_mapper_pin_tmpl">
	<i class="icon-pin wricon-plus"></i>
	<a class="pin-action delete-pin" href="#"><i class="wricon-trash"></i></a>
	<a class="pin-action duplicate-pin" href="#"><i class="wricon-docs"></i></a>
	<span class="tooltip bgw br__3 pa <% if (settings['pin-type'] && settings['pin-type'] == 'woocommerce') { %>hidden<% } %>">
		<% if (settings['popup-title'] && settings['popup-title'] != '') { %>
		<%= settings['popup-title'] %>
		<% } else { %>
		<%= wr_mapper.text.please_input_a_title %>
		<% } %>
	</span>

	<div class="setting-box pin-setting br__3 bgw bdgr">
		<h4 class="mg__0 pr">
			<?php _e( 'Pin Settings', 'wr-mapper' ); ?>
			<i class="close-box pa wricon-cancel"></i>
		</h4>

		<input type="hidden" data-option="top" value="<%= top %>">
		<input type="hidden" data-option="left" value="<%= left %>">
		<input type="hidden" data-option="settings[id]" value="">

		<ul class="nav mg__0 fc">
			<li data-nav="general" class="mg__0 active"><?php _e( 'General', 'wr-mapper' ); ?></li>
			<li data-nav="icon-settings" class="mg__0"><?php _e( 'Icon Settings', 'wr-mapper' ); ?></li>
			<li data-nav="popup-settings" class="mg__0"><?php _e( 'Popup Settings', 'wr-mapper' ); ?></li>
		</ul>

		<div class="tab-content">
			<div data-tab="general" class="tab-item">
				<div class="radio-group fc mb__25">
					<div class="item-styled">
						<label class="pr">
							<input type="radio" data-option="settings[pin-type]" value="woocommerce" checked="checked">
							<span></span>
							<?php _e( 'WooCommerce', 'wr-mapper' ); ?>
						</label>
					</div>
					<div class="item-styled">
						<label class="pr">
							<input type="radio" data-option="settings[pin-type]" value="image">
							<span></span>
							<?php _e( 'Image', 'wr-mapper' ); ?>
						</label>
					</div>
					<div class="item-styled">
						<label class="pr">
							<input type="radio" data-option="settings[pin-type]" value="text">
							<span></span>
							<?php _e( 'Text', 'wr-mapper' ); ?>
						</label>
					</div>
					<div class="item-styled">
						<label class="pr">
							<input type="radio" data-option="settings[pin-type]" value="link">
							<span></span>
							<?php _e( 'Link', 'wr-mapper' ); ?>
						</label>
					</div>
				</div>

				<!-- WooCommerce Settings -->
				<div class="form-input mb__25" data-pin-type="woocommerce">
					<label class="db mb__10"><?php _e( 'Select product', 'wr-mapper' ); ?></label>
					<input type="text" data-option="settings[product]" class="input-text input-large product-selector" value="">
				</div>
				<div class="checkbox-group fc mb__25" data-pin-type="woocommerce">
					<div class="item-styled">
						<label class="pr">
							<input type="hidden" data-option="settings[product-thumbnail]" value="1">
							<input type="checkbox" onchange="jQuery(this).prev().val(this.checked ? 1 : 0);" checked="checked">
							<span></span>
							<?php _e( 'Show thumbnail', 'wr-mapper' ); ?>
						</label>
					</div>
					<div class="item-styled">
						<label class="pr">
							<input type="hidden" data-option="settings[product-description]" value="1">
							<input type="checkbox" onchange="jQuery(this).prev().val(this.checked ? 1 : 0);" checked="checked">
							<span></span>
							<?php _e( 'Show description', 'wr-mapper' ); ?>
						</label>
					</div>
					<div class="item-styled">
						<label class="pr">
							<input type="hidden" data-option="settings[product-rate]" value="1">
							<input type="checkbox" onchange="jQuery(this).prev().val(this.checked ? 1 : 0);" checked="checked">
							<span></span>
							<?php _e( 'Show rate', 'wr-mapper' ); ?>
						</label>
					</div>
				</div>
				<!-- End WooCommerce Settings -->

				<!-- Image / Text / Link Settings -->
				<div class="form-input mb__25" data-pin-type="image|text|link">
					<label class="db mb__10"><?php _e( 'Popup title', 'wr-mapper' ); ?></label>
					<input type="text" data-option="settings[popup-title]" class="input-text input-large" value="" placeholder="<?php
						_e( 'Input a title for the popup here...', 'wr-mapper' );
					?>">
				</div>

				<!-- Image Settings -->
				<div class="input-group mb__25" data-pin-type="image">
					<label class="db mb__10"><?php _e( 'Select image', 'wr-mapper' ); ?></label>
					<div class="pr">
						<input type="text" class="input-image input-large" data-option="settings[image]" value="">
						<a href="#" class="pa image-selector"><i class="wricon-upload"></i></a>
					</div>
				</div>
				<!-- <div class="item-styled mb__25" data-pin-type="image">
					<label class="pr">
						<input type="hidden" data-option="settings[image-full-width]" value="">
						<input type="checkbox" onchange="jQuery(this).prev().val(this.checked ? 1 : 0);">
						<span></span>
						<?php _e( 'Full width image', 'wr-mapper' ); ?>
					</label>
				</div> -->
				<div class="row mb__25" data-pin-type="image|link">
					<div class="cm-7">
						<div class="form-input">
							<label class="db mb__10"><?php _e( 'Link To', 'wr-mapper' ); ?></label>
							<input type="text" data-option="settings[image-link-to]" class="input-text input-large" value="">
						</div>
					</div>
					<div class="cm-5">
						<label class="db mb__10"><?php _e( 'Target', 'wr-mapper' ); ?></label>
						<div class="select-styled pr">
							<select data-option="settings[image-link-target]" class="slt select-large">
								<option value="_self"><?php _e( 'Default', 'wr-mapper' ); ?></option>
								<option value="_blank"><?php _e( 'New Tab', 'wr-mapper' ); ?></option>
							</select>
						</div>
					</div>
				</div>
				<!-- End Image Settings -->

				<!-- Text Settings -->
				<div class="form-input" data-pin-type="text">
					<label class="db mb__10"><?php _e( 'Text Content', 'wr-mapper' ); ?></label>
					<textarea data-option="settings[text]" rows="6" placeholder="<?php
						_e( 'Input some content for the popup here...', 'wr-mapper' );
					?>"></textarea>
				</div>
				<!-- End Text Settings -->
			</div>

			<div data-tab="icon-settings" class="tab-item hidden">
				<div class="radio-group fc mb__25">
					<div class="item-styled">
						<label class="pr">
							<input type="radio" data-option="settings[icon-type]" value="icon-font" checked="checked">
							<span></span>
							<?php _e( 'Icon', 'wr-mapper' ); ?>
						</label>
					</div>
					<div class="item-styled">
						<label class="pr">
							<input type="radio" data-option="settings[icon-type]" value="icon-image">
							<span></span>
							<?php _e( 'Image', 'wr-mapper' ); ?>
						</label>
					</div>
				</div>

				<hr>

				<div class="row mb__25" data-icon-type="icon-font">
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Background color', 'wr-mapper' ); ?></label>
						<div class="picker-styled pr">
							<input type="text" data-option="settings[bg-color]" class="color-picker" data-default-color="#ff3535" value="#ff3535">
						</div>
					</div>
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Select icon', 'wr-mapper' ); ?></label>
						<input type="text" data-option="settings[icon]" class="input-text input-large icon-selector" value="">
					</div>
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Icon color', 'wr-mapper' ); ?></label>
						<div class="picker-styled pr">
							<input type="text" data-option="settings[icon-color]" class="color-picker" data-default-color="#fff" value="#fff">
						</div>
					</div>
				</div>

				<div class="row" data-icon-type="icon-font">
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Icon size', 'wr-mapper' ); ?></label>
						<div class="input-unit pr">
							<input type="number" data-option="settings[icon-size]" class="input-text input-large" value="20">
							<span class="pa tc">px</span>
						</div>
					</div>
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Border width', 'wr-mapper' ); ?></label>
						<div class="input-unit pr">
							<input type="number" data-option="settings[border-width]" class="input-text input-large" value="0">
							<span class="pa tc">px</span>
						</div>
					</div>
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Border color', 'wr-mapper' ); ?></label>
						<div class="picker-styled pr">
							<input type="text" data-option="settings[border-color]" class="color-picker" data-default-color="#dfdfdf" value="#dfdfdf">
						</div>
					</div>
				</div>

				<hr data-icon-type="icon-font">

				<div class="row" data-icon-type="icon-font">
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Background hover', 'wr-mapper' ); ?></label>
						<div class="picker-styled pr">
							<input type="text" data-option="settings[bg-color-hover]" class="color-picker" data-default-color="#515151" value="#515151">
						</div>
					</div>
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Icon hover', 'wr-mapper' ); ?></label>
						<div class="picker-styled pr">
							<input type="text" data-option="settings[icon-color-hover]" class="color-picker" data-default-color="#eee" value="#eee">
						</div>
					</div>
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Icon effect', 'wr-mapper' ); ?></label>
						<div class="select-styled pr">
							<select data-option="settings[icon-effect]" class="slt select-large">
								<option value="none"><?php _e( 'None', 'wr-mapper' ); ?></option>
								<option value="rotate"><?php _e( 'Rotate', 'wr-mapper' ); ?></option>
								<option value="scale"><?php _e( 'Scale', 'wr-mapper' ); ?></option>
								<option value="fade"><?php _e( 'Fade', 'wr-mapper' ); ?></option>
							</select>
						</div>
					</div>
				</div>

				<div class="input-group mb__25" data-icon-type="icon-image">
					<label class="db mb__10"><?php _e( 'Select image', 'wr-mapper' ); ?></label>
					<div class="pr">
						<input type="text" class="input-image input-large" data-option="settings[image-template]" value="">
						<a href="#" class="pa image-selector"><i class="wricon-upload"></i></a>
					</div>
				</div>
			</div>

			<div data-tab="popup-settings" class="tab-item hidden">
				<label class="db mb__10"><?php _e( 'Custom popup size', 'wr-mapper' ); ?></label>
				<div class="row">
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Width', 'wr-mapper' ); ?></label>
						<div class="input-unit pr">
							<input type="number" data-option="settings[popup-width]" class="input-text input-large" value="">
							<span class="pa tc">px</span>
						</div>
					</div>
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Height', 'wr-mapper' ); ?></label>
						<div class="input-unit pr">
							<input type="number" data-option="settings[popup-height]" class="input-text input-large" value="">
							<span class="pa tc">px</span>
						</div>
					</div>
					<div class="cm-4">
						<label class="db mb__10"><?php _e( 'Position', 'wr-mapper' ); ?></label>
						<div class="select-styled pr">
							<select data-option="settings[popup-position]" class="slt select-large">
								<option value="right"><?php _e( 'Right', 'wr-mapper' ); ?></option>
								<option value="left"><?php _e( 'Left', 'wr-mapper' ); ?></option>
								<option value="top"><?php _e( 'Top', 'wr-mapper' ); ?></option>
								<option value="bottom"><?php _e( 'Bottom', 'wr-mapper' ); ?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/html" id="wr_mapper_icon_selector_tmpl">
	<div class="icon-selector select-styled pr bdgr br__3">
		<div class="icon-selected"><i class="wricon-%SELECTED%"></i></div>
		<div class="icon-wrap pa bdgr">
			<h5><?php _e( 'Select icon', 'wr-mapper' ); ?><i class="close wricon-cancel"></i></h5>
			<div class="icon-list bgw bdgr fc fcw">
				<a data-value="plus" href="#"><i class="wricon-plus"></i></a>
				<a data-value="lady" href="#"><i class="wricon-lady"></i></a>
				<a data-value="men" href="#"><i class="wricon-men"></i></a>
				<a data-value="shirts" href="#"><i class="wricon-shirts"></i></a>
				<a data-value="hand" href="#"><i class="wricon-hand"></i></a>
				<a data-value="shoes" href="#"><i class="wricon-shoes"></i></a>
				<a data-value="ring" href="#"><i class="wricon-ring"></i></a>
				<a data-value="underwear" href="#"><i class="wricon-underwear"></i></a>
				<a data-value="kitchen-utensils" href="#"><i class="wricon-kitchen-utensils"></i></a>
				<a data-value="love" href="#"><i class="wricon-love"></i></a>
				<a data-value="bikini" href="#"><i class="wricon-bikini"></i></a>
				<a data-value="short" href="#"><i class="wricon-short"></i></a>
				<a data-value="material" href="#"><i class="wricon-material"></i></a>
				<a data-value="people" href="#"><i class="wricon-people"></i></a>
				<a data-value="restaurant" href="#"><i class="wricon-restaurant"></i></a>
				<a data-value="sewing" href="#"><i class="wricon-sewing"></i></a>
				<a data-value="mobile-old" href="#"><i class="wricon-mobile-old"></i></a>
				<a data-value="mobile-new" href="#"><i class="wricon-mobile-new"></i></a>
			</div>
		</div>
	</div>
</script>

<script type="text/javascript">
	jQuery(function($) {
		$(window).load(function() {
			// Override default UI.
			var form = $($('#wr_mapper_tmpl').text()).prepend($('#post').children('input[type="hidden"]'));

			$('#screen-meta, #screen-meta-links').remove();

			$('#wpbody-content > .wrap').replaceWith(form);

			// Trigger event to initialize application.
			setTimeout( function() {
				$( document ).trigger( 'init_wr_mapper' );
			}, 500 );

			// Pass data to client-side.
			window.wr_mapper_settings = <?php echo json_encode( $settings ? $settings : new stdClass() ); ?>;
			window.wr_mapper_pins = <?php echo json_encode( $pins ? array_values( $pins ) : array() ); ?>;
		});
	});
</script>
