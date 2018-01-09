<?php
/**
* $Desc
*
* @version    $Id$
* @package    wpbase
* @author     WPOPAL <opalwordpress@gmail.com >
* @copyright  Copyright (C) 2015 prestabrain.com. All Rights Reserved.
* @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*
* @website  http://www.opalthemer.com
* @support  http://www.opalthemer.com/questions/
*/
 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
class OpalThemecontrol_PostType_Footer{

    /**
   * init action and filter data to define menu post type
   */
    public static function init(){ 

        add_action( 'init', array( __CLASS__, 'opalthemecontrol_create_type_footer' ) );
        //----
        define( 'OPAL_THEMECONTROL_FOOTER_PREFIX', 'footer_' );
    }

    /**
    * func register postype and taxonomy
    */
    public static function opalthemecontrol_create_type_footer(){
        $labels = array(
            'name'               => __( 'Footers', "opal-themecontrol" ),
            'singular_name'      => __( 'Footer', "opal-themecontrol" ),
            'add_new'            => __( 'Add New Footer', "opal-themecontrol" ),
            'add_new_item'       => __( 'Add New Footer', "opal-themecontrol" ),
            'edit_item'          => __( 'Edit Footer', "opal-themecontrol" ),
            'new_item'           => __( 'New Footer', "opal-themecontrol" ),
            'view_item'          => __( 'View Footer', "opal-themecontrol" ),
            'search_items'       => __( 'Search Footers', "opal-themecontrol" ),
            'not_found'          => __( 'No Footers found', "opal-themecontrol" ),
            'not_found_in_trash' => __( 'No Footers found in Trash', "opal-themecontrol" ),
            'parent_item_colon'  => __( 'Parent Footer:', "opal-themecontrol" ),
            'menu_name'          => __( 'Footers', "opal-themecontrol" ),
        );

        $labels = apply_filters( 'opalthemer_filter_postype_footer_labels' , $labels );
        $slug_field = opalthemecontrol_get_option( 'slug_footer' );
        $slug = ($slug_field != false) ? $slug_field : "footer";

        $args = array(
            'labels'                => $labels,
            'hierarchical'          => true,
            'description'           => 'List Footer',
            'supports'              => array( 'title', 'editor'),
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_nav_menus'     => false,
            'exclude_from_search'   => false,
            'has_archive'           => false,
            'query_var'             => true,
            'can_export'            => true,
            'rewrite'               => array( 'slug' => $slug),
            'menu_icon'             => 'dashicons-editor-kitchensink',
            'publicly_queryable'    => false, //disable view
        );
        $args = apply_filters( 'opalthemer_filter_postype_footer_args' , $args );
        register_post_type( 'footer', $args );

        if($options = get_option('wpb_js_content_types')){
            $check = true;
            foreach ($options as $key => $value) {
                if($value=='footer') $check=false;
            }
            if($check)
                $options[] = 'footer';
            update_option( 'wpb_js_content_types',$options );
        }else{
            $options = array('page','footer');
        }
    }// end func

}// end Classs

OpalThemecontrol_PostType_Footer::init();



