<?php
$galleries = get_post_meta(get_the_ID(), 'gallery_file_advanced');
$show_info = opal_themecontrol_get_options('gallery_single_info');
$column = opal_themecontrol_get_options('gallery_single_columns',4);
$_id = rand();
?>
<div id="gallery-wrapper" class="gallery-thumb clearfix">
    <article id="gallery-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="gallery-content">
            <div id="carousel-<?php echo esc_attr($_id); ?>" class="widget-content text-center  owl-carousel-play" data-ride="owlcarousel">
                <div class="owl-carousel " data-slide="1" data-slider-id="1" data-dots="true"
                         data-nav="false" data-loop="true" data-autoplay="true" data-thumbs="true" data-thumbimage="true" data-thumprerendered="false">
				<?php if (isset($galleries[0]) && !empty($galleries[0])) : ?>
					<?php foreach ($galleries[0] as $src): ?>
                        <div class="gallery-item">
                            <a class="fancy-gallery"
                               href="<?php echo esc_url($src); ?>">
                                <img src="<?php echo esc_url($src); ?>" alt="<?php the_title();?>">
                            </a>
                        </div>
					<?php endforeach; ?>
				<?php endif; ?>
                </div>
            </div>
        </div><!-- .gallery-content -->
    </article><!-- #gallery-## -->
</div>

