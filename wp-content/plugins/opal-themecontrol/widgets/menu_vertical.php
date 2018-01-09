<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author      Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2015  prestabrain.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.opalthemer.com
 * @support  http://www.opalthemer.com/questions/
 */

class Opal_Themecontrol_Menu_Vertical extends Opal_Themecontrol_Widget {
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'opalthemer_menu_vertical',
            // Widget name will appear in UI
            __('Opal Menu Vertical Widget', 'opal-themecontrol'),
            // Widget description
            array( 'description' => __( 'Show Menu Vertical', 'opal-themecontrol' ), )
        );
        $this->widgetName = 'menu_vertical';
    }

    public function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );
        $title = apply_filters( 'widget_title', $title );
        echo    $before_widget;
            require($this->renderLayout( 'default'));
        echo    $after_widget;
    }
    // Widget Backend
    public function form( $instance ) {
        $d = array(
            'menu' => '',
            'position' => ''
        );
        $instance = array_merge( $d, $instance );

        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( '', 'opal-themecontrol' );
        }
        
        if ( isset( $instance[ 'menu' ] ) ) {
            $opalthemer_menu = $instance[ 'menu' ];
        }else {
            $opalthemer_menu = array();
        }
        
        // Widget admin form        
        $menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
        foreach ($menus as $menu) {
            $option_menu[$menu->slug]=$menu->name;
        }
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'opal-themecontrol' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'menu' )); ?>">Menu:</label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'menu' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'menu' )); ?>">
                <option value="" <?php selected( $opalthemer_menu, $menu->term_id ); ?>> <?php _e('---Select Menu---', 'opal-themecontrol'); ?></option>
                <?php foreach ($menus as $key => $menu): ?>
                    <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $instance['menu'], $menu->term_id ); ?>><?php echo esc_html( $menu->name ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'position' )); ?>">Position:</label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'position' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'position' )); ?>">
                <option value="left" <?php selected( $instance['position'], 'left' ); ?>><?php _e( 'Left:', 'opal-themecontrol' ); ?></option>
                <option value="right" <?php selected( $instance['position'], 'right' ); ?>><?php _e( 'Right:', 'opal-themecontrol' ); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>">Template Style:</label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'layout' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>">
                <?php foreach ($this->selectLayout() as $key => $value): ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $instance['layout'], $value ); ?>><?php echo esc_html( $value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        
        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['menu'] = $new_instance['menu'];
        $instance['position'] = $new_instance['position'];
        $instance['layout'] = $new_instance['layout'];

        return $instance;

    }
}

register_widget( 'Opal_Themecontrol_Menu_Vertical' );