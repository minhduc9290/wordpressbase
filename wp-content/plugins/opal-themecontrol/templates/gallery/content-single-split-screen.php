<?php
$galleries = get_post_meta(get_the_ID(), 'gallery_file_advanced');
$space = isset($_GET['space']) ? $_GET['space'] : opal_themecontrol_get_options('gallery_single_space', 0);
?>
<div id="gallery-wrapper" class="clearfix">
    <article id="gallery-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="gallery-content">
            <div class="container">
                <div id="page_caption" class="hasbg parallax <?php if ($space) echo esc_attr('wide'); ?> split classic">
                    <div id="bg_regular"
                         style="background-image:url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"></div>
                    <div class="bg_frame_split" style="bottom: 90px;"></div>
                </div>
                <div id="page_content_wrapper" class="hasbg <?php if ($space) echo esc_attr('wide'); ?> split">
                    <div class="inner"
                    <!-- Begin main content -->
                    <div class="inner_wrapper">

                        <div class="sidebar_content full_width fixed_column">

                            <div id="gallery_filter_wrapper"
                                 class="gallery cols-2 <?php if ($space) echo esc_attr('wide'); ?> clearfix split isotope">
								<?php if (isset($galleries[0]) && !empty($galleries[0])) : ?>
									<?php foreach ($galleries[0] as $src): ?>
                                        <div class="element grid classic2_cols isotope-item">

                                            <div class="one_half gallery2 static filterable gallery_type animated1 fadeIn"
                                                 data-id="post-1">

                                                <a class="fancy-gallery" href="<?php echo esc_url($src); ?>">
                                                    <img src="<?php echo esc_url($src); ?>" alt="">
                                                </a>
                                            </div>
                                        </div>
									<?php endforeach; ?>
								<?php endif; ?>

                            </div>

                        </div>

                    </div>
                    <!-- End main content -->

                </div>

                <br class="clear"><br>
            </div> <!-- /.container-## -->
        </div><!-- /.gallery-content-## -->
    </article><!-- #gallery-## -->
</div>

