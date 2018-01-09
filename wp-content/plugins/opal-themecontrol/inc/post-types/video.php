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
class OpalThemecontrol_PostType_Video{

    /**
    * init action and filter data to define menu post type
    */
    public static function init(){ 

        add_action( 'init', array( __CLASS__, 'opalthemecontrol_create_type_video' ) );
        //-- custom add column to list post
        add_filter( 'manage_video_posts_columns',array(__CLASS__,'init_menu_columns'),10);
        add_action("manage_video_posts_custom_column", array(__CLASS__, "show_menu_columns"), 10, 2);
        //----
        add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
        //----
        define( 'OPAL_THEMECONTROL_VIDEO_PREFIX', 'video_' );
    }

    /**
    * func load script 
    */
    public static function video_scripts($hook) {
        wp_enqueue_script( 'video_js',  OPAL_THEMECONTROL_PLUGIN_URL.'assets/js/video.js' );
    }

    /**
    * func register postype and taxonomy
    */
    public static function opalthemecontrol_create_type_video(){
        $labels = array(
            'name'               => __( 'Videos', "opal-themecontrol" ),
            'singular_name'      => __( 'Video', "opal-themecontrol" ),
            'add_new'            => __( 'Add New Video', "opal-themecontrol" ),
            'add_new_item'       => __( 'Add New Video', "opal-themecontrol" ),
            'edit_item'          => __( 'Edit Video', "opal-themecontrol" ),
            'new_item'           => __( 'New Video', "opal-themecontrol" ),
            'view_item'          => __( 'View Video', "opal-themecontrol" ),
            'search_items'       => __( 'Search Videos', "opal-themecontrol" ),
            'not_found'          => __( 'No Videos found', "opal-themecontrol" ),
            'not_found_in_trash' => __( 'No Videos found in Trash', "opal-themecontrol" ),
            'parent_item_colon'  => __( 'Parent Video:', "opal-themecontrol" ),
            'menu_name'          => __( 'Videos', "opal-themecontrol" ),
        );

        $labels = apply_filters( 'opalthemer_filter_postype_video_labels' , $labels );
        $slug_field = opalthemecontrol_get_option( 'slug_video' );
        $slug = ($slug_field != false) ? $slug_field : "video";

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => true,
            'description'         => 'List Video',
            'supports'            => array( 'title', 'thumbnail','comments', 'excerpt' ),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'show_in_nav_menus'   => true,
            'exclude_from_search' => false,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => array( 'slug' => $slug),
            'capability_type'     => 'post',
            'menu_icon'           => 'dashicons-format-video',
            'publicly_queryable'  => false, //disable view
        );
        $args = apply_filters( 'opalthemer_filter_postype_video_args' , $args );
        register_post_type( 'video', $args );

        // Add new taxonomy, make it hierarchical like categories
        //first do the translations part for GUI
        $labels = array(
            'name'              => __( 'Categories', "opal-themecontrol" ),
            'singular_name'     => __( 'Category', "opal-themecontrol" ),
            'search_items'      => __( 'Search Category', "opal-themecontrol" ),
            'all_items'         => __( 'All Categories', "opal-themecontrol" ),
            'parent_item'       => __( 'Parent Category', "opal-themecontrol" ),
            'parent_item_colon' => __( 'Parent Category:', "opal-themecontrol" ),
            'edit_item'         => __( 'Edit Category', "opal-themecontrol" ),
            'update_item'       => __( 'Update Category', "opal-themecontrol" ),
            'add_new_item'      => __( 'Add New Category', "opal-themecontrol" ),
            'new_item_name'     => __( 'New Category Name', "opal-themecontrol" ),
            'menu_name'         => __( 'Categories', "opal-themecontrol" ),
        );
        $labels = apply_filters( 'opalthemer_filter_taxonomy_video_labels' , $labels );
        // Now register the taxonomy
        register_taxonomy('category_video',array('video'),
            array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'show_in_nav_menus' =>false,
                'rewrite'           => array( 'slug' => 'category-video'),
            )
        );
    }// end func



    /**
    * Add custom taxonomy columns
    *
    * @param $columns
    *
    * @return array
    */
    public static function init_menu_columns($columns) {
        $columns = array_slice($columns, 0, 1, true) + array(OPAL_THEMECONTROL_VIDEO_PREFIX .'thumb' => __("Image", 'opal-themecontrol')) + array_slice($columns, 1, count($columns) - 1, true);
        $columns = array_slice($columns, 0, 3, true) + array('category_video' => __("Categories", 'opal-themecontrol')) + array_slice($columns, 3, count($columns) - 1, true);
        return $columns;
    }

    /**
    * Add content to custom column
    *
    * @param $column
    */
    public static function show_menu_columns($column, $post_ID) {

        $category_name = "category_video";
        global $post;
        switch ($column) {
            case $category_name:
                $listname = Opalthemecontrol_Query::get_the_term_filter_name($post, $category_name);
                foreach ($listname as $name) {
                    $names = $name.'/';
                    if ($name === end($listname)){
                        $names = $name;
                    }
                    echo $names;
                }
            break;
            case OPAL_THEMECONTROL_VIDEO_PREFIX .'thumb':
                echo '<a href="' . get_edit_post_link($post->ID) . '">' . get_the_post_thumbnail($post_ID,array( 100, 100)) . '</a>';
            break;
        }
    }

    /**
    *
    */
    public static function metaboxes( array $metaboxes ) {
        $prefix = OPAL_THEMECONTROL_VIDEO_PREFIX;     
        $metaboxes[ $prefix . 'managements' ] = array(
            'id'                        => $prefix . 'standard-video',
            'title'                     => __( 'Video Setting', "opal-themecontrol" ),
            'object_types'              => array( 'video' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => self::opal_themecontrol_func_metaboxes_video_fields()
        );
        return $metaboxes;
    }// end function


    /**
    * Register Metabox 
    */
    public static function opal_themecontrol_func_metaboxes_video_fields(){

        /**
         * prefix of meta keys (optional)
         * Use underscore (_) at the beginning to make keys hidden
         * Alt.: You also can make prefix empty to disable it
         */

        // Better has an underscore as last sign
        $prefix = OPAL_THEMECONTROL_VIDEO_PREFIX;
        $fields =  array(
            //Links
            array(
                'name' => __( 'Video Link', "opal-themecontrol" ),
                'id'   => "{$prefix}video_link",
                'type' => 'text',
                'description' => __('Support Show Video From Youtube and Vimeo', "opal-themecontrol")
            ), 
        ); 
        return apply_filters( 'opal_themecontrol_func_metaboxes_video_fields', $fields );
    }//end function

}// end Classs

OpalThemecontrol_PostType_Video::init();



