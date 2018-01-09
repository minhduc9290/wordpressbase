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

class Opalthemecontrol_Plugin_Settings {

	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'opalthemecontrol_settings';

	/**
	 * Array of metaboxes/fields
	 * @var array
	 */
	protected $option_metabox = array();

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 1.0
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'admin_menu' ) , 10 );

		add_action( 'admin_init', array( $this, 'init' ) );

		//Custom CMB2 Settings Fields
		add_action( 'cmb2_render_opalthemecontrol_title', 'opalthemecontrol_title_callback', 10, 5 );

		add_action( 'cmb2_render_api', 'opalthemecontrol_api_callback', 10, 5 );
		add_action( 'cmb2_render_license_key', 'opalthemecontrol_license_key_callback', 10, 5 );
		add_action( "cmb2_save_options-page_fields", array( $this, 'settings_notices' ), 10, 3 );

		// Include CMB CSS in the head to avoid FOUC
		add_action( "admin_print_styles-opalthemecontrol_menu_page_opalthemecontrol-settings", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );

	}

	public function admin_menu() {
		//Settings
		add_menu_page(esc_html__( 'Theme Controls', 'opalthemecontrol' ), esc_html__('Theme Controls','opalthemecontrol'), 'manage_options', 'opalthemecontrol-settings', array( $this, 'admin_page_display' ),OPAL_THEMECONTROL_MEDIA_URL.'img/logo_opal.png',2);
	}

	/**
	 * Register our setting to WP
	 * @since  1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );

	}

	/**
	 * Retrieve settings tabs
	 *
	 * @since 1.0
	 * @return array $tabs
	 */
	public function opalthemecontrol_get_settings_tabs() {

		$tabs             		= array();
		$tabs['sampledata'] 	= __( 'Sample data', 'opalthemecontrol' );
		$tabs['addons']  		= __( 'Addons', 'opalthemecontrol' );
		$tabs['support'] 		= __( 'Support', 'opalthemecontrol' );
		$tabs['customize']  	= __( 'Theme Options', 'opalthemecontrol' );

		return apply_filters( 'opalthemecontrol_settings_tabs', $tabs );
	}

	/**
	 * Filter menu icon by tab_id
	 * @since  1.0
	 */
	public function set_menu_icon($tab_id) {
		$menu_icon = "";
		switch ($tab_id) {
			case 'sampledata':
				$menu_icon = "dashicons-welcome-view-site";
				break;
			case 'addons':
				$menu_icon = "dashicons-admin-plugins";
				break;
			case 'support':
				$menu_icon = "dashicons-smiley";
				break;
			case 'customize':
				$menu_icon = "dashicons-admin-generic";
				break;
			default:
				$menu_icon = "dashicons-tag";
				break;
		}
		return $menu_icon;
	}


	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap opalthemecontrol_settings_page">
			<div class="opalthemecontrol_settings-header">
				<h2><?php esc_html_e('Opal Theme Control','opalthemecontrol'); ?></h2>
			</div>
			<form class="cmb-form" method="post" id="options_page" enctype="multipart/form-data" encoding="multipart/form-data">
			<div class="themecontrol-form-wraper">
				<div class="header-form pull-right">
				</div> <!-- /.header-form -->
				<div class="row">
					<div class="col-md-2"> <!-- required for floating -->
					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs tabs-left"><!-- 'tabs-right' for right tabs -->
					   	<?php
						$cnt =0; foreach ( $this->opalthemecontrol_get_settings_tabs() as $tab_id => $tab_name ) {

						if($cnt == 0){
							echo '<li class="active"><a href="#'.$tab_id.'" data-toggle="tab"><span class="dashicons '.$this->set_menu_icon($tab_id).'"></span>' . esc_html( $tab_name ) .'</a></li>';
						}elseif($tab_id == "customize"){
							echo '<li><a href="'.admin_url('customize.php').'" ><span class="dashicons '.$this->set_menu_icon($tab_id).'"></span>' . esc_html( $tab_name ) .'</a></li>';
						}else{
							echo '<li ><a href="#'.$tab_id.'" data-toggle="tab"><span class="dashicons '.$this->set_menu_icon($tab_id).'"></span>' . esc_html( $tab_name ) .'</a></li>';
						}
						$cnt++;
						}
					?>
					  </ul>
					</div>
					<div class="col-md-10">
					    <!-- Tab panes -->
					    <div class="tab-content">
					    	<div class="tab-pane active" id="sampledata">
					    		<?php echo opalthemecontrol_display_sample_data_content(); ?>
					    	</div> <!-- End ID #sampledata -->
					    	<div class="tab-pane" id="addons">
					    		<?php opalthemecontrol_display_addons_content(); ?>
					    	</div> <!-- End ID #addons -->
					    	<div class="tab-pane" id="support">
					    		<?php opalthemecontrol_display_support_content(); ?>
					    	</div> <!-- End ID #support -->
					    </div>
					</div>
			</div> <!-- /.row -->
			<div class="footer-form">
				<div id="opal-share">
					<a href="http://www.facebook.com/ducphambkap" title="Facebook" target="_opal">
						<img src="<?php echo OPAL_THEMECONTROL_MEDIA_URL; ?>img/socials/glyphicons_320_facebook.png">
					</a>
					<a href="https://twitter.com/opalthemer" title="Folow me on Twitter" target="_opal">
						<img src="<?php echo OPAL_THEMECONTROL_MEDIA_URL; ?>img/socials/glyphicons_322_twitter.png" >
					</a>
					<a href="http://www.youtube/opalthemer" title="Folow me on Youtube" target="_opal">
						<img src="<?php echo OPAL_THEMECONTROL_MEDIA_URL; ?>img/sdidocials/glyphicons_342_youtube.png">
					</a>
				</div>
			</div> <!-- /.footer-form -->
			<div class="clearfix"></div>
			</div> <!-- /.themecontrol-form-wraper -->
			</form>
		</div> <!-- /.opalthemecontrol_settings_page -->
		<?php
	}

	/**
	 * Show Settings Notices
	 *
	 * @param $object_id
	 * @param $updated
	 * @param $cmb
	 */
	public function settings_notices( $object_id, $updated, $cmb ) {

		//Sanity check
		if ( $object_id !== $this->key ) {
			return;
		}

		if ( did_action( 'cmb2_save_options-page_fields' ) === 1 ) {
			settings_errors( 'opalthemecontrol-notices' );
		}

		add_settings_error( 'opalthemecontrol-notices', 'global-settings-updated', __( 'Settings updated.', 'opalthemecontrol' ), 'updated' );

	}


	/**
	 * Public getter method for retrieving protected/private variables
	 *
	 * @since  1.0
	 *
	 * @param  string $field Field to retrieve
	 *
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {

		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'fields', 'opalthemecontrol_title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid menu: ' . $field );
	}


}

// Get it started
$Opalthemecontrol_Settings = new Opalthemecontrol_Plugin_Settings();

/**
* Show Content Data Sample
* @filter opalthemecontrol_display_sample_data_content  - content
*/
if (!function_exists('opalthemecontrol_display_sample_data_content')) {
	function opalthemecontrol_display_sample_data_content(){
		$_instance = new opal_themecontrol_Import();
		return apply_filters('opalthemecontrol_display_sample_data_content',$_instance->render_admin_import_page());
	}
}

/**
* Show Content Addons
* @filter opal_themecontrol_default_preview_image  - link
* @filter opal_themecontrol_default_addons - array()
*/
if (!function_exists('opalthemecontrol_display_addons_content')) {
function opalthemecontrol_display_addons_content(){
	$previewURL = apply_filters(  'opal_themecontrol_default_preview_image', "http://wpsampledemo.com/opal/theme_preview.png" );
	$addons = apply_filters('opal_themecontrol_default_addons',array(
		array('key'=>'portfolio','name' => 'Portfolio','preview'=>'portfolio.png'),
		array('key'=>'team','name' => 'Teams','preview'=>'team.png'),
		array('key'=>'testimonials','name' => 'Testimonials','preview'=>'testimonial.png'),
		array('key'=>'brands','name' => 'Brands','preview'=>'brands.png'),
		array('key'=>'video','name' => 'Video','preview'=>'video.png'),
		array('key'=>'gallery','name' => 'Gallery','preview'=>'gallery.png'),
		array('key'=>'footer','name' => 'Footer','preview'=>'footer.png'),
		array('key'=>'faq','name' => 'FAQ','preview'=>'faq.png'),
	));
	
?>
	<div class="addons-content">
		<div class="update-nag">
			<?php esc_html_e( "Below you can see the list of addons custom made especially for theme is included in Theme Control. You can activate to use for your theme.", 'opal-themecontrol');?>
		</div> 
		<ul class="preview-demos"> 
		<?php foreach( $addons as  $addon ){ ?>
			<?php $is_active = opalthemecontrol_get_option($addon['key']); 
			//var_dump($is_active);die();
			?>
			<li>
				<a class="addon-item <?php if ($is_active) echo "active" ; ?>" data-key="<?php echo $addon['key'];?>">
					<?php if( isset($addon['preview']) && $addon['preview'] ) :?> 
						<img src="<?php echo OPAL_THEMECONTROL_MEDIA_URL; ?>img/addons/<?php echo $addon['preview']; ?>">
					<?php else : ?>
						<img src="<?php echo esc_attr($previewURL); ?>">
					<?php endif; ?>
					<span class="footer-item">
						<h5><span title="<?php echo ucfirst($addon['name']);?>"><?php echo ucfirst($addon['name']);?></span> <sup><?php echo OPAL_THEMECONTROL_VERSION; ?></sup></h5>
						<?php if( $is_active ) { ?>
							<span data-key="<?php echo $addon['key'];?>" title="Deactivate" class="addon-item-btn button button-danger"><?php esc_html_e('Deactivate','opal-themecontrol'); ?>
								<input class="<?php echo $addon['key'];?>" type="hidden"  name="<?php echo $addon['key'];?>" value="deactivate">
							</span>
						<?php }else{ ?>
							<span data-key="<?php echo $addon['key'];?>" title="Activate" class="addon-item-btn button button-primary"><?php esc_html_e('Activate','opal-themecontrol'); ?>
								<input class="<?php echo $addon['key'];?>" type="hidden" name="<?php echo $addon['key'];?>" value="activate">
							</span>
						<?php } ?>
					</span>
				</a> 
			</li>
			<?php } ?>
		</ul>	
    </div>
    
<?php
}
}

/**
* Show Content Spport
* @filter opalthemecontrol_display_support_content  - content html
*/
if (!function_exists('opalthemecontrol_display_support_content')) {
function opalthemecontrol_display_support_content(){

	$contents = '<div class="support-content">
		<div class="row">
			<div class="col-md-4">
				<h3>Documentation</h3>
				<p>Here is our user guide for theme, including basic setup steps, as well as Theme Control features and elements for your reference.</p>
				<a target="_blank" href="http://opalthemer.com/guides/" class="button button-primary">Read Documentation</a>
			</div>
			<div class="col-md-4">
				<h3>Video Tutorials</h3>
				<p class="coming-soon">Video tutorials is the great way to show you how to setup Theme Control plugin, make sure that the feature works as it\'s designed.</p>
				<a href="#" class="button button-primary">See Video</a>
			</div>
			<div class="col-md-4">
				<h3>Forum</h3>
				<p>Can\'t find the solution on documentation? We\'re here to help, even on weekend. Just click here to start 1on1 chatting with us!</p>
				<a target="_blank" href="http://www.opalthemer.com/" class="button button-primary">Request Support</a>
			</div>
		</div>
    </div>';
    echo apply_filters( 'opalthemecontrol_display_support_content', $contents );
}
}



/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 *
 * @param  string $key Options array key
 *
 * @return mixed        Option value
 */
function opalthemecontrol_get_option( $key = '', $default = false ) {
	global $opalthemecontrol_options;
	$value = ! empty( $opalthemecontrol_options[ $key ] ) ? $opalthemecontrol_options[ $key ] : $default;
	$value = apply_filters( 'opalthemecontrol_get_option', $value, $key, $default );

	return apply_filters( 'opalthemecontrol_get_option_' . $key, $value, $key, $default );
}


/**
 * Update an option
 *
 * Updates an opalthemecontrol setting value in both the db and the global variable.
 * Warning: Passing in an empty, false or null string value will remove
 *          the key from the opalthemecontrol_options array.
 *
 * @since 1.0
 *
 * @param string          $key   The Key to update
 * @param string|bool|int $value The value to set the key to
 *
 * @return boolean True if updated, false if not.
 */
function opalthemecontrol_update_option( $key = '', $value = false ) {

	// If no key, exit
	if ( empty( $key ) ) {
		return false;
	}

	if ( empty( $value ) ) {
		$remove_option = opalthemecontrol_delete_option( $key );

		return $remove_option;
	}

	// First let's grab the current settings
	$options = get_option( 'opalthemecontrol_settings' );

	// Let's let devs alter that value coming in
	$value = apply_filters( 'opalthemecontrol_update_option', $value, $key );

	// Next let's try to update the value
	$options[ $key ] = $value;
	$did_update      = update_option( 'opalthemecontrol_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ) {
		global $opalthemecontrol_options;
		$opalthemecontrol_options[ $key ] = $value;
	}

	return $did_update;
}

/**
 * Remove an option
 *
 * Removes an opalthemecontrol setting value in both the db and the global variable.
 *
 * @since 1.0
 *
 * @param string $key The Key to delete
 *
 * @return boolean True if updated, false if not.
 */
function opalthemecontrol_delete_option( $key = '' ) {

	// If no key, exit
	if ( empty( $key ) ) {
		return false;
	}

	// First let's grab the current settings
	$options = get_option( 'opalthemecontrol_settings' );

	// Next let's try to update the value
	if ( isset( $options[ $key ] ) ) {

		unset( $options[ $key ] );

	}

	$did_update = update_option( 'opalthemecontrol_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ) {
		global $opalthemecontrol_options;
		$opalthemecontrol_options = $options;
	}

	return $did_update;
}


/**
 * Get Settings
 *
 * Retrieves all Opalthemecontrol plugin settings
 *
 * @since 1.0
 * @return array Opalthemecontrol settings
 */
function opalthemecontrol_get_settings() {

	$settings = get_option( 'opalthemecontrol_settings' );

	return (array) apply_filters( 'opalthemecontrol_get_settings', $settings );

}

/**
 * Opalthemecontrol Title
 *
 * Renders custom section titles output; Really only an <hr> because CMB2's output is a bit funky
 *
 * @since 1.0
 *
 * @param       $field_object , $escaped_value, $object_id, $object_type, $field_type_object
 *
 * @return void
 */
function opalthemecontrol_title_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$title             = $field_type_object->field->args['name'];
	$field_description = $field_type_object->field->args['desc'];

	echo '<hr>';

}

/**
 * Gets a number of posts and displays them as options
 *
 * @param  array $query_args Optional. Overrides defaults.
 * @param  bool  $force      Force the pages to be loaded even if not on settings
 *
 * @see: https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-field-types
 * @return array An array of options that matches the CMB2 options array
 */
function opalthemecontrol_cmb2_get_post_options( $query_args, $force = false ) {

	$post_options = array( '' => '' ); // Blank option

	if ( ( ! isset( $_GET['page'] ) || 'opalthemecontrol-settings' != $_GET['page'] ) && ! $force ) {
		return $post_options;
	}

	$args = wp_parse_args( $query_args, array(
		'post_type'   => 'page',
		'numberposts' => 10,
	) );

	$posts = get_posts( $args );

	if ( $posts ) {
		foreach ( $posts as $post ) {

			$post_options[ $post->ID ] = $post->post_title;

		}
	}

	return $post_options;
}


/**
 * Modify CMB2 Default Form Output
 *
 * @param string @args
 *
 * @since 1.0
 */

add_filter( 'cmb2_get_metabox_form_format', 'opalthemecontrol_modify_cmb2_form_output', 10, 3 );

function opalthemecontrol_modify_cmb2_form_output( $form_format, $object_id, $cmb ) {

	//only modify the opalthemecontrol settings form
	if ('opalthemecontrol_settings' == $object_id && 'options_page' == $cmb->cmb_id ) {

		return '<input type="hidden" name="object_id" value="%2$s">
			%3$s';
	}

	return $form_format;

}


/**
 * Opalthemecontrol License Key Callback
 *
 * @description Registers the license field callback for EDD's Software Licensing
 * @since       1.0
 *
 * @param array $field_object , $escaped_value, $object_id, $object_type, $field_type_object Arguments passed by CMB2
 *
 * @return void
 */
if ( ! function_exists( 'opalthemecontrol_license_key_callback' ) ) {
	function opalthemecontrol_license_key_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

		$id                = $field_type_object->field->args['id'];
		$field_description = $field_type_object->field->args['desc'];
		$license_status    = get_option( $field_type_object->field->args['options']['is_valid_license_option'] );
		$field_classes     = 'regular-text opalthemecontrol-license-field';
		$type              = empty( $escaped_value ) ? 'text' : 'password';

		if ( $license_status === 'valid' ) {
			$field_classes .= ' opalthemecontrol-license-active';
		}

		$html = $field_type_object->input( array(
			'class' => $field_classes,
			'type'  => $type
		) );

		//License is active so show deactivate button
		if ( $license_status === 'valid' ) {
			$html .= '<input type="submit" class="button-secondary opalthemecontrol-license-deactivate" name="' . $id . '_deactivate" value="' . __( 'Deactivate License', 'opalthemecontrol' ) . '"/>';
		} else {
			//This license is not valid so delete it
			opalthemecontrol_delete_option( $id );
		}

		$html .= '<label for="opalthemecontrol_settings[' . $id . ']"> ' . $field_description . '</label>';

		wp_nonce_field( $id . '-nonce', $id . '-nonce' );

		echo $html;
	}
}


/**
 * Hook Callback
 *
 * Adds a do_action() hook in place of the field
 *
 * @since 1.0
 *
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function opalthemecontrol_hook_callback( $args ) {
	do_action( 'opalthemecontrol_' . $args['id'] );
}