<?php
/**
* The template for displaying archive
*
* @version    $Id$
* @package    wpbase
* @author     WPOPAL <opalwordpress@gmail.com >
* @copyright  Copyright (C) 2015 prestabrain.com. All Rights Reserved.
* @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*
* @website  http://www.opalthemer.com
* @support  http://www.opalthemer.com/questions/
*/
$opalthemer_page_layouts = apply_filters( 'opalthemer_fnc_get_archive_sidebar_configs', null );
$column = opal_themecontrol_get_options('portfolio_column') ? opal_themecontrol_get_options('portfolio_column') : 4;
$colclass = floor(12/$column); 
$layous = opal_themecontrol_get_options('portfolio_layout','grid');; 
get_header( apply_filters( 'opalthemer_fnc_get_header_layout', null ) ); ?>
<?php do_action( 'opalthemer_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('opalthemer_template_main_container_class','container');?> inner <?php echo opal_themecontrol_get_options('blog-archive-layout') ; ?>">
	<div class="row">
		<?php if( isset($opalthemer_page_layouts['sidebars']) && !empty($opalthemer_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		
		<div id="main-content" class="main-content  col-sm-12 <?php echo esc_attr($opalthemer_page_layouts['main']['class']); ?>">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">
					<?php if ( have_posts() ) : ?>

						<div class="portfolio-archive">
							<div class="row">
								<?php $cnt=0; while ( have_posts() ) : the_post();
								$cls = '';

								if( $cnt++%$column==0 ){
									$cls .= ' first-child';
								}
								if ($layous == "grid") : ?>
								<div class="col-lg-<?php echo esc_attr($colclass); ?> col-md-<?php echo esc_attr($colclass); ?> col-sm-<?php echo esc_attr($colclass); ?> <?php echo esc_attr($cls); ?>">
									<?php echo Opal_Themecontrol_Template_Loader::get_template_part( 'portfolio/content-grid' ); ?>
								</div>
							<?php else: ?>
								<div class="col-md-12">
									<?php echo Opal_Themecontrol_Template_Loader::get_template_part( 'portfolio/content-list' ); ?>
								</div>
							<?php endif; ?>
						<?php endwhile; ?>
					</div>
				</div>
				<?php  opal_themecontrol_fnc_paging_nav(); ?>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

</div><!-- #main-content -->
</div>	
</section>
<?php
get_footer();


