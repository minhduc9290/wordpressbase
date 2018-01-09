<?php
$meta = OpalThemecontrol_PostType_Portfolio::opal_themecontrol_func_metaboxes_portfolio_fields();
?>
<div class="portfolio-meta-info">
	<h4><?php _e('Information', 'opal-themecontrol'); ?></h4>
	<ul>
		<?php foreach ($meta as $key => $item) {
			if ($item['id'] == "portfolio_video_link" || $item['id'] == "portfolio_file_advanced" || $item['id'] == 'portfolio_layout' || $item['id'] == 'portfolio_image' || $item['id'] == 'portfolio_check') {
				continue;
			} ?>

			<li class="<?php echo $item['id']; ?>"><span
					class="meta-label"><?php echo trim($item['name']); ?></span>
				:<?php echo get_post_meta(get_the_ID(), $item['id'], true); ?></li>
		<?php } ?>
	</ul>
</div>