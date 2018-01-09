<?php 
/**
 * Class Opal_Themecontrol Woocommerce
 *
 */
class Opal_ThemecontrolWoocommerce{

    /**
     * Constructor to create an instance of this for processing logics render content and modules.
     */
    public function __construct(){ 
        
        // Remove some default action handlers.
        remove_action( 'woocommerce_after_shop_loop_item_title'  , 'woocommerce_template_loop_rating'   , 5  );
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb'             , 20 );
        remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
        remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
       
        // registerCustomizer
        add_action( 'customize_register',  array( $this, 'registerCustomizer' ), 9 );
       
        // Add custom fields to product options
        add_action( 'woocommerce_product_options_pricing',   array( __CLASS__, 'add_custom_general_fields' ) );
        add_action( 'woocommerce_process_product_meta',      array( __CLASS__, 'add_custom_general_fields_save' ) );
        // Customize product tabs.
        add_filter( 'woocommerce_product_tabs', array( __CLASS__, 'woocommerce_product_tabs' ), 100 );
        // Override theme default specification for product # per row
        add_filter('loop_shop_columns',  array( __CLASS__,'loop_columns'), 999);
        // Change number of products displayed per page
        add_filter( 'loop_shop_per_page', array( __CLASS__, 'change_product_per_page' ) );
        // image_srcset
        //add_filter( 'wp_calculate_image_srcset'  , array( __CLASS__, 'calculate_image_srcset'   ), 10, 5 );

        // Add form fields Image title for product category
        add_filter( 'woocommerce_available_variation', array( __CLASS__, 'woocommerce_available_variation' ), 20, 3 );

        if( opal_themecontrol_get_options('wc_general_quickview',true) ){
            add_action( 'wp_ajax_opal_themecontrol_quickview', array($this,'quickview') );
            add_action( 'wp_ajax_nopriv_opal_themecontrol_quickview', array($this,'quickview') );
            add_action( 'wp_footer', array($this,'quickviewModal') );
        }

        if( opal_themecontrol_get_options( 'is-swap-effect',true ) ){
            //remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            //add_action('woocommerce_before_shop_loop_item_title',   array($this,'swapImages'),10);

        }
        //Add scripts
        add_action( 'wp_enqueue_scripts', array( __CLASS__,'opal_woocommerce_scripts'), 999 );  


    }
    /**
    * Add scripts
    *
    * @since Opal_Themecontrol 1.0
    */
    public static function opal_woocommerce_scripts(){
        wp_enqueue_script( 'opal-themecontrol-woocommerce-js', get_template_directory_uri() . '/js/woocommerce.js', array( 'jquery', 'suggest' ), '20131022', true );
        wp_enqueue_script( 'opal-themecontrol-elevatezoom', OPAL_THEMECONTROL_PLUGIN_URL.'assets/3rd-party/elevatezoom/jquery.elevateZoom.min.js' );
    }

    /**
     * Add custom fields to general settings
     *
     * @since Opal_Themecontrol 1.0
     */
    public static function add_custom_general_fields() {

        global $woocommerce, $post;

        woocommerce_wp_checkbox(
            array(
                'id'            => '_show_countdown',
                'wrapper_class' => 'show_if_simple show_if_external show_if_sale_schedule',
                'label'         => __( 'Show Countdown Timer', 'opal-themecontrol' ),
            )
        );

    }

    /**
     * Save custom fields to general settings
     *
     * @since  1.0
     */
    public static function add_custom_general_fields_save( $post_id ){

        $show_countdown = isset( $_POST['_show_countdown'] ) ? 'yes' : 'no';
        update_post_meta( $post_id, '_show_countdown', $show_countdown );

    }
    /**
     * Override theme default specification for product # per row
     * @since  1.0
    */

     public static function loop_columns() {
        return $opal_columns =  opal_themecontrol_get_options('wc_archive_layout_column',4); // 4 products per row
    }

    /**
     * Change number of products displayed per page.
     *
     * @since  1.0
     *
     * @return  number
     *
     */
    public static function change_product_per_page() {
        $number  = opal_themecontrol_get_options('wc_archive_number_products');

        return $number;
    }

    /**
     * Calculate remote source set for demo image.
     *
     * @param   array  $sources  {
     *     One or more arrays of source data to include in the 'srcset'.
     *
     *     @type array $width {
     *         @type string $url        The URL of an image source.
     *         @type string $descriptor The descriptor type used in the image candidate string,
     *                                  either 'w' or 'x'.
     *         @type int    $value      The source width if paired with a 'w' descriptor, or a
     *                                  pixel density value if paired with an 'x' descriptor.
     *     }
     * }
     * @param   array   $size_array     Array of width and height values in pixels (in that order).
     * @param   string  $image_src      The 'src' of the image.
     * @param   array   $image_meta     The image meta data as returned by 'wp_get_attachment_metadata()'.
     * @param   int     $attachment_id  Image attachment ID or 0.
     *
     * @return  string|false
     */
    public static function calculate_image_srcset( $sources, $size_array, $image_src, $image_meta, $attachment_id ) {
        foreach ( $sources as $width => $define ) {
            // Check if attachment file exists.
            $upload = isset( $upload ) ? $upload : wp_upload_dir();
            $file   = str_replace( $upload['baseurl'], $upload['basedir'], $define['url'] );

            if ( ! @is_file( $file ) ) {
                if ( preg_match( '#' . self::$demo_site_pattern . self::$demo_image_pattern . '#i', $image_src ) ) {
                    $remote_src = $image_src;
                } elseif ( $attachment = get_post( $attachment_id ) ) {
                    if ( preg_match( '#' . self::$demo_site_pattern . self::$demo_image_pattern . '#i', $attachment->guid ) ) {
                        $remote_src = $attachment->guid;
                    }
                }

                if ( isset( $remote_src ) ) {
                    // Get base local and remote URL.
                    $remote_base = current( explode( '/wp-content/uploads/', $remote_src ) ) . '/wp-content/uploads';

                    // Replace local base with remote base.
                    $sources[ $width ]['url'] = str_replace( $upload['baseurl'], $remote_base, $define['url'] );
                }
            }
        }

        return $sources;
    }

    /**
     * Customize product tabs.
     *
     * @since  1.0
     */
    public static function woocommerce_product_tabs( $tabs = array() ) {
        global $product, $post;
        // Get product setting
        $single_style = opal_themecontrol_get_options('wc_single_style');
        
        $tab_description    = opal_themecontrol_get_options('wc_single_product_tab_description');
        $tab_additional     = opal_themecontrol_get_options('wc_single_product_tab_info');
        $tab_review         = opal_themecontrol_get_options('wc_single_product_tab_review');
        $wpc_disable_review = get_option( 'wpc_tab_show_hide' );

        // Description tab - shows product content
        if ( $post->post_content ) {
            $tabs['description'] = array(
                'title'    => __( 'Description', 'opal-themecontrol' ),
                'priority' => 10,
                'callback' => 'woocommerce_product_description_tab',
            );
        }

        // Additional information tab - shows attributes
        if ( $product && ( $product->has_attributes() || ( $product->has_dimensions() || $product->has_weight() ) ) ) {

            $tabs['additional_information'] = array(
                'title'    => __( 'Additional Information', 'opal-themecontrol' ),
                'priority' => 20,
                'callback' => 'woocommerce_product_additional_information_tab',
            );
        }

        // Reviews tab - shows comments
        if ( comments_open() ) {
            $tabs['reviews'] = array(
                'title'    => sprintf( __( 'Reviews (%d)', 'opal-themecontrol' ), $product->get_review_count() ),
                'priority' => 30,
                'callback' => 'comments_template',
            );
        }

        if ( '4' == $single_style && ! wp_is_mobile() ) {
            if ( opal_themecontrol_get_options('wc_single_product_related') ) {
                // Related products tab
                $tabs['related'] = array(
                    'title'    => __( 'Related products', 'opal-themecontrol' ),
                    'priority' => 40,
                    'callback' => 'woocommerce_output_related_products',
                );
            }

            if ( opal_themecontrol_get_options('wc_single_product_upsell') ) {
                // Upsell products tab
                $tabs['upsell'] = array(
                    'title'    => __( 'Upsell products', 'opal-themecontrol' ),
                    'priority' => 50,
                    'callback' => 'woocommerce_upsell_display',
                );
            }

            if ( opal_themecontrol_get_options('wc_single_product_recent_viewed') ) {
                // Recent viewed products tab
                $tabs['recent_viewed'] = array(
                    'title'    => __( 'Recent viewed products', 'opal-themecontrol' ),
                    'priority' => 60,
                    'callback' => 'Opal_ThemecontrolWoocommerce::woocommerce_recent_viewed_products',
                );
            }
        }

        // Enable VC page builder for single product
        $builder = get_post_meta( get_the_ID(), 'enable_builder', true );

        // Remove some default tabs
        if ( ! $tab_description || $builder ) {
            unset( $tabs['description'] );
        }
        if ( ! $tab_additional ) {
            unset( $tabs['additional_information'] );
        }
        if ( ! $tab_review ) {
            unset( $tabs['reviews'] );
        }

        return $tabs;
    }

    /**
     * Add Recent viewed products
     *
     * @since  1.0
     */
    public static function woocommerce_recent_viewed_products() {
        wc_get_template( 'single-product/recent-viewed.php' );
    }

    /**
     * Enable product swap image
     *
     * @static
     * @access public
     * @since Opal_Themecontrol 1.0
     */
    public function swapImages(){
        global $post, $product, $woocommerce;
        $placeholder_width = get_option('shop_catalog_image_size');
        $placeholder_width = $placeholder_width['width'];

        $placeholder_height = get_option('shop_catalog_image_size');
        $placeholder_height = $placeholder_height['height'];

        $output='';
        $class = 'image-no-effect';
        if(has_post_thumbnail()){
            $attachment_ids = $product->get_gallery_image_ids();
            if(is_array($attachment_ids) && isset( $attachment_ids[0] )) {
                $class = 'image-hover';
                $output.=wp_get_attachment_image($attachment_ids[0],'shop_catalog',false,array('class'=>"attachment-shop_catalog image-effect"));
            }
            $output.=get_the_post_thumbnail( $post->ID,'shop_catalog',array('class'=>$class) );
        }else{
            $output .= '<img src="'.woocommerce_placeholder_img_src().'" alt="'.esc_html__('Placeholder' , 'opal-themecontrol').'" class="'.$class.'" width="'.$placeholder_width.'" height="'.$placeholder_height.'" />';
        }
        echo trim($output);
    }

    /**
     * Add settings to the Customizer.
     *
     * @static
     * @access public
     * @since Opal_Themecontrol 1.0
     *
     * @param WP_Customize_Manager $wp_customize Customizer object.
     */
    public function registerCustomizer( $wp_customize ){
        return $wp_customize;
    }

    public function quickview(){
        $args = array(
                'post_type'=>'product',
                'product'=>$_GET['productslug']
            );
        $query = new WP_Query($args);
        if($query->have_posts()){
            while($query->have_posts()): $query->the_post(); global $product;
                if(is_file( get_template_directory().'/woocommerce/quickview.php')){
                     get_template_part( 'woocommerce/quickview'); 
                }
            endwhile;
        }

        wp_reset_postdata();
        die;
    }

    public function quickviewModal(){
    ?>
    <div class="modal fade" id="opal-quickview-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close btn btn-close" data-dismiss="modal" aria-hidden="true">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body"><span class="spinner"></span></div>
                </div>
            </div>
        </div>

    <?php    
    }

    /**
     * Add attribute image shop thumbnail
     *
     * @param array $attribute
     * @param class $wc_product_variable
     * @param array $variation
     */
    public static function woocommerce_available_variation( $attribute, $wc_product_variable, $variation ) {
        $attachment_id = get_post_thumbnail_id( $attribute['variation_id'] );

        if( $attachment_id == 0 ) {
            $attachment_id = get_post_thumbnail_id( $variation->id );
        }

        $attachment    = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );

        $image_srcset      = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $attachment_id, 'shop_single' ) : false;
        $image_srcset      = $image_srcset ? $image_srcset : '';
        $image_sizes       = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $attachment_id, 'shop_single' ) : false;
        $image_sizes       = $image_sizes ? $image_sizes : '';

        $attribute['thumb_image_src'] = $attachment[0];
        $attribute['thumb_image_srcset'] = $image_srcset;
        $attribute['thumb_image_sizes'] = $image_sizes;

        return $attribute;
    }
}//end class

//Init Class
new Opal_ThemecontrolWoocommerce();

/* ---------------------------------------------------------------------------
 * WooCommerce - Function get Query
 * --------------------------------------------------------------------------- */
function opal_themecontrol_woocommerce_query( $type, $post_per_page=-1, $cat='',$offset='' ){
    global $woocommerce, $wp_query;
    
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $orderby = (get_query_var('orderby')) ? get_query_var('orderby') : null;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $post_per_page,
        'post_status' => 'publish',
        'paged' => $paged,
        'offset' => $offset,
        'orderby'   => $orderby
    );

    if ( isset( $args['orderby'] ) ) {
        if ( 'price' == $args['orderby'] ) {
            $args = array_merge( $args, array(
                'meta_key'  => '_price',
                'orderby'   => 'meta_value_num'
            ) );
        }
        if ( 'featured' == $args['orderby'] ) {
            $args = array_merge( $args, array(
                'meta_key'  => '_featured',
                'orderby'   => 'meta_value'
            ) );
        }
        if ( 'sku' == $args['orderby'] ) {
            $args = array_merge( $args, array(
                'meta_key'  => '_sku',
                'orderby'   => 'meta_value'
            ) );
        }
    }

 

    switch ($type) {
      
        case 'best_selling_products':
            $args['meta_key']='total_sales';
            $args['orderby']='meta_value_num';
            $args['ignore_sticky_posts']   = 1;
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            break;

        case 'featured_product':
            $args['ignore_sticky_posts']=1;
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = array(
                         'key' => '_featured',
                         'value' => 'yes'
                     );
            $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            break;

        case 'top_rate':
            add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            break;

        case 'recent_products':
           
            $args['orderby']  = 'date';
            $args['order']  =  'desc';

            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();


            break;

        case 'deals': 
            
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $args['meta_query'][] =  array(
                array( // Variable products type
                    'key'           => '_sale_price_dates_to',
                    'value'         => time(),
                    'compare'       => '>',
                    'type'          => 'numeric'
                )
            );

            break;   

        case 'sale_products':
            $product_ids_on_sale    = wc_get_product_ids_on_sale();
            $product_ids_on_sale[]  = 0;
            $args['post__in'] = $product_ids_on_sale;
            break;

        case 'featured_products':

            $meta_query   = WC()->query->get_meta_query();
            $meta_query[] = array(
                'key'   => '_featured',
                'value' => 'yes'
            );

            $args['meta_query'] = $meta_query;
            break;

        case 'recent_review':

            if($post_per_page == -1) $_limit = 4;
            else $_limit = $post_per_page;
            global $wpdb;
            $query = "SELECT c.comment_post_ID FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c 
                WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0 
                ORDER BY c.comment_date ASC";
            $results = $wpdb->get_results($query, OBJECT);
            $_pids = array();
            foreach ($results as $re) {
                if(!in_array($re->comment_post_ID, $_pids))
                    $_pids[] = $re->comment_post_ID;
                if(count($_pids) == $_limit)
                    break;
            }

            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $args['post__in'] = $_pids;

            break;
    }
 
    if( !empty($cat) && !is_array($cat) ){
        $cat = array( $cat );
    }
    if( !empty($cat) && is_array($cat) ){

        if( isset($cat[0]) && !is_numeric($cat[0]) ){
            $terms = array();
            foreach( $cat as $ct ){
                $ocategory = get_term_by( 'slug', $ct, 'product_cat' ); 
            
                if( $ocategory ){
                    $terms[] = $ocategory->term_id;
                }
            }
            $cat = $terms;
        }

        $args['tax_query']    = array(
            array(
                'taxonomy'      => 'product_cat',
                'field'         => 'term_id', //This is optional, as it defaults to 'term_id'
                'terms'         =>  $cat,
                'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
            )
        );
    }
    
    $query = new WP_Query($args);
    
    wp_reset_postdata();
    
    return $query;
    
}//End Func


/**
 * Creat Post Type Product Tabs which display in product detail
 */
if(!function_exists('opalthemer_create_type_producttab')   ){

    function opalthemer_create_type_producttab(){
        $labels = array(
            'name' => __( 'Product Info Tab', "opal-themecontrol" ),
            'singular_name' => __( 'Product Tab', "opal-themecontrol" ),
            'add_new' => __( 'Add New Product Tab', "opal-themecontrol" ),
            'add_new_item' => __( 'Add New Product Tab', "opal-themecontrol" ),
            'edit_item' => __( 'Edit Product Tab', "opal-themecontrol" ),
            'new_item' => __( 'New Product Tab', "opal-themecontrol" ),
            'view_item' => __( 'View Product Tab', "opal-themecontrol" ),
            'search_items' => __( 'Search Product Tabs', "opal-themecontrol" ),
            'not_found' => __( 'No Product Tabs found', "opal-themecontrol" ),
            'not_found_in_trash' => __( 'No Product Tabs found in Trash', "opal-themecontrol" ),
            'parent_item_colon' => __( 'Parent Product Tab:', "opal-themecontrol" ),
            'menu_name' => __( 'Product Info Tabs', "opal-themecontrol" ),
        );

        $args = array(
          'labels' => $labels,
          'hierarchical' => true,
          'description' => 'List Product Tab',
          'supports' => array( 'title', 'editor','slug' ),
          'public' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'menu_position' => 5,
          'show_in_nav_menus' => false,
          'publicly_queryable' => true,
          'exclude_from_search' => false,
          'has_archive' => true,
          'query_var' => true,
          'can_export' => true,
          'rewrite' => true,
          'capability_type' => 'post'
        );
        register_post_type( 'producttab', $args );
    }
    add_action( 'init','opalthemer_create_type_producttab' );
}

/**
* get setting files
*/
function opalthemer_func_metaboxes_producttab_fields(){
 
   /**
    * prefix of meta keys (optional)
    * Use underscore (_) at the beginning to make keys hidden
    * Alt.: You also can make prefix empty to disable it
    */

    // Better has an underscore as last sign
    $fields = array(); 

    return apply_filters( 'opalthemer_producttab_metaboxes_fields', $fields );
}

/**
 *
 */
function opal_themecontrol_func_producttabs_register_meta_boxes( $meta_boxes ){

    $fields = opalthemer_func_metaboxes_producttab_fields(); 
    if( $fields ){
        // 1st meta box
        $meta_boxes[] = array(
            // Meta box id, UNIQUE per meta box. Optional since 4.1.5
            'id'         => 'standard',
            // Meta box title - Will appear at the drag and drop handle bar. Required.
            'title'      => __( 'Product Tabs Info', "opal-themecontrol" ),
            // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
            'post_types' => array( 'producttab' ),
            // Where the meta box appear: normal (default), advanced, side. Optional.
            'context'    => 'normal',
            // Order of meta box: high (default), low. Optional.
            'priority'   => 'low',
            // Auto save: true, false (default). Optional.
            'autosave'   => true,
            // List of meta fields
            'fields'     => $fields 
        );
    }    
    return $meta_boxes;
}

/**
 * Register Metabox 
 */
add_filter( 'rwmb_meta_boxes', 'opal_themecontrol_func_producttabs_register_meta_boxes', 12);


/** 
 * Remove review to products tabs. and display this as block below the tab.
 */
function opalthemer_woocommerce_product_tabs( $tabs ){
    $args = array(
        'post_type'        => 'producttab',
    );
    $posts = get_posts( $args ); 

    if( !empty($posts) ){
        foreach( $posts as $post ){
             $tabs['producttab-'.$post->ID] = array(
                'title'    => $post->post_title,
                'priority' => 20,
                'callback' => 'opalthemer_woocommerce_product_tabs_content',
                'post_content'   => $post->post_content
            );
        }
    }
   
    wp_reset_postdata();

    return $tabs;
}
add_filter( 'woocommerce_product_tabs','opalthemer_woocommerce_product_tabs', 99 );

function opalthemer_woocommerce_product_tabs_content( $key, $data ){
    if( isset($data['post_content']) ){
        echo '<div class="custom-producttab">'. do_shortcode( $data['post_content'] ).'</div><div class="clear clearfix"></div>';
    }
}