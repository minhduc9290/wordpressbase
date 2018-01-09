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
 * Sub heading for WordPress Theme Customize.
 *
 * @package  Opal_ThemeControl
 * @since    1.0
 */
if(!class_exists('Opal_Themecontrol_Customize_Control_Heading')):
class Opal_Themecontrol_Customize_Control_Heading extends WP_Customize_Control {
	public $type = 'heading';

	/**
	 * Render the control's content.
	 *
	 * @return  void
	 */
	public function render_content() {
		// Generate name for this custom control.
		$name = '_customize-heading-' . $this->id;

		if ( ! empty( $this->label ) ) :
		?>
		<h4><?php echo esc_html( $this->label ); ?></h4>
		<?php
		endif;

		if ( ! empty( $this->description ) ) :
		?>
		<span class="description customize-control-description"><?php echo '' . $this->description ; ?></span>
		<?php endif;
	}
}
endif;
