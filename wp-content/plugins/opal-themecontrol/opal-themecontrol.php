<?php
/**
* @package opal-themecontrol
* @category Plugins
* @author WPOPAL
* |--------------------------------------------------------------------------
* | Plugin Opal Theme Control 
* |--------------------------------------------------------------------------
* Plugin Name: WPOPAL Framework For Themes
* Plugin URI: http://www.opalthemer.com/
* Description: Implement rich functions for themes base on WP_Opal wordpress framework and load widgets for theme used, this is required.
* Version: 1.0.0.0
* Author: WPOPAL
* Author URI: http://www.opalthemer.com
* License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
* Update: January, 13,2017
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if (!class_exists("OpalThemeControl")):
/**
 * Main OpalThemeControl Class
 * @since 1.0
 */
final class OpalThemeControl 
{
	/**
	 * @var OpalThemeControl The one true OpalThemeControl
	 * @since 1.0
	 */
	private static $instance;

	 /**
     * Plugin path
     *
     * @var string
     */
	 protected $_plugin_path = null;

	/**
	 * contructor
	 */
	public function __construct() {

	}

	/**
	* Main OpalThemeControl Instance
	*
	* Insures that only one instance of OpalThemeControl exists in memory at any one
	* time. Also prevents needing to define globals all over the place.
	*
	* @since     1.0
	* @static
	* @staticvar array $instance
	* @uses      OpalThemeControl::setup_constants() Setup the constants needed
	* @uses      OpalThemeControl::includes() Include the required files
	* @uses      OpalThemeControl::load_textdomain() load the language files
	* @see       OpalThemeControl()
	* @return    OpalThemeControl
	*/
	public static function getInstance() {
		
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof OpalThemeControl ) ) {
			self::$instance = new OpalThemeControl;
			self::$instance->setup_constants();

			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain'));
			self::$instance->includes();
			self::$instance->init_hooks();
			
			// Plug into WordPress Theme Customize.
			add_action( 'customize_register'                , array( 'Opal_Themecontrol_Customize', 'initialize'               ),999,1 );
			add_action( 'customize_controls_enqueue_scripts', array( 'Opal_Themecontrol_Customize', 'customize_assets'         ) );
			add_action( 'customize_controls_print_scripts'  , array( 'Opal_Themecontrol_Customize', 'create_loading_mask'      ) );
			add_action( 'customize_preview_init'            , array( 'Opal_Themecontrol_Customize', 'customize_preview_assets' ) );
			add_action( 'customize_save_after'              , array( 'Opal_Themecontrol_Customize', 'post_save_theme_mods'     ) );
			add_filter( 'opalthemecontrol_google_map_api', array( self::$instance, 'load_google_map_api') );
		}
		
		return self::$instance;
	}

	public static function load_google_map_api( $key ){ 
		if( opalthemecontrol_get_option('google_map_api') ){
			$key = '//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&amp;key='.opal_themecontrol_get_options('google_map_api') ;
		}
		return $key; 
	}
	/**
	 * Hook into actions and filters.
	 * @since  2.3
	 */
	private function init_hooks() {
		add_action( 'after_setup_theme', array( self::$instance, 'loadVendors' ), 11 );
	}

	/**
	* Function Defien
	*/
	public function setup_constants()
	{
        define("OPAL_THEMECONTROL_VERSION", "1.0.0.0");
		define("OPAL_THEMECONTROL_MINIMUM_WP_VERSION", "4.0");
		define("OPAL_THEMECONTROL_PLUGIN_URL", plugin_dir_url( __FILE__ ));
		define("OPAL_THEMECONTROL_PLUGIN_DIR", plugin_dir_path( __FILE__ ));
		define('OPAL_THEMECONTROL_MEDIA_URL', plugins_url(plugin_basename(__DIR__) . '/assets/'));
		define('OPAL_THEMECONTROL_LANGUAGE_DIR', plugin_dir_path( __FILE__ ) . '/languages/');
		define('OPAL_THEMECONTROL_THEMER_TEMPLATES_URL', get_bloginfo('template_url').'/' );
	}

	/**
	* Throw error on object clone
	*
	* The whole idea of the singleton design pattern is that there is a single
	* object, therefore we don't want the object to be cloned.
	*
	* @since  1.0
	* @access protected
	* @return void
	*/
	public function __clone() {
			// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'opalthemecontrol' ), '1.0' );
	}

	/**
     * Include a file
     *
     * @param string
     * @param bool
     * @param array
     */
	function _include( $file, $root = true, $args = array(), $unique = true ){
		if( $root ){
			$file = $this->plugin_path( $file );
		}
		if( is_array( $args ) ){
			extract( $args );
		}

		if( file_exists( $file ) )
		{
			if ( $unique ) {
				require_once $file;
			}
			else {
				require $file;
			}
		}
	}
    /**
    * Get the path of the plugin with sub path
    *
    * @param string $sub
    * @return string
    */
    function plugin_path( $sub = '' ){
    	if( ! $this->_plugin_path ) {
    		$this->_plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
    	}
    	return $this->_plugin_path . '/' . $sub;
    }
    public function setup_cmb2_url() {
    	return OPAL_THEMECONTROL_PLUGIN_URL . 'inc/vendors/cmb2/libraries';
    }

    public function includes(){
    	global $opalthemecontrol_options;

		//-- include admin setting
		$this->_include('inc/admin/register-settings.php');
		$opalthemecontrol_options = opalthemecontrol_get_settings();
		
		//--
		$this->_include("inc/mixes-functions.php");
		//--
		$this->_include("inc/teamplate-functions.php");

		//-- include all file *.php in directories , call function in inc/mixes-functions.php
		opalthemecontrol_includes( OPAL_THEMECONTROL_PLUGIN_DIR . 'inc/classes/*.php' );
		//--
		$this->_include("inc/import/import.php");
		//--
		$this->_include("inc/ajax-functions.php");
		//--
		//------
		$this->loadPosttypes();
		//------ 
		$this->loadCustomize();
		//------
		//--
		$this->_include("inc/template-functions.php");
		//--

		$this->_include('install.php');
		//--
		if ( get_option( 'opalthemecontrol_setup', false ) != 'installed' ) {
			register_activation_hook( __FILE__, 'opalthemecontrol_install' );
			update_option( 'opalthemecontrol_setup', 'installed' );
		}
		// add widgets
		add_action( 'widgets_init', array($this, 'widgets_init') );
	}

	/**
	 * Function used to Init Template Functions - This makes them pluggable by plugins and themes.
	 */
	public function include_template_functions() {
		include_once OPAL_THEMECONTROL_PLUGIN_DIR . "inc/teamplate-functions.php";

	}

	/**
	 * load Widgets Supported inside theme.
	 */
	public function loadCustomize(){

		//-- include all file *.php in directories , call function in inc/mixes-functions.php
		$this->_include('inc/customize/customize.php' );
		$this->_include('inc/customize/sidebar.php' );
		opalthemecontrol_includes( OPAL_THEMECONTROL_PLUGIN_DIR . 'inc/customize/options/*.php' );
		//--
	   
	}

	/**
	 * load Widgets Supported inside theme.
	 */
	public function loadPosttypes(){
		$this->_include("inc/post-types/blog.php");
		$opts = apply_filters( 'opalthemer_load_posttypes', get_option( 'opalthemecontrol_settings' ) ); 
	    if( !empty($opts) ){

	        foreach( $opts as $opt => $key ){
	            $filepath_postype 	= 'inc/post-types/'.$opt.'.php';
	            if($key=='on'){
	            	$this->_include( $filepath_postype );
	            }
	        }  
	    }
	}

	/**
	 * Load Vendor plugins
	 */
	public function loadVendors(){
		if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
	 	   require_once( OPAL_THEMECONTROL_PLUGIN_DIR.'inc/vendors/woocommerce.php' );
	 	}
	    /**
		 * Get the CMB2 bootstrap!
		 *
		 * @description: Checks to see if CMB2 plugin is installed first the uses included CMB2; we can still use it even it it's not active. This prevents fatal error conflicts with other themes and users of the CMB2 WP.org plugin
		 *
		 */
		if ( file_exists( WP_PLUGIN_DIR . '/cmb2/init.php' ) ) {
			require_once WP_PLUGIN_DIR . '/cmb2/init.php';
		} 
	}

	/**
	* this is function Load all Widgets
	*/
	public function widgets_init() {
		opalthemecontrol_includes( OPAL_THEMECONTROL_PLUGIN_DIR . 'inc/widgets/*.php' );
	}
	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	*/
	public function load_textdomain() {
			// Set filter for OpalThemeControl's languages directory
		$lang_dir = dirname( plugin_basename( OPAL_THEMECONTROL_PLUGIN_DIR ) ) . '/languages/';
		$lang_dir = apply_filters( 'opal_themecontrol_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
		$locale = apply_filters( 'plugin_locale', get_locale(), 'opal-themecontrol' );
		$mofile = sprintf( '%1$s-%2$s.mo', 'opal-themecontrol', $locale );

			// Setup paths to current locale file
		$mofile_local  = $lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/opal-themecontrol/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/opalthemecontrol folder
			load_textdomain( 'opal-themecontrol', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/opalthemecontrol/languages/ folder
			load_textdomain( 'opal-themecontrol', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'opal-themecontrol', false, $lang_dir );
		}
	}

}// end Class Root
endif; // End if class_exists check



/**
 * The main function responsible for returning the one true OpalThemeControl
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $themecontrol = OpalThemeControl(); ?>
 *
 * @since 1.0
 * @return object - The one true OpalThemeControl Instance
 */
function OpalThemeControl() {
	return OpalThemeControl::getInstance();
}

// Get OpalThemeControl Running
OpalThemeControl();
