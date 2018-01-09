<?php

function opalthemer_themer_is_edit_page($new_edit = null){
    global $pagenow;
    //make sure we are on the backend
 


    if($new_edit == "edit")
        return in_array( $pagenow, array( 'post.php',  ) );
    elseif($new_edit == "new") //check for new post page
        return in_array( $pagenow, array( 'post-new.php' ) );
    else //check for either new or edit
        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}


/**
 *
 */
function opalthemer_themer_setup_admin_setting(){


	
	if( opalthemer_themer_is_edit_page() ){ 	
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		wp_enqueue_script( 'custom-admin-scripts', get_template_directory_uri() . '/js/custom-admin.js', array( 'jquery'  ), '20131022', true );
	}

	wp_enqueue_style( 'custom-admin-css', get_template_directory_uri() . '/css/custom-admin.css', array(), '3.0.3' );	


}
add_action( 'init', 'opalthemer_themer_setup_admin_setting'  );


function opalthemer_themer_fnc_megamenu_item_config_toplevel( $item ) {
	
      $item_id = esc_attr( $item->ID );
?>
       	<p class="field-class_icon description description-wide">   
	        <label for="edit-menu-item-class_icon-<?php echo esc_attr($item_id); ?>"><?php esc_html_e( 'Icon Class:', "woosa" ); ?> <br>
	            <input type="text" name="menu-item-class_icon[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->class_icon); ?>">
	        </label>
       	</p>
<?php 
}
add_action( 'opalthemer_megamenu_item_config_toplevel', 'opalthemer_themer_fnc_megamenu_item_config_toplevel' );


if (!function_exists('opalthemer_themer_fnc_custom_nav_update')) {
    add_action('wp_update_nav_menu_item', 'opalthemer_themer_fnc_custom_nav_update',10, 3);
    function opalthemer_themer_fnc_custom_nav_update($menu_id, $menu_item_db_id, $args ) {
      	$fields = array( 'class_icon' );
      	foreach( $fields as $field ){
	        if(!isset($_POST['menu-item-'.$field][$menu_item_db_id])){
	            $_POST['menu-item-'.$field][$menu_item_db_id] = "";
	        }
	        $custom_value = $_POST['menu-item-'.$field][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, $field, $custom_value );
      	}
    }
}