<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    Opal_ThemeControl
 * @author     WpOpal Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2016 http://www.opalthemer.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.opalthemer.com
 * @support  http://www.opalthemer.com/questions/
 */

/**
 * Preset support for WordPress Theme Customize.
 *
 * @package  Opal_ThemeControl
 * @since    1.0
 */
if(!class_exists('Opal_Themecontrol_Customize_Control_Preset')):
class Opal_Themecontrol_Customize_Control_Preset extends WP_Customize_Control {
	public $type = 'preset';

	/**
	 * Variable to hold preset data.
	 *
	 * @var  array
	 */
	public $preset = array();

	/**
	 * Constructor.
	 *
	 * @param   WP_Customize_Manager  $manager  WordPress's Customize Manager object.
	 * @param   string                $id       Control ID.
	 * @param   array                 $args     Control arguments.
	 *
	 * @return  void
	 */
	public function __construct( $manager, $id, $args ) {
		parent::__construct( $manager, $id, $args );

		if ( isset( $args['preset'] ) && is_array( $args['preset'] ) ) {
			$this->preset = $args['preset'];
		}
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @return  void
	 */
	public function enqueue() {
		static $enqueued;

		if ( ! isset( $enqueued ) ) {
			wp_enqueue_script( 'opal-themecontrol-customize-preset', OPAL_THEMECONTROL_PLUGIN_URL . '/assets/js/customize/control/preset.js', array(), '1.0.0', true );

			wp_localize_script( 'opal-themecontrol-customize-preset', 'opal_themecontrol_customize_preset', array(
				'type'                => $this->type,
				'custom_preset_title' => esc_html__( 'Custom', 'opal-themecontrol' ),
			) );

			$enqueued = true;
		}
	}

	/**
	 * Render the control's content.
	 *
	 * @return  void
	 */
	public function render_content() {
		if ( $this->label ) {
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php
		}

		if ( $this->description ) {
			?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php
		}

		$value = $this->value();
		?>
		<div class="customize-control-content" id="opal-<?php echo esc_attr( $this->type ); ?>-<?php echo esc_attr( $this->id ); ?>">
			<a class="opal-image-selected <?php echo esc_attr( $value ); ?>" href="#" data-title="<?php
				if ( isset( $this->preset[ $value ]['title'] ) )
					echo esc_attr( $this->preset[ $value ]['title'] );
			?>">
				<ul class="colors-preset">
					<li style="background: <?php echo esc_attr( $this->preset[ $value ]['data']['custom_color'] ); ?>"></li>
					<li style="background: <?php echo esc_attr( $this->preset[ $value ]['data']['content_body_color']['heading_text'] ); ?>"></li>
					<li style="background: <?php echo esc_attr( $this->preset[ $value ]['data']['content_meta_color'] ); ?>"></li>
					<li style="background: <?php echo esc_attr( $this->preset[ $value ]['data']['general_line_color'] ); ?>"></li>
					<li style="background: <?php echo esc_attr( $this->preset[ $value ]['data']['general_overlay_color'] ); ?>"></li>
					<li style="background: <?php echo esc_attr( $this->preset[ $value ]['data']['general_fields_bg'] ); ?>"></li>
					<li style="background: <?php echo esc_attr( $this->preset[ $value ]['data']['opal_general_container_color'] ); ?>"></li>
				</ul>
				<i class="fa fa-angle-down"></i>
			</a>
			<ul class="opal-select-image-container">
				<?php foreach ( $this->preset as $val => $label ) { ?>
				<li class="opal-select-image <?php echo esc_attr( $val ); if ( checked( $value, $val, false ) ) echo ' selected'; ?>" data-title="<?php echo esc_attr( $label['title'] ); ?>">
					<ul class="colors-preset">
						<li style="background: <?php echo esc_attr( $label['data']['custom_color'] ); ?>"></li>
						<li style="background: <?php echo esc_attr( $label['data']['content_body_color']['heading_text'] ); ?>"></li>
						<li style="background: <?php echo esc_attr( $label['data']['content_meta_color'] ); ?>"></li>
						<li style="background: <?php echo esc_attr( $label['data']['general_line_color'] ); ?>"></li>
						<li style="background: <?php echo esc_attr( $label['data']['general_overlay_color'] ); ?>"></li>
						<li style="background: <?php echo esc_attr( $label['data']['general_fields_bg'] ); ?>"></li>
						<li style="background: <?php echo esc_attr( $label['data']['opal_general_container_color'] ); ?>"></li>
					</ul>
					<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $val ); ?>" <?php
						checked( $value, $val );
					?>>
					<?php if ( is_array( $label ) && isset( $label['image'] ) ) { ?>
					<img data-src="<?php echo esc_url( $label['image'] ); ?>" alt="<?php
						if ( is_array( $label ) && isset( $label['title'] ) )
							echo esc_attr( $label['title'] );
					?>">
					<?php } ?>
				</li>
				<?php } ?>
			</ul>
		</div>
		<?php echo '<scr' . 'ipt type="text/javascript">'; ?>
			new jQuery.WR_Preset_Control( {
				id: '<?php echo esc_js( $this->id ); ?>',
				preset: <?php echo json_encode( $this->preset ); ?>,
			} );
		<?php
		echo '</scr' . 'ipt>';
	}
}
endif;
