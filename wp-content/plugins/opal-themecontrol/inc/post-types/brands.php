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
class OpalThemecontrol_PostType_Brands{

    /**
    * init action and filter data to define menu post type
    */
    public static function init(){ 

        add_action( 'init', array( __CLASS__, 'opalthemecontrol_create_type_brands' ) );
        //-- custom add column to list post
        add_filter( 'manage_brands_posts_columns',array(__CLASS__,'init_menu_columns'),10);
        add_action("manage_brands_posts_custom_column", array(__CLASS__, "show_menu_columns"), 10, 2);
        //----
        add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
        //----
        define( 'OPAL_THEMECONTROL_BRAND_PREFIX', 'brands_' );
    }

    /**
    * func register postype and taxonomy
    */
    public static function opalthemecontrol_create_type_brands(){
        $labels = array(
            'name'               => __( 'Brand Logos', "opal-themecontrol" ),
            'singular_name'      => __( 'Brand', "opal-themecontrol" ),
            'add_new'            => __( 'Add New Brand', "opal-themecontrol" ),
            'add_new_item'       => __( 'Add New Brand', "opal-themecontrol" ),
            'edit_item'          => __( 'Edit Brand', "opal-themecontrol" ),
            'new_item'           => __( 'New Brand', "opal-themecontrol" ),
            'view_item'          => __( 'View Brand', "opal-themecontrol" ),
            'search_items'       => __( 'Search Brands', "opal-themecontrol" ),
            'not_found'          => __( 'No Brands found', "opal-themecontrol" ),
            'not_found_in_trash' => __( 'No Brands found in Trash', "opal-themecontrol" ),
            'parent_item_colon'  => __( 'Parent Brand:', "opal-themecontrol" ),
            'menu_name'          => __( 'Brands', "opal-themecontrol" ),
        );

        $labels = apply_filters( 'opalthemer_filter_postype_brands_labels' , $labels );
        $slug_field = opalthemecontrol_get_option( 'slug_brands' );
        $slug = ($slug_field != false) ? $slug_field : "brands";

        $args = array(
            'labels'                => $labels,
            'hierarchical'          => true,
            'description'           => 'List Brands',
            'supports'              => array( 'title', 'thumbnail'),
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_nav_menus'     => false,
            'exclude_from_search'   => false,
            'has_archive'           => true,
            'query_var'             => true,
            'can_export'            => true,
            'rewrite'               => array( 'slug' => $slug),
            'capability_type'       => 'post',
            'menu_icon'             => 'dashicons-nametag',
            'publicly_queryable'    => false, //disable view
        );
        $args = apply_filters( 'opalthemer_filter_postype_brands_args' , $args );
        register_post_type( 'brands', $args );
    }// end func



    /**
    * Add custom taxonomy columns
    *
    * @param $columns
    *
    * @return array
    */
    public static function init_menu_columns($columns) {
        $columns = array_slice($columns, 0, 1, true) + array(OPAL_THEMECONTROL_BRAND_PREFIX .'thumb' => __("Image", 'opal-themecontrol')) + array_slice($columns, 1, count($columns) - 1, true);
        return $columns;
    }

    /**
    * Add content to custom column
    *
    * @param $column
    */
    public static function show_menu_columns($column, $post_ID) {
        global $post;
        switch ($column) {
            case OPAL_THEMECONTROL_BRAND_PREFIX .'thumb':
                echo '<a href="' . get_edit_post_link($post->ID) . '">' . get_the_post_thumbnail($post_ID,array( 100, 100)) . '</a>';
            break;
        }
    }

    /**
    *
    */
    public static function metaboxes( array $metaboxes ) {
        $prefix = OPAL_THEMECONTROL_BRAND_PREFIX;     
        $metaboxes[ $prefix . 'managements' ] = array(
            'id'                        => $prefix . 'standard-brands',
            'title'                     => __( 'Brand Setting', "opal-themecontrol" ),
            'object_types'              => array( 'brands' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => self::opal_themecontrol_func_metaboxes_brands_fields()
        );
        return $metaboxes;
    }// end function


    /**
     * Register Metabox 
    */
    public static function opal_themecontrol_func_metaboxes_brands_fields(){

        /**
         * prefix of meta keys (optional)
         * Use underscore (_) at the beginning to make keys hidden
         * Alt.: You also can make prefix empty to disable it
         */

        // Better has an underscore as last sign
        $prefix = OPAL_THEMECONTROL_BRAND_PREFIX;
        $fields =  array(
            array(
                'name' => __( 'Brand Link', "opal-themecontrol" ),
                'id'   => "{$prefix}brand_link",
                'type' => 'text',
                'default' => '#',
                'description' => __('Enter Link To', "opal-themecontrol")
            ), 
        ); 


        return apply_filters( 'opal_themecontrol_func_metaboxes_brands_fields', $fields );
    }//end function

}// end Classs

OpalThemecontrol_PostType_Brands::init();



