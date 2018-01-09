<?php
$galleries = get_post_meta(get_the_ID(), 'gallery_file_advanced');
$show_info = opal_themecontrol_get_options('gallery_single_info');
?>
<div id="gallery-wrapper" class="clearfix">
    <article id="gallery-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="gallery-single ">
            <div class="gallery-content">
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery('body header').addClass('gallry-site-header');
                        jQuery('footer').hide();
                        jQuery('body').append('<canvas id="kenburns"></canvas>');
                        jQuery('body').append('<div id="kenburns_overlay"></div>');

                        var $canvas = jQuery('#kenburns');

                        $canvas.attr('width', jQuery(window).width());
                        $canvas.attr('height', jQuery(window).height());

                        var kb = $canvas.kenburned({
                            images: [
					            <?php if (isset($galleries[0]) && !empty($galleries[0])) : ?>
					            <?php foreach ($galleries[0] as $src): ?>
                                "<?php echo esc_url($src); ?>",
					            <?php endforeach; ?>
					            <?php endif; ?>
                            ],
                            frames_per_second: 100,
                            display_time: 7000,
                            zoom: 1.2,
                            fade_time: 1000,
                        });

                        jQuery(window).resize(function () {
                            jQuery('#kenburns').remove();
                            jQuery('#kenburns_overlay').remove();
                            jQuery('body header').addClass('gallry-site-header');
                            jQuery('footer').hide();
                            jQuery('body').append('<canvas id="kenburns"></canvas>');
                            jQuery('body').append('<div id="kenburns_overlay"></div>');

                            var $canvas = jQuery('#kenburns');
                            $canvas.attr('width', jQuery(window).width());
                            $canvas.attr('height', jQuery(window).height());

                            var kb = $canvas.kenburned({
                                images: [
						            <?php if (isset($galleries[0]) && !empty($galleries[0])) : ?>
						            <?php foreach ($galleries[0] as $src): ?>
                                    "<?php echo esc_url($src); ?>",
						            <?php endforeach; ?>
						            <?php endif; ?>
                                ],
                                frames_per_second: 100,
                                display_time: 7000,
                                zoom: 1.2,
                                fade_time: 1000,
                            });
                        });

                    });
                </script>

            </div><!-- .gallery-content -->
        </div>
    </article><!-- #gallery-## -->
</div>

