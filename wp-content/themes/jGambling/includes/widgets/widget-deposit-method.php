<?php

class deposit_method extends WP_Widget {

	function __construct() {
		parent::__construct(
			'deposit_method',
			__( 'DEPOSIT METHOD WIDGET', 'jgambling' )
		);
	}

	private $widget_fields = array();

	public function widget( $args, $instance ) {
		$num   = ! empty( $instance['count'] ) ? $instance['count'] : '';
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$cat   = ! empty( $instance['cat'] ) ? $instance['cat'] : '';
		$desc  = ! empty( $instance['desc'] ) ? $instance['desc'] : '';

		if ( ! $num ) {
			$num = 5;
		}

		if ( ! $title ) {
			$title = __( 'Deposit methods', 'jgambling' );
		}
		echo '<div class="payments-block"><div class="name">' . $title . '</div><p>' . $desc . '</p>';

		$terms = get_terms( [
			'taxonomy'   => 'deposit',
			'hide_empty' => false,
			'number'     => $num
		] );
		if ( $terms ):
			echo '<table>';
			foreach ( $terms as $term ) {
				$term_id           = $term->term_id;
				$term_mini_img_att = carbon_get_term_meta( $term_id, 'mini_img' );
				$term_mini_img_src = wp_get_attachment_url( $term_mini_img_att );
				echo '<tr>
                        <td><a href="' . get_term_link( $term_id, 'deposit' ) . '">' . $term->name . '</a></td>
                        <td><img class="lazy" data-src="' . $term_mini_img_src . '" alt=""></td>
                    </tr>';
			}
			echo '</table>';
		else:
			echo __( 'Deposit methods not found', 'jgambling' );
		endif;


		echo "</div>";


	}

	public function field_generator( $instance ) {
		$output = '';
		foreach ( $this->widget_fields as $widget_field ) {
			$default = '';
			if ( isset( $widget_field['default'] ) ) {
				$default = $widget_field['default'];
			}
			$widget_value = ! empty( $instance[ $widget_field['id'] ] ) ? $instance[ $widget_field['id'] ] : esc_html__( $default, 'textdomain' );
			switch ( $widget_field['type'] ) {
				default:
					$output .= '<p>';
					$output .= '<label for="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '">' . esc_attr( $widget_field['label'], 'textdomain' ) . ':</label> ';
					$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '" name="' . esc_attr( $this->get_field_name( $widget_field['id'] ) ) . '" type="' . $widget_field['type'] . '" value="' . esc_attr( $widget_value ) . '">';
					$output .= '</p>';
			}
		}
		echo $output;
	}

	public function form( $instance ) {
		$count = ! empty( $instance['count'] ) ? $instance['count'] : '';
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$desc  = ! empty( $instance['desc'] ) ? $instance['desc'] : '';
		?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo __( 'Widget title', 'jgambling' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php echo __( 'Count', 'jgambling' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $count ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>"><?php echo __( 'Short description', 'jgambling' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'desc' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'desc' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $desc ); ?>">
        </p>
		<?php
		$this->field_generator( $instance );
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		$instance['desc']  = ( ! empty( $new_instance['desc'] ) ) ? strip_tags( $new_instance['desc'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				default:
					$instance[ $widget_field['id'] ] = ( ! empty( $new_instance[ $widget_field['id'] ] ) ) ? strip_tags( $new_instance[ $widget_field['id'] ] ) : '';
			}
		}

		return $instance;
	}
}

function register_new_widget3() {
	register_widget( 'deposit_method' );
}

add_action( 'widgets_init', 'register_new_widget3' );
wp_reset_query();