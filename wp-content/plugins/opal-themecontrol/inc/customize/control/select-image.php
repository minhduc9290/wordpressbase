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
 * Select image custom control for WordPress Theme Customize.
 *
 * @package  Opal_ThemeControl
 * @since    1.0
 */
if(!class_exists('Opal_Themecontrol_Customize_Control_Select_Image')):
class Opal_Themecontrol_Customize_Control_Select_Image extends WP_Customize_Control {
	public $type = 'select-image';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @return  void
	 */
	public function enqueue() {
		static $enqueued;

		if ( ! isset( $enqueued ) ) {
			wp_enqueue_script( 'opal-themecontrol-customize-select-image', OPAL_THEMECONTROL_PLUGIN_URL . '/assets/js/customize/control/select-image.js', array(), '1.0.0', true );

			wp_localize_script( 'opal-themecontrol-customize-select-image', 'opal_themecontrol_customize_select_image', array(
				'type' => $this->type,
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
			<a class="opal-image-selected <?php echo esc_attr( $value ); ?>" href="#"><span><span class="first"></span><span class="last"></span></span></a>
			<ul class="opal-select-image-container">
				<?php foreach ( $this->choices as $val => $label ) { ?>
				<li class="opal-select-image <?php echo esc_attr( $val ); if ( checked( $value, $val, false ) ) echo ' selected'; ?>">
					<span><span class="first"></span><span class="last"></span></span>
					<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $val ); ?>" <?php
						checked( $value, $val );
					?>>
				</li>
				<?php } ?>
			</ul>
		</div>
		<?php
	}
}
endif;
