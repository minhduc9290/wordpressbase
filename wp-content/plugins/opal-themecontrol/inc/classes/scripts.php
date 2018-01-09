<?php 
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalthemecontrol
 * @author     Opal  Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2016 opalthemer.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.opalthemer.com
 * @support  http://www.opalthemer.com/support/forum.html
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class OpalThemeControl_Scripts{

	/**
	 * Init
	 */
	public static function init(){
		add_action( 'wp_head', array( __CLASS__, 'initAjaxUrl' ), 15 );
		add_action( 'admin_head', array( __CLASS__, 'initAjaxUrl' ), 15 );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'loadFrontendStyles' ),10);
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'loadScripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'loadAdminStyles') );
	}

	/**
	 * load script file in backend
	 */
	public static function loadScripts(){
		
		wp_enqueue_style( 'idx-css', get_template_directory_uri() . '/css/idx.css', array( 'mode-style' ), '20131205' );
		$key = 'AIzaSyCWM_dg1PmApt9uZ99bsJ1ftUSswUB1ggI';
		$api = apply_filters( 'opalthemecontrol_google_map_api',  '//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&amp;key='.$key );	
		wp_enqueue_script("google-map-api",$api , null, "0.0.1", false);
		//load Bootstrap
		wp_enqueue_script("opalthemecontrol-bootstrap-js", OPAL_THEMECONTROL_PLUGIN_URL . 'assets/js/bootstrap.min.js', array('jquery'), "3.3.6", true);
		//load Parallax
		wp_enqueue_script("opalthemecontrol-parallax-js", OPAL_THEMECONTROL_PLUGIN_URL . 'assets/3rd-party/parallax/parallax.min.js', array( 'jquery' ), "1.4.2", true);
		//load Skrollr
		wp_enqueue_script("opalthemecontrol-skrollr-js", OPAL_THEMECONTROL_PLUGIN_URL . 'assets/3rd-party/skrollr/skrollr.min.js', array( 'jquery' ), "1.4.2", true);
		//load owl.corousel
		wp_enqueue_script("opalthemecontrol-owl-carousel-js", OPAL_THEMECONTROL_PLUGIN_URL . 'assets/3rd-party/owl-carousel/owl.carousel2.min.js', array( 'jquery' ), "2.2.1", true);
		wp_enqueue_script("opalthemecontrol-owl-carousel-thumbnail-js", OPAL_THEMECONTROL_PLUGIN_URL . 'assets/3rd-party/owl-carousel/owl.carousel2.thumbs.min.js', array( 'jquery' ), "2.2.1", true);
		//load jquery-countdown
		wp_enqueue_script("opalthemecontrol-jquery-countdown-js", OPAL_THEMECONTROL_PLUGIN_URL . 'assets/3rd-party/jquery-countdown/jquery.countdown.js', array( 'jquery' ), "1.0.1", true);
		// load Ken Burns
		wp_enqueue_script( 'opalthemecontrol-kenburns-js',  OPAL_THEMECONTROL_PLUGIN_URL.'assets/3rd-party/kenburns/kenburns.js' );
		// load Isotope
		wp_enqueue_script( 'opalthemecontrol-isotope-js',  OPAL_THEMECONTROL_PLUGIN_URL.'assets/3rd-party/isotope/isotope-pkgd.min.js' );
		// load Nivo Lightbox
		wp_enqueue_script( 'opalthemecontrol-nivo-lightbox-js',  OPAL_THEMECONTROL_PLUGIN_URL.'assets/3rd-party/nivo-lightbox/nivo-lightbox.min.js' );
		// load scrollreveal
		wp_register_script( 'opalthemecontrol-scrollreveal', OPAL_THEMECONTROL_PLUGIN_URL . 'assets/3rd-party/scrollreveal/scrollreveal.min.js', array(), false, true );
		// Init scrollreveal
		if ( opal_themecontrol_get_options('wc_archive_item_animation') ) {
			wp_enqueue_script( 'opalthemecontrol-scrollreveal' );
		}

		// load Manifict Popup
		wp_enqueue_script( 'opalthemecontrol-magnific-popup-js',  OPAL_THEMECONTROL_PLUGIN_URL.'assets/3rd-party/magnific-popup/jquery-magnific-popup.min.js',array( 'jquery' ), "1.1.1", true);
		//load global js
		wp_enqueue_script("opalthemecontrol-scripts-js", OPAL_THEMECONTROL_PLUGIN_URL . 'assets/js/scripts.js', array('jquery'), "1.0.0", true);
	}

	/**
     * load javascript and css file in frontend system.
     */
    public static function loadFrontendStyles() {

    	//load owl.corousel
    	wp_enqueue_style( 'opalthemecontrol-carousel-css', OPAL_THEMECONTROL_PLUGIN_URL . 'assets/3rd-party/owl-carousel/owl.carousel.min.css', array(), '2.2.1' );
    	wp_enqueue_style( 'opalthemecontrol-carousel-theme-default-css', OPAL_THEMECONTROL_PLUGIN_URL . 'assets/3rd-party/owl-carousel/owl.theme.default.min.css', array(), '2.2.1' );
	    // load Ken Burns
	    //wp_enqueue_style( 'kenburns-css',  OPAL_THEMECONTROL_PLUGIN_URL.'assets/3rd-party/kenburns/style.css' );

	    wp_enqueue_style( 'opalthemecontrol-nivo-lightbox-css', OPAL_THEMECONTROL_PLUGIN_URL . 'assets/3rd-party/nivo-lightbox/nivo-lightbox.css', array(), '1.2.0' );

    	//load global css
    	wp_enqueue_style( 'opalthemecontrol-style-css', OPAL_THEMECONTROL_PLUGIN_URL . 'assets/css/style.css', array(), '1.0.0' );	

      	self::custom_styles();
    }

	/**
     * load javascript and css file in admin system.
     */
    public static function loadAdminStyles() {
      	// load bootstrap for page settings
      	if(isset($_GET['page']) && $_GET['page']=='opalthemecontrol-settings') {
	        wp_enqueue_style('opalthemecontrol-bootstrap-css', OPAL_THEMECONTROL_PLUGIN_URL . 'assets/css/bootstrap.min.css', null, '3.3.7');
	        wp_enqueue_script("opalthemecontrol-bootstrap-js", OPAL_THEMECONTROL_PLUGIN_URL . 'assets/js/bootstrap.min.js', array('jquery'), "3.3.6", true);
	        wp_enqueue_style('opalthemecontrol-vertical-tabs', OPAL_THEMECONTROL_PLUGIN_URL . 'assets/css/bootstrap.vertical-tabs.min.css', array(), '1.0.0');
        }
	    wp_enqueue_style( 'opalthemecontrol-admin-css', OPAL_THEMECONTROL_PLUGIN_URL . 'assets/css/admin.css', array(), '1.0.0' );
		wp_enqueue_script("opalthemecontrol-admin-js", OPAL_THEMECONTROL_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery' ), "1.0.0", true);
		
		wp_enqueue_media();
    }

    /**
     * add ajax url
     */
	public static function initAjaxUrl() {
		?>
		<script type="text/javascript">
			var ajaxurl = '<?php echo esc_js( admin_url('admin-ajax.php') ); ?>';
			var opalsiteurl = '<?php echo get_template_directory_uri(); ?>';
			var pluginmediaurl ='<?php echo OPAL_THEMECONTROL_MEDIA_URL; ?>';
		</script>
		<?php
	}

	/**
	 * Embed inline custom styles.
	 *
	 * @return  void
	 */
	public static function custom_styles() {
		// Get theme options.
		$css = $boxed_image = $page_title_image = array();

		// WooCommerce Settings
		$product_style         = opal_themecontrol_get_options('wc_archive_style');
		$product_column        = opal_themecontrol_get_options('wc_archive_layout_column');
		$product_item_layout   = opal_themecontrol_get_options('wc_archive_item_layout');
		$hover_mask_bg         = opal_themecontrol_get_options('wc_archive_item_mask_color');
		$product_single_bg     = opal_themecontrol_get_options('wc_single_product_custom_bg');

		//woocommerce
		$css[] = $hover_mask_bg ? '.product__image.mask .mask-inner { background: ' . esc_attr( $hover_mask_bg ) . ' }' : '';


		//Blog Setting
		$css[] = '
			.post-title {
				padding-top: ' . opal_themecontrol_get_options('blog_single_title_padding_top',100) . 'px;
				padding-bottom: ' . opal_themecontrol_get_options('blog_single_title_padding_bottom',100) . 'px;
			}
			.post-title .entry-title {
				font-size: ' . opal_themecontrol_get_options('blog_single_title_font_size',50) . 'px;
				line-height: ' . opal_themecontrol_get_options('blog_single_title_font_size',50) . 'px;
			}
		';

		$css = preg_replace( '/\n|\t/i', '', apply_filters( 'wr_custom_styles', implode ( $css ) ) );
		// Embed inline custom styles.
		wp_add_inline_style( 'opalthemecontrol-style-css', $css );
	}// End Function
}

OpalThemeControl_Scripts::init();		