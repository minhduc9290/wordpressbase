<?php
$column = opal_themecontrol_get_options('portfolio_single_related_column', 4);
$col = floor(12 / $column);
$smcol = ($col > 4) ? 6 : $col;
$class_column = 'col-lg-' . $col . ' col-md-' . $col . ' col-sm-' . $smcol;
$_id = rand();
// arguments
$args = array(
	'post_type' => 'portfolio',
	'post_status' => 'publish',
	'posts_per_page' => opal_themecontrol_get_options('portfolio_single_related_limit', 20), // you may edit this number
	'post__not_in' => array(get_the_ID()),
);
$relates = Opalthemecontrol_Query::getQuery($args);

?>
<?php if ($relates->have_posts()): ?>
    <div class="widget widget-style clearfix">
        <h3 class="widget-title">
            <span><?php esc_html_e('Related Portfolio ', 'opal-themecontrol'); ?></span>
        </h3>
    </div>
    <div class="related-posts-content space-30">
        <div id="carousel-<?php echo esc_attr($_id); ?>" class="widget-content text-center  owl-carousel-play"
             data-ride="owlcarousel">
            <div class="owl-carousel " data-slide="<?php echo esc_attr($column); ?>" data-dots="true"
                 data-nav="true" data-loop="true">
				<?php while ($relates->have_posts()) : $relates->the_post(); ?>
                    <div class="portfolio-item">
                        <div class="wpo-portfolio-content text-center">
                            <div class="ih-item square colored effect16">
                                <div class="img">
									<?php if (has_post_thumbnail()) {
										the_post_thumbnail('post-thumbnail');
									} ?>
                                </div>
                                <div class="info">
                                    <div class="info-inner">
                                        <h3><a class="text-success"
                                               href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <div class="categories">
											<?php
											$item_cats = get_the_terms($relates->post->ID, 'category_portfolio');
											$cats_name = '';
											foreach ((array)$item_cats as $item_cat) {
												if (!empty($item_cats) && !is_wp_error($item_cats)) {
													$cats_name .= $item_cat->name . '/ ';
												}
											} ?>
                                            <a href="#" class="category"><?php esc_html($cats_name); ?> </a>
                                        </div>
                                        <div class="description hidden"><?php the_excerpt(20, '...'); ?></div>
                                        <div class="created hidden"><?php echo get_the_date(); ?></div>
                                        <a class="hidden zoom"
                                           href="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()))); ?>"
                                           data-rel="prettyPhoto[pp_gal]"> <i
                                                    class="fa fa-search radius-x space-padding-10 btn-primary"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php
				endwhile; ?>
				<?php wp_reset_postdata(); ?>

            </div>
        </div>
    </div>
	<?php
endif;