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
 * Toggle custom control for WordPress Theme Customize.
 *
 * @package  Opal_ThemeControl
 * @since    1.0
 */
if(!class_exists('Opal_Themecontrol_Customize_Control_Toggle')):
class Opal_Themecontrol_Customize_Control_Toggle extends WP_Customize_Control {
	public $type = 'toggle';

	/**
	 * Render the control's content.
	 *
	 * @return  void
	 */
	public function render_content() {
		// Generate name for this custom control.
		$name = '_customize-toggle-' . $this->id;

		if ( ! empty( $this->label ) ) :
		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php
		endif;

		if ( ! empty( $this->description ) ) :
		?>
		<span class="description customize-control-description"><?php echo '' . $this->description ; ?></span>
		<?php endif; ?>
		<div class="opal-toggle-control switch" id="<?php echo esc_attr( $name ); ?>">
			<input type="checkbox" class="opal-toggle" id="<?php echo esc_attr( $this->id ); ?>-checkbox" value="1" <?php
				$this->link();
				checked( $this->value(), 1 );
			?>>
			<label for="<?php echo esc_attr( $this->id ); ?>-checkbox"></label>
		</div>
		<?php
	}
}
endif;