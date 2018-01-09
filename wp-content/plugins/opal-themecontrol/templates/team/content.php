<?php
$social_share = opal_themecontrol_get_options('team_single_social_share');
$show_info = opal_themecontrol_get_options('team_single_info');
?><div class="team-wrapper clearfix">
	<article id="team-<?php the_ID(); ?>" <?php post_class(); ?>>		
		<div class="team-single ">
			<div class="team-content">
				<div class="row">
					<div class="col-md-4">
						<div class="team-info">
						 	<div class="team-preview">
								<?php if ( has_post_thumbnail() ) : ?>
								<div class="post-thumbnail">
							        <a href="<?php the_permalink(); ?>" class="teacher-box-image-inner ">	
							         	<?php the_post_thumbnail('full'); ?>
							        </a>
								</div>
							<?php endif; ?>
							</div><!-- .image-thumbnail -->

							<div class="text-center">
								<div class="team-job">
									<?php echo opalthemer_getMetaboxValue( get_the_ID(), 'team_job'); ?>
								</div>
                                <?php if ($social_share): ?>
                                    <div class="social">
                                        <a href="<?php echo esc_url( opalthemer_getMetaboxValue( get_the_ID(), 'team_facebook') ); ?>"><i class="fa fa-facebook"></i> </a>
                                        <a href="<?php echo esc_url( opalthemer_getMetaboxValue( get_the_ID(), 'team_google') ); ?>"><i class="fa fa-google"></i></a>
                                        <a href="<?php echo esc_url( opalthemer_getMetaboxValue( get_the_ID(), 'team_twitter') ); ?>"><i class="fa fa-twitter"></i></a>
                                        <a href="<?php echo esc_url( opalthemer_getMetaboxValue( get_the_ID(), 'team_pinterest') ); ?>"><i class="fa fa-pinterest"></i></a>
                                    </div>
                                <?php endif; ?>
							</div>
							<?php if ($show_info): ?>
                                <ul class="metabox">
                                    <li class="address">
                                        <span><?php esc_html_e( 'Address : ', 'opal-themecontrol' ); ?></span>
                                        <?php echo esc_html( opalthemer_getMetaboxValue( get_the_ID(), 'team_address') ); ?></li>
                                    <li class="phone">
                                        <span><?php esc_html_e( 'Phone : ', 'opal-themecontrol' ); ?></span>
                                        <?php echo esc_html( opalthemer_getMetaboxValue( get_the_ID(), 'team_phone_number') ); ?></li>
                                    <li class="mobile">
                                        <span><?php esc_html_e( 'Mobile : ', 'opal-themecontrol' ); ?></span>
                                        <?php echo esc_html( opalthemer_getMetaboxValue( get_the_ID(), 'team_mobile') ); ?></li>
                                    <li class="fax">
                                        <span><?php esc_html_e( 'Fax : ', 'opal-themecontrol' ); ?></span>
                                        <?php echo esc_html( opalthemer_getMetaboxValue( get_the_ID(), 'team_fax') ); ?></li>
                                    <li class="web">
                                        <span><?php esc_html_e( 'Web : ', 'opal-themecontrol' ); ?></span>
                                        <?php echo esc_html( opalthemer_getMetaboxValue( get_the_ID(), 'team_web') ); ?></li>
                                    <li class="email">
                                        <span><?php esc_html_e( 'Email : ', 'opal-themecontrol' ); ?></span>
                                        <?php echo esc_html( opalthemer_getMetaboxValue( get_the_ID(), 'team_email') ); ?></li>
                                </ul>
							<?php endif; ?>
						</div>
					</div> <!-- /.col -->
					<div class="col-md-4">
						<div class="team-body">
							
							<?php the_title( '<h1 class="team-title">', '</h1>' ); ?>
							<?php
								the_content( sprintf(
									esc_html__( 'Continue reading %s', 'opal-themecontrol').'<span class="meta-nav">&rarr;</span>',
									the_title( '<span class="screen-reader-text">', '</span>', false )
								) ); 
							?> <!-- .the-content -->

						</div><!-- .team-header -->
					</div><!-- /.col 4-->
				</div> <!-- /.row -->
			</div><!-- .team-content -->

		</div>
	</article><!-- #team-## -->

</div>

