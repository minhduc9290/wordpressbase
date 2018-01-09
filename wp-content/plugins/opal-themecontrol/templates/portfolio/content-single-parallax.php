<?php
$check = get_post_meta(get_the_ID(), 'portfolio_check', true);
$parallax_image = get_post_meta(get_the_ID(), 'portfolio_image', true);
$parallax_image_height = get_post_meta(get_the_ID(), 'portfolio_image_height', true);
$parallax_image_height = $parallax_image_height ? $parallax_image_height : '400';
$item_cats = get_the_terms(get_the_ID(), 'category_portfolio');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ($check){ ?>
    <div class="fullwidth"><?php } ?>

		<?php if (has_post_thumbnail()) { ?>
            <div class="entry-thumb">
				<?php the_post_thumbnail('full'); ?>
            </div>
		<?php } ?>

        <div class="single-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
					<?php $cats_name = '';
					foreach ((array)$item_cats as $item_cat) {
						if (!empty($item_cats) && !is_wp_error($item_cats)) {
							$cats_name .= $item_cat->name . '/ ';
						}
					}
					if ($cats_name) $cats_name = trim($cats_name, '/ ');
					?>
                    <div class="category-portfolio"><?php echo esc_html($cats_name); ?></div>
                    <div class="entry-title"><h3 class="title-post fweight-800 text-big-1"><?php the_title(); ?></h3>
                    </div>
                    <div class="description"><?php the_excerpt(); ?></div>
                </div>
                <div class="col-md-6 col-sm-12">
	                <?php opal_controlpanel_portfolio_information(); ?>
                </div>
            </div>

            <div class="post-area single-portfolio">
                <div class="post-container">
                    <div class="parallax" data-z-index="10" data-parallax="scroll"
                         data-image-src="<?php echo esc_url($parallax_image); ?>" data-naturalWidth="1440"
                         data-naturalHeight="933" style="height:<?php esc_attr_e($parallax_image_height); ?>px; "></div>
                    <div class="entry-content no-border">
						<?php the_content(); ?>
						<?php get_template_part('page-templates/parts/sharebox'); ?>
						<?php wp_link_pages(); ?>
                    </div>
                </div>
            </div>
        </div>

		<?php if ($check){ ?></div><?php } ?>
</article> 

