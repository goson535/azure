<?php

class top_casino extends WP_Widget {

	function __construct() {
		parent::__construct(
			'new_widget',
			__( 'TOP CASINO WIDGET', 'jgambling' )
		);
	}

	private $widget_fields = array();

	public function widget( $args, $instance ) {
		$num   = ! empty( $instance['count'] ) ? $instance['count'] : '';
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$geo   = ! empty( $instance['geo'] ) ? $instance['geo'] : '';

		if ( ! $num ) {
			$num = 5;
		}

		if ( ! $title ) {
			$title = __( 'Top casino', 'jgambling' );
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


		echo '<div class="top-casinos"><div class="name">' . $title;
		if ( $geo AND get_full_country() ) {
			echo '<div class="tool-tip">
            <i class="tool-tip__icon">?</i>
            <p class="tool-tip__info">
            ' . __( 'The list of casinos allowed in', 'jgambling' ) . ' ' . get_full_country() . ' 
            </p>
          </div>';
		}
		echo '</div>';
		$args = array(
			'post_type'      => 'casino',
			'posts_per_page' => $num,
			'order'          => 'DESC',
			'meta_key'       => '_rating',
			'orderby'        => 'meta_value_num',

		);

		if ( $geo ) {
			//Fetch RC terms
			$current_user_country = get_user_country();
			$term_args            = array( 'taxonomy' => 'restricted', 'number' => 999, 'hide_empty' => false );
			$terms                = get_terms( $term_args );
			$term_ids             = array();
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$val = carbon_get_term_meta( $term->term_id, 'iso' );
					if ( $val == $current_user_country ) {
						$term_ids[] = $term->term_id;
					}
				}
			}
			if ( sizeof( $term_ids ) ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'restricted',
						'field'    => 'id',
						'terms'    => $term_ids,
						'operator' => 'NOT IN',
					)
				);
			}
		}
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {

			while ( $query->have_posts() ):
				$query->the_post();
				$image_att     = carbon_get_post_meta( get_the_ID(), 'img_table' );
				$image_rounded = wp_get_attachment_url( $image_att );
				$rating_ceil   = ceil( carbon_get_post_meta( get_the_ID(), 'rating' ) );
				$ref           = carbon_get_post_meta( get_the_ID(), 'ref' );
				echo '  <div class="item">
                    <a href="' . get_the_permalink() . '">
                    <img src="' . $image_rounded . '" class="logo" alt="' . get_the_title() . '">' . get_the_title() . '</a>' . draw_rating( $rating_ceil ) . '
                    <a class="play" href="' . $ref . '">' . __( 'Play ', 'jgambling' ) . '</a>
                </div>';

			endwhile;
		} else {
			echo __( 'No casino reviews found', 'jgambling' );
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
		$geo   = ! empty( $instance['geo'] ) ? $instance['geo'] : '';
		echo $geo;
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
        <hr>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'geo' ) ); ?>"><?php echo __( 'Casino by GEO location', 'jgambling' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'geo' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'geo' ) ); ?>" type="checkbox"
                   value="1" <?php if ( $geo ) {
				echo ' checked ';
			} ?>>
        </p>
        <hr>
		<?php
		$this->field_generator( $instance );
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['geo']   = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['geo'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				default:
					$instance[ $widget_field['id'] ] = ( ! empty( $new_instance[ $widget_field['id'] ] ) ) ? strip_tags( $new_instance[ $widget_field['id'] ] ) : '';
			}
		}

		return $instance;
	}
}

function register_new_widget() {
	register_widget( 'top_casino' );
}

add_action( 'widgets_init', 'register_new_widget' );

wp_reset_query();