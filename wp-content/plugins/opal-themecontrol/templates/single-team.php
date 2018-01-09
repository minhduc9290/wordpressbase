<?php
/**
* The template for displaying single
* @version    $Id$
* @package    wpbase
* @author     WPOPAL <opalwordpress@gmail.com >
* @copyright  Copyright (C) 2015 prestabrain.com. All Rights Reserved.
* @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*
* @website  http://www.opalthemer.com
* @support  http://www.opalthemer.com/questions/
*/

// Single Team Layout
$opalthemer_page_layouts = apply_filters( 'opalthemer_fnc_get_single_sidebar_configs', null );

get_header( apply_filters( 'opalthemer_fnc_get_header_layout', null ) );

do_action( 'opalthemer_template_main_before' ); ?>

<section id="main-container" class="<?php echo apply_filters( 'opalthemer_template_main_content_class',  'container' ); ?>">
	<div class="row">
		<?php if(!empty($opalthemer_page_layouts['sidebars']) && isset($opalthemer_page_layouts['sidebars'])) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<div id="main-content" class="main-content col-sm-12 <?php echo esc_attr($opalthemer_page_layouts['main']['class']); ?>">

			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					<?php if ( have_posts() ) : ?>
						<div class="single-team-container">
							<?php while ( have_posts() ) : the_post(); ?>
			                    <?php echo Opal_Themecontrol_Template_Loader::get_template_part( 'team/content' ); ?>
							<?php endwhile; ?>
						</div>
						<?php
							/**
							 * opal_themecontrol_after_single_team_summary hook
							 * 
							 */
							do_action( 'opal_themecontrol_after_single_team_summary' );
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
												
						?>
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
					<?php wp_reset_query(); ?>
				</div><!-- #content -->
			</div><!-- #primary -->
		</div>	<!-- #main-content -->


	</div>	<!-- /.row -->
</section> <!-- #main-container -->
<?php get_footer(); ?>
