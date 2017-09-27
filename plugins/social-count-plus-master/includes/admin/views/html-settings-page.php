<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap">

	<?php include dirname( __FILE__ ) . '/html-help-us.php'; ?>

	<form method="post" action="options.php">
		<?php
			if ( 'design' == $current_tab ) {
				settings_fields( 'socialcountplus_design' );
				do_settings_sections( 'socialcountplus_design' );
				submit_button();
			} elseif ( 'shortcodes' == $current_tab ) {
				include dirname( __FILE__ ) . '/html-settings-functions-shortcodes-page.php';
			} elseif ( 'system_status' == $current_tab ) {
				include dirname( __FILE__ ) . '/html-settings-system-status-page.php';
			} else {
				$options      = self::get_plugin_options();
				$options      = $options['socialcountplus_settings'];
				$options_keys = array_keys( $options );
				$last         = end( $options_keys );

				echo '<ul class="subsubsub">';
				foreach ( $options as $section => $data ) {
					echo '<li><a href="#section-' . esc_attr( $section ) . '">' . esc_html( $data['title'] ) .  '</a>';
					echo $last !== $section ? ' | ' : '';
					echo '</li>';
				}
				echo '</ul><br class="clear">';

				settings_fields( 'socialcountplus_settings' );
				do_settings_sections( 'socialcountplus_settings' );
				submit_button();
			}
		?>
	</form>
	<table id="social-count-plus-system-status" class="widefat" cellspacing="0">

		<thead>
			<tr>
				<th colspan="2"><?php _e( 'Environment', 'social-count-plus' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><?php _e( 'Web Server Info', 'social-count-plus' ); ?>:</td>
				<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
			</tr>
			<tr>
				<td><?php _e( 'PHP Version', 'social-count-plus' ); ?>:</td>
				<td><?php if ( function_exists( 'phpversion' ) ) { echo esc_html( phpversion() ); } ?></td>
			</tr>
			<tr>
				<?php
					$connection_status = 'error';
					$connection_note   = __( 'Your server does not have fsockopen or cURL enabled. The scripts which communicate with the social APIs will not work. Contact your hosting provider.', 'social-count-plus' );

					if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
						if ( function_exists( 'fsockopen' ) && function_exists( 'curl_init' ) ) {
							$connection_note = __( 'Your server has fsockopen and cURL enabled.', 'social-count-plus' );
						} elseif ( function_exists( 'fsockopen' ) ) {
							$connection_note = __( 'Your server has fsockopen enabled, cURL is disabled.', 'social-count-plus' );
						} else {
							$connection_note = __( 'Your server has cURL enabled, fsockopen is disabled.', 'social-count-plus' );
						}

						$connection_status = 'yes';
					}
				?>
				<td><?php _e( 'fsockopen/cURL', 'social-count-plus' ); ?>:</td>
				<td>
					<mark class="<?php echo $connection_status; ?>">
						<?php echo $connection_note; ?>
					</mark>
				</td>
			</tr>
			<tr>
				<?php
					$remote_status = 'error';
					$remote_note   = __( 'wp_remote_get() failed. This may not work with your server.', 'social-count-plus' );
					$response      = wp_remote_get( 'https://httpbin.org/ip', array( 'timeout' => 60 ) );

					if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
						$remote_status = 'yes';
						$remote_note   = __( 'wp_remote_get() was successful.', 'social-count-plus' );
					} elseif ( is_wp_error( $response ) ) {
						$remote_note = __( 'wp_remote_get() failed. This plugin won\'t work with your server. Contact your hosting provider. Error:', 'social-count-plus' ) . ' ' . $response->get_error_message();
					}
				?>
				<td><?php _e( 'WP Remote Get', 'social-count-plus' ); ?>:</td>
				<td>
					<mark class="<?php echo $remote_status; ?>">
						<?php echo $remote_note; ?>
					</mark>
				</td>
			</tr>
		</tbody>
	</table>
</div>
