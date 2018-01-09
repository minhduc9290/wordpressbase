<?php
$galleries = get_post_meta(get_the_ID(), 'portfolio_file_advanced');
if ($galleries):
	if (count($galleries) > 1) {
		$class_col_1 = 'col-lg-8 col-md-8 col-sm-8 col-xs-12';
		$class_col_2 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
	} else {
		$class_col_1 = '';
		$class_col_2 = '';
	}
endif;

$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnails-medium');
$check = get_post_meta(get_the_ID(), 'portfolio_check', true);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ($check){ ?>
    <div class="fullwidth"><?php } ?>
            <div class="row">
                <div class="portfolio-gallery <?php echo esc_attr($class_col_1); ?>">
					<?php if (has_post_thumbnail()): ?>
                        <div class="entry-thumb">
                            <a href="<?php echo esc_url($image_url[0]); ?>" data-rel="prettyPhoto[pp_gal]">
								<?php the_post_thumbnail('full'); ?>
                            </a>
                        </div>
					<?php endif; ?>
                </div>
                <div class="<?php echo esc_attr($class_col_2); ?> gallery-thumb">
                    <div class="row">
						<?php if (isset($galleries[0]) && !empty($galleries[0])) : ?>
							<?php foreach ($galleries[0] as $src): ?>
                                <div class="col-md-6">
                                    <a href="<?php echo esc_url( $src); ?>" data-rel="prettyPhoto[pp_gal]">
                                        <img src="<?php echo esc_url_raw($src); ?>" alt="gallery">
                                    </a>
                                </div>
							<?php endforeach; ?>
						<?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="single-body">
                <div class="entry-title"><h1 class="title-post fweight-800 text-big-1"><?php the_title(); ?></h1></div>
                <div class="post-area single-portfolio">

                    <div class="post-container">

                        <div class="entry-content no-border">

							<?php the_content(); ?>

							<?php opal_controlpanel_portfolio_information(); ?>

							<?php get_template_part('page-templates/parts/sharebox'); ?>

							<?php wp_link_pages(); ?>

                        </div>

                    </div>

                </div>
            </div>

		<?php if ($check){ ?></div><?php } ?>
</article>