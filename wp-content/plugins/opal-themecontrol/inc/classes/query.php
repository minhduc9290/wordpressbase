<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opal-themecontrol
 * @author     Opal  Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2016 opalthemer.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.opalthemer.com
 * @support  http://www.opalthemer.com/support/forum.html
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Opalthemecontrol_Query {
	
	public static function getFeatured( $args=array() ){
		$default = array(
			'post_type'         => 'post',
			'posts_per_page'	=> 10,
		 
		);

		$args = array_merge( $default, $args );
		return new WP_Query( $args );
	}
	/**
	*
	*/

	public static function getQuery( $args=array() ){
		$default = array(
			'post_type'         => 'post',
			'posts_per_page'	=> 10 ,

		);

		$args = array_merge( $default, $args );
		return new WP_Query( $args );
	}
	/**
	* @param $term_id is term_id in taxonomy
	* @param $post is name post type
	* @param taxonomy  is name taxonomy
	*/
	public static function get_post_by_term_id($term_id,$per_page = -1){
		wp_reset_query();
		$args = array();
		if($term_id == 0 || empty($term_id)){
			$args = array(
				'posts_per_page' => $per_page,
				'post_type' => "opalrestaurant_menu",
			);
		}else{
			$args = array(
				'posts_per_page' => $per_page,
				'post_type' => "opalrestaurant_menu",
				'tax_query' => array(
					array(
						'taxonomy' => "opalrestaurant_category",
						'field' => 'term_id',
						'terms' => $term_id,
						'operator' => 'IN'
						)
					)
				);
		}
		return new WP_Query( $args );
	}

	/**
	* @param $term_id is term_id in taxonomy
	* @param $post is name post type
	* @param taxonomy  is name taxonomy
	*/
	public static function get_menu_by_term_slug($term_slug,$per_page = -1){
		wp_reset_query();
		$args = array();
		if($term_slug == 0 || empty($term_slug)){
			$args = array(
				'posts_per_page' => $per_page,
				'post_type' => "opalrestaurant_menu",
			);
		}else{
			$args = array(
				'posts_per_page' => $per_page,
				'post_type' => "opalrestaurant_menu",
				'tax_query' => array(
					array(
						'taxonomy' => "opalrestaurant_category",
						'field' => 'slug',
						'terms' => $term_slug,
						'operator' => 'IN'
						)
					)
				);
		}
		return new WP_Query( $args );
	}


	/**
	* @param $term_id is term_id in taxonomy
	* @param $post is name post type
	* @param taxonomy  is name taxonomy
	*/
	public static function get_chef_by_term_id($term_id,$per_page = -1){
		wp_reset_query();
		$args = array(
				'posts_per_page' => $per_page,
				'post_type' => "opalrestaurant_chef",
				'tax_query' => array(
					array(
						'taxonomy' => "opalrestaurant_category_chef",
						'field' => 'term_id',
						'terms' => $term_id,
						'operator' => 'IN'
						)
					)
				);
		return new WP_Query( $args );
	}

	/**
	* @param $term_id is term_id in taxonomy
	* @param $post is name post type
	* @param taxonomy  is name taxonomy
	*/
	public static function get_chef_by_term_slug($term_slug,$per_page = -1){
		wp_reset_query();
		$args = array(
				'posts_per_page' => $per_page,
				'post_type' => "opalrestaurant_chef",
				'tax_query' => array(
					array(
						'taxonomy' => "opalrestaurant_category_chef",
						'field' => 'slug',
						'terms' => $term_slug,
						'operator' => 'IN'
						)
					)
				);
		return new WP_Query( $args );
	}

	/**
	* 
	* @param $post is name post type
	* @param taxonomy  is name taxonomy
	*/
	public static function get_the_term_filter_name($post,$taxonomy_name){
		$terms = wp_get_post_terms( $post->ID, $taxonomy_name ,array("fields" => "names") );
		return $terms; 
	}


	/**
	* 
	* @param $taxonomy_slug is slug tax
	* @param $taxonomy  is name taxonomy
	*/
	public static function get_term_by_slug($taxonomy,$taxonomy_slug){
		$terms = get_terms( $taxonomy, array('hide_empty' => false,"slug" => $taxonomy_slug ) );
		return $terms; 
	} 

	/**
	* Get All Categories 
	* @param $args
	*/
	public static function get_categories($per_page = 0){
		$args = array(
				  'hide_empty' => false,
				  'orderby' => 'name',
				  'order' => 'ASC',
				  'number' => $per_page,
				);
		$terms = get_terms('opalrestaurant_category',$args);
		return $terms;
	}

	/**
	* Get All Categories 
	* @param $args
	*/
	public static function get_category_chef($per_page = 0){
		$args = array(
				  'hide_empty' => false,
				  'orderby' => 'name',
				  'order' => 'ASC',
				  'number' => $per_page,
				);
		$terms = get_terms('opalrestaurant_category_chef',$args);
		return $terms;
	}
 	public static function get_chef_menus( $post_id = null, $menu_id = null, $per_page = 10 ) {
		if ( null == $post_id ) {
			$post_id = get_the_ID();
		}

		$args = array(
			'post_type'         => 'opalrestaurant_menu',
			'posts_per_page'    => $per_page,
			'post__not_in' 		=> array($post_id),

			'meta_query'        => array(
				array(
					'key'       => OPALRESTAURANT_MENU_PREFIX . 'chef',
					'value'     => $menu_id,
					'compare'   => '=',
				),
			),
		);
		return new WP_Query( $args );
	}

	/**
	 * Gets Category by Post
	 *
	 * @access public
	 * @return array
	 */
	public static function getCategoryByPost($post_id){
		$terms = wp_get_post_terms( $post_id, 'opalrestaurant_category' );
		return $terms; 
	}


}