<?php
/**
  * $Desc
  *
  * @version    $Id$
  * @package    wpbase
  * @author     Wordpress Opal  Team <opalwordpress@gmail.com>
  * @copyright  Copyright (C) 2015 www.opalthemer.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @website  http://www.opalthemer.com
  * @support  http://www.opalthemer.com/questions/
  */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Opal_Themecontrol_Import {


	/**
	 * @var String $messages 
	 */
	public $message;

	/**
	 * @var Boolean $attachments 
	 */
	public $attachments = false;

	/**
	 * @var String $theme 
	 */
    public $theme;

    public $previewURL; 

    /**
	 *  Constructor
	 */
	public function __construct() {
		if(!defined('OPAL_THEMECONTROL_IMPORT_FOLDER')){
			define( 'OPAL_THEMECONTROL_IMPORT_FOLDER', get_template_directory() . '/opalthemer/import/'  );
		}

		if( is_dir( OPAL_THEMECONTROL_IMPORT_FOLDER ) ){
			 
			add_action('admin_menu', array(&$this, 'admin_import_page')); 
	        $this->theme = apply_filters( 'opal_themecontrol_import_theme', 'opal-themecontrol' );
	   
    	}

    	add_action( 'admin_init', array( $this, 'export_data') );
    	//add_action( 'admin_init', array( $this, 'get_remote_data') );

    	add_action('wp_ajax_download_remote_data',  array( $this, 'get_remote_data') );
		add_action('wp_ajax_nopriv_download_remote_data', array( $this, 'get_remote_data') );
	}
 	
 	public function get_remote_data(){
 		$this->previewURL = apply_filters(  'opal_themecontrol_default_preview_image', "http://wpsampledemo.com/opal/theme_preview.png" );
 		if( isset($_POST['action']) && $_POST['action'] == 'download_remote_data' && isset($_POST['package']) ){
 			$remotes = apply_filters( 'opal_themecontrol_import_remote_demos', array() );  

 			$package = trim($_POST['package']);
 			if( isset($remotes[$package]) ){
 				
 				$lpackage = OPAL_THEMECONTROL_IMPORT_FOLDER.'demoa.zip'; 	 

 				$data = file_get_contents( $remotes[$package]['source'] );
				$file = fopen($lpackage, "w+");
				fputs($file, $data);
				fclose($file);


   				if( file_exists($lpackage) ){
   					WP_Filesystem();
   					unzip_file( $lpackage , OPAL_THEMECONTROL_IMPORT_FOLDER );  
   				}
   				@unlink( $lpackage );
   				//wp_redirect( admin_url('themes.php?page=opal_themecontrol_options_import_page') );
   				$return = array( 'status' => 'success');
 			}else{
 				$return = array( 'status' => 'error','message' => 'packge is not found!');
 			}
 			echo json_encode($return); die();
 		}
 	}

 	public function export_data(){
 		if( isset($_GET['epxort_theme']) ){
 			do_action( 'opal_themecontrol_export_theme_data' );
 		}
 	}	


 	public static function getInstance(){
 		static $_instance;
 		
 		if( !$_instance ){
 			$_instance = new opal_themecontrol_Import();
 		}

 		return $_instance;
 	}

 	/**
	 * Import Setting of Customizer
	 */
	public function import_customizer_options($file){

		$options = $this->get_file_content_unserialize($file);

		if (is_array($options)) {
			foreach ($options as $key => $val) {
				set_theme_mod( $key, $val );
			}
		}

		$this->message = __("Customizer options imported successfully", 'opal-themecontrol');
		return $this->outputJson( true, $this->message, '' );
	}

	/**
	 * Import menu sample
	 */
	public function import_menus($file){
		global $wpdb;
		$opal_themecontrol_terms_table = $wpdb->prefix . "terms";
		$this->menus_data = $this->get_file_content_unserialize($file);


		if(  $this->menus_data ){ 
			$menu_array = array();
			foreach ($this->menus_data as $registered_menu => $menu_slug) {
				$term_rows = $wpdb->get_results("SELECT * FROM $opal_themecontrol_terms_table where slug='{$menu_slug}'", ARRAY_A);
				if(isset($term_rows[0]['term_id'])) {
					$term_id_by_slug = $term_rows[0]['term_id'];
				} else {
					$term_id_by_slug = null;
				}
				$menu_array[$registered_menu] = $term_id_by_slug;
			}

			set_theme_mod('nav_menu_locations', array_map('absint', $menu_array ) );
		}	
		$log      = ob_get_clean();
		return $this->outputJson( true, $this->message,  $log );
	}

	public function outputJson( $status, $msg, $log='', $loop=false ){

		$response       = array(

			'status'  => $status,
			'message' => $mgs,
			'log'     => $log,
			'loop'	  => $loop,
			'loopnumber'=>0
		);

		return $response;

	}

	/**
	 * Import Page Options
	 */
	public function import_page_options($file){
		$pages = $this->get_file_content_unserialize($file);

		if( $pages ){
			foreach($pages as $opal_themecontrol_page_option => $opal_themecontrol_page_id){
				update_option( $opal_themecontrol_page_option, $opal_themecontrol_page_id);
			}
		}
		$log      = ob_get_clean();
		return $this->outputJson( true, $this->message,  $log );
	}

	public function import_theme_options($file){
		$pages = $this->get_file_content_unserialize($file);
	 
		if( $pages ){
			update_option( 'opalthemer_theme_options', $pages );
		}
		$log      = ob_get_clean();
		return $this->outputJson( true, $this->message,  $log );
	}
	public function import_content_vc(){
		return $this->outputJson( true, $this->message, '' );	
	}
	/**
	 * Import data sample from xml.
	 */
	public function import_content($file){
		session_start();
		if (!class_exists('WPOPAL_Import')) {

			
			ob_start();

            require_once('class.wordpress-importer.php');

			$opal_themecontrol_import = new WPOPAL_Import();
			
			if( !isset($_SESSION['importpostcount']) ){
            	$_SESSION['importpoststart'] = 0;
            	$_SESSION['importpostcount'] = 0;	
            	if( method_exists("deleteCache", $opal_themecontrol_impor)){
            		$this->deleteCaches();
            	}
            }

			$path = OPAL_THEMECONTROL_IMPORT_FOLDER . $file;
			 
			$opal_themecontrol_import->fetch_attachments = $this->attachments;
			
			$returned_value = $opal_themecontrol_import->import($path);
			$log      = ob_get_clean();
  			$data = $this->outputJson( true, $this->message,  $log, !$returned_value );
			$data['loopnumber'] = $_SESSION['importpostcount'];

			if( $returned_value == true ){
				unset( $_SESSION['importpoststart'] );
				unset( $_SESSION['importpoststart'] );
			}

			return $data;
		} else {
			$this->message = __("Error loading files", 'opal-themecontrol');
		}
		return $this->outputJson( false, $this->message, '' );
	}

	/**
	 * Import Widget and content
	 */
	public function import_widgets( $file ){
 
		$options = $this->get_file_content_unserialize($file);
 
		if( $options['widgets'] ){
			foreach ( (array) $options['widgets'] as $opal_themecontrol_widget_id => $opal_themecontrol_widget_data ) {
				update_option( 'widget_' . $opal_themecontrol_widget_id, $opal_themecontrol_widget_data );
			}

			$this->import_sidebars_widgets($file);
		}
		$this->message = __("Widgets imported successfully", 'opal-themecontrol');

		$log      = ob_get_clean();
		return $this->outputJson( true, $this->message,  $log );
		
	}

	/**
	 * Import widget with data nad logic
	 */
	public function import_widget_logic($file) {

		$file_path = OPAL_THEMECONTROL_IMPORT_FOLDER . '/' . $file;

		if (file_exists($file_path)) {
			global $wl_options;

			$import = split("\n", file_get_contents($file_path, false));

			if (trim(array_shift($import))=="[START=WIDGET LOGIC OPTIONS]" && trim(array_pop($import))=="[STOP=WIDGET LOGIC OPTIONS]")
			{	
				foreach ( $import as $import_option )
				{	list($key, $value)=split("\t",$import_option);
					$wl_options[$key]=json_decode($value);
				}
			}

			update_option('widget_logic', $wl_options);
		}
		$log      = ob_get_clean();
		return $this->outputJson( true, $this->message,  $log );
	}

	/**
	 * Import Widget to sidebars
	 */
	public function import_sidebars_widgets( $file ){ 

		$opal_themecontrol_sidebars = get_option("sidebars_widgets");
		
		unset($opal_themecontrol_sidebars['array_version']);
		
		$data = $this->get_file_content_unserialize($file);
		
		if ( is_array($data['sidebars']) ) {
			$opal_themecontrol_sidebars = array_merge( (array) $opal_themecontrol_sidebars, (array) $data['sidebars'] );
			
			unset($opal_themecontrol_sidebars['wp_inactive_widgets']);
			
			$opal_themecontrol_sidebars = array_merge(array('wp_inactive_widgets' => array()), $opal_themecontrol_sidebars);
			$opal_themecontrol_sidebars['array_version'] = 2;
			wp_set_sidebars_widgets($opal_themecontrol_sidebars);
		}

		$log      = ob_get_clean();
		return $this->outputJson( true, $this->message,  $log );
	}

	/**
	 * Import data to revolutions
	 */
	public function import_rev_slider($demo) {
		
		if( !defined("RS_PLUGIN_PATH")){
			
			$log      = ob_get_clean();
			return $this->outputJson( true, $this->message,  $log );

			return ;
		}

		if ( ! class_exists( 'RevSliderAdmin' ) ) {
			require( RS_PLUGIN_PATH . '/admin/revslider-admin.class.php' );			
		}

		$rev_files = glob( OPAL_THEMECONTROL_IMPORT_FOLDER . $demo . '/rev_sliders/*.zip' );

		if (!empty($rev_files)) {
			foreach ($rev_files as $rev_file) {
				$_FILES['import_file']['error'] = UPLOAD_ERR_OK;
				$_FILES['import_file']['tmp_name']= $rev_file;

				$slider = new RevSlider();
				$slider->importSliderFromPost( true, 'none' );
			}
		}
		$log      = ob_get_clean();
		return $this->outputJson( true, $this->message,  $log );
	}

	/**
	 * Import Visual Composer Templates
	 */
	public function import_vc_templates($file){
		if (!class_exists('WPOPAL_Import')) {
			ob_start();
            require_once('class.wordpress-importer.php');
			$opal_themecontrol_import = new WPOPAL_Import();
			set_time_limit(0);
			$path = OPAL_THEMECONTROL_IMPORT_FOLDER . $file;

			$opal_themecontrol_import->fetch_attachments = $this->attachments;
			$returned_value = $opal_themecontrol_import->import($path);

            echo $returned_value;
            die();

			if(is_wp_error($returned_value)){
				$this->message = __("An Error Occurred During Import", 'opal-themecontrol');
			}
			else {
				$this->message = __("Content imported successfully", 'opal-themecontrol');
			}
			 
		} else {
			$this->message = __("Error loading files", 'opal-themecontrol');
		}

		$log      = ob_get_clean();
		return $this->outputJson( true, $this->message,  $log );
	}

	/**
	 * Get content inside file with unserialize and decode 64
	 */
	public function get_file_content_unserialize( $file ){
		$file_content = "";
		$file_for_import = OPAL_THEMECONTROL_IMPORT_FOLDER . $file;
		if ( file_exists($file_for_import) ) {
			$file_content = $this->get_file_contents($file_for_import);
		} else {
			$this->message = __("File doesn't exist", 'opal-themecontrol');
		}
		if ($file_content) {
			$unserialized_content = unserialize(base64_decode($file_content));
			if ($unserialized_content) {
				return $unserialized_content;
			}
		}
		return false;
	}

	/**
	 *  Get content inside file with json
	 */
	public function get_file_content_json($file) {
		$file_content = "";
		$file_for_import = OPAL_THEMECONTROL_IMPORT_FOLDER . $file;
		if ( file_exists($file_for_import) ) {
			$file_content = $this->get_file_contents($file_for_import);
		} else {
			$this->message = __("File doesn't exist", 'opal-themecontrol');
		}

		if ($file_content) {
			return json_decode($file_content, true);
		}

		return false;
	}

	/**
	 * get file content
	 */
	public function get_file_contents( $path ) {
		$opal_themecontrol_content = '';
		if ( function_exists('realpath') )
			{$filepath = realpath($path);}
		if ( !$filepath || !@is_file($filepath) )
			{return '';}

		if( ini_get('allow_url_fopen') ) {
			$opal_themecontrol_file_method = 'fopen';
		} else {
			$opal_themecontrol_file_method = 'file_get_contents';
		}
		if ( $opal_themecontrol_file_method == 'fopen' ) {
			$opal_themecontrol_handle = fopen( $filepath, 'rb' );

			if( $opal_themecontrol_handle !== false ) {
				while (!feof($opal_themecontrol_handle)) {
					$opal_themecontrol_content .= fread($opal_themecontrol_handle, 8192);
				}
				fclose( $opal_themecontrol_handle );
			}
			return $opal_themecontrol_content;
		} else {
			return file_get_contents($filepath);
		}
	}

	/**
	 * Add Import Page Menu to Sidebar Menu in Admin Page.
	 */
	public function admin_import_page() {

		$theme = wp_get_theme();
		$this->pagehook = add_submenu_page( 'themes.php',  __( 'Opal Import Demo', 'opal-themecontrol'), esc_html__( 'Opal Import Demo', 'opal-themecontrol'), 'manage_options', 'opal_themecontrol_options_import_page', array(&$this, 'render_admin_import_page'),'dashicons-download');

	}

	/**
	 * Add Import Page Menu to Sidebar Menu in Admin Page.
	 */
	public function check_exist_demo($filename) {
		$lpackage = OPAL_THEMECONTROL_IMPORT_FOLDER.$filename;
		if( is_dir($lpackage) ){
			return true;
		}
		return false;
	}
	/**
	 * Render content of the import page
	 */
	public function render_admin_import_page() {
		$theme = wp_get_theme();
		$remotes = apply_filters( 'opal_themecontrol_import_remote_demos', array() );  
        $demos = apply_filters( 'opal_themecontrol_import_demos', array() );
        $types = apply_filters( 'opal_themecontrol_import_types', array() );
        @session_start( );

		if( isset($_SESSION['importpostcount']) ){
           	$_SESSION['importpoststart'] = null;
            $_SESSION['importpostcount'] = null;
        }


     	define( 'OPAL_THEMECONTROL_RECOMMEND_MEMORY_LIMIT'	, 128 );
		define( 'OPAL_THEMECONTROL_RECOMMEND_EXECUTION_TIME'  , -1 );
		define( 'OPAL_THEMECONTROL_RECOMMEND_PHP_VERSION'	    , '5.4.0' );
		
		$memory_limit       = ini_get( 'memory_limit' );
		$max_execution_time = ini_get( 'max_execution_time' );

		$all_ini_config = ini_get_all();
		$is_ok = true;
		if ( intval( $memory_limit ) < OPAL_THEMECONTROL_RECOMMEND_MEMORY_LIMIT || intval( $max_execution_time ) < OPAL_THEMECONTROL_RECOMMEND_EXECUTION_TIME ) {
			$is_ok = false;
		}
     
		?>

        <div class="wrap" >
            <h2 class="opal-themecontrolf-page-title"><?php _e( $theme->Name . ' - One-Click Import', 'opal-themecontrol') ?></h2>
          
			
            <form method="post" action="" id="importContentForm">
                <table class="form-table">
                	<?php if( $remotes  ){ ?>
                	<tr>
                		<td colspan="2">
                			
                			<div class="update-nag">
				                <?php _e( "Click to the follow buttons to get sample demo from our live sites, the package will put into THEME/opalthemer/import folder.<br> Or you can copy the demo package from the downloadable you purchased. <br> Please make sure this folder has writeable permision", 'opal-themecontrol');?>
							</div> 
							<?php 
							if( !is_writable(OPAL_THEMECONTROL_IMPORT_FOLDER) ){ ?><br>
							<div class="update-nag clearfix error">
				                <?php _e( "THEME/opalthemer/import folder is not writeable", 'opal-themecontrol');?>
							</div> 
							<?php }
							?>
							<?php 
				          	/**
							 * Memory limit and Maximum execution time
							 */
							if ( ! $is_ok ) : ?>
								<?php if ( intval( $memory_limit ) < OPAL_THEMECONTROL_RECOMMEND_MEMORY_LIMIT ) { ?>
									<div class="error OPAL_THEMECONTROL_notification">
										<div class="memory_limit">
											<p>
												<?php
												printf(
													__( '<strong>Important:</strong> The Importer requires memory limit of your system >= %1$sMB. Please follow <a href="%2$s" target="_blank">these guidelines</a> to improve it.', 'opal-themecontrol' ),
													OPAL_THEMECONTROL_RECOMMEND_MEMORY_LIMIT,
													'//www.opalthemer.com/common-issues-with-installing-wordpress-data-sample-and-solutions/'
												);
												?>
											</p>
										</div>
									</div>
								<?php } ?>
							<?php endif; ?>

                		</td>	
                	</tr>	

                	 <tr>
                        <td colspan="2">
                        	<h3><?php _e( 'Found Demos From Live Server', 'opal-themecontrol') ?></h3>

                         	<div class="demo-explain">
				                <?php _e( "Click to the follow Image to get sample demo from our live sites, the package will put into <b>THEME/opalthemer/import</b> folder.Or you can copy the demo package from the downloadable you purchased. Please make sure this folder has writeable permision",'opal-themecontrol');?>
							</div> 
                            <ul class="preview-demos"> 
	                           	<?php foreach( $remotes as  $remote ){ ?>
	                           	<li>
	                           		<a class="demo-item <?php if ($this->check_exist_demo($remote['name'])) echo "active" ; ?>" data-package="<?php echo $remote['name'];?>">
	                           			<?php if( isset($remote['preview']) && $remote['preview'] ) :?> 
	                           			<img src="<?php echo $remote['preview']; ?>">
	                           			<?php else : ?>
	                           			<img src="<?php echo $this->previewURL; ?>">
	                           			<?php endif; ?>
	                           			<span><?php echo ucfirst($remote['name']);?> Sample</span>
	                           			<span class="item-icon">
	                           			<?php $is_dir = $this->check_exist_demo( $remote['name'] ); 
	                           			if( $is_dir ) { ?>
	                           				<img src="<?php echo OPAL_THEMECONTROL_MEDIA_URL; ?>img/ok.png">
	                           			<?php }else{ ?>
	                           				<b class="btn btn-primary"><?php esc_html_e('Download','opal-themecontrol'); ?></b>
	                           			<?php } ?>
	                           			</span>
	                           		</a> 
	                           	</li>
	                           	<?php } ?>
                           </ul>	
                        </td>
                    </tr>
                    <?php } ?>
                
                    <?php if( $demos ){ ?>
               
                    <tr>
                    	<td colspan="2">
                    		<hr>
                    		<div class="demo-explain">
				                <?php _e( "The follow demos ready downloaded and put inside  THEME/opalthemer/import folder",'opal-themecontrol');?><br>
				                 <?php _e( "Select option to install data sample, the installation may complete in 10 minutes. After done your site getting look like as our demo",'opal-themecontrol');?>
							</div> 
                    	</td>	
                    </tr>	
                    <tr>
                        <th class="row"><?php _e( 'Demo Source', 'opal-themecontrol') ?></th>
                        <td>

                        	<div class="import-process-wrap">
                        		<div class="import-process"><?php _e("Importing"); ?> <span class="import-source"></span></div>
								<div id="processbar-import" class="progress-wrap" data-progress-percent="25">
								  <div class="progress-bar progress"></div>
								</div>
							</div>	

                            <select name="demo_source" id="demo_source">
                                <?php foreach ( $demos as $key => $name ) : ?>
                                <option value="<?php echo $key; ?>"><?php echo ucfirst($name); ?> Sample</option>
                                <?php endforeach; ?>
                            </select>
 
                        </td>
                    </tr>
                    <tr>
                        <th class="row"><?php _e( 'Import Type', 'opal-themecontrol') ?></th>
                        <td>
                            <select name="import_type" id="import_type">
                                <option value=""><?php _e( "Please Select ",'opal-themecontrol'); ?></option>
                                <?php foreach ( $types as $key => $name ) : ?>
                                <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                    	<th class="row">&nbsp;</th>
                    	<td>
                    	    <p class="submit">
                    	        <input type="submit" name="submit" id="import" class="button button-primary" value="<?php _e( 'Import', 'opal-themecontrol') ?>">
                    	        <span class="spinner" style="float: none;"></span>
                    	    </p>
						</td>
					</tr>
					<?php }  ?> 
					<tr>
                		<td colspan="2">
                			
                			
							<?php 
							if( !is_writable(OPAL_THEMECONTROL_IMPORT_FOLDER) ){ ?><br>
							<div class="update-nag clearfix clear">
				                <?php _e( "THEME/opalthemer/import folder is not writeable",'opal-themecontrol');?>
							</div> 
							<?php }
							?>
                		</td>	
                	</tr>	
					<?php 
					if( empty($demos) && !empty($remotes)  ){
					?>
					<tr>
                    	<td colspan="2">
	            		 	 <div class="update-nag">
				                <?php _e( "No avairiable package for installing sample demos. Please click above sample to get it into your server, the sampel will appear to replace this warning!",'opal-themecontrol');?>
							</div>

                    	</td>
                    </tr>	
					<?php } ?>
                </table>
            </form>

  <script type="text/javascript">
            jQuery(document).ready(function($) {
                var attachmentImport = true,
                    $importBtn = $('#import'),
                    $demoItem = $('.demo-item');

				function opal_themecontrol_import_successfull() {
					$importBtn
						.prop('disabled', false)
						.next('.spinner')
                            .removeClass('is-active');

					alert('Import is successful!');

					$(".import-process-wrap").hide();
			        $("#processbar-import .progress").css( 'width', '0%' );

				}
				/**
				*	Event Click Item demo
				*/
			 	$demoItem.each(function(){
			 		$(this).on('click', function(e) {
                    	e.preventDefault();
                    	var element = $(this);
                    	var package = $(this).data( 'package' );
                    	//do acction loading on item here
                    	var loading = '<img src="'+pluginmediaurl+'img/bx_loader.gif">';
                    	var ok = '<img src="'+pluginmediaurl+'img/ok.png">';
        				$(this).find('.item-icon').html(loading);
        				$(this).addClass('active');
                    	// call ajax download here
                    	$.ajax({
                    		type: 'POST',
                    		url: ajaxurl,
                    		dataType: 'json', 
                    		data: {
                    			action:'download_remote_data',
                    			package: package
                    		},
                    		success: function ( data, textStatus, XMLHttpRequest){
	                    		if (data.status == "success") {
	                    			//do acction add class active item here
	                    			element.find('.item-icon').html(ok);
	                    			$( "#demo_source" ).append($("<option></option>")
                    				.attr("value",package)
                    				.text(package+' Sample')); 
	                    			$( "#demo_source" ).val(package).change();
	                    			$( "#demo_source" ).focus();
	                    			$("html, body").animate({ scrollTop: $(document).height() }, 1000);
	                    		}
                    		},
                    		error: function (MLHttpRequest, textStatus, errorThrown){
                    			console.error("The following error occured: " + textStatus, errorThrown);
                    		}
                    	}); //end Ajax
                	});
			 	});// End demoItem

                $importBtn.on('click', function(e) {
                    e.preventDefault();

					var import_type = $( "#import_type" ).val(),
						demo_source = $( "#demo_source" ).val();

					if (!import_type) {
						alert( '<?php _e("Please choose import type!","pbrthemer");?>' );
						return false;
					}

                    if ( confirm('<?php _e("Do you want to import demo now?", 'opal-themecontrol'); ?>') ) {
						
						$importBtn
                            .prop('disabled', true)
	                        .next('.spinner')
	                            .addClass('is-active')

	                    var $action = 'opal_themecontrol_'+import_type+'Import';   

	                    if( import_type == 'all' ){
	                    	
	                    	
	                    	var ajaxes = new Array(); var i = 0;

	                    	$( "#import_type option" ).each( function() {
	                    		
	                    		if(  $(this).val() == "" || $(this).val() == "all" ){
	                    		
	                    		}else {
	                    			ajaxes[i++] = $(this).val();
	                    		}
	                    	
	                    	} );
	                    	var current = 0; 
	                    	var pc = 100/6; 
	                    	var nloop = 0;
	                    	var loop = 0;
	                    	function importdata( action ){
	                    		$(".import-process-wrap").show();
	                    		var $action = 'opal_themecontrol_'+action+'Import';   
	                    		if (current < ajaxes.length) {
	                    			
	                    			var text =  $( "#import_type option" ).eq(current+2).text();  
	                    			$(".import-process .import-source").html( " <span>"+ text + "</span> " );

		                    		 $.ajax({
			                            type: 'POST',
			                            url: ajaxurl,
			                            dataType: 'json', 
			                            data: {
			                                action: $action,
			                                xml: 'content.xml',
			                                demo_source: demo_source,
			                                ajax:1,
			                                import_attachments: (attachmentImport ? 1 : 0)
			                            },
			                            success: function ( data, textStatus, XMLHttpRequest){
			                            	if(   data.loopnumber != null && data.loopnumber > 0  ){
			                            		nloop = pc/data.loopnumber;
			                            	}
			                            	if(  data.loop != null && data.loop == true ){
			                            		importdata( ajaxes[current] );
			                            		++loop;
			                            		$("#processbar-import .progress").css( 'width', pc*current+(nloop*loop)+'%' );
			                            	}else {
			                            		current++;	
			                            		importdata( ajaxes[current] );
			                            		$("#processbar-import .progress").css( 'width', pc*current+'%' );
			                            	}
			                            	
			                
			                           		if( current == ajaxes.length ){
			                           			opal_themecontrol_import_successfull();
			                           			
			                           		}
			                            },
			                            error: function (MLHttpRequest, textStatus, errorThrown){

			                            }
			                        });
		                    	}	 
	                    	}
	                    	importdata( ajaxes[current] );
	                    }  else { 

	                    	var $loop = 0; 
	                    	var $pc = 100; 
	                    	function importLoop( $action ){
	                    		$(".import-process-wrap").show();
	                    		$.ajax({
		                            type: 'POST',
		                            url: ajaxurl,
		                            dataType:'json',
		                            data: {
		                                action: $action,
		                                xml: 'content.xml',
		                                demo_source: demo_source,
		                                ajax:1,
		                                import_attachments: (attachmentImport ? 1 : 0)
		                            },
		                            success: function (data, textStatus, XMLHttpRequest){
		                            	if( data.loopnumber && $loop<= 0 ){
	
		                            		$pc = 100/data.loopnumber;
		                            	}
		                            	if(  data.loop == true ){
		                            		++$loop;
		                            		importLoop( $action );
		                            		$("#processbar-import .progress").css( 'width', $pc*$loop+'%' );
		                            	}else {
		    
		                            		$("#processbar-import .progress").css( 'width', '100%' );
		                            		opal_themecontrol_import_successfull();
		                            	}
	  
		                            },
		                            error: function (MLHttpRequest, textStatus, errorThrown){
		                            }
		                        });
		                        // console.log( $loop );

	                    	}
		                  	importLoop( $action  );  
	                    }    
                    }

                    return false;

                });
            });
        </script>
      

        </div>
     	<div class="clearfix"></div>
    <?php	}
}

Opal_Themecontrol_Import::getInstance();

require_once( dirname(__FILE__).'/ajax.php' );