<?php
$galleries = get_post_meta(get_the_ID(), 'gallery_file_advanced');
$show_info = opal_themecontrol_get_options('gallery_single_info');
$column = opal_themecontrol_get_options('gallery_single_columns',4);

?>
<div id="gallery-wrapper" class="clearfix">
    <article id="gallery-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="gallery-content">
            <div id="" class="gallery cols-<?php echo esc_attr($column); ?> isotope-masonry" data-columns="<?php echo esc_attr($column); ?>">
                
				<?php if (isset($galleries[0]) && !empty($galleries[0])) : ?>
					<?php foreach ($galleries[0] as $key => $src):
						$image = wp_get_attachment_image( $key, 'thumbnail' , "", array( "class" => "img-responsive" ))
                        ?>
                        <div class="element grid classic<?php echo esc_attr($column); ?>_cols isotope-item">
                            <a class="fancy-gallery" href="<?php echo esc_url($src); ?>">
                                <?php echo trim($image); ?>
                            </a>
                        </div>
					<?php endforeach; ?>
				<?php endif; ?>

            </div>
        </div><!-- .gallery-content -->
    </article><!-- #gallery-## -->
</div>

