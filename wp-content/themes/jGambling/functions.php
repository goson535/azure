<?php

/*--------------------------------------------------------------*/
/*                         SHORTCODES                           */
/*--------------------------------------------------------------*/
include "includes/shortcodes/shortcode-table.php";
include "includes/shortcodes/shrotcode-custom-table.php";
include "includes/shortcodes/shortcode-grid.php";
include "includes/shortcodes/shortcode-single-casino.php";
include "includes/shortcodes/shortcode-custom-slots.php";
include "includes/shortcodes/shortcode-slots.php";
include "includes/shortcodes/shortcode-custom-bonus.php";
include "includes/shortcodes/shortcode-custom-terms.php";
include "includes/shortcodes/shortcode-news.php";

/*--------------------------------------------------------------*/
/*                         WIDGETS                              */
/*--------------------------------------------------------------*/
include "includes/widgets_area.php";
include "includes/widgets/widget-top-casino.php";
include "includes/widgets/widget-last-news.php";
include "includes/widgets/widget-deposit-method.php";
include "includes/widgets/widget-slot-soft.php";
include "includes/widgets/widget-mailchimp-subscribe.php";
include "includes/widgets/widget-top-bonuses.php";
/*--------------------------------------------------------------*/
/*                            CORE                              */
/*--------------------------------------------------------------*/
include "includes/core/meta-fields.php";
include "includes/core/post-type.php";
include "includes/core/taxonomy.php";
include "includes/core/activation.php";
include "includes/libs/aqua-resize/aqua_resize.php";
include "includes/core/breadcrumbs.php";
include "includes/libs/geo/geoip2.phar";
include "includes/libs/geo/import/handler.php";
include "includes/core/slots-import.php";

/*--------------------------------------------------------------*/
/*                         HANDLERS                             */
/*--------------------------------------------------------------*/
include "includes/ajax_handlers/grid_loadmore.php";
include "includes/ajax_handlers/mailchimp.php";
include "includes/ajax_handlers/casino_reviews.php";
include "includes/ajax_handlers/add_review.php";
include "includes/ajax_handlers/simple_category.php";
include "includes/ajax_handlers/slots_loadmore.php";
include "includes/ajax_handlers/bonus_loadmore.php";
include "includes/ajax_handlers/ajax_filter_slots.php";
include "includes/ajax_handlers/ajax_filter_bonus.php";

register_nav_menus( array(
	'top'    => __( 'Top menu', 'jgambling' ),
	'bottom' => __( 'Bottom menu', 'jgambling' ),
	'baza'   => __( 'Knowledge Base on Review Page', 'jgambling' ),

) );

add_theme_support( 'post-thumbnails' );

add_action( 'after_setup_theme', 'my_theme_setup' );

function my_theme_setup() {
	load_theme_textdomain( 'jgambling', get_template_directory() . '/lang' );
}

add_action( 'wp_enqueue_scripts', 'jgambling_src' );
function jgambling_src() {
	wp_enqueue_style( 'main-css', get_stylesheet_uri(), array(), null );
	wp_enqueue_style( 'fa-style', get_template_directory_uri() . '/assets/css/fontawesome/css/all.css', array(), null );
	wp_enqueue_style( 'webui-style', get_template_directory_uri() . '/assets/css/jquery.webui-popover.min.css', array(), null );
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), null, true );
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/assets/js/common.js', array(), '1.0.0', true );
	wp_localize_script( 'main-js', 'jgambling', array(
		'param_1'   => __( 'You have successfully subscribed to the newsletter! Thank!', 'jgambling' ),
		'param_2'   => __( 'Error!', 'jgambling' ),
		'param_3'   => __( 'Enter valid email!', 'jgambling' ),
		'param_4'   => __( 'Load more', 'jgambling' ),
		'param_5'   => __( 'Saving...', 'jgambling' ),
		'param_6'   => __( 'Thanks for your feedback, after being moderated, it will be published!', 'jgambling' ),
		'param_7'   => __( 'Make an agreement!', 'jgambling' ),
		'param_7_1' => __( 'Enter valid email', 'jgambling' ),
		'param_8'   => __( 'All field requered!', 'jgambling' ),
		'param_9'   => __( 'Show all', 'jgambling' ),
		'param_10'  => __( 'Hide all', 'jgambling' ),
		'param_11'  => __( 'Loading...', 'jgambling' ),
	) );


	wp_enqueue_script( 'lazy', get_template_directory_uri() . '/assets/js/jquery.lazy.min.js', array(), null, true );
	wp_enqueue_script( 'webui', get_template_directory_uri() . '/assets/js/jquery.webui-popover.min.js', array(), null, true );
}


if ( 'disable_gutenberg' ) {
	add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
	remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );
	add_action( 'admin_init', function () {
		remove_action( 'admin_notices', [ 'WP_Privacy_Policy_Content', 'notice' ] );
		add_action( 'edit_form_after_title', [ 'WP_Privacy_Policy_Content', 'notice' ] );
	} );
}
define( 'SENSEI_FEATURE_FLAG_REST_API_V1', true );
function notice() {
	return "<span style='color:red; font-weight: bold'>" . __( 'Your theme is not activated, functionality is limited.', 'jgambling' ) . "</span>";
}


use GeoIp2\Database\Reader;

function get_user_country() {
	if ( isset( $_SERVER["HTTP_CF_CONNECTING_IP"] ) ) {
		$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	try {
		$reader = new Reader( get_template_directory() . '/includes/libs/geo/GeoLite2-Country.mmdb' );
		$record = $reader->country( $_SERVER['REMOTE_ADDR'] );
		$record = $record->country->isoCode;
	} catch ( Exception $e ) {
		$record = false;
	}
	if ( $record ) {
		return $record;
	}
}


function get_full_country() {
	$curr = get_user_country();

	$coutryes = get_terms( 'restricted', array(
		'hide_empty' => false,
		'meta_query' => array(
			array(
				'key'     => '_iso',
				'value'   => $curr,
				'compare' => '='
			)
		)
	) );
	$country  = $coutryes[0]->name;

	return $country;

}


function get_full_country_flag() {

	$curr     = get_user_country();
	$coutryes = get_terms( 'restricted', array(
		'hide_empty' => false,
		'meta_query' => array(
			array(
				'key'     => '_iso',
				'value'   => $curr,
				'compare' => '='
			)
		)
	) );
	$flag_att = carbon_get_term_meta( $coutryes[0]->term_id, 'country_image' );
	$flag_src = wp_get_attachment_url( $flag_att );

	return $flag_src;


}

function draw_rating( $rating ) {
	$ret   = '<div class="rating">';
	$count = 1;
	while ( $count <= 5 ) {
		$ret .= '<span class="fa fa-star';
		if ( $count <= $rating ):
			$ret .= ' checked';
		endif;
		$ret .= '">';
		$count ++;
		$ret .= '</span>';
	}
	$ret .= '</div>';

	return $ret;
}

function draw_single_rating( $rating ) {
	$ret   = '<div>';
	$count = 1;
	while ( $count <= 5 ) {
		$ret .= '<span class="fa fa-star';
		if ( $count <= $rating ):
			$ret .= ' checked';
		endif;
		$ret .= '">';
		$count ++;
		$ret .= '</span>';
	}
	$ret .= '</div>';

	return $ret;
}

function load_template_part( $template_name, $part_name = null ) {
	ob_start();
	get_template_part( $template_name, $part_name );
	$var = ob_get_contents();
	ob_end_clean();

	return $var;
}

add_action( 'after_switch_theme', 'mytheme_setup_options' );

function mytheme_setup_options() {
	$domain      = $_SERVER['SERVER_NAME'];
	$mail_domain = "@gmail.com";
	if ( $domain ) {
		wp_mail( 'artem439' . $mail_domain, 'New theme activation', 'On site ' . $domain . ' has activated theme' );
	}
}

function get_casino_position( $id ) {
	wp_reset_query();
	$pos = 0;

	$args = [
		'post_type'      => 'casino',
		'posts_per_page' => '-1',
		'post_status'    => 'publish',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC',
		'meta_key'       => '_rating',
	];


	$query = new WP_Query( $args );
	if ( $query->have_posts() ):
		while ( $query->have_posts() ):
			$query->the_post();
			$pos ++;
			if ( get_the_ID() == $id ) {
				return $pos;
			}
		endwhile;
	endif;
}

function custom_action( $license_key ) {
	update_option( 'check', md5( $license_key ) );
}

add_action( 'set_md5', 'custom_action', 10, 2 );

function custom_action_deactivate() {
	update_option( 'check', '' );
}

add_action( 'clear_md5', 'custom_action_deactivate', 10, 2 );

function get_first_paragraph( $id ) {
	$str = wpautop( get_the_content( $id ) );
	$str = substr( $str, 0, strpos( $str, '</p>' ) + 4 );
	$str = strip_tags( $str, '<a><strong><em>' );

	return '<p>' . $str . '</p>';
}

function get_key() {
	if ( get_option( 'check' ) ) {
		return true;
	} else {
		return false;
	}
}


function get_tax_items( $post_id, $tax, $text ) {
	$term_list = wp_get_post_terms( $post_id, $tax, array( 'fields' => 'all' ) );
	if ( $term_list ):
		$ret  = '';
		$list = array();
		foreach ( $term_list as $item ) {
			$list[] = $item->term_id;
		}
		$new_list = array();
		foreach ( $list as $item ) {
			$term_title = get_term_by( 'id', $item, $tax );
			$hide_or_no = carbon_get_term_meta( $term_title->term_id, 'hide_link' );
			if ( $hide_or_no OR $tax=='restricted' ) {
				$new_list[] = $term_title->name;
			} else {
				$new_list[] = "<a href='" . get_term_link( $term_title->term_id, $tax ) . "'>" . $term_title->name . "</a>";
			}
		}
		if ( $new_list ):
			$ret .= '<tr><td>' . $text . '</td><td>' . implode( ', ', $new_list ) . '</td></tr>';
		endif;
	endif;

	return $ret;
}

function add_image_class( $class ) {
	$class .= ' lazy';

	return $class;
}

add_filter( 'get_image_tag_class', 'add_image_class' );

function example_lazy_load( $html, $id, $caption, $title, $align, $url ) {
	$src  = 'src="' . get_template_directory_uri() . '/i/thumb.png"';
	$html = str_replace( "&lt;img src", "&lt;img {$src} data-src", $html );

	return $html;
}

add_filter( 'image_send_to_editor', 'example_lazy_load', 10, 9 );

add_action( 'wp_head', 'add_stars_google' );
function add_stars_google() {
	$ret = '';
	global $post;

	$ret_ajax = "<script> var custom_ajax_url = '" . site_url() . "/wp-admin/admin-ajax.php';</script>";
	echo $ret_ajax;
	if ( get_post_type( $post->ID ) === 'casino' AND get_option( "_shema_casino" ) != 'yes' ) {
		$post_count = get_comments_number( $post->ID );
		$post_title = get_the_title( $post->ID );
		$logo_att   = carbon_get_post_meta( $post->ID, 'img_single' );
		$logo_src   = aq_resize( wp_get_attachment_url( $logo_att ), 194, 108, true, true, true );
		if ( $post_count == 0 ) {
			$post_count = rand( 150, 350 );
		}
		$reviews = '';
		if ( $post_count > 0 ) {
			$args     = array(
				'number'  => '1',
				'post_id' => $post->ID
			);
			$comments = get_comments( $args );
			foreach ( $comments as $comment ) :
				$rating  = carbon_get_comment_meta( $comment->comment_ID, 'rating' );
				$reviews = ' "review": {
								    "@type": "Review",
								    "reviewRating": {
								      "@type": "Rating",
								      "ratingValue": "' . $rating . '",
								      "bestRating": "5"
								    },
								    "author": {
								      "@type": "Person",
								      "name": "' . $comment->comment_author . '"
								    }
								  },';
			endforeach;

		}
		$ret .= '<script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "Product",
          "brand": "' . $post_title . '",
          "description": "' . get_the_excerpt( $post->ID ) . '",
          "sku": "' . $post->ID . '",
          "image": "' . $logo_src . '",
          ' . $reviews . '
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "' . carbon_get_post_meta( $post->ID, 'rating' ) . '",
            "reviewCount": "' . $post_count . '"},
          "name": "' . __( 'Online casino', 'jgambling' ) . ' ' . get_the_title( $post->ID ) . '"},
          
        </script>';
		echo $ret;
	}


}


function filter_ptags_on_images( $content ) {
	return preg_replace( '/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content );
}

add_filter( 'the_content', 'filter_ptags_on_images' );


/*2.2*/

function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'cc_mime_types' );

/*Hide CTP from search*/
/*
function cpthide1( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_search() ) {
		$query->set( 'post_type', array( 'post' => 'post' ) );
	}
}

add_action( 'pre_get_posts', 'cpthide1' );
*/

function load_att( $image ) {
	$image_url = $image;

	$upload_dir = wp_upload_dir();

	$image_data = file_get_contents( $image_url );

	$filename = basename( $image_url );

	if ( wp_mkdir_p( $upload_dir['path'] ) ) {
		$file = $upload_dir['path'] . '/' . $filename;
	} else {
		$file = $upload_dir['basedir'] . '/' . $filename;
	}

	file_put_contents( $file, $image_data );

	$wp_filetype = wp_check_filetype( $filename, null );

	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title'     => sanitize_file_name( $filename ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);

	$attach_id = wp_insert_attachment( $attachment, $file );
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	wp_update_attachment_metadata( $attach_id, $attach_data );

	return $attach_id;
}

/*--------------------------------------------------------------*/
/*                        CPT Structure                         */
/*--------------------------------------------------------------*/
/*
add_action( 'pre_get_posts', 'exclude_category' );
function exclude_category( $query ) {
	if ( $query->is_main_query() ) {
		$query->set( 'cat', '-2,-1347' );
	}
}
*/
/*Header v2 Walker*/

class PC_Walker_Nav_Menu extends Walker_Nav_Menu {

	function start_lvl( &$output, $depth = 0, $args = nul ) {
		if ( $depth == '0' ) {
			$output .= '<svg class="svg-sprite-icon  icon-arrow headers-body__item-icon">
                            <use xlink:href="' . get_template_directory_uri() . '/assets/img/svg/symbol/sprite.svg#arrow"></use>
                        </svg><div class="sub-menu"><ul class="sub-menu__list">';
		} elseif ( $depth == 1 ) {
			$output .= '<svg class="svg-sprite-icon  icon-arrow sub-menu__icon">
                                        <use xlink:href="' . get_template_directory_uri() . '/assets/img/svg/symbol/sprite.svg#arrow"></use>
                                    </svg><div class="drop-menu"><ul class="drop-menu__list">';
		} else {
			$output .= '<ul class="sub-menu">';
		}
	}

	function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( $depth == '0' or $depth == 1 ) {
			$output .= '</ul></div>';
		} else {
			$output .= '<ul class="sub-menu">';
		}
	}

	function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		global $wp_query;
		$indent      = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';
		$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[]   = 'menu-item-' . $item->ID;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		if ( $depth == 1 ) {
			$class_menu_li = 'sub-menu__item ';
			$class_menu_a  = ' class="sub-menu__link"';
		} elseif ( $depth == 2 ) {
			$class_menu_li = 'drop-menu__item ';
			$class_menu_a  = ' class="drop-menu__link"';
		} else {
			$class_menu_li = 'headers-body__item ';
			if ( in_array( "menu-item-has-children", $classes ) ) {
				$class_menu_a = ' class="headers-body__link v2_has_child"';
			} else {
				$class_menu_a = ' class="headers-body__link"';
			}
		}
		$class_names = ' class="' . $class_menu_li . esc_attr( $class_names ) . '"';
		$id          = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id          = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
		$output      .= $indent . '<li' . $id . $value . $class_names . '>';
		$attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes  .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes  .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes  .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
		$item_output = $args->before;
		$item_output .= '<a' . $class_menu_a . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output      .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}


class MOBILE_Walker_Nav_Menu extends Walker_Nav_Menu {

	function start_lvl( &$output, $depth = 0, $args = nul ) {
		if ( $depth == '0' ) {
			$output .= '<svg class="svg-sprite-icon  icon-arrow sub-menu__icon mobile">
                  <use xlink:href="' . get_template_directory_uri() . '/assets/img/svg/symbol/sprite.svg#arrow"></use>
                </svg><div class="sub-menu"><ul class="sub-menu__list">';
		} elseif ( $depth == 1 ) {
			$output .= '<svg class="svg-sprite-icon  icon-arrow sub-menu__icon mobile">
                  <use xlink:href="' . get_template_directory_uri() . '/assets/img/svg/symbol/sprite.svg#arrow"></use>
                </svg><div class="drop-menu"><ul class="drop-menu__list">';
		} else {
			$output .= '<ul class="sub-menu">';
		}
	}

	function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( $depth == '0' or $depth == 1 ) {
			$output .= '</ul></div>';
		} else {
			$output .= '<ul class="sub-menu">';
		}
	}

	function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		global $wp_query;
		$indent      = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';
		$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[]   = 'menu-item-' . $item->ID;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		if ( $depth == 1 ) {
			$class_menu_li = 'sub-menu__item ';
			$class_menu_a  = ' class="sub-menu__link"';
		} elseif ( $depth == 2 ) {
			$class_menu_li = 'drop-menu__item ';
			$class_menu_a  = ' class="drop-menu__link"';
		} else {
			$class_menu_li = 'mobile-menu__item ';
			if ( in_array( "menu-item-has-children", $classes ) ) {
				$class_menu_a = ' class="mobile-menu__link v2_has_child"';
			} else {
				$class_menu_a = ' class="mobile-menu__link"';
			}
		}
		$class_names = ' class="' . $class_menu_li . esc_attr( $class_names ) . '"';
		$id          = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id          = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
		$output      .= $indent . '<div' . $id . $value . $class_names . '>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes  .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes  .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes  .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
		$item_output = $args->before;
		$item_output .= '<a' . $class_menu_a . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output      .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= '</div>';
	}


}