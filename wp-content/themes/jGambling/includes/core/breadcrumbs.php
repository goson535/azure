<?php
function dimox_breadcrumbs() {
	if ( carbon_get_theme_option( 'hide_bread' ) ) {
		return false;
	}
	if ( carbon_get_theme_option( 'header_style' ) == 'v2' AND ! carbon_get_theme_option( 'v2_height' )) {
		$color_home = '#fac833';
	} else {
		$color_home = '#0F0F0F';
	}
	$text['home'] = '<svg width="13" height="11" viewBox="0 0 13 11" style="fill:' . mb_strtoupper( $color_home ) . ';" xmlns="http://www.w3.org/2000/svg">
<path d="M6.49999 2.41565L1.8636 6.23787C1.8636 6.24326 1.86225 6.2512 1.85954 6.26201C1.85688 6.27275 1.85547 6.28054 1.85547 6.28608V10.1565C1.85547 10.2962 1.90656 10.4173 2.00871 10.5193C2.11084 10.6213 2.23177 10.6727 2.37155 10.6727H5.46778V7.57628H7.53223V10.6728H10.6284C10.7682 10.6728 10.8893 10.6216 10.9913 10.5193C11.0934 10.4174 11.1447 10.2962 11.1447 10.1565V6.28608C11.1447 6.26461 11.1417 6.2484 11.1365 6.23787L6.49999 2.41565Z" fill="' . mb_strtoupper( $color_home ) . '" fill-opacity="1"/>
<path d="M12.9103 5.36697L11.1445 3.89943V0.609525C11.1445 0.534315 11.1204 0.472464 11.0718 0.424056C11.0237 0.375704 10.9619 0.351529 10.8865 0.351529H9.33834C9.26304 0.351529 9.20122 0.375704 9.15278 0.424056C9.10446 0.472464 9.08031 0.534343 9.08031 0.609525V2.18188L7.11288 0.536885C6.94105 0.397112 6.73675 0.32724 6.50019 0.32724C6.26365 0.32724 6.05938 0.397112 5.88738 0.536885L0.0896012 5.36697C0.0358556 5.4099 0.00639857 5.46768 0.000919507 5.54027C-0.00453131 5.61279 0.01425 5.67614 0.0573199 5.72986L0.557242 6.32657C0.600312 6.37492 0.656684 6.40449 0.726584 6.41531C0.791118 6.42073 0.855653 6.40187 0.920187 6.35888L6.50002 1.70613L12.0799 6.35885C12.123 6.39636 12.1793 6.41508 12.2492 6.41508H12.2735C12.3433 6.40446 12.3995 6.3747 12.4428 6.32646L12.9428 5.72983C12.9858 5.676 13.0046 5.61277 12.999 5.54015C12.9935 5.46777 12.964 5.40998 12.9103 5.36697Z" fill="' . mb_strtoupper( $color_home ) . '" fill-opacity="1"/>
</svg>
&nbsp; ' . __( 'Homepage', 'jgambling' );
	//$text['home']     = '<img src="' . get_template_directory_uri() . '/assets/img/svg/home_icon.svg">&nbsp;&nbsp; ' . __( 'Homepage', 'jgambling' );
	$text['category'] = '%s';
	$text['search']   = __( 'Search result for', 'jgambling' ) . ' "%s"';
	$text['tag']      = __( 'Tags', 'jgambling' ) . '"%s"';
	$text['author']   = __( 'Author articles', 'jgambling' ) . ' %s';
	$text['404']      = __( 'Error 404', 'jgambling' ) . '';
	$text['page']     = __( 'Page', 'jgambling' ) . ' %s';
	$text['cpage']    = __( 'Comment page', 'jgambling' ) . ' %s';

	$wrap_before = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">';
	$wrap_after  = '</div><!-- .breadcrumbs -->';
	$sep         = '<span class="breadcrumbs__separator"> › </span>';
	$before      = '<span class="breadcrumbs__current">';
	$after       = '</span>';

	$show_on_home   = 0;
	$show_home_link = 1;
	$show_current   = 1;
	$show_last_sep  = 1;


	global $post;
	$home_url  = home_url( '/' );
	$link      = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	$link      .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
	$link      .= '<meta itemprop="position" content="%3$s" />';
	$link      .= '</span>';
	$parent_id = ( $post ) ? $post->post_parent : '';
	$home_link = sprintf( $link, $home_url, $text['home'], 1 );

	if ( is_home() || is_front_page() ) {

		if ( $show_on_home ) {
			echo $wrap_before . $home_link . $wrap_after;
		}

	} else {

		$position = 0;

		echo $wrap_before;

		if ( $show_home_link ) {
			$position += 1;
			echo $home_link;
		}

		if ( is_category() ) {
			$parents = get_ancestors( get_query_var( 'cat' ), 'category' );
			foreach ( array_reverse( $parents ) as $cat ) {
				$position += 1;
				if ( $position > 1 ) {
					echo $sep;
				}
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$cat      = get_query_var( 'cat' );
				echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) {
						echo $sep;
					}
					echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
				} elseif ( $show_last_sep ) {
					echo $sep;
				}
			}

		} elseif ( is_search() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $show_home_link ) {
					echo $sep;
				}
				echo sprintf( $link, $home_url . '?s=' . get_search_query(), sprintf( $text['search'], get_search_query() ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current ) {
					if ( $position >= 1 ) {
						echo $sep;
					}
					echo $before . sprintf( $text['search'], get_search_query() ) . $after;
				} elseif ( $show_last_sep ) {
					echo $sep;
				}
			}

		} elseif ( is_year() ) {
			if ( $show_home_link && $show_current ) {
				echo $sep;
			}
			if ( $show_current ) {
				echo $before . get_the_time( 'Y' ) . $after;
			} elseif ( $show_home_link && $show_last_sep ) {
				echo $sep;
			}

		} elseif ( is_month() ) {
			if ( $show_home_link ) {
				echo $sep;
			}
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ), $position );
			if ( $show_current ) {
				echo $sep . $before . get_the_time( 'F' ) . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}

		} elseif ( is_day() ) {
			if ( $show_home_link ) {
				echo $sep;
			}
			$position += 1;
			echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ), $position ) . $sep;
			$position += 1;
			echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ), $position );
			if ( $show_current ) {
				echo $sep . $before . get_the_time( 'd' ) . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}

		} elseif ( is_single() && ! is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$position  += 1;
				$post_type = get_post_type_object( get_post_type() );
				if ( $position > 1 ) {
					echo $sep;
				}
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->labels->name, $position );
				if ( $show_current ) {
					echo $sep . $before . get_the_title() . $after;
				} elseif ( $show_last_sep ) {
					echo $sep;
				}
			} else {
				$cat       = get_the_category();
				$catID     = $cat[0]->cat_ID;
				$parents   = get_ancestors( $catID, 'category' );
				$parents   = array_reverse( $parents );
				$parents[] = $catID;
				foreach ( $parents as $cat ) {
					$position += 1;
					if ( $position > 1 ) {
						echo $sep;
					}
					echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				}
				if ( get_query_var( 'cpage' ) ) {
					$position += 1;
					echo $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
					echo $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
				} else {
					if ( $show_current ) {
						echo $sep . $before . get_the_title() . $after;
					} elseif ( $show_last_sep ) {
						echo $sep;
					}
				}
			}

		} elseif ( is_post_type_archive() ) {
			$post_type = get_post_type_object( get_post_type() );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				if ( $position > 1 ) {
					echo $sep;
				}
				echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) {
					echo $sep;
				}
				if ( $show_current ) {
					echo $before . $post_type->label . $after;
				} elseif ( $show_home_link && $show_last_sep ) {
					echo $sep;
				}
			}

		} elseif ( is_attachment() ) {
			$parent    = get_post( $parent_id );
			$cat       = get_the_category( $parent->ID );
			$catID     = $cat[0]->cat_ID;
			$parents   = get_ancestors( $catID, 'category' );
			$parents   = array_reverse( $parents );
			$parents[] = $catID;
			foreach ( $parents as $cat ) {
				$position += 1;
				if ( $position > 1 ) {
					echo $sep;
				}
				echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
			}
			$position += 1;
			echo $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
			if ( $show_current ) {
				echo $sep . $before . get_the_title() . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}

		} elseif ( is_page() && ! $parent_id ) {
			if ( $show_home_link && $show_current ) {
				echo $sep;
			}
			if ( $show_current ) {
				echo $before . get_the_title() . $after;
			} elseif ( $show_home_link && $show_last_sep ) {
				echo $sep;
			}

		} elseif ( is_page() && $parent_id ) {
			$parents = get_post_ancestors( get_the_ID() );
			foreach ( array_reverse( $parents ) as $pageID ) {
				$position += 1;
				if ( $position > 1 ) {
					echo $sep;
				}
				echo sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
			}
			if ( $show_current ) {
				echo $sep . $before . get_the_title() . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}

		} elseif ( is_tag() ) {
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				$tagID    = get_query_var( 'tag_id' );
				echo $sep . sprintf( $link, get_tag_link( $tagID ), single_tag_title( '', false ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) {
					echo $sep;
				}
				if ( $show_current ) {
					echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
				} elseif ( $show_home_link && $show_last_sep ) {
					echo $sep;
				}
			}

		} elseif ( is_author() ) {
			$author = get_userdata( get_query_var( 'author' ) );
			if ( get_query_var( 'paged' ) ) {
				$position += 1;
				echo $sep . sprintf( $link, get_author_posts_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
				echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current ) {
					echo $sep;
				}
				if ( $show_current ) {
					echo $before . sprintf( $text['author'], $author->display_name ) . $after;
				} elseif ( $show_home_link && $show_last_sep ) {
					echo $sep;
				}
			}

		} elseif ( is_404() ) {
			if ( $show_home_link && $show_current ) {
				echo $sep;
			}
			if ( $show_current ) {
				echo $before . $text['404'] . $after;
			} elseif ( $show_last_sep ) {
				echo $sep;
			}

		} elseif ( has_post_format() && ! is_singular() ) {
			if ( $show_home_link && $show_current ) {
				echo $sep;
			}
			echo get_post_format_string( get_post_format() );
		}

		echo $wrap_after;

	}
} // end of dimox_breadcrumbs()
