<?php
/**
 * @version    1.0
 * @package    Kage_Kakashi
 * @author     Mr-DucPham <minhduc9290@gmail.com>
 * @copyright  Copyright (C) 2014 Ducpham.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.ducpham.com
 */

 Class Kage_Kakashi {
     /**
 	 * Variable to hold class prefix supported for autoloading.
 	 *
 	 * @var  string
 	 */
     protected $prifix = 'kage-kakashi';
     /**
      * initialize
      */
     public static function initialize(){

     }

     /**
      * Autoloader
      */
      public static function autoload(){
          global $kage_kakashi_options;
          // include admin options
          //$this->_include('/inc/admin/register_setting');

          // include mixes functions
          //$this->_include('mixes-functions');

      }

      /**
       * Include a file
       *
       * @param string
       * @param bool
       * @param array
       */
  	public function _include( $file, $root = true, $args = array(), $unique = true ){
        $file = $file.'.php';
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
      public function plugin_path( $sub = '' ){
      	if( ! $this->_plugin_path ) {
      		$this->_plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
      	}
      	return $this->_plugin_path . '/' . $sub;
      }
 }
?>
