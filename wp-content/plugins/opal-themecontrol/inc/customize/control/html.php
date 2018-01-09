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
 * HTML based dropdown select box custom control for WordPress Theme Customize.
 *
 * @package  Opal_ThemeControl
 * @since    1.0
 */
if(!class_exists('Opal_Themecontrol_Customize_Control_HTML')):
class Opal_Themecontrol_Customize_Control_HTML extends WP_Customize_Control {
	public $type = 'html';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @return  void
	 */
	public function enqueue() {
		static $enqueued;

		if ( ! isset( $enqueued ) ) {
			wp_enqueue_script( 'opal-themecontrol-customize-html', OPAL_THEMECONTROL_PLUGIN_URL . '/assets/js/customize/control/html.js', array(), '1.0.0', true );

			wp_localize_script( 'opal-themecontrol-customize-html', 'opal_themecontrol_customize_html', array(
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
		<div class="customize-control-content-html" id="opal-<?php echo esc_attr( $this->type ); ?>-<?php echo esc_attr( $this->id ); ?>">
			<?php foreach ( $this->choices as $val => $label ) { ?>
			<div title="<?php
			if ( is_array( $label ) && isset( $label['title'] ) )
				echo esc_attr( $label['title'] );
			?>" class="opal-html <?php if ( checked( $value, $val, false ) ) echo 'selected'; ?>">
				<?php
					if ( is_array( $label ) && isset( $label['html'] ) )
						echo wp_kses(
							$label['html'],
							array(
								'a' => array(
									'data-section' => array(),
									'href'         => array(),
									'class'        => array()
								),
								'div' => array(
									'class' => array()
								),
								'span' => array(
									'class' => array()
								),
								'h3' => array(
									'class' => array()
								)
							)
						);
					else
						echo wp_kses(
							$label,
							array(
								'a' => array(
									'data-section' => array(),
									'href'         => array(),
									'class'        => array()
								),
								'div' => array(
									'class' => array()
								),
								'span' => array(
									'class' => array()
								),
								'h3' => array(
									'class' => array()
								)
							)
						);
				?>
				<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" title="<?php
					if ( is_array( $label ) && isset( $label['title'] ) )
						echo esc_attr( $label['title'] );
				?>" value="<?php echo esc_attr( $val ); ?>" <?php
					checked( $value, $val );
				?>>
			</div>
			<?php } ?>
		</div>
		<?php
	}
}
endif;
