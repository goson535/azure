<?php

add_action( 'admin_menu', 'geo_terms' );
function geo_terms() {
	add_options_page( 'GEO Import', 'GEO Import', 'manage_options', 'importgeo', 'importing_geo' );

}

function importing_geo() {
	echo '<div class="wrap">';
	echo '<h2>' . __( 'Import of "Restricted Country" terms with fields', 'jgambling' ) . '</h2>';
	echo '<h4>' . __( 'Import 190 countries into a taxonomy, and adds the country value and flag picture for each ISO taxonomy.', 'jgambling' ) . '</h4>';
	$arr = array();
	//print_r( json_encode( $arr ) );
	if ( isset( $_REQUEST['impgeo'] ) ) {
		$lang = $_POST['langg'];
		if ( $lang ) {
			if ( $lang != 'none' ) {
				$file = file_get_contents( get_template_directory_uri() . '/includes/libs/geo/import/' . $lang . '.json' );
				//print_r( $file );
				$json_encoded = json_decode( $file );
				$added_tax    = array();
				if ( $file ) {
					foreach ( $json_encoded as $item ) {
						$name     = $item->name;
						$iso      = $item->iso;
						$flag_url = $item->img;
						if ( $name ) {
							$insert_data = wp_insert_term( $name, 'restricted', array(
								'description' => '',
								'slug'        => '',
							) );
							if ( ! is_wp_error( $insert_data ) ) {
								$term_id = $insert_data['term_id'];
							}
							if ( $term_id ) {
								if ( $iso ):
									update_term_meta( $term_id, '_iso', $iso );
								endif;
								if ( $flag_url ):
									update_term_meta( $term_id, '_country_image', load_att( $flag_url ) );
								endif;
								array_push( $added_tax, $name );
							}
						}
					}
					if ( $added_tax ) {
						echo "<b style='color: green'>" . __( 'Added this country: ', 'jgambling' ) . "" . implode( ', ', $added_tax ) . '</b>';
					}
				}

			} else {
				echo "<b style='color: red'>" . __( 'Select language!', 'jgambling' ) . "</b>";
			}
		} else {
			echo "<b style='color: red'>" . __( 'Select language!', 'jgambling' ) . "</b>";
		}
	}
	?>
    <form action="" method="post">
        <p><?php echo __( 'If you have already filled in any terms in this taxonomy, it is recommended that you delete them to avoid duplicates.', 'jgambling' ) ?></p>
        <table class="form-table">
            <tr>
                <th style="width:100px;"><label for="langg"><?php echo __( 'Language', 'jgambling' ); ?></label></th>
                <td>
                    <select id="langg" name="langg">
                        <option value="none"><?php echo __( 'Select Language', 'jgambling' ); ?></option>
                        <option value="ru"><?php echo __( 'Russian', 'jgambling' ); ?></option>
                        <option value="eng"><?php echo __( 'English country', 'jgambling' ); ?></option>
                    </select>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="impgeo" value="Import" class="button-primary"/>
        </p>
    </form>
	<?php
	echo '</div>';
}