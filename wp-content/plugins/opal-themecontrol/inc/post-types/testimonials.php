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
class OpalThemecontrol_PostType_Testimonials{

   
    /**
    * init action and filter data to define menu post type
    */
    public static function init(){ 

        add_action( 'init', array( __CLASS__, 'create_type_testimonials' ) );
        //-- custom add column to list post
        add_filter( 'manage_testimonials_posts_columns',array(__CLASS__,'init_menu_columns'),10);
        add_action("manage_testimonials_posts_custom_column", array(__CLASS__, "show_menu_columns"), 10, 2);
        //----
        add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
        //----
        define( 'OPAL_THEMECONTROL_TESTIMONIAL_PREFIX', 'testimonials_' );
    }

    /**
    * func register postype and taxonomy
    */
    public static function create_type_testimonials(){
        $labels = array(
            'name'               => __( 'Testimonials', "opal-themecontrol" ),
            'singular_name'      => __( 'Testimonial', "opal-themecontrol" ),
            'add_new'            => __( 'Add New Testimonial', "opal-themecontrol" ),
            'add_new_item'       => __( 'Add New Testimonial', "opal-themecontrol" ),
            'edit_item'          => __( 'Edit Testimonial', "opal-themecontrol" ),
            'new_item'           => __( 'New Testimonial', "opal-themecontrol" ),
            'view_item'          => __( 'View Testimonial', "opal-themecontrol" ),
            'search_items'       => __( 'Search Testimonials', "opal-themecontrol" ),
            'not_found'          => __( 'No Testimonials found', "opal-themecontrol" ),
            'not_found_in_trash' => __( 'No Testimonials found in Trash', "opal-themecontrol" ),
            'parent_item_colon'  => __( 'Parent Testimonial:', "opal-themecontrol" ),
            'menu_name'          => __( 'Testimonials', "opal-themecontrol" ),
        );

        $labels = apply_filters( 'opalthemer_filter_postype_testimonial_labels' , $labels );
        $slug_field = opalthemecontrol_get_option( 'slug_testimonial' );
        $slug = ($slug_field != false) ? $slug_field : "testimonial";

        $args = array(
            'labels'                => $labels,
            'hierarchical'          => true,
            'description'           => 'List Testimonial',
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
            'menu_icon'             => 'dashicons-testimonial',
            'publicly_queryable'    => false, //disable view
        );
        $args = apply_filters( 'opalthemer_filter_postype_testimonial_args' , $args );
        register_post_type( 'testimonials', $args );
    }// end func



    /**
   * Add custom taxonomy columns
   *
   * @param $columns
   *
   * @return array
   */
  public static function init_menu_columns($columns) {
    $columns = array_slice($columns, 0, 1, true) + array(OPAL_THEMECONTROL_TESTIMONIAL_PREFIX .'thumb' => __("Image", 'opal-themecontrol')) + array_slice($columns, 1, count($columns) - 1, true);
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
            case OPAL_THEMECONTROL_TESTIMONIAL_PREFIX .'thumb':
                echo '<a href="' . get_edit_post_link($post->ID) . '">' . get_the_post_thumbnail($post_ID,array( 100, 100)) . '</a>';
            break;
        }
    }

    /**
    *
    */
    public static function metaboxes( array $metaboxes ) {
        $prefix = OPAL_THEMECONTROL_TESTIMONIAL_PREFIX;     
        $metaboxes[ $prefix . 'managements' ] = array(
            'id'                        => $prefix . 'standard-testimonials',
            'title'                     => __( 'Testimonial Setting', "opal-themecontrol" ),
            'object_types'              => array( 'testimonials' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => self::opal_themecontrol_func_metaboxes_testimonials_fields()
        );
        return $metaboxes;
    }// end function


    /**
     * Register Metabox 
    */
    public static function opal_themecontrol_func_metaboxes_testimonials_fields(){

        /**
         * prefix of meta keys (optional)
         * Use underscore (_) at the beginning to make keys hidden
         * Alt.: You also can make prefix empty to disable it
         */

        // Better has an underscore as last sign
        $prefix = OPAL_THEMECONTROL_TESTIMONIAL_PREFIX;
        $fields =  array(
            array(
                'name' => __( 'Job', "opal-themecontrol" ),
                'id'   => "{$prefix}job",
                'type' => 'text',
                'description' => __('Enter Job example CEO, CTO', "opal-themecontrol")
            ), 

            array(
                'name' => __( 'Link', "opal-themecontrol" ),
                'id'   => "{$prefix}link",
                'type' => 'text',
                'description' => __('Enter Link to this personal', "opal-themecontrol")
            ), 
        ); 


        return apply_filters( 'opal_themecontrol_func_metaboxes_testimonials_fields', $fields );
    }//end function

}// end Classs

OpalThemecontrol_PostType_Testimonials::init();



