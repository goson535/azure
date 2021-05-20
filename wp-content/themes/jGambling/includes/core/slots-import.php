<?php

add_action( 'admin_menu', 'slot_import' );
function slot_import() {
	add_options_page( 'Slots import', 'Slots Import', 'manage_options', 'slotsimport', 'slotsimport' );

}

function slotsimport() {
	echo '<div class="wrap">';
	if ( isset( $_REQUEST['impslots'] ) ) {
		$providers = $_POST['providers'];
		$ch = curl_init( 'http://api.thejema.ru/slots/get/?provider=' . implode( ',', $providers ) );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		$file = curl_exec( $ch );
		curl_close( $ch );
		$json_encoded = json_decode( $file );
		$added_slots  = array();
		if ( $file ) {
			foreach ( $json_encoded as $item ) {
				$title    = $item->title;
				$rtp      = $item->rtp;
				$iframe   = $item->iframe;
				$img      = $item->image;
				$provider = $item->provider;
				if ( $title ) {
					$post_data = array(
						'post_title'  => wp_strip_all_tags( $title ),
						'post_status' => 'publish',
						'post_type'   => 'slots',
					);
					$post_id   = wp_insert_post( $post_data );
					if ( $provider ) {
						wp_set_post_terms( $post_id, $provider, "software" );
					}
					if ( $post_id ) {
						if ( $rtp ):
							update_post_meta( $post_id, '_rtp', $rtp );
						endif;
						if ( $iframe ):
							update_post_meta( $post_id, '_demo', $iframe );
						endif;
						if ( $img ):
							update_post_meta( $post_id, '_slot_img_grid', load_att( $img ) );
						endif;
						array_push( $added_slots, $title );
					}
				}
			}
			if ( $added_slots ) {
				echo "<b style='color: green'>" . __( 'Added this slots: ', 'jgambling' ) . "" . implode( ', ', $added_slots ) . '</b>';
			}
		}
	}
	?>
    <form action="" method="post">
        <h3><?php echo __( 'Select the providers you want to import to the site.', 'jgambling' ) ?></h3>
        <h3><?php echo __( 'We recommend importing several providers at a time so as not to overload the server', 'jgambling' ) ?></h3>
        <b>If it displays an error:</b>
        <ul>
            <li>- Try re-defining WP_MEMORY_LIMIT and increase it to i.e. 1024MB</li>
            <li>- Try increasing the max_execution_time
                (https://thimpress.com/knowledge-base/how-to-increase-maximum-execution-time-for-wordpress-site/)
            </li>
        </ul>
        </p>
        <table class="form-table">
            <tr>
                <th style="width:100px;"><label for="langg"><?php echo __( 'Providers', 'jgambling' ); ?></label></th>
                <td>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="33">
                            2 By 2 Gaming</label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="25">
                            Amatic Industries</label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="16">Belatra Games
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="12">Betsoft
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="3">BF Games
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="24">BGaming
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="10">Big Time Gaming
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="14">Blueprint Gaming
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="27">Booming Games
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="17">Booongo
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="32">Cayetano Gaming
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="13">ELK Studios
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="23"> Endorphina
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="19">Foxium
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="29">GameArt
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="28">Habanero
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="26">Igrosoft
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="4">Microgaming
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="2">NetEnt
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="20">NetGame
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="30">NextGen Gaming
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="31">Novomatic
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="7">Play’n GO
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="15">Playson
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="34">Playtech
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="8">Pragmatic Play
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="21">PushGaming
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="11">Quickspin
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="22">Red Rake Gaming
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="6">Red Tiger Gaming
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="9">Relax Gaming
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="18">Thunderkick
                        </label>
                    </div>
                    <div>
                        <label for="providers">
                            <input type="checkbox" name="providers[]" value="5"> Yggdrasil Gaming
                        </label>
                    </div>


                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="impslots" value="Import" class="button-primary"/>
        </p>
    </form>
	<?php
	echo '</div>';
}