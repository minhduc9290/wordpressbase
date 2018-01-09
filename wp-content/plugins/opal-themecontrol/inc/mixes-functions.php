<?php
/**
 * Template Functions
 *
 * @package     Give
 * @subpackage  Functions/Templates
 * @copyright   Copyright (c) 2015, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * batch including all files in a path.
 *
 * @param String $path : PATH_DIR/*.php or PATH_DIR with $ifiles not empty
 */
function opalthemecontrol_includes( $path, $ifiles=array() ){

    if( !empty($ifiles) ){
         foreach( $ifiles as $key => $file ){
            $file  = $path.'/'.$file; 
            if(is_file($file)){
                require($file);
            }
         }   
    }else {
        $files = glob($path);
        foreach ($files as $key => $file) {
            if(is_file($file)){
                require($file);
            }
        }
    }
}

/**
 * Get option value by key follow theme setting.
 */
function opal_themecontrol_get_options($name, $default = false) {
  
    // get the meta from the database
    $options = Opal_Themecontrol_Customize::get_options();

    
   
    // return the option if it exists
    if ( isset( $options[$name] ) ) {
        return apply_filters( 'opalthemer_options_$name', $options[ $name ] );
    }
    if( get_option( $name ) ){
        return get_option( $name );
    }
    // return default if nothing else
    return apply_filters( 'opalthemer_options_$name', $default );
}


/**
 * Returns the path to the Give templates directory
 *
 * @since 1.0
 * @return string
 */
function opal_themecontrol_get_templates_dir() {
	return OPAL_THEMECONTROL_PLUGIN_DIR . 'templates';
}

/**
 * Returns the URL to the Give templates directory
 *
 * @since 1.0
 * @return string
 */
function opal_themecontrol_get_templates_url() {
	return OPAL_THEMECONTROL_PLUGIN_URL . 'templates';
}

/**
 * Returns a list of paths to check for template locations
 *
 * @since 1.0
 * @return mixed|void
 */
function opal_themecontrol_get_theme_template_paths() {

	$template_dir = opal_themecontrol_get_theme_template_dir_name();

	$file_paths = [
		1   => trailingslashit( get_stylesheet_directory() ),
		10  => trailingslashit( get_template_directory() ) . $template_dir,
		100 => opal_themecontrol_get_templates_dir()
	];

	$file_paths = apply_filters( 'opal_themecontrol_template_paths', $file_paths );

	// sort the file paths based on priority
	ksort( $file_paths, SORT_NUMERIC );

	return array_map( 'trailingslashit', $file_paths );
}

/**
 * Returns the template directory name.
 *
 * Themes can filter this by using the opal_themecontrol_templates_dir filter.
 *
 * @since 1.0
 * @return string
 */
function opal_themecontrol_get_theme_template_dir_name() {
	return trailingslashit( apply_filters( 'opal_themecontrol_templates_dir', 'opal-themecontrol' ) );
}

/**
 * get list content blog layout
 */
function opal_themecontrol_get_content_blog_layouts(){
    $files = glob( get_stylesheet_directory().'/content-blog*.php' );

    $output = array();
    $output['blog'] = 'blog';
    if( $files ){
        foreach( $files as $file ){
            $name =  str_replace('content-', '',str_replace( '.php', '', basename( $file ) ) ) ;
            $output[$name] = $name;
        }
    }
    return $output;
}

/**
 * get list content portfolio layout
 */
function opal_themecontrol_get_content_portfolio_layouts(){
    if(is_dir(get_stylesheet_directory().'/opalthemer/portfolio')){
        $files = glob( get_stylesheet_directory().'/opalthemer/portfolio/content-single*.php' );
    }else{
        $files = glob( OPAL_THEMECONTROL_PLUGIN_DIR.'templates/portfolio/content-single*.php' );
    }
	

	$output = array();
	$output['default'] = 'default';
	if( $files ){
		foreach( $files as $file ){
			$name =  str_replace('content-single-', '',str_replace( '.php', '', basename( $file ) ) ) ;
			$output[$name] = $name;
		}
	}
	return $output;
}

/**
 * create a random key to use as primary key.
 */
function opal_themecontrol_makeid( $length = 5 ){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

/**
 * Helper for get list of array of key and value
 */
function opal_themecontrol_autocomplete_options_helper( $options ){
	$output = array();
   $options = array_map('trim', explode(',', $options));
	foreach( $options as $option ){
		$tmp = explode( ":", $option );
		$output[$tmp[0]] = $tmp[1];
	}
	return $output; 
} 


if(!function_exists('opal_themecontrol_fnc_excerpt')){
    //Custom Excerpt Function
    function opal_themecontrol_fnc_excerpt($limit,$afterlimit='[...]') {
        $excerpt = get_the_excerpt();
        if( $excerpt != ''){
           $excerpt = explode(' ', strip_tags( $excerpt ), $limit);
        }else{
            $excerpt = explode(' ', strip_tags(get_the_content( )), $limit);
        }
        if (count($excerpt)>=$limit) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).' '.$afterlimit;
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return strip_shortcodes( $excerpt );
    }
}


if(!function_exists('opal_themecontrol_string_limit_words')){
    function opal_themecontrol_string_limit_words($string, $word_limit)
    {
      $words = explode(' ', $string, ($word_limit + 1));

      if(count($words) > $word_limit) {
        array_pop($words);
      }

      return implode(' ', $words);
    }
}




/**
  * find all header files with prefix name having header-
  */
function opal_themecontrol_fnc_get_header_layouts(){
    $path = get_template_directory().'/header-*.php';
    $files = glob( $path  );
    $headers = array( 'default' => esc_html__('Default', 'opal-themecontrol') );
    if( count($files)>0 ){
        foreach ($files as $key => $file) {
            $header = str_replace( "header-", '', str_replace( '.php', '', basename($file) ) );
            $headers[$header] = esc_html__( 'Header', 'opal-themecontrol' ) . ' ' .str_replace( '-',' ', ucfirst( $header ) );
        }
    }

    return $headers;
}

 /**
  * Get list of footer profile as array. they are post from  post type 'footer'
  */
function opal_themecontrol_fnc_get_footer_profiles(){
    
    $footers_type = get_posts( array('posts_per_page' => -1, 'post_type' => 'footer') );
    $footers = array(  'default' => esc_html__('Default', 'opal-themecontrol') );
    foreach ($footers_type as $key => $value) {
        $footers[$value->post_name] = $value->post_title;
    }

    wp_reset_postdata();


    return $footers;
}

/**
 * get list of menu group
 */
function opal_themecontrol_fnc_get_menugroups(){
    $menus       = wp_get_nav_menus( );
    $option_menu = array( '' => '---Select Menu---' );
    foreach ($menus as $menu) {
        $option_menu[$menu->term_id]=$menu->name;
    }
    return $option_menu;
}

/**
 *
 */
if(!function_exists('opal_themecontrol_fnc_cst_skins')){
    function opal_themecontrol_fnc_cst_skins(){
        $path = get_template_directory().'/css/skins/*';
        $files = glob($path , GLOB_ONLYDIR );
        $skins = array( 'default' => 'default' );
        if( is_array($files) && count($files) > 0 ){
          foreach ($files as $key => $file) {
              $skin = str_replace( '.css', '', basename($file) );
              $skins[$skin] =  $skin;
          }
        }
        return $skins;
    }
}

if ( ! function_exists( 'opal_themecontrol_fnc_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Opalhomes 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function opal_themecontrol_fnc_paging_nav() {
    global $wp_query, $wp_rewrite;

    // Don't print empty markup if there's only one page.
    if ( $wp_query->max_num_pages < 2 ) {
        return;
    }

    $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $query_args   = array();
    $url_parts    = explode( '?', $pagenum_link );

    if ( isset( $url_parts[1] ) ) {
        wp_parse_str( $url_parts[1], $query_args );
    }

    $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
    $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

    $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

    // Set up paginated links.
    $links = paginate_links( array(
        'base'     => $pagenum_link,
        'format'   => $format,
        'total'    => $wp_query->max_num_pages,
        'current'  => $paged,
        'mid_size' => 1,
        'add_args' => array_map( 'urlencode', $query_args ),
        'prev_text' => esc_html__( '&larr; Previous', 'opalhomes' ),
        'next_text' => esc_html__( 'Next &rarr;', 'opalhomes' ),
    ) );

    if ( $links ) :

    ?>
    <nav class="navigation paging-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'opalhomes' ); ?></h1>
        <div class="pagination loop-pagination">
            <?php echo trim($links); ?>
        </div><!-- .pagination -->
    </nav><!-- .navigation -->
    <?php
    endif;
}
endif;

if(!function_exists('opalthemer_getMetaboxValue')){
    function opalthemer_getMetaboxValue( $post_id ,$key, $single = true ) {
      return get_post_meta( $post_id, $key, $single ); 
    }
}