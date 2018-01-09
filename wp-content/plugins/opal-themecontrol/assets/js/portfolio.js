(function ($) {

    "use strict";

    $(document).ready(function () {
        // --- Event onChange select in portfolios
        var choice = $('#portfolio_layout').val();

        function display(choice) {
            switch (choice) {
                case "video":
                    $('#portfolio_video_link').parent().parent().show();
                    $('.cmb2-id-portfolio-video-height').show();
                    $('.cmb2-id-portfolio-file-advanced').hide();
                    $('.cmb2-id-portfolio-image').hide();
                    $('.cmb2-id-portfolio-image-height').hide();
                    break;
                case "parallax":
                    $('.cmb2-id-portfolio-image').show();
                    $('.cmb2-id-portfolio-image-height').show();
                    $('.cmb2-id-portfolio-video-height').hide();
                    $('.cmb2-id-portfolio-file-advanced').hide();
                    $('#portfolio_video_link').parent().parent().hide();
                    break;
                case "default":
                    $('#portfolio_video_link').parent().parent().hide();
                    $('.cmb2-id-portfolio-video-height').hide();
                    $('.cmb2-id-portfolio-image').hide();
                    $('.cmb2-id-portfolio-image-height').hide();
                    $('.cmb2-id-portfolio-file-advanced').hide();
                    break;
                case "gallery":
                case "slideshow":
                default:
                    $('#portfolio_video_link').parent().parent().hide();
                    $('.cmb2-id-portfolio-video-height').hide();
                    $('.cmb2-id-portfolio-image').hide();
                    $('.cmb2-id-portfolio-image-height').hide();
                    $('.cmb2-id-portfolio-file-advanced').show();
                    break;
            }
        }

        display(choice);

        //--------------
        $('#portfolio_layout').on('change', function () {
            var selected = this.value;
            display(selected);
        });

    });
})(jQuery);