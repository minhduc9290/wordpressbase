<?php 
$max_char = opal_themecontrol_get_options('team_max_char',50);
$enable_job = opal_themecontrol_get_options('team_enable_job',1);
$enable_social = opal_themecontrol_get_options('team_enable_social',1);
$enable_readmore = opal_themecontrol_get_options('team_enable_readmore',1);
$enable_description = opal_themecontrol_get_options('team_enable_description',1);
?>
<div class="item">  

	<!-- start items -->
	<?php 
	$data = array( 'google', 'job', 'phone_number', 'facebook', 'twitter', 'pinterest' );
	foreach( $data as $item ){
		$$item =  get_post_meta( get_the_ID(), 'team_'.$item, true ); 
	} 
	?>
	<div class="team-list row">
		<div class="col-sm-12 col-md-6">
			<?php if( has_post_thumbnail() ): ?>
				<div class="team-header">
					<a href="<?php echo esc_url( get_permalink() );?>"><?php the_post_thumbnail('full', '', 'class="radius-x"');?> </a>
				</div>	 
			<?php endif;  ?>
		</div><!-- /.col-md-6 -->
		<div class="col-sm-12 col-md-6">
			<div class="team-body">
				<div class="team-body-content">
					<h3 class="team-name"><a href="<?php echo esc_url( get_permalink() );?>"><?php the_title(); ?></a></h3>
					<?php if(!empty($job) && $enable_job): ?>
						<p><?php echo esc_html( $job ); ?></p>
					<?php endif; ?>
				</div>
				<?php if($enable_social): ?>	  
				<div class="bo-social-icons">
					<?php if( $facebook ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $facebook ); ?>"> <i  class="fa fa-facebook"></i> </a>
					<?php } ?>
					<?php if( $twitter ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $twitter ); ?>"><i  class="fa fa-twitter"></i> </a>
					<?php } ?>
					<?php if( $pinterest ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $pinterest ); ?>"><i  class="fa fa-pinterest"></i> </a>
					<?php } ?>
					<?php if( $google ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $google ); ?>"> <i  class="fa fa-google"></i></a>
					<?php } ?>  
				</div>
				<?php endif; ?>
				<?php if($enable_description): ?>	
				<div class="team-info">
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