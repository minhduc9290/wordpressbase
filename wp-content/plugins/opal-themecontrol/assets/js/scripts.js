/*!
 * Script global for all site
 *
 * Other: WPOAL
 * Copyright 2017
 * Released under the GPL v2 License
 *
 * $ate: Mar 26, 2017
 */

(function ($) {
    "use strict";
    //Global var 
    var Opal_OwlCarousel;
    /**
    *  Mixes Element
    * @desc the contain all element 
    */
    function Opal_MixesElement(){
        /**
         * set width 100% for video
         * */
        var video_width = $('.video-thumb').width();
        var video_height = Math.min( Math.ceil( video_width * 1.5 ), 1000 );
        $('.video-thumb').find('iframe').attr('width', video_width);
        $('.video-thumb').find('iframe').attr('height', video_height);

        /*----------------------------------------------
        * Remove attribute srcset
        *----------------------------------------------*/
        $('.woocommerce-main-image > img').removeAttr('srcset');

    }// end fnc

    /**
    *  NivoLightbox
    */
    function Opal_NivoLightbox(){
        $('a[data-lightbox^="nivo"]').each(function() {
            if (!$(this).data("nivo-lightbox-initialized")) {
                $(this).nivoLightbox({
                    effect: "fall",
                    keyboardNav: true,
                    clickOverlayToClose: true
                });
                $(this).data("nivo-lightbox-initialized", true)
            }
        });
    }// end fnc

    /**
    *  ScrollReveal
    */
    function Opal_ScrollReveal() {
        if (typeof ScrollReveal != "undefined") {
            window.sr = ScrollReveal().reveal(".opal-item-animation", {
                duration: 700
            })
        }
    }// End Func

    /**
    *  Opal_Quickview
    */
    function Opal_Quickview() {
        // Ajax QuickView
        $(document).ready(function(){  
            $('.quickview').on('click', function (e) {  
                e.preventDefault(); 
                var productslug = $(this).data('productslug');
                var url = woocommerce_params.ajax_url + '?action=opal_themecontrol_quickview&productslug=' + productslug;
                 $.get(url,function(data,status){ 
                        $('#opal-quickview-modal .modal-body').html(data);
                 });
             });
            $('#opal-quickview-modal').on('hidden.bs.modal',function(){
                $(this).find('.modal-body').empty().append('<span class="spinner"></span>');
            });
                
        })
    /////   
    }

    /**
    * Automatic apply  OWL carousel
    * @version 2.2.1
    */
    function Opal_OwlCarousel(){
        window.Opal_OwlCarousel = $(".owl-carousel-play .owl-carousel").each(function () {
            var loop,autoplay,nav,dots,mousedrag,touchdrag,autoheight,thumbs,thumbimage,thumprerendered;
            loop        = $(this).data( 'loop' );
            autoplay    = $(this).data( 'autoplay' );
            nav         = $(this).data( 'nav' );
            dots        = $(this).data( 'dots' );
            mousedrag   = $(this).data( 'mousedrag' );
            touchdrag   = $(this).data( 'touchdrag' );
            autoheight  = $(this).data( 'autoheight' );
            thumbs      = $(this).data( 'thumbs' );
            thumbimage  = $(this).data( 'thumbimage' );
            thumprerendered  = $(this).data( 'thumprerendered' );

            var config = {
                loop : (typeof(loop) !== "undefined" && loop !== null) ? loop : false,
                thumbs: (typeof(thumbs) !== "undefined" && thumbs !== null) ? thumbs : false,
                thumbImage: (typeof(thumbimage) !== "undefined" && thumbimage !== null) ? thumbimage : false,
                thumbsPrerendered: (typeof(thumprerendered) !== "undefined" && thumprerendered !== null) ? thumprerendered : true,
                thumbContainerClass: 'owl-thumbs',
                thumbItemClass: 'owl-thumb-item',
                nav  : (typeof(nav) !== "undefined" && nav !== null) ? nav : true,
                dots : (typeof(dots) !== "undefined" && dots !== null) ? dots : false,
                autoplay : (typeof(autoplay) !== "undefined" && autoplay !== null) ? autoplay : false,
                mouse$rag : (typeof(mousedrag) !== "undefined" && mousedrag !== null) ? mousedrag : true,
                touch$rag : (typeof(touchdrag) !== "undefined" && touchdrag !== null) ? touchdrag : true,
                autoHeight : (typeof(autoheight) !== "undefined" && autoheight !== null) ? autoheight : true,
                navText : ["<span class='fa fa-angle-left'></span>","<span class='fa fa-angle-right'></span>"],
            };

            var owl = $(this);
            if($(this).data('slide')){
                config.items = $(this).data( 'slide' );
            }
            if($(this).data('margin')){
                config.margin = $(this).data( 'margin' );
            }
            if($(this).data('navspeed')){
                config.navSpeed = $(this).data( 'navspeed' );
            }
            //init
            $(this).owlCarousel( config );

            $('.left',$(this).parent()).on('click', function(){
                owl.trigger('owl.prev');
                return false;
            });
            $('.right',$(this).parent()).on('click', function(){
                owl.trigger('owl.next');
                return false;
            });
        });
        
    }// end func

    /**
    *  Isotope
    */
    function Opal_Isotope() {
        $('.isotope-masonry').isotope({
            itemSelector: '.isotope-item',
            layoutMode: 'masonry'
        });
        var $grid = $('.isotope').isotope({
            itemSelector: '.isotope-item'
        });
    }// end func



    /**
    * load for customize
    */
    Opal_OwlCarousel();

    //----------------------------------------------------
    // Init All Functions
    //----------------------------------------------------
    $(document).ready(function () {
        // Scroll Animation Image Background like Parallax
        if (window.skrollr) {
            skrollr.init({
                forceHeight: false
            })
        }
        Opal_MixesElement();
        Opal_NivoLightbox();
        Opal_Isotope();
        Opal_ScrollReveal();
        Opal_Quickview();
        
    }); // end document
})(jQuery);