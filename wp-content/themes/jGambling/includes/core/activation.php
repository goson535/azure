<?php
/*--------------------------------------------------------------------------------------------*/
/*                                     ПРЕДУПРЕЖДЕНИЕ!                                        */
/*         В случае изменения данного файла или передачи файлов шаблона третьему лицу         */
/*                Ваша лицензия аннулируется, Вы лишаетесь всех обновлений                    */
/*         и сайты на котором будет стоять шаблон будут автоматически отправлены в РКН.       */
/*--------------------------------------------------------------------------------------------*/
define( 'YOUR_SPECIAL_SECRET_KEY', '5cf04e3b6a2f18.86105037' );
define( 'YOUR_LICENSE_SERVER_URL', 'http://api.thejema.ru' );
define( 'YOUR_ITEM_REFERENCE', 'jGambling' );
add_action( 'admin_menu', 'license_menu' );
function license_menu() { 
	add_menu_page( __( 'Activation', 'jgambling' ), __( 'Activation', 'jgambling' ), 'manage_options', __FILE__, 'sample_license_management_page', '
dashicons-media-text' );
}

function sample_license_management_page() {
	echo '<div class="wrap">';
	echo '<h2>' . __( 'Theme Activation', 'jgambling' ) . '</h2>';
	if ( get_key() ) {
		echo "<div style='color: green;border: 2px solid green;padding: 6px;font-weight: 700; width: 700px;'>" . __( 'Your theme is already activated. You can unlink a license to link to another domain.', 'jgambling' ) . "</div>";
	} else {
		echo "<div style='color: red;border: 2px solid red;padding: 6px;font-weight: 700; width: 700px;'>" . __( 'Your theme is not yet activated. After activation, the full functionality of the template will be available.', 'jgambling' ) . "</div>";
	}
	if ( isset( $_REQUEST['activate_license'] ) ) {
		$license_key = $_REQUEST['sample_license_key'];
		$api_params  = array(
			'slm_action'        => 'slm_activate',
			'secret_key'        => YOUR_SPECIAL_SECRET_KEY,
			'license_key'       => $license_key,
			'registered_domain' => $_SERVER['SERVER_NAME'],
			'item_reference'    => urlencode( YOUR_ITEM_REFERENCE ),
		);
		$query       = esc_url_raw( add_query_arg( $api_params, YOUR_LICENSE_SERVER_URL ) );
		$response    = wp_remote_get( $query, array( 'timeout' => 20, 'sslverify' => false ) );
		if ( is_wp_error( $response ) ) {
			echo "Unexpected Error! The query returned with an error.";
		}
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		if ( $license_data->result == 'success' ) {
			echo '<br /><strong>Response:</strong> ' . $license_data->message;
			update_option( 'license_key', $license_key );
			do_action( 'set_md5', $license_key );

		} else {
			echo '<br /><strong>Response:</strong> : ' . $license_data->message;
		}
	}
	if ( isset( $_REQUEST['deactivate_license'] ) ) {
		$license_key = $_REQUEST['sample_license_key'];
		$api_params  = array(
			'slm_action'        => 'slm_deactivate',
			'secret_key'        => YOUR_SPECIAL_SECRET_KEY,
			'license_key'       => $license_key,
			'registered_domain' => $_SERVER['SERVER_NAME'],
			'item_reference'    => urlencode( YOUR_ITEM_REFERENCE ),
		);
		$query       = esc_url_raw( add_query_arg( $api_params, YOUR_LICENSE_SERVER_URL ) );
		$response    = wp_remote_get( $query, array( 'timeout' => 20, 'sslverify' => false ) );
		if ( is_wp_error( $response ) ) {
			echo "Unexpected Error! The query returned with an error.";
		}
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		if ( $license_data->result == 'success' ) {
			echo '<br /><strong>Response:</strong> : ' . $license_data->message;
			update_option( 'sample_license_key', '' );
			do_action( 'clear_md5', $license_key );

		} else {
			echo '<br /><strong>Response:</strong> : ' . $license_data->message;
		}
	}
	?>
    <p><?php echo __( 'Enter the activation key for the template you received when purchasing this template.', 'jgambling' ); ?></p>
    <small><?php echo __( 'After activacion refresh page =).', 'jgambling' ); ?></small>
    <form action="" method="post">
        <table class="form-table">
            <tr>
                <th style="width:100px;"><label for="sample_license_key">Key</label></th>
                <td><input class="regular-text" type="text" id="sample_license_key" name="sample_license_key"
                           value="<?php echo get_option( 'sample_license_key' ); ?>"></td>
            </tr>
        </table>
        <p class="submit">
            <input style="width: 140px;" type="submit" name="activate_license" value="Activate" class="button-primary"/>
            <input style="width: 140px;" type="submit" name="deactivate_license" value="Deactivate" class="button"/>
        </p>
    </form>
	<?php
	echo '</div>';
}

/*--------------------------------------------------------------------------------------------*/
/*                                     ПРЕДУПРЕЖДЕНИЕ!                                        */
/*         В случае изменения данного файла или передачи файлов шаблона третьему лицу         */
/*                Ваша лицензия аннулируется, Вы лишаетесь всех обновлений                    */
/*         и сайты на котором будет стоять шаблон будут автоматически отправлены в РКН.       */
/*--------------------------------------------------------------------------------------------*/