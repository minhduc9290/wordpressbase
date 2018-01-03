<?php
/**
 * @version    1.0
 * @package    Nitro_Gallery
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

/**
 * Define class to register and manage custom post type nitro gallery.
 */
class Nitro_Gallery_Post_Type {
	/**
	 * Initialize.
	 *
	 * @return  void
	 */
	public static function initialize() {
		// Register post type
		add_action( 'init', array( __CLASS__, 'register' ) );

		// Custom template for single & archive gallery
		add_filter( 'single_template', array( __CLASS__, 'single_template' ) );
		add_filter( 'archive_template', array( __CLASS__, 'archive_template' ) );

		// Enqueue script
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );

		// Customize gallery message
		add_filter( 'post_updated_messages', array( __CLASS__, 'updated_messages' ) );
	}

	/**
	 * Register nitro gallery post types.
	 *
	 *
	 * @return  string
	 */
	public static function register() {
		$slug = get_theme_mod( 'gallery_slug', 'galleries' );

		register_post_type(
			'nitro-gallery',
			array(
				'labels' => array(
					'name'               => __( 'Nitro Gallery', 'nitro-gallery' ),
					'singular_name'      => __( 'Gallery', 'nitro-gallery' ),
					'menu_name'          => __( 'Nitro Gallery', 'nitro-gallery' ),
					'name_admin_bar'     => __( 'Gallery', 'nitro-gallery' ),
					'add_new'            => __( 'Add New', 'nitro-gallery' ),
					'add_new_item'       => __( 'Add New Gallery', 'nitro-gallery' ),
					'new_item'           => __( 'New Gallery', 'nitro-gallery' ),
					'edit_item'          => __( 'Edit Gallery', 'nitro-gallery' ),
					'view_item'          => __( 'View Gallery', 'nitro-gallery' ),
					'all_items'          => __( 'All Gallery', 'nitro-gallery' ),
					'search_items'       => __( 'Search Gallery', 'nitro-gallery' ),
					'parent_item_colon'  => __( 'Parent Gallery:', 'nitro-gallery' ),
					'not_found'          => __( 'No gallery found.', 'nitro-gallery' ),
					'not_found_in_trash' => __( 'No gallery found in Trash.', 'nitro-gallery' )
				),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => esc_attr( $slug ) ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'menu_icon'          => 'dashicons-slides',
				'supports'           => array( 'title', 'editor', 'thumbnail' )
			)
		);

		// Add new taxonomy, make it hierarchical (like categories)
		register_taxonomy(
			'gallery_cat',
			'nitro-gallery',
			array(
				'labels' => array(
					'name'              => __( 'Categories', 'nitro-gallery' ),
					'singular_name'     => __( 'Category', 'nitro-gallery' ),
					'search_items'      => __( 'Search Categories', 'nitro-gallery' ),
					'all_items'         => __( 'All Categories', 'nitro-gallery' ),
					'parent_item'       => __( 'Parent Category', 'nitro-gallery' ),
					'parent_item_colon' => __( 'Parent Category:', 'nitro-gallery' ),
					'edit_item'         => __( 'Edit Category', 'nitro-gallery' ),
					'update_item'       => __( 'Update Category', 'nitro-gallery' ),
					'add_new_item'      => __( 'Add New Category', 'nitro-gallery' ),
					'new_item_name'     => __( 'New Category Name', 'nitro-gallery' ),
					'menu_name'         => __( 'Categories', 'nitro-gallery' ),
				),
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'gallery_cat' ),
			)
		);

		// Add new taxonomy, NOT hierarchical (like tags)
		register_taxonomy(
			'gallery_tag',
			'nitro-gallery',
			array(
				'labels' => array(
					'name'                       => __( 'Tags', 'nitro-gallery' ),
					'singular_name'              => __( 'Tag', 'nitro-gallery' ),
					'search_items'               => __( 'Search Tags', 'nitro-gallery' ),
					'popular_items'              => __( 'Popular Tags', 'nitro-gallery' ),
					'all_items'                  => __( 'All Tags', 'nitro-gallery' ),
					'parent_item'                => null,
					'parent_item_colon'          => null,
					'edit_item'                  => __( 'Edit Tag', 'nitro-gallery' ),
					'update_item'                => __( 'Update Tag', 'nitro-gallery' ),
					'add_new_item'               => __( 'Add New Tag', 'nitro-gallery' ),
					'new_item_name'              => __( 'New Tag Name', 'nitro-gallery' ),
					'separate_items_with_commas' => __( 'Separate writers with commas', 'nitro-gallery' ),
					'add_or_remove_items'        => __( 'Add or remove writers', 'nitro-gallery' ),
					'choose_from_most_used'      => __( 'Choose from the most used writers', 'nitro-gallery' ),
					'not_found'                  => __( 'No writers found.', 'nitro-gallery' ),
					'menu_name'                  => __( 'Tags', 'nitro-gallery' ),
				),
				'hierarchical'          => false,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var'             => true,
				'rewrite'               => array( 'slug' => 'gallery_tag' ),
			)
		);
	}

	/**
	 * Gallery update messages.
	 *
	 * See /wp-admin/edit-form-advanced.php
	 *
	 * @param array $messages Existing post update messages.
	 *
	 * @return array Amended post update messages with new CPT update messages.
	 */
	public static function updated_messages( $messages ) {
		$post             = get_post();
		$post_type        = get_post_type( $post );

		if( $post_type == 'nitro-gallery' ) {
			$post_type_object = get_post_type_object( $post_type );

			$messages['nitro-gallery'] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => __( 'Gallery updated.', 'nitro-gallery' ),
				2  => __( 'Custom field updated.', 'nitro-gallery' ),
				3  => __( 'Custom field deleted.', 'nitro-gallery' ),
				4  => __( 'Gallery updated.', 'nitro-gallery' ),
				/* translators: %s: date and time of the revision */
				5  => isset( $_GET['revision'] ) ? sprintf( __( 'Gallery restored to revision from %s', 'nitro-gallery' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6  => __( 'Gallery published.', 'nitro-gallery' ),
				7  => __( 'Gallery saved.', 'nitro-gallery' ),
				8  => __( 'Gallery submitted.', 'nitro-gallery' ),
				9  => sprintf(
					__( 'Gallery scheduled for: <strong>%1$s</strong>.', 'nitro-gallery' ),
					// translators: Publish box date format, see http://php.net/date
					date_i18n( __( 'M j, Y @ G:i', 'nitro-gallery' ), strtotime( $post->post_date ) )
				),
				10 => __( 'Gallery draft updated.', 'nitro-gallery' )
			);

			if ( $post_type_object->publicly_queryable ) {
				$permalink = get_permalink( $post->ID );

				$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View gallery', 'nitro-gallery' ) );
				$messages[ $post_type ][1] .= $view_link;
				$messages[ $post_type ][6] .= $view_link;
				$messages[ $post_type ][9] .= $view_link;

				$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
				$preview_link = sprintf( ' <a target="_blank" rel="noopener noreferrer" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview gallery', 'nitro-gallery' ) );
				$messages[ $post_type ][8]  .= $preview_link;
				$messages[ $post_type ][10] .= $preview_link;
			}
		}

		return $messages;
	}

	/**
	 * Load single item template file for the gallery custom post type.
	 *
	 * @param   string  $template  Current template file.
	 *
	 * @return  string
	 */
	public static function single_template( $template ) {
		global $post;

		if ( isset( $post->post_type ) && $post->post_type == 'nitro-gallery' ) {
			$template = NITRO_GALLERY_PATH . 'templates/single.php';
		}

		return $template;
	}

	/**
	 * Load archive template file for the gallery custom post type.
	 *
	 * @param   string  $template  Current template file.
	 *
	 * @return  string
	 */
	public static function archive_template( $template ) {
		global $post;

		if ( isset( $post->post_type ) && $post->post_type == 'nitro-gallery' ) {
			$template = NITRO_GALLERY_PATH . 'templates/archive.php';
		}

		return $template;
	}

	/**
	 * Define helper function to print related gallery.
	 *
	 * @return  array
	 */
	public static function related() {
		global $post;

		// Get the gallery tags.
		$cats = get_the_terms( $post, 'gallery_cat' );

		if ( ! class_exists( 'WR_Nitro' ) ) return;
		$wr_nitro_options = WR_Nitro::get_options();

		if ( $cats ) {
			$cat_ids = array();

			foreach ( $cats as $cat ) {
				$cat_ids[] = $cat->term_id;
			}

			$args = array(
				'post_type'      => 'nitro-gallery',
				'post__not_in'   => array( $post->ID ),
				'posts_per_page' => 12,
				'tax_query'      => array(
					array(
						'taxonomy' => 'gallery_cat',
						'field'    => 'id',
						'terms'    => $cat_ids,
					),
				)
			);

			$the_query = new WP_Query( $args );
			?>
			<div class="related-gallery grid w-info mgt70">
				<h4 class="widget-title"><?php _e( 'Related Galleries', 'nitro-gallery' ); ?></h4>

				<div class="related clear wr-nitro-carousel" data-owl-options='{"items": "4", "tablet": "3", "mobile": "1"<?php echo ( $wr_nitro_options['rtl'] ? ',"rtl": "true"' : '' ); ?>}'>
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<figure class="hentry">
						<div class="mask pr">
							<?php
								if ( has_post_thumbnail() ) :

									$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '405x300' );

									echo '<a href="' . esc_url( get_permalink() ) . '">';
										echo '<img width="405" height="300" src="' . esc_url( $img[0] ) . '" alt="' . get_the_title() . '">';
									echo '</a>';

								else :
									echo '<img width="405" height="300" src="' . NITRO_GALLERY_URL . 'assets/img/placeholder.png" alt="' . get_the_title() . '">';
								endif;
							?>
						</div><!-- .mask -->
						<figcaption>
							<div class="title mgt20">
								<h5><a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
							</div><!-- .title -->
						</figcaption>
					</figure><!-- .hentry -->
					<?php endwhile; ?>
				</div><!-- .related -->
			</div><!-- .related-gallery -->
		<?php
		}

		wp_reset_postdata();
	}

	/**
	 * Get excerpt.
	 *
	 * @param   integer  $limit        The number of words for an excerpt.
	 * @param   string   $after_limit  Read more text.
	 *
	 * @return  string
	 */
	public static function get_excerpt( $limit, $after_limit = '[...]' ) {
		$excerpt = get_the_excerpt();

		if ( $excerpt != '' ) {
			$excerpt = explode( ' ', strip_tags( strip_shortcodes( $excerpt ) ), $limit );
		} else {
			$excerpt = explode( ' ', strip_tags( strip_shortcodes( get_the_content() ) ), $limit );
		}

		if ( count( $excerpt ) < $limit ) {
			$excerpt = implode( ' ', $excerpt );
		} else {
			array_pop( $excerpt );

			$excerpt = implode( ' ', $excerpt ) . ' ' . $after_limit;
		}

		return $excerpt;
	}

	/**
	 * Get image links for creating gallery.
	 *
	 * @param   string/array  $size  Image size.
	 *
	 * @return  array
	 */
	public static function get_multiple_image( $size = 'full' ) {
		$images = get_post_meta( get_the_ID(), 'multiple_image', false );

		$output = array();

		foreach ( $images as $key => $id ) {
			$link = wp_get_attachment_image_src( $id, $size );

			$output[$key][] = $link[0];
			$output[$key][] = $link[1];
			$output[$key][] = $link[2];
		}

		return $output;
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @return  void
	 */
	public static function enqueue_scripts() {
		$layout     = get_theme_mod( 'gallery_single_layout', 'grid' );
		$mousewheel = get_theme_mod( 'gallery_single_mousewheel', 0 );

		if ( is_singular( 'nitro-gallery' ) &&  'horizontal' == $layout && $mousewheel ) {
			wp_enqueue_script( 'mousewheel', NITRO_GALLERY_URL . 'assets/vendors/mousewheel/jquery.mousewheel.min.js', array(), false, true  );
		}
	}
}
