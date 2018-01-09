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
class OpalThemecontrol_PostType_Portfolio{

    /**
    * init action and filter data to define menu post type
    */
    public static function init(){ 

        add_action( 'init', array( __CLASS__, 'create_type_portfolio' ) );
        //-- custom add column to list post
        add_filter( 'manage_portfolio_posts_columns',array(__CLASS__,'init_menu_columns'),10);
        add_action( 'manage_portfolio_posts_custom_column', array(__CLASS__, "show_menu_columns"), 10, 2);
        //----
        add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
        //----
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'portfolio_scripts' ) );
        //----
        define( 'OPAL_THEMECONTROL_PORTFOLIO_PREFIX', 'portfolio_' );
    }

    /**
    * func load script 
    */
    public static function portfolio_scripts($hook) {
        wp_enqueue_script( 'portfolio_js',  OPAL_THEMECONTROL_PLUGIN_URL.'assets/js/portfolio.js' );
    }

    /**
    * func register postype and taxonomy
    */
    public static function create_type_portfolio(){
        $labels = array(
            'name'               => __( 'Portfolios', "opal-themecontrol" ),
            'singular_name'      => __( 'Portfolio', "opal-themecontrol" ),
            'add_new'            => __( 'Add New Portfolio', "opal-themecontrol" ),
            'add_new_item'       => __( 'Add New Portfolio', "opal-themecontrol" ),
            'edit_item'          => __( 'Edit Portfolio', "opal-themecontrol" ),
            'new_item'           => __( 'New Portfolio', "opal-themecontrol" ),
            'view_item'          => __( 'View Portfolio', "opal-themecontrol" ),
            'search_items'       => __( 'Search Portfolios', "opal-themecontrol" ),
            'not_found'          => __( 'No Portfolios found', "opal-themecontrol" ),
            'not_found_in_trash' => __( 'No Portfolios found in Trash', "opal-themecontrol" ),
            'parent_item_colon'  => __( 'Parent Portfolio:', "opal-themecontrol" ),
            'menu_name'          => __( 'Portfolios', "opal-themecontrol" ),
        );

        $labels = apply_filters( 'opalthemer_filter_postype_portfolio_labels' , $labels );
        $slug_field = opalthemecontrol_get_option( 'slug_portfolio' );
        $slug = ($slug_field != false) ? $slug_field : "portfolio";

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => true,
            'description'         => 'List Portfolio',
            'supports'            => array( 'title', 'editor', 'author', 'thumbnail','excerpt'  ), //page-attributes, post-formats
            'taxonomies'          => array( 'portfolio_category'  ),
            'post-formats'        => array( 'aside', 'image', 'quote' ) ,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => array( 'slug' => $slug),
            'capability_type'     => 'post',
            'menu_icon'           => 'dashicons-images-alt',
        );
        $args = apply_filters( 'opalthemer_filter_postype_portfolio_args' , $args );
        register_post_type( 'portfolio', $args );

        //Add Portfolio Skill
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
        $labels = apply_filters( 'opalthemer_filter_taxonomy_portfolio_labels' , $labels );
        // Now register the taxonomy
        register_taxonomy('category_portfolio',array('portfolio'),
            array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'show_in_nav_menus' =>false,
                'rewrite'           => array( 'slug' => 'category-portfolio'),
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
        $columns = array_slice($columns, 0, 1, true) + array(OPAL_THEMECONTROL_PORTFOLIO_PREFIX .'thumb' => __("Image", 'opal-themecontrol')) + array_slice($columns, 1, count($columns) - 1, true);
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
          case OPAL_THEMECONTROL_PORTFOLIO_PREFIX .'thumb':
            echo '<a href="' . get_edit_post_link($post->ID) . '">' . get_the_post_thumbnail($post_ID,array( 100, 100)) . '</a>';
            break;
        }
    }

    /**
    *
    */
    public static function metaboxes( array $metaboxes ) {
        $prefix = OPAL_THEMECONTROL_PORTFOLIO_PREFIX;     
        $metaboxes[ $prefix . 'managements' ] = array(
            'id'                        => $prefix . 'standard-portfolio',
            'title'                     => __( 'Portfolio Setting', "opal-themecontrol" ),
            'object_types'              => array( 'portfolio' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => self::opal_themecontrol_func_metaboxes_portfolio_fields()
        );
        return $metaboxes;
    }// end function


    /**
     * Register Metabox 
    */
    public static function opal_themecontrol_func_metaboxes_portfolio_fields(){

        /**
         * prefix of meta keys (optional)
         * Use underscore (_) at the beginning to make keys hidden
         * Alt.: You also can make prefix empty to disable it
         */

        // Better has an underscore as last sign
        $prefix = OPAL_THEMECONTROL_PORTFOLIO_PREFIX;
        $fields =  array(
            // COLOR
            array(
                'name' => __( 'Job', "opalrestaurant" ),
                'id'   => "{$prefix}job",
                'type' => 'text',
                'description' => __('Enter Job example CEO, CTO', "opalrestaurant")
            ), 
            array(
                'name'        => __( 'Layout Fullwidth ?', "opal-themecontrol" ),
                'id'          => "{$prefix}check",
                'type'        => 'checkbox',
            ),

            array(
                'name'        => __( 'Select Layout', "opal-themecontrol" ),
                'id'          => "{$prefix}layout",
                'type'        => 'select',
                'options'     => opal_themecontrol_get_content_portfolio_layouts(),
                'default'        => 'default', // Default value, optional
            ),

            array(
                'name' => __( 'Video Link', "opal-themecontrol" ),
                'id'   => "{$prefix}video_link",
                'type' => 'text',
                'description' => __('Support Show Video From Youtube and Vimeo', "opal-themecontrol")
            ), 

            // THICKBOX IMAGE UPLOAD (WP 3.3+)
            // FILE ADVANCED (WP 3.5+)
            array(
                'name'             => __( 'Gallery Images', "opal-themecontrol" ),
                'id'               => "{$prefix}file_advanced",
                'type'             => 'file_list',
                'description' => __('Using for Gallery and Slideshow', "opalrestaurant")
            ),

             array(
                'name'             => __( 'Image', "opal-themecontrol" ),
                'id'               => "{$prefix}image",
                'type'             => 'file',
            ),
	        array(
		        'name'             => __( 'Image Height', "opal-themecontrol" ),
		        'id'               => "{$prefix}image_height",
		        'type'             => 'text',
		        'default'          => '400',
		        'description' => __('set image height for parallax', "opal-themecontrol")
	        ),

            array(
                'name' => __( 'Author FullName', "opal-themecontrol" ),
                'id'   => "{$prefix}author",
                'type' => 'text',
                'description' => __('Enter Full Name For Author', "opal-themecontrol")
            ), 

            array(
                'name' => __( 'Showcase Link', "opal-themecontrol" ),
                'id'   => "{$prefix}link",
                'type' => 'text',
                'description' => __('Enter the link to showcase site', "opal-themecontrol")
            ), 

            array(
                'name' => __( 'Client', "opal-themecontrol" ),
                'id'   => "{$prefix}client",
                'type' => 'text',
                'description' => __('Enter Full Name For Author', "opal-themecontrol")
            ), 

            array(
                'name' => __( 'Date Created', "opal-themecontrol" ),
                'id'   => "{$prefix}date",
                'type' => 'text_date',
                'description' => __('Enter date released the project', "opal-themecontrol")
            ), 

        ); 

        return apply_filters( 'opal_themecontrol_func_metaboxes_portfolio_fields', $fields );
    }//end function

}// end Classs

OpalThemecontrol_PostType_Portfolio::init();



