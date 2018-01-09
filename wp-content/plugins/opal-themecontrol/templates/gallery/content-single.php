<?php
$galleries = get_post_meta(get_the_ID(), 'gallery_file_advanced');
$fullwidth = opal_themecontrol_get_options('gallery_single_fullwidth',0);
$column = opal_themecontrol_get_options('gallery_single_columns', 4);
$space = opal_themecontrol_get_options('gallery_single_space', 0);
$col = floor(12/$column);
$smcol = ($col > 2)? 6: $col;
$class_column='col-lg-'.$col.' col-md-'.$col.' col-sm-'.$smcol;
?>
<div id="gallery-wrapper" class="clearfix">
    <article id="gallery-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if($fullwidth): ?>
        <div class="container">
	        <?php endif; ?>
            <div class="gallery-content">
                <div id="gallery_filter_wrapper" class="gallery cols-<?php echo esc_attr($column); ?> <?php if ($space) echo esc_attr('wide'); ?>" data-columns="<?php echo esc_attr($column); ?>">
		            <?php if (isset($galleries[0]) && !empty($galleries[0])) : ?>
			            <?php foreach ($galleries[0] as $src): ?>
                            <div class="element grid classic<?php echo esc_attr($column); ?>_cols <?php if ($space) echo esc_attr('wide'); ?>">
                                <a class="fancy-gallery"
                                   href="<?php echo esc_url($src); ?>">
                                    <img src="<?php echo esc_url($src); ?>" alt="<?php the_title();?>">
                                </a>
                            </div>
			            <?php endforeach; ?>
		            <?php endif; ?>

                </div>
            </div><!-- .gallery-content -->
            <?php if($fullwidth): ?>
        </div>  <!-- .container -->
        <?php endif; ?>
    </article><!-- #gallery-## -->
</div>

