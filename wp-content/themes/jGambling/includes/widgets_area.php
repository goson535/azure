<?php
function jgambling_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Homepage', 'jgambling' ),
		'id'            => 'home-right',
		'before_widget' => '<div class="custom_widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="name">',
		'after_title'   => '</div>',
		'description'   => esc_html__( 'Right on homepage', 'jgambling' )
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Casino rating', 'jgambling' ),
		'id'            => 'rating',
		'before_widget' => '<div class="custom_widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="name">',
		'after_title'   => '</div>',
		'description'   => esc_html__( 'Right on casino rating page', 'jgambling' )
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Casino review left sidebar', 'jgambling' ),
		'id'            => 'single-casino-left',
		'before_widget' => '<div class="custom_widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="name">',
		'after_title'   => '</div>',
		'description'   => esc_html__( 'Casino review page left sidebar after bonuses', 'jgambling' )
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Casino review right sidebar', 'jgambling' ),
		'id'            => 'single-casino-right',
		'before_widget' => '<div class="custom_widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="name">',
		'after_title'   => '</div>',
		'description'   => esc_html__( 'Casino review page right sidebar after "All about ... casino"', 'jgambling' )
	) );


	register_sidebar( array(
		'name'          => esc_html__( 'Category page and single post', 'jgambling' ),
		'id'            => 'category_single',
		'before_widget' => '<div class="custom_widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="name">',
		'after_title'   => '</div>',
		'description'   => esc_html__( 'Category page and single post on right', 'jgambling' )
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Slots sidebar', 'jgambling' ),
		'id'            => 'slots',
		'before_widget' => '<div class="custom_widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="name">',
		'after_title'   => '</div>',
		'description'   => esc_html__( 'After filter', 'jgambling' )
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Bonus page', 'jgambling' ),
		'id'            => 'bonuses',
		'before_widget' => '<div class="custom_widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="name">',
		'after_title'   => '</div>',
		'description'   => esc_html__( 'Right', 'jgambling' )
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'jgambling' ),
		'id'            => 'footer1',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
		'description'   => esc_html__( 'Footer 1', 'jgambling' ),
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'jgambling' ),
		'id'            => 'footer2',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
		'description'   => esc_html__( 'Footer 2', 'jgambling' ),
	) );


	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'jgambling' ),
		'id'            => 'footer3',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
		'description'   => esc_html__( 'Footer 3', 'jgambling' ),
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'jgambling' ),
		'id'            => 'footer4',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
		'description'   => esc_html__( 'Footer 4', 'jgambling' ),
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 5', 'jgambling' ),
		'id'            => 'footer5',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
		'description'   => esc_html__( 'Footer 5', 'jgambling' ),
	) );
}
add_action( 'widgets_init', 'jgambling_widgets_init' );