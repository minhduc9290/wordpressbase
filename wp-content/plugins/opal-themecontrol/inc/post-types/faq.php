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
class OpalThemecontrol_PostType_FAQ{

    /**
    * init action and filter data to define menu post type
    */
    public static function init(){ 

        add_action( 'init', array( __CLASS__, 'create_type_faq' ) );
        //-- custom add column to list post
        add_filter( 'manage_faq_posts_columns',array(__CLASS__,'init_menu_columns'),10);
        add_action("manage_faq_posts_custom_column", array(__CLASS__, "show_menu_columns"), 10, 2);
        //----
        define( 'OPAL_THEMECONTROL_FAQ_PREFIX', 'faq_' );
    }

    /**
    * func register postype and taxonomy
    */
    public static function create_type_faq(){
        $labels = array(
            'name'               => __( 'FAQS', "opal-themecontrol" ),
            'singular_name'      => __( 'FAQ', "opal-themecontrol" ),
            'add_new'            => __( 'Add New FAQ', "opal-themecontrol" ),
            'add_new_item'       => __( 'Add New FAQ', "opal-themecontrol" ),
            'edit_item'          => __( 'Edit FAQ', "opal-themecontrol" ),
            'new_item'           => __( 'New FAQ', "opal-themecontrol" ),
            'view_item'          => __( 'View FAQ', "opal-themecontrol" ),
            'search_items'       => __( 'Search Faq', "opal-themecontrol" ),
            'not_found'          => __( 'No Faq found', "opal-themecontrol" ),
            'not_found_in_trash' => __( 'No Faq found in Trash', "opal-themecontrol" ),
            'parent_item_colon'  => __( 'Parent FAQ:', "opal-themecontrol" ),
            'menu_name'          => __( 'FAQ', "opal-themecontrol" ),
        );

        $labels = apply_filters( 'opalthemer_filter_postype_faq_labels' , $labels );
        $slug_field = opalthemecontrol_get_option( 'slug_faq' );
        $slug = ($slug_field != false) ? $slug_field : "faq";

        $args = array(
            'labels'            	=> $labels,
            'hierarchical'      	=> true,
            'description'       	=> 'List FAQ',
            'supports' 				=> array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats'),
            'public'            	=> true,
            'show_ui'           	=> true,
            'show_in_menu'      	=> true,
            'menu_position'     	=> 5,
            'show_in_nav_menus' 	=> false,
            'exclude_from_search'   => false,
            'has_archive'           => true,
            'query_var'             => true,
            'can_export'            => true,
            'rewrite'               => array( 'slug' => $slug),
            'capability_type'       => 'post',
            'menu_icon'             => 'dashicons-money',
            'publicly_queryable'    => false, //disable view
        );
        $args = apply_filters( 'opalthemer_filter_postype_faq_args' , $args );
        register_post_type( 'faq', $args );

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
        $labels = apply_filters( 'opalthemer_filter_taxonomy_faq_labels' , $labels );
        // Now register the taxonomy
        register_taxonomy('category_faq',array('faq'),
            array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'show_in_nav_menus' => false,
                'rewrite'           => array( 'slug' => 'category-faq'),
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
        $columns = array_slice($columns, 0, 1, true) + array(OPAL_THEMECONTROL_FAQ_PREFIX .'thumb' => __("Image", 'opal-themecontrol')) + array_slice($columns, 1, count($columns) - 1, true);
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
            case OPAL_THEMECONTROL_FAQ_PREFIX .'thumb':
                echo '<a href="' . get_edit_post_link($post->ID) . '">' . get_the_post_thumbnail($post_ID,array( 100, 100)) . '</a>';
            break;
        }
    }


}// end Classs

OpalThemecontrol_PostType_FAQ::init();



