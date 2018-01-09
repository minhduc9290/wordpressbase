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
 * Typography custom control for WordPress Theme Customize.
 *
 * @package  Opal_ThemeControl
 * @since    1.0
 */
if(!class_exists('Opal_Themecontrol_Customize_Control_Upload_Font')):
class Opal_Themecontrol_Customize_Control_Upload_Font extends WP_Customize_Control {
	public $type = 'upload-font';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @return  void
	 */
	public function enqueue() {
		static $enqueued;

		if ( ! isset( $enqueued ) ) {
			// Enqueue media.
			wp_enqueue_media();

			// Enqueue custom control script.
			wp_enqueue_script( 'opal-themecontrol-customize-upload-font', OPAL_THEMECONTROL_PLUGIN_URL . '/assets/js/customize/control/upload-font.js', array(), '1.0.0', true );

			wp_localize_script( 'opal-themecontrol-customize-upload-font', 'opal_themecontrol_customize_upload_font', array(
				'type'              => $this->type,
				'select_font_label' => esc_html__( 'Select Font', 'opal-themecontrol' ),
				'change_font_label' => esc_html__( 'Change Font', 'opal-themecontrol' ),
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
			<div class="preview-font" style="margin:0 0 1em 0;border:1px dashed lightgray;padding:.75em 1em;background:#fff;"><?php
				esc_html_e( 'The quick brown fox jumps over the lazy dog', 'opal-themecontrol' );
			?></div>
			<div class="flex opal-custom-fonts">
				<button type="button" class="button upload-font"></button>
				<button type="button" class="button remove-font"><?php esc_html_e( 'Remove Font', 'opal-themecontrol' ); ?></button>
			</div>
		<?php
	}
}
endif;