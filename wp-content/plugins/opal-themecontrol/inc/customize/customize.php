<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    Opal_ThemeControl
 * @author     WpOpal Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2016 http://www.opalthemer.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.opalthemer.com
 * @support  http://www.opalthemer.com/questions/
 */

/**
 * Plug Opal ThemeControl theme options into WordPress Theme Customize.
 *
 * @package  Opal_ThemeControl
 * @since    1.0
 */
class Opal_Themecontrol_Customize {
	/**
	 * Variable to hold the initialization state.
	 *
	 * @var  boolean
	 */
	protected static $initialized = false;

	/**
	 * Define controls dependencies.
	 *
	 * @var  array
	 */
	protected static $dependencies = array();

	/**
	 * Variable to hold default values for all theme options.
	 *
	 * @var  array
	 */
	protected static $theme_options = array();

	/**
	 * Old color profile.
	 *
	 * @var  string
	 */
	protected static $old_color_profile = '';

	/**
	 * Initialize Theme Control theme options.
	 *
	 * @param   object  $wp_customize  The core customize object of WordPress.
	 *
	 * @return  void
	 */
	public static function initialize( $wp_customize ) {
		if(  class_exists("WP_Customize_Control") ){
			// Include Class Panel and Control for innit customize_register.
			//require_once(OPAL_THEMECONTROL_PLUGIN_DIR .'inc/customize/panel.php');
			opalthemecontrol_includes( OPAL_THEMECONTROL_PLUGIN_DIR . 'inc/customize/control/*.php' );
		}
		$opts = get_option( 'opalthemecontrol_settings' );
		// Add Website section and child options.
		$theme_options['general'] = Opal_Themecontrol_Customize_Options_General::get_options();

		// Add Layout section and child options.
		$theme_options['layout'] = Opal_Themecontrol_Customize_Options_Layout::get_options();

		// Add Typography section and child options.
		$theme_options['typography'] = Opal_Themecontrol_Customize_Options_Typography::get_options();;

		// Add Color Schemes section and child options.
		$theme_options['color_schemes'] = Opal_Themecontrol_Customize_Options_Color_Schemes::get_options();

		// Add Header section and child options.
		$theme_options['header'] = Opal_Themecontrol_Customize_Options_Header::get_options();

		// Add WooCommerce section and child options.
		$theme_options['woocommerce'] = Opal_Themecontrol_Customize_Options_WooCommerce::get_options();

		// Add Blog section and child options.
		$theme_options['blog'] = Opal_Themecontrol_Customize_Options_Blog::get_options();

		if(isset($opts['team']) and $opts['team'] == 'on') {
			// Add Team section and child options.
			$theme_options['team'] = Opal_Themecontrol_Customize_Options_Team::get_options();
		}
		if(isset($opts['portfolio']) and $opts['portfolio'] == 'on') {
			// Add Team section and child options.
			$theme_options['portfolio'] = Opal_Themecontrol_Customize_Options_Portfolio::get_options();
		}
		if(isset($opts['gallery']) and $opts['gallery'] == 'on') {
			// Add Gallery section and child options.
			$theme_options['gallery'] = Opal_Themecontrol_Customize_Options_Gallery::get_options();
		}
		// Add Pages section and child options.
		$theme_options['pages'] = Opal_Themecontrol_Customize_Options_Pages::get_options();

		// Add Footer section and child options.
		$theme_options['footer'] = Opal_Themecontrol_Customize_Options_Footer::get_options();

		// Add System section and child options.
		$theme_options['system'] = Opal_Themecontrol_Customize_Options_System::get_options();

		// Add System section and child options.
		$theme_options['sidebar'] = Opal_Themecontrol_Customize_Options_Sidebar::get_options();

		// Apply filters to allow custom hook from outside.
		$theme_options = apply_filters( 'opal_themecontrol_theme_options_definition', $theme_options );

		if ( $wp_customize ) {
			// Do nothing if theme options already initialized.
			if ( self::$initialized ) {
				return;
			}
			

			// Update controls.
			$wp_customize->get_control( 'blogname'        )->section = 'site_identity';
			$wp_customize->get_control( 'blogdescription' )->section = 'site_identity';
			$wp_customize->get_control( 'site_icon'       )->section = 'site_identity';

			if ( get_pages() ) {
				$wp_customize->get_control( 'show_on_front'   )->section = 'system';
				$wp_customize->get_control( 'page_on_front'   )->section = 'system';
				$wp_customize->get_control( 'page_for_posts'  )->section = 'system';
			}

			// // Update settings.
			$wp_customize->get_setting( 'blogname'        )->transport = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

			// Remove default sections.
			$wp_customize->remove_section( 'title_tagline' );
			$wp_customize->remove_section( 'colors' );
		}

		// Add all panels first.
		foreach ( $theme_options as $section => $define ) {
			// Check if a panel is being added.
			if ( isset( $define['sections'] ) ) {
				// Get sections.
				$sections = $define['sections'];

				// Unset sections data.
				unset( $define['sections'] );

				// Check if panel already exists.
				$panel = $section;

				if ( $wp_customize ) {
					if ( $wp_customize->get_panel( $panel ) ) {
						foreach ( $define as $k => $v ) {
							$wp_customize->get_panel( $panel )->$k = $v;
						}
					} else {
						if ( isset( $define['type'] ) && class_exists( $class = $define['type'] ) ) {
							unset( $define['type'] );

							$section = new $class( $wp_customize, $panel, $define );

							$wp_customize->add_panel( $section );
						} else {
							$wp_customize->add_panel( $panel, $define );
						}
					}
				}

				// Add sections.
				foreach ( $sections as $section => $define ) {
					if ( ! isset( $define['panel'] ) ) {
						$define['panel'] = $panel;
					}

					$theme_options[ $section ] = $define;
				}

				// Remove panel definition.
				unset( $theme_options[ $panel ] );
			}
		}

		// Get the preset data of the current color profile.
		$preset = get_theme_mod( 'color_profile' );

		if ( $preset ) {
			$preset = self::get_color_profiles( $preset );
		}

		// Then, add all sections and their settings and controls.
		foreach ( $theme_options as $section => $define ) {
			// Get settings and controls.
			$settings = isset( $define['settings'] ) ? $define['settings'] : array();
			$controls = isset( $define['controls'] ) ? $define['controls'] : array();

			// Unset settings and controls data.
			unset( $define['settings'] );
			unset( $define['controls'] );

			// Check if section already exists.
			if ( $wp_customize ) {
				if ( $wp_customize->get_section( $section ) ) {
					foreach ( $define as $k => $v ) {
						$wp_customize->get_section( $section )->$k = $v;
					}
				} else {
					if ( isset( $define['type'] ) && class_exists( $class = $define['type'] ) ) {
						unset( $define['type'] );

						$section = new $class( $wp_customize, $section, $define );

						$wp_customize->add_section( $section );
					} else {
						$wp_customize->add_section( $section, $define );
					}
				}
			}

			// Add settings.
			foreach ( $settings as $setting => $define ) {
				// Use default value from the preset data of the current color profile.
				if ( $preset && isset( $preset['data'][ $setting ] ) ) {
					$define['default'] = $preset['data'][ $setting ];
				}

				// Store default value of the setting.
				if ( ! array_key_exists( $setting, self::$theme_options ) ) {
					self::$theme_options[ $setting ] = isset( $define['default'] ) ? $define['default'] : null;
				}

				if ( $wp_customize ) {
					$wp_customize->add_setting( $setting, array_merge( array( 'sanitize_callback' => null ), $define ) );
				}
			}

			// Add controls.
			if ( $wp_customize ) {
				foreach ( $controls as $control => $define ) {
					if ( isset( $define['type'] ) && class_exists( $class = $define['type'] ) ) {
						unset( $define['type'] );

						$control = new $class( $wp_customize, $control, $define );

						$wp_customize->add_control( $control );
					} else {
						$wp_customize->add_control( $control, $define );
					}

					// Check if this control is depended on other control.
					if ( isset( $define['required'] ) && is_array( $define['required'] ) && count( $define['required'] ) ) {
						self::$dependencies[ is_object( $control ) ? $control->id : $control ] = $define['required'];
					}
				}
			}
		}

		if ( $wp_customize ) {
			// Do an action to let other know that all Theme Control customize controls have been added.
			do_action( 'opal_themecontrol_registered_customize_controls', $wp_customize );

			// Register action to print controls dependencies data.
			add_action( 'customize_controls_print_footer_scripts', array( __CLASS__, 'print_footer_scripts' ) );

			// State that initialization completed.
			self::$initialized = true;
		}
	}

	/**
	 * Print inline script including but not limited to  controls dependencies data.
	 *
	 * @return  void
	 */
	public static function print_footer_scripts() {
		echo '<scr' . 'ipt>';
		?>
			setTimeout( function() {
				var nodes = document.querySelector( '#accordion-section-themes > .accordion-section-title' );

				for ( var i = 0, n = nodes.childNodes.length; i < n; i++ ) {
					if ( nodes.childNodes[i].textContent.indexOf( 'ThemeControl' ) > -1 ) {
						var elm = document.createElement( 'a' );

						elm.target = '_blank';
						elm.title  = '<?php echo esc_html__( 'Go To ThemeControl Settings', 'opal-themecontrol' ); ?>';
						elm.href = '<?php echo esc_url( admin_url( 'admin.php?page=opalthemecontrol-settings' ) ); ?>';
						elm.textContent = 'ThemeControl';

						nodes.replaceChild( elm, nodes.childNodes[i] );

						break;
					}
				}
			}, 500 );

			<?php if ( count( self::$dependencies ) ) : ?>
			window.Opal_Themecontrol_Customize_Controls_Dependencies = <?php echo json_encode( self::$dependencies ); ?>;
			<?php endif; ?>
		<?php
		echo '</scr' . 'ipt>';

		// Print template for search box.
		echo '<scr' . 'ipt type="text/html" id="opal_customize_spotlight_search_template">';
		?>
			<div id="opal_customize_spotlight_search">
				<input class="search-for" type="text" value="" placeholder="<?php
					esc_attr_e( 'Search...', 'opal-themecontrol' );
				?>" />
				<div class="search-results hidden"></div>
			</div>
		<?php
		echo '</scr' . 'ipt>';
	}

	/**
	 * Enqueue script for custom customize control.
	 *
	 * @return  void
	 */
	public static function customize_assets() {
		// Enqueue jQuery UI tool-tips.
		wp_enqueue_script( 'jquery-ui-tooltip' );

		// Enqueue customize assets.
		wp_enqueue_script( 'opal-customize-control', OPAL_THEMECONTROL_PLUGIN_URL . '/assets/js/customize/customize.js', array( 'jquery', 'customize-controls' ), '', true );

		wp_enqueue_style( 'opal-customize-control' , OPAL_THEMECONTROL_PLUGIN_URL . '/assets/css/customize/customize.css' );
		wp_enqueue_style( 'font-awesome'         , OPAL_THEMECONTROL_PLUGIN_URL . '/assets/3rd-party/font-awesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'opal-themecontrol-google-fonts', OPAL_THEMECONTROL_PLUGIN_URL . '/assets/css/google-fonts.css' );

		// Pass data to client-side script.
		wp_localize_script( 'opal-customize-control', 'opal_site_data', self::localize_links() );

		// Pass common messages to client-side script.
		wp_localize_script( 'opal-customize-control', 'opal_customize_messages', array(
			'disabled_because_of_dependency'  => esc_html__( 'This control is disabled because it depends on other control which is disabled.', 'opal-themecontrol' ),
			'wc_catalog_mode_enabled_warning' => esc_html__( 'The section is disabled because its options affect nothing when the Catalog Mode of WooCommerce is enabled.', 'opal-themecontrol' ),
			'sections' => esc_html__( 'Sections', 'opal-themecontrol' ),
			'options'  => esc_html__( 'Options', 'opal-themecontrol' )
		) );
	}

	/**
	 * Embed inline script.
	 *
	 * @return  array
	 */
	public static function localize_links() {
		return array(
			'ajax_url'   => admin_url( 'admin-ajax.php' ),
			'admin_root' => admin_url(),
			'site_url'   => site_url(),
			'theme_url'  => get_template_directory_uri(),
			'_nonce'     => wp_create_nonce( 'opal_themecontrol_nonce_check' ),
		);
	}

	/**
	 * Render a loading mask on the Customize screen.
	 *
	 * @return  void
	 */
	public static function create_loading_mask() { ?>
		<?php echo '<scr' . 'ipt type="text/javascript">'; ?>
			var runtime_delayed_sources = [], links = document.querySelectorAll( 'link' );

			for (var i = 0; i < links.length; i++) {
				if (links[i].getAttribute('rel') == 'stylesheet' && links[i].getAttribute('href').indexOf('/fonts.googleapis.com/') > -1) {
					runtime_delayed_sources.push(links[i].getAttribute('href'));
					links[i].parentNode.removeChild(links[i]);
				}
			}
		<?php echo '</scr' . 'ipt>'; ?>

		<div class="nitro-customizer-loader">
			<span class="spinner is-active"></span>
		</div>
	<?php }

	/**
	 * This outputs the javascript needed to automate the live settings preview.
	 * Also keep in mind that this function isn't necessary unless your settings
	 * are using 'transport'=>'postMessage' instead of the default 'transport'
	 * => 'refresh'
	 *
	 * Used by hook: 'customize_preview_init'
	 *
	 * @see   add_action( 'wp_enqueue_scripts', array( 'Opal_Themecontrol_Render', 'header_output') );
	 * @since Nitro 1.0
	 */
	public static function customize_preview_assets() {
		wp_enqueue_script( 'opal-customize-preview', OPAL_THEMECONTROL_PLUGIN_URL . '/assets/js/customize/preview.js', array( 'jquery', 'customize-preview' ), '', true );
		wp_enqueue_script( 'opal-customize-actions', OPAL_THEMECONTROL_PLUGIN_URL . '/assets/js/customize/actions.js', array( 'jquery' ), '', true );
	}

	/**
	 * Method to prepare and return active theme options.
	 *
	 * @return  array
	 */
	public static function get_options() {
		// Get theme options.
		static $prepared;

		if ( ! isset( $prepared ) ) {
			self::initialize( null );

			// Prepare theme option values.
			$theme_mods = get_theme_mods();

			if ( $theme_mods && is_array( $theme_mods ) ) {
				self::$theme_options = array_merge( self::$theme_options, $theme_mods );
			}

			// State that this is theme options.
			self::$theme_options['use_global'] = 1;

			// Check if live preview is active?
			if ( is_customize_preview() ) {
				global $wp_customize;

				$changeset = $wp_customize->unsanitized_post_values();

				if ( @count( $changeset ) ) {
					self::$theme_options = array_merge( self::$theme_options, $changeset );
				}
			}

			// State that theme options is prepared.
			$prepared = true;
		}

		return apply_filters( 'opal_themecontrol_theme_options', self::$theme_options );
	}

	/**
	 * Get all available color profiles.
	 *
	 * @param   string  $preset  If provided, then data of the specified preset will be returned.
	 *
	 * @return  array
	 */
	public static function get_color_profiles( $preset = null ) {
		// Define path to color profiles definition file.
		static $presets, $preset_file;

		// Get file system object.
		global $wp_filesystem;

		// Initialize the WP filesystem, no more using 'file-put-contents' function
		if (empty($wp_filesystem)) {
		    require_once (ABSPATH . '/wp-admin/includes/file.php');
		    WP_Filesystem();
		}

		if ( isset( $presets ) ) {
			return ( $preset ? @$presets[ $preset ] : $presets );
		}

		if ( ! isset( $preset_file ) ) {
			$preset_file = OPAL_THEMECONTROL_PLUGIN_DIR . 'inc/customize/control/preset.json';
		}

		// Get preset data from transient first.
		$transient = md5( $preset_file );
		$data      = get_transient( $transient );

		if ( $data && isset( $data['last_update'] ) && $data['last_update'] >= filemtime( $preset_file ) ) {
			$presets = isset( $data['presets'] ) ? $data['presets'] : $data['preset'];
		} else {

			// Read preset data from data file.
			$presets = json_decode( $wp_filesystem->get_contents( $preset_file ), true );
			// if(!empty($wp_filesystem)){
			// 	$presets = json_decode( $wp_filesystem->get_contents( $preset_file ), true );
			// }else{
			// 	$presets = json_decode( WP_Filesystem( $preset_file ), true );	
			// }
			// Prepare preset data.
			foreach ( $presets as $key => $define ) {
				if ( isset( $define['image'] ) && ! preg_match( '#^https?://#', $define['image'] ) ) {
					if ( is_file( OPAL_THEMECONTROL_PLUGIN_DIR . '/' . ltrim( $define['image'], '/' ) ) ) {
						$presets[ $key ]['image'] = OPAL_THEMECONTROL_PLUGIN_URL . '/' . ltrim( $define['image'], '/' );
					}
				}
			}

			// Store preset data to transient.
			set_transient( $transient, array(
				'last_update' => time(),
				'presets'     => $presets,
			) );
		}

		// Check if there is a 'custom' color profile.
		if ( $custom_profile = get_transient( 'opal_custom_color_profile' ) ) {
			$presets['custom'] = $custom_profile;
		}

		return ( $preset ? $presets[ $preset ] : $presets );
	}

	/**
	 * Do extra processing after WordPress saved theme mods.
	 *
	 * @param   WP_Customize_Manager  $wp_customize  WP_Customize_Manager instance.
	 *
	 * @return  void
	 */
	public static function post_save_theme_mods( $wp_customize ) {
		// Get the selected color profile.
		$color_profile = get_theme_mod( 'color_profile' );
		$updated = false;

		// If the selected color profile is 'custom', update the preset data.
		if ( 'custom' == $color_profile ) {
			// If the 'custom' color profile was created before, update its preset data.
			if ( 'custom' == self::$old_color_profile ) {
				// Get the current preset data.
				$preset_data = get_transient( 'opal_custom_color_profile' );
			}

			// Otherwise, create and save a 'custom' color profile.
			else {
				// Create the 'custom' color profile based on the previously selected color profile.
				$preset_data = $wp_customize->get_control( 'color_profile' )->preset[
					$wp_customize->get_setting( 'color_profile' )->default
				];

				// Set title for the 'custom' color profile.
				$preset_data['title'] = esc_html__( 'Custom', 'opal-themecontrol' );
			}

			// Update the preset data if needed.
			$theme_mods = get_theme_mods();

			foreach ( $preset_data['data'] as $opt => $val ) {
				if ( isset( $theme_mods[ $opt ] ) && $val != $theme_mods[ $opt ] ) {
					$preset_data['data'][ $opt ] = $theme_mods[ $opt ];

					$updated = true;
				}
			}
		}

		if ( $updated ) {
			set_transient( 'opal_custom_color_profile', $preset_data );
		}
	}
}
