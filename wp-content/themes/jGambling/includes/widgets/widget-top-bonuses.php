<?php

class top_bonus extends WP_Widget {

	function __construct() {
		parent::__construct(
			'top_bonus',
			__( 'BONUSES WIDGET', 'jgambling' )
		);
	}

	private $widget_fields = array();

	public function widget( $args, $instance ) {
		$num   = ! empty( $instance['count'] ) ? $instance['count'] : '';
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		if ( ! $num ) {
			$num = 5;
		}

		if ( ! $title ) {
			$title = __( 'Casino bonuses', 'jgambling' );
		}

		$b_static = carbon_get_theme_option( 'top10' );
		$b_hover  = carbon_get_theme_option( 'top10_hover' );
		if ( $b_static || $b_hover ) {
			echo "<style>";
			if ( $b_static ) {
				echo '.top-casinos a.play{background: ' . $b_static . '! important;}';
			}
			if ( $b_hover ) {
				echo '.top-casinos a.play:hover{background: ' . $b_hover . '! important;}';
			}
			echo "</style>";
		}


		echo '<div class="top-bonuses"><div class="name">' . $title . '</div>';
		$args  = array(
			'post_type'      => 'bonus',
			'posts_per_page' => $num,


		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {

			while ( $query->have_posts() ):
				$query->the_post();
				$image_att     = carbon_get_post_meta( get_the_ID(), 'img_table' );
				$image_rounded = wp_get_attachment_url( $image_att );
				$rating_ceil   = ceil( carbon_get_post_meta( get_the_ID(), 'rating' ) );
				$ref           = carbon_get_post_meta( get_the_ID(), 'ref' );
				$casino        = carbon_get_post_meta( get_the_ID(), 'cas' )[0]['id'];
				$logo_att      = carbon_get_post_meta( $casino, 'img_table' );
				$logo_src      = aq_resize( wp_get_attachment_url( $logo_att ), 55, 55, true, true, true );
				$summa         = carbon_get_post_meta( get_the_ID(), 'summa' );
				echo ' <div class="item">
                        <div><img class="lazy" data-src="' . $logo_src . '" alt=""></div>
                        <div>
                            <a href="' . get_the_permalink() . '">' . get_the_title() . '</a>
                            <span>' . $summa . '</span>
                        </div>
                    </div>';

			endwhile;
		} else {
			echo __( 'Bonuses not found', 'jgambling' );
		}
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
		?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php echo __( 'Count', 'jgambling' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $count ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo __( 'Widget title', 'jgambling' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>
		<?php
		$this->field_generator( $instance );
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				default:
					$instance[ $widget_field['id'] ] = ( ! empty( $new_instance[ $widget_field['id'] ] ) ) ? strip_tags( $new_instance[ $widget_field['id'] ] ) : '';
			}
		}

		return $instance;
	}
}

function register_new_widget5() {
	register_widget( 'top_bonus' );
}

add_action( 'widgets_init', 'register_new_widget5' );

wp_reset_query();
?>
