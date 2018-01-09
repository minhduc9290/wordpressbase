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
class OpalThemecontrol_PostType_Gallery{

    /**
   * init action and filter data to define menu post type
   */
    public static function init(){ 
        add_action( 'init', array( __CLASS__, 'opalthemecontrol_create_type_gallery' ) );
        //-- custom add column to list post
        add_filter( 'manage_gallery_posts_columns',array(__CLASS__,'init_menu_columns'),10);
        add_action("manage_gallery_posts_custom_column", array(__CLASS__, "show_menu_columns"), 10, 2);
        //----
	    add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
	    //----

        define( 'OPAL_THEMECONTROL_GALLERY_PREFIX', 'gallery_' );
    }

	/**
    * func register postype and taxonomy
    */
    public static function opalthemecontrol_create_type_gallery(){
        $labels = array(
            'name'               => __( 'Galleries', "opal-themecontrol" ),
            'singular_name'      => __( 'Gallery', "opal-themecontrol" ),
            'add_new'            => __( 'Add New Gallery', "opal-themecontrol" ),
            'add_new_item'       => __( 'Add New Gallery', "opal-themecontrol" ),
            'edit_item'          => __( 'Edit Gallery', "opal-themecontrol" ),
            'new_item'           => __( 'New Gallery', "opal-themecontrol" ),
            'view_item'          => __( 'View Gallery', "opal-themecontrol" ),
            'search_items'       => __( 'Search Gallerys', "opal-themecontrol" ),
            'not_found'          => __( 'No Gallerys found', "opal-themecontrol" ),
            'not_found_in_trash' => __( 'No Gallerys found in Trash', "opal-themecontrol" ),
            'parent_item_colon'  => __( 'Parent Gallery:', "opal-themecontrol" ),
            'menu_name'          => __( 'Galleries', "opal-themecontrol" ),
        );

        $labels = apply_filters( 'opalthemer_filter_postype_gallery_labels' , $labels );
        $slug_field = opalthemecontrol_get_option( 'slug_gallery' );
        $slug = ($slug_field != false) ? $slug_field : "galleries";


        $args = array(
            'labels'                => $labels,
            'hierarchical'          => true,
            'description'           => 'List Gallery',
            'supports'              => array( 'title', 'thumbnail'),
            'taxonomies'            => array( 'category_gallery' ),
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
            'capability_type'       => 'post',
            'menu_icon'             => 'dashicons-slides',
            'publicly_queryable'    => true, //disable view
        );
        $args = apply_filters( 'opalthemer_filter_postype_gallery_args' , $args );
        register_post_type( 'gallery', $args );

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
        $labels = apply_filters( 'opalthemer_filter_taxonomy_gallery_labels' , $labels );
        // Now register the taxonomy
        register_taxonomy('category_gallery',array('gallery'),
            array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'show_in_nav_menus' => false,
                'rewrite'           => array( 'slug' => 'category-gallery'),
            )
        );

	    // Add new taxonomy, NOT hierarchical (like tags)
	    register_taxonomy(
		    'tag_gallery',
		    'gallery',
		    array(
			    'labels' => array(
				    'name'                       => __( 'Tags', 'opal-themecontrol' ),
				    'singular_name'              => __( 'Tag', 'opal-themecontrol' ),
				    'search_items'               => __( 'Search Tags', 'opal-themecontrol' ),
				    'popular_items'              => __( 'Popular Tags', 'opal-themecontrol' ),
				    'all_items'                  => __( 'All Tags', 'opal-themecontrol' ),
				    'parent_item'                => null,
				    'parent_item_colon'          => null,
				    'edit_item'                  => __( 'Edit Tag', 'opal-themecontrol' ),
				    'update_item'                => __( 'Update Tag', 'opal-themecontrol' ),
				    'add_new_item'               => __( 'Add New Tag', 'opal-themecontrol' ),
				    'new_item_name'              => __( 'New Tag Name', 'opal-themecontrol' ),
				    'separate_items_with_commas' => __( 'Separate writers with commas', 'opal-themecontrol' ),
				    'add_or_remove_items'        => __( 'Add or remove writers', 'opal-themecontrol' ),
				    'choose_from_most_used'      => __( 'Choose from the most used writers', 'opal-themecontrol' ),
				    'not_found'                  => __( 'No writers found.', 'opal-themecontrol' ),
				    'menu_name'                  => __( 'Tags', 'opal-themecontrol' ),
			    ),
			    'hierarchical'          => false,
			    'show_ui'               => true,
			    'show_admin_column'     => true,
			    'update_count_callback' => '_update_post_term_count',
			    'query_var'             => true,
			    'rewrite'               => array( 'slug' => 'tag-gallery' ),
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
        $columns = array_slice($columns, 0, 1, true) + array(OPAL_THEMECONTROL_GALLERY_PREFIX .'thumb' => __("Image", 'opal-themecontrol')) + array_slice($columns, 1, count($columns) - 1, true);
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
          case OPAL_THEMECONTROL_GALLERY_PREFIX .'thumb':
            echo '<a href="' . get_edit_post_link($post->ID) . '">' . get_the_post_thumbnail($post_ID,array( 100, 100)) . '</a>';
            break;
        }
    }

	/**
	 *
	 */
	public static function metaboxes( array $metaboxes ) {
		$prefix = OPAL_THEMECONTROL_GALLERY_PREFIX;
		$metaboxes[ $prefix . 'managements' ] = array(
			'id'                        => $prefix . 'standard-gallery',
			'title'                     => __( 'Gallery Setting', "opal-themecontrol" ),
			'object_types'              => array( 'gallery' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::opal_themecontrol_func_metaboxes_gallery_fields()
		);
		return $metaboxes;
	}// end function


	/**
	 * Register Metabox
	 */
	public static function opal_themecontrol_func_metaboxes_gallery_fields(){

		/**
		 * prefix of meta keys (optional)
		 * Use underscore (_) at the beginning to make keys hidden
		 * Alt.: You also can make prefix empty to disable it
		 */

		// Better has an underscore as last sign
		$prefix = OPAL_THEMECONTROL_GALLERY_PREFIX;
		$fields =  array(
			// THICKBOX IMAGE UPLOAD (WP 3.3+)
			// FILE ADVANCED (WP 3.5+)
			array(
				'name'             => __( 'Gallery Images', "opal-themecontrol" ),
				'id'               => "{$prefix}file_advanced",
				'type'             => 'file_list',
				'description' => __('Using for Gallery and Slideshow', "opal-themecontrol")
			),

		);

		return apply_filters( 'opal_themecontrol_func_metaboxes_gallery_fields', $fields );
	}//end function

}// end Classs

OpalThemecontrol_PostType_Gallery::init();



