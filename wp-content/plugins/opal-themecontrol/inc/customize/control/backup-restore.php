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
 * Backup / restore custom control for WordPress Theme Customize.
 *
 * @package  Opal_ThemeControl
 * @since    1.0
 */
if(!class_exists('Opal_Themecontrol_Customize_Control_Backup_Restore')):
class Opal_Themecontrol_Customize_Control_Backup_Restore extends WP_Customize_Control {
	public $type = 'backup-restore';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @return  void
	 */
	public function enqueue() {
		static $enqueued;

		if ( ! isset( $enqueued ) ) {
			// Enqueue necessary assets.
			wp_enqueue_media();

			wp_enqueue_script( 'opal-themecontrol-customize-backup-restore', OPAL_THEMECONTROL_PLUGIN_URL . '/assets/js/customize/control/backup-restore.js', array(), '1.0.0', true );

			wp_localize_script( 'opal-themecontrol-customize-backup-restore', 'opal_themecontrol_customize_backup_restore', array(
				'type'            => $this->type,
				'dismiss'         => esc_html__( 'Dismiss this message.', 'opal-themecontrol' ),
				'restore_url'     => admin_url( 'admin-ajax.php?action=opalthemer_restore_settings' ),
				'restore_nonce'   => wp_create_nonce( 'nitro_restore_settings' ),
				'select_button'   => __( 'Select', 'opal-themecontrol' ),
				'select_backup'   => __( 'Select backup file', 'opal-themecontrol' ),
				'change_backup'   => __( 'Change backup file', 'opal-themecontrol' ),
				'restore_button'  => __( 'Restore', 'opal-themecontrol' ),
				'restore_success' => esc_html__(
					'Successfully restored theme options from backup file. Please reload to see restored settings.',
					'opal-themecontrol'
				),
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
		<div class="customize-control-content-backup-restore" id="opal-<?php echo esc_attr( $this->type ); ?>-<?php echo esc_attr( $this->id ); ?>">
			<ul>
				<li><a class="nitro-backup-settings button" class="welcome-icon dashicons-backup" href="<?php
					echo add_query_arg(
						'nonce',
						wp_create_nonce( 'nitro_backup_settings' ),
						admin_url( 'admin-ajax.php?action=nitro_backup_settings' )
					);
				?>">
					<?php esc_html_e( 'Backup Theme Options', 'opal-themecontrol' ); ?>
				</a></li>
				<li><a class="nitro-restore-settings button" class="welcome-icon dashicons-update" href="#">
					<?php esc_html_e( 'Restore Theme Options', 'opal-themecontrol' ); ?>
				</a></li>
			</ul>
			<div class="nitro-restore-settings-form hidden">
				<input type="hidden" name="backup-file" value="" />
				<div class="nitro-upload-backup">
					<p class="selected-file"></p>
					<a class="select-file" href="javascript:void(0)">
						<?php esc_html_e( 'Select backup file', 'opal-themecontrol' ); ?>
					</a>
					<br />
					<a class="remove-file hidden" href="javascript:void(0)">
						<?php esc_html_e( 'Remove backup file', 'opal-themecontrol' ); ?>
					</a>
				</div>
				<a class="restore-backup hidden" href="javascript:void(0)">
					<?php esc_html_e( 'Restore', 'opal-themecontrol' ); ?>
				</a>
			</div>
		</div>
		<?php
	}
}
endif;
