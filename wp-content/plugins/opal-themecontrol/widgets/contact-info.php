<?php

class Opal_Themecontrol_Contact_Info_Widget extends Opal_Themecontrol_Widget {

    
    private $params;
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'opalthemer_contact_info',
            // Widget name will appear in UI
            __('Opal Contact Info Widget', 'opal-themecontrol'),
            // Widget description
            array( 'description' => __( 'Add contact information. ', 'opal-themecontrol' ), )
        );
        $this->widgetName = 'contact-info';
        
        $this->params = array(
            'title' => __('Title', 'opal-themecontrol'), 
            'description' => __('Description', 'opal-themecontrol'), 
            'company' => __('Company', 'opal-themecontrol'), 
            'country' => __('Country', 'opal-themecontrol'), 
            'locality' => __('Locality', 'opal-themecontrol'),
            'region' => __('Region', 'opal-themecontrol'),
            'street' => __('Street', 'opal-themecontrol'),
            'working-days' => __('Working Days', 'opal-themecontrol'),
            'working-hours' => __('Working Hours', 'opal-themecontrol'),
            'phone' => __('Phone', 'opal-themecontrol'),
            'mobile' => __('Mobile', 'opal-themecontrol'),
            'fax' => __('Fax', 'opal-themecontrol'),
            'skype' => __('Skype', 'opal-themecontrol'),
            'email-address' => __('Email Address', 'opal-themecontrol'),
            'email' => __('Email', 'opal-themecontrol'),
            'website-url' => __('Website URL', 'opal-themecontrol'),
            'website' => __('Website', 'opal-themecontrol')
        );
    }


    function widget($args, $instance) {
        extract( $args );
        extract( $instance );

        $title = apply_filters('widget_title', $instance['title']);
        echo    $before_widget;
            require($this->renderLayout( 'default'));
        echo    $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        
        foreach ($this->params as $key => $value){
            $instance[$key] = $new_instance[$key];
            $instance[$key.'_class'] = $new_instance[$key.'_class'];
        }
        return $instance;
    }

    function form($instance) {
        $defaults = array('title' => __('Contact Info', 'opal-themecontrol'));
        $instance = wp_parse_args((array) $instance, $defaults);
        $array_class = array('phone', 'mobile', 'fax', 'skype', 'email', 'website' );
        foreach ($this->params as $key => $value) :
        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id($key) ); ?>"><?php echo trim($value); ?>:</label>
                <?php if(in_array($key, $array_class)):?>
                    <input class="widefat" id="<?php echo esc_attr($this->get_field_id($key)); ?>" name="<?php echo esc_attr($this->get_field_name($key)); ?>" type="text" value="<?php if (isset($instance[$key])) echo esc_attr( $instance[$key] ); ?>" />
                    <label for="<?php echo esc_attr($this->get_field_id($key.'_class')); ?>"><?php echo 'Icon class '.$value ?>:</label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id($key.'_class')); ?>" name="<?php echo esc_attr($this->get_field_name($key.'_class')); ?>" type="text" value="<?php if (isset($instance[$key.'_class'])) echo esc_attr( $instance[$key.'_class'] ); ?>" />
                <?php else: ?>
                    <input class="widefat" id="<?php echo esc_attr($this->get_field_id($key)); ?>" name="<?php echo esc_attr($this->get_field_name($key)); ?>" type="text" value="<?php if (isset($instance[$key])) echo esc_attr( $instance[$key] ); ?>" />
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
        <script type="application/javascript">
        jQuery('.checkbox').on('click',function(){
            jQuery('.'+this.id).toggle();
        });
    </script>
    <?php
    }
}

register_widget( 'Opal_Themecontrol_Contact_Info_Widget' );