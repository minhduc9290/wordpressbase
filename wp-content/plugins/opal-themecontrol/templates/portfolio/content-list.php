<?php 
$max_char = opal_themecontrol_get_options('portfolio_max_char',50);
$enable_job = opal_themecontrol_get_options('portfolio_enable_job',1);
$enable_social = opal_themecontrol_get_options('portfolio_enable_social',1);
$enable_readmore = opal_themecontrol_get_options('portfolio_enable_readmore',1);
$enable_description = opal_themecontrol_get_options('portfolio_enable_description',1);
$job =  get_post_meta( get_the_ID(), 'portfolio_job', true );
?>
<!-- start items -->
<div class="item">
	<div class="portfolio-list row">
		<div class="col-sm-12 col-md-6">
			<?php if( has_post_thumbnail() ): ?>
				<div class="portfolio-header">
					<a href="<?php echo esc_url( get_permalink() );?>"><?php the_post_thumbnail('full', '', 'class="radius-x"');?> </a>
				</div>	 
			<?php endif;  ?>
		</div><!-- /.col-md-6 -->
		<div class="col-sm-12 col-md-6">
			<div class="portfolio-body">
				<div class="portfolio-body-content">
					<h3 class="portfolio-name"><a href="<?php echo esc_url( get_permalink() );?>"><?php the_title(); ?></a></h3>
					<?php if(!empty($job) && $enable_job): ?>
						<p><?php echo esc_html( $job ); ?></p>
					<?php endif; ?>
				</div>
				<?php if($enable_description): ?>	
				<div class="portfolio-info">
					<?php echo opal_themecontrol_fnc_excerpt($max_char,'...'); ?>
				</div>
				<?php endif; ?>
				<?php if($enable_readmore): ?>
				<div class="readmore">
		        	<a class="read-link" href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Read More', 'opal-themecontrol' ); ?>"><?php esc_html_e( 'Read More', 'opal-themecontrol' ); ?><i class="fa fa-angle-double-right"></i></a>
			    </div>
			    <?php endif; ?>
			</div>  
		</div><!-- /.col-md-6 -->
	</div>
</div>
<!-- end items -->