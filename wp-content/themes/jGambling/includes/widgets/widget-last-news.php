<?php

class last_news extends WP_Widget {

	function __construct() {
		parent::__construct(
			'last_news',
			__( 'LAST NEWS WIDGET', 'jgambling' )
		);
	}

	private $widget_fields = array();

	public function widget( $args, $instance ) {
		$num       =! empty( $instance['count'] ) ? $instance['count'] : '';
		$title     =! empty( $instance['title'] ) ? $instance['title'] : '';
		$cat       = ! empty( $instance['cat'] ) ? $instance['cat'] : '';
		$full_link = ! empty( $instance['full_link'] ) ? $instance['full_link'] : '';

		if ( ! $num ) {
			$num = 5;
		}

		if ( ! $title ) {
			$title = __( 'Last news', 'jgambling' );
		}
		echo '<div class="last-news"><div class="name">' . $title . '</div>';
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => $num,


		);
		if ( $cat ) {
			$args['cat'] = $cat;
		}
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {

			while ( $query->have_posts() ):
				$query->the_post();
				echo '<div class="item">
                    <a href="' . get_the_permalink() . '"><img class="lazy" data-src="' . aq_resize( get_the_post_thumbnail_url( get_the_ID(), 'full' ), 62, 62, true, true, true ) . '" alt="' . get_the_title() . '"></a>
                    <div class="content">
                        <div class="date">' . get_the_date( 'd F' ) . '</div>
                        <a href="' . get_the_permalink() . '">' . get_the_title() . '</a>
                    </div>
                    <div class="clear"></div>
                </div>';

			endwhile;
		} else {
			echo __( 'No news', 'jgambling' );
		}
		wp_reset_query();
		if ( $full_link ) {
			echo '<a href="' . $full_link . '" class="more">'.__( 'Show more', 'jgambling' ).' <img class="lazy" alt="more" data-src="'.get_template_directory_uri().'/assets/img/svg/right-arrow 2.svg"></a>';
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
		$count     = ! empty( $instance['count'] ) ? $instance['count'] : '';
		$title     = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$cat       = ! empty( $instance['cat'] ) ? $instance['cat'] : '';
		$full_link = ! empty( $instance['full_link'] ) ? $instance['full_link'] : '';
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
            <label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php echo __( 'Cats ID(,)', 'jgambling' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'cat' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $cat ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'full_link' ) ); ?>"><?php echo __( 'Link to full list', 'jgambling' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'full_link' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'full_link' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $full_link ); ?>">
        </p>
		<?php
		$this->field_generator( $instance );
	}

	public function update( $new_instance, $old_instance ) {
		$instance              = array();
		$instance['count']     = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		$instance['title']     = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['full_link'] = ( ! empty( $new_instance['full_link'] ) ) ? strip_tags( $new_instance['full_link'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				default:
					$instance[ $widget_field['id'] ] = ( ! empty( $new_instance[ $widget_field['id'] ] ) ) ? strip_tags( $new_instance[ $widget_field['id'] ] ) : '';
			}
		}

		return $instance;
	}
}

function register_new_widget2() {
	register_widget( 'last_news' );
}

add_action( 'widgets_init', 'register_new_widget2' );

