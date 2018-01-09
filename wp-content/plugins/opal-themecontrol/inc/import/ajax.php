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

class Opal_Themecontrol_Import_Ajax{

	public static $batch;
	/**
	 * Init ajax function to import data
	 */
	public static function init(){

		$actions = array(
			'opal_themecontrol_contentImport',
			'opal_themecontrol_allImport',
			'opal_themecontrol_metaImport',
			'opal_themecontrol_vc_templatesImport',
			'opal_themecontrol_rev_sliderImport',
			'opal_themecontrol_essential_gridImport',
			'opal_themecontrol_customizer_optionsImport',
			'opal_themecontrol_page_optionsImport',
			'opal_themecontrol_menusImport',
			'opal_themecontrol_widgetsImport'
		);

		foreach( $actions as $action ){
			add_action('wp_ajax_' . trim($action) ,  array( __CLASS__ , trim($action) ) );
			add_action( 'wp_ajax_nopriv_'.trim($action), array( __CLASS__, trim($action)) );

		}
		self::$batch = false ;
	}

	/**
	 *
	 */
	public static function opal_themecontrol_allImport(){ 
		return self::opal_themecontrol_contentImport();
	}

	/**
	 *
	 */
	public static function opal_themecontrol_contentImport(){
 		
		$importObj = Opal_Themecontrol_Import::getInstance();

		if ($_POST['import_attachments'] == 1)
			{$importObj->attachments = true;}
		else
			{$importObj->attachments = false;}

		$folder = $_POST['demo_source']."/";

		$ouput = $importObj->import_content($folder.$_POST['xml']);
		echo json_encode( $ouput );
		die("ahsdsd");
	}

	/**
	 *
	 */
	public static function opal_themecontrol_metaImport()
	{
		self::$batch = true ;
		$importObj = Opal_Themecontrol_Import::getInstance();
		
		

		$folder = $_POST['demo_source'] . "/";

		$import_types = apply_filters( 'opal_themecontrol_import_types', array() );
		if( isset($import_types['content']) ){
			unset( $import_types['content'] );
		}
		if( isset($import_types['all']) ){
			unset( $import_types['all'] );
		}

			
		if( $import_types ){
			foreach(  $import_types as $type => $value ){
				$method =  "opal_themecontrol_".$type."Import";		 
				if( method_exists( __CLASS__ , $method) ){
					 Opal_Themecontrol_Import_Ajax::$method();  
				}
			}	
		}

		die('okokokok');
	}

	/**
	 *
	 */
	public static function opal_themecontrol_vc_templatesImport()
	{
		$importObj = Opal_Themecontrol_Import::getInstance();

		$importObj->attachments = true;

		$ouput  = $importObj->import_content_vc($_POST['demo_source'] . "/vc_templates.xml");

		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public static function opal_themecontrol_rev_sliderImport()
	{	
		$importObj = Opal_Themecontrol_Import::getInstance();

		$ouput = $importObj->import_rev_slider($_POST['demo_source']);

		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public static function opal_themecontrol_essential_gridImport()
	{
		$importObj = Opal_Themecontrol_Import::getInstance();

		$ouput = $importObj->import_essential_grid($_POST['demo_source'] . '/essential_grid.txt');

		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public function opal_themecontrol_customizer_optionsImport()
	{
		$importObj = Opal_Themecontrol_Import::getInstance();

		$ouput = $importObj->import_customizer_options($_POST['demo_source'] . '/skins/Skin 1.txt');

		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public static function opal_themecontrol_page_optionsImport()
	{
		$importObj = Opal_Themecontrol_Import::getInstance();

		$importObj->import_page_options($_POST['demo_source'] . '/page_options.txt');

		$ouput = $importObj->import_theme_options( $_POST['demo_source'] . '/options.txt' );
		
		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public static function opal_themecontrol_menusImport()
	{
		$importObj = Opal_Themecontrol_Import::getInstance();

		$ouput  = $importObj->import_menus($_POST['demo_source'] . '/menus.txt');

		echo json_encode( $ouput ); exit;
	}

	/**
	 *
	 */
	public static function opal_themecontrol_widgetsImport() {

		$importObj = Opal_Themecontrol_Import::getInstance();

		$folder = $_POST['demo_source']."/";

		$importObj->import_widgets($folder.'widgets.txt');

		// Import widget logic
		$ouput = $importObj->import_widget_logic( $folder.'widget_logic_options.txt' );

		echo json_encode( $ouput ); exit;
	}
}

Opal_Themecontrol_Import_Ajax::init();