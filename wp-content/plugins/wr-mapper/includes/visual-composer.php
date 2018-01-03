<?php
/**
 * @version    1.0
 * @package    WR_Theme
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

/**
 * Plug WR_Mapper into Visual Composer.
 *
 * @package  WR_Mapper
 * @since    1.0
 */

class WR_Mapper_Visual_Composer {
	/**
	 * Initialize pluggable functions for Visual Composer.
	 *
	 * @return  void
	 */
	public static function initialize() {
		// Plug into Visual Composer.
		add_action( 'vc_before_init', array( __CLASS__, 'wr_mapper_pluggable'   ) );

		// Hook to VC auto complete to add custom ajax search
		add_filter( 'vc_autocomplete_wr_mapper_id_callback', array( __CLASS__, 'autocomplete_suggestion', ), 1, 1 );

		// Render
		add_filter( 'vc_autocomplete_wr_mapper_id_render', array( __CLASS__, 'autocomplete_render_value', ), 1, 1 );
	}

	/**
	 * Suggester for autocomplete by id/name/title/sku
	 *
	 * @param $query
	 *
	 * @return array - id's from posts with title/ID.
	 */
	public static function autocomplete_suggestion( $query ) {
		$current_filter = current_filter();

		switch ( $current_filter ) {
			case 'vc_autocomplete_wr_mapper_id_callback':
				$query = array(
					'query' => 'wr_mapper',
					'term'  => $query
				);

				$suggestions = apply_filters( 'vc_autocomplete_vc_basic_grid_exclude_callback', $query );

				break;
		}
		if ( is_array( $suggestions ) && ! empty( $suggestions ) ) {
			die( json_encode( $suggestions ) );
		}

		die( 'Notthing' ); // if nothing found..
	}

	/**
	 * Suggester for autocomplete render value
	 *
	 * @param $value
	 *
	 * @return array
	 */
	public static function autocomplete_render_value( $value ) {
		$current_filter = current_filter();

		switch ( $current_filter ) {
			case 'vc_autocomplete_wr_mapper_id_render':
				break;
		}
		return $value;
	}

	/**
	 * Added element into Visual Composer.
	 *
	 * @since  1.0
	 * @see    https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524329
	 */
	public static function wr_mapper_pluggable() {
		vc_map(
			array(
				'name'     => esc_html__( 'WR Mapper', 'wr-nitro' ),
				'base'     => 'wr_mapper',
				'icon'     => 'fa fa-dot-circle-o',
				'category' => esc_html__( 'Nitro Elements', 'wr-nitro' ),
				'params'   => array(
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Select identificator', 'wr-nitro' ),
						'param_name'  => 'id',
						'description' => esc_html__( 'Input the title of WR Mapper to see suggestions', 'wr-nitro' ),
						'admin_label' => true
					),
					array(
						'param_name'  => 'extra_class',
						'heading'     => esc_html__( 'Extra Class Name', 'wr-nitro' ),
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'wr-nitro' ),
						'type'        => 'textfield',
					),
				)
			)
		);
	}
}