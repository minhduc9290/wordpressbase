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
class OpalThemecontrol_PostType_Team{

    /**
    * init action and filter data to define menu post type
    */
    public static function init(){ 

        add_action( 'init', array( __CLASS__, 'opalthemecontrol_create_type_team' ) );
        //-- custom add column to list post
        add_filter( 'manage_team_posts_columns',array(__CLASS__,'init_menu_columns'),10);
        add_action("manage_team_posts_custom_column", array(__CLASS__, "show_menu_columns"), 10, 2);
        //----
        add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
        //----
        define( 'OPAL_THEMECONTROL_TEAM_PREFIX', 'team_' );
    }

    /**
    * func register postype and taxonomy
    */
    public static function opalthemecontrol_create_type_team(){
        $labels = array(
            'name'               => __( 'Teams', "opal-themecontrol" ),
            'singular_name'      => __( 'Team', "opal-themecontrol" ),
            'add_new'            => __( 'Add New Team', "opal-themecontrol" ),
            'add_new_item'       => __( 'Add New Team', "opal-themecontrol" ),
            'edit_item'          => __( 'Edit Team', "opal-themecontrol" ),
            'new_item'           => __( 'New Team', "opal-themecontrol" ),
            'view_item'          => __( 'View Team', "opal-themecontrol" ),
            'search_items'       => __( 'Search Teams', "opal-themecontrol" ),
            'not_found'          => __( 'No Teams found', "opal-themecontrol" ),
            'not_found_in_trash' => __( 'No Teams found in Trash', "opal-themecontrol" ),
            'parent_item_colon'  => __( 'Parent Team:', "opal-themecontrol" ),
            'menu_name'          => __( 'Teams', "opal-themecontrol" ),
        );

        $labels = apply_filters( 'opalthemer_filter_postype_team_labels' , $labels );
        $slug_field = opalthemecontrol_get_option( 'slug_team' );
        $slug = ($slug_field != false) ? $slug_field : "team";

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => true,
            'description'         => 'List Team',
            'supports'            => array( 'title', 'editor', 'author', 'thumbnail','excerpt'  ), //page-attributes, post-formats
            'taxonomies'          => array( 'category_team'  ),
            'post-formats'        => array( 'aside', 'image', 'quote' ) ,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'show_in_nav_menus'   => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => array( 'slug' => $slug),
            'capability_type'     => 'post',
            'menu_icon'           => 'dashicons-id',
        );
        $args = apply_filters( 'opalthemer_filter_postype_team_args' , $args );
        register_post_type( 'team', $args );

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
        $labels = apply_filters( 'opalthemer_filter_taxonomy_team_labels' , $labels );
        // Now register the taxonomy
        register_taxonomy('category_team',array('team'),
            array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'show_in_nav_menus' =>false,
                'rewrite'           => array( 'slug' => 'category-team'),
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
    $columns = array_slice($columns, 0, 1, true) + array(OPAL_THEMECONTROL_TEAM_PREFIX .'thumb' => __("Image", 'opal-themecontrol')) + array_slice($columns, 1, count($columns) - 1, true);
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
          case OPAL_THEMECONTROL_TEAM_PREFIX .'thumb':
            echo '<a href="' . get_edit_post_link($post->ID) . '">' . get_the_post_thumbnail($post_ID,array( 100, 100)) . '</a>';
            break;
        }
    }

    /**
    *
    */
    public static function metaboxes( array $metaboxes ) {
        $prefix = OPAL_THEMECONTROL_TEAM_PREFIX;     
        $metaboxes[ $prefix . 'managements' ] = array(
          'id'                        => $prefix . 'standard-team',
          'title'                     => __( 'Team Setting', "opal-themecontrol" ),
          'object_types'              => array( 'team' ),
          'context'                   => 'normal',
          'priority'                  => 'high',
          'show_names'                => true,
          'fields'                    => self::opal_themecontrol_func_metaboxes_team_fields()
        );
        return $metaboxes;
    }// end function


    /**
     * Register Metabox 
    */
    public static function opal_themecontrol_func_metaboxes_team_fields(){

        /**
         * prefix of meta keys (optional)
         * Use underscore (_) at the beginning to make keys hidden
         * Alt.: You also can make prefix empty to disable it
         */

        // Better has an underscore as last sign
        $prefix = OPAL_THEMECONTROL_TEAM_PREFIX;
        $fields =  array(
            // COLOR
            array(
            'name' => __( 'Job', "opalthemer-themer" ),
            'id'   => "{$prefix}job",
            'type' => 'text',
            'description' => __('Enter Job example CEO, CTO', "opalthemer-themer")
          ), 

          array(
            'name'             => __( 'Address', "opalthemer-themer" ),
            'id'               => "{$prefix}address",
            'type'             => 'textarea',
            'cols'             => '30'
          ),

          array(
            'name'             => __( 'Phone Number', "opalthemer-themer" ),
            'id'               => "{$prefix}phone_number",
            'type'             => 'text',
          ),

          array(
            'name'             => __( 'Mobile Number', "opalthemer-themer" ),
            'id'               => "{$prefix}mobile",
            'type'             => 'text',
          ),

          array(
            'name'             => __( 'Fax Number', "opalthemer-themer" ),
            'id'               => "{$prefix}fax",
            'type'             => 'text',
          ),

          array(
            'name'             => __( 'Email', "opalthemer-themer" ),
            'id'               => "{$prefix}email",
            'type'             => 'text',
          ),

          array(
            'name'             => __( 'Web', "opalthemer-themer" ),
            'id'               => "{$prefix}web",
            'type'             => 'text',
          ),

          array(
            'name' => __( 'Google Plus Link', "opalthemer-themer" ),
            'id'   => "{$prefix}google",
            'type' => 'text',
            'description' => __('Enter google', "opalthemer-themer")
          ), 

          array(
            'name' => __( 'Facebook Link', "opalthemer-themer" ),
            'id'   => "{$prefix}facebook",
            'type' => 'text',
            'description' => __('Enter facebook', "opalthemer-themer")
          ), 

          array(
            'name' => __( 'Twitter', "opalthemer-themer" ),
            'id'   => "{$prefix}twitter",
            'type' => 'text',
            'description' => __('Enter Twitter', "opalthemer-themer")
          ), 

          array(
            'name' => __( 'Printest', "opalthemer-themer" ),
            'id'   => "{$prefix}pinterest",
            'type' => 'text',
            'description' => __('Enter pinterest', "opalthemer-themer")
          ),

        ); 


        return apply_filters( 'opal_themecontrol_func_metaboxes_team_fields', $fields );
    }//end function

}// end Classs

OpalThemecontrol_PostType_Team::init();



