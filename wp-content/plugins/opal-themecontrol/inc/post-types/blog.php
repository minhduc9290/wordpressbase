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
class OpalThemecontrol_PostType_Blog{

    /**
    * init action and filter data to define menu post type
    */
    public static function init(){ 
        add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
    }

    /**
    *
    */
    public static function metaboxes( array $metaboxes ) { 
        $metaboxes[ 'managements' ] = array(
            'id'                        => 'post-format-group',
            'title'                     => __( 'Post Setting', "opal-themecontrol" ),
            'object_types'              => array( 'post' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => self::opal_themecontrol_func_metaboxes_blog_fields()
        );
        return $metaboxes;
    }// end function


    /**
    * Register Metabox 
    */
    public static function opal_themecontrol_func_metaboxes_blog_fields(){
        // Better has an underscore as last sign
        $fields =  array(
            //Links
            
            array(
                'name' => __( 'Video Link', "opal-themecontrol" ),
                'id'   => "blog-format-video",
                'type' => 'oembed',
                'description' => __('Support Show Blog From Youtube and Vimeo', "opal-themecontrol")
            ),
            array(
                'name' => __( 'Soundcloud Link', "opal-themecontrol" ),
                'id'   => "blog-format-audio",
                'type' => 'oembed',
                'description' => __('Support Show Blog From Soundcloud', "opal-themecontrol")
            ),
            array(
                'name'    => esc_html__( 'Quote content', 'opal-themecontrol' ),
                'type'    => 'textarea',
                'id'   => "blog-format-quote-content",
                'attributes'  => array(
                    'placeholder' => 'A small amount of text',
                    'rows'        => 6,
                ),
                'before_row' => '<div class="cmb2-id-blog-format-quote">'
            ),
            array(
                'name'    => esc_html__( 'Quote author', 'opal-themecontrol' ),
                'type'    => 'text',
                'id'   => "blog-format-quote-author",
                'after_row' => '</div>'
            ),
            array(
                'name' => __( 'Galleries', "opal-themecontrol" ),
                'id'   => "blog-format-gallery",
                'type' => 'file_list',
            ),

        ); 
        return apply_filters( 'opal_themecontrol_func_metaboxes_blog_fields', $fields );
    }//end function

}// end Classs

OpalThemecontrol_PostType_Blog::init();



