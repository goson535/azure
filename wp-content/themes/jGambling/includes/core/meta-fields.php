<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
	/* Theme setting */
	if ( get_key() ):
		Container::make( 'theme_options', "jGambling" )
		         ->set_icon( 'dashicons-sos' )
		         ->add_tab( __( "General Options", "jgambling" ), array(
			         Field::make( 'separator', 'crb_styls1', __( "Header", "jgambling" ) ),
			         Field::make( 'select', 'header_style', __( "Head", 'jgambling' ) )
			              ->add_options( array(
				              'v1' => 'v1',
				              'v2' => 'v2'
			              ) ),
			         Field::make( 'text', 'v2_height', __( "Header height v2(157 or 250)", "jgambling" ) ),
			         Field::make( 'checkbox', 'hide_search', __( "Hide search form from header", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'hide_buttom', __( "Hide buttom menu from header", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'hide_comments', __( "Hide comment form from posts", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'hide_bread', __( "Hide breadcrumbs", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'image', 'logo', __( "Site logo(134*30)", "jgambling" ) ),
			         Field::make( 'separator', 'crb_style_options11', __( "Comments", "jgambling" ) ),
			         Field::make( 'text', 'comment_count', __( "Comment count for one AJAX load", "jgambling" ) ),
			         Field::make( 'separator', 'crb_style_options33', __( "MailChimp integration", "jgambling" ) ),
			         Field::make( 'text', 'list_id', __( "List ID", "jgambling" ) ),
			         Field::make( 'text', 'api_key', __( "Api key", "jgambling" ) ),
			         Field::make( 'text', 'api_num', __( "Server name API", "jgambling" ) ),

			         Field::make( 'separator', 'crb_style_options121', __( "Homepage banner", "jgambling" ) ),
			         Field::make( 'image', 'banner_img', __( "Image banner(1200*...)", "jgambling" ) ),
			         Field::make( 'text', 'banner_link', __( "Image link", "jgambling" ) ),
			         Field::make( 'separator', 'crb_style_options1213', __( "Custom Codes", "jgambling" ) ),
			         Field::make( 'textarea', 'header_code', __( "Custom code in header", "jgambling" ) ),
			         Field::make( 'textarea', 'footer_code', __( "Custom code in footer", "jgambling" ) ),

		         ) )
		         ->add_tab( __( "Taxonomy Options", "jgambling" ), array(
			         Field::make( 'text', 'casino_slug', __( "Casino slug (Default 'casino')(For delete slug install plugin 'Remove CPT base')", "jgambling" ) ),
			         Field::make( 'text', 'bonus_slug', __( "Bonus slug (Default 'bonus')(For delete slug install plugin 'Remove CPT base')", "jgambling" ) ),
			         Field::make( 'text', 'slot_slug', __( "Slots slug (Default 'slots')(For delete slug install plugin 'Remove CPT base')", "jgambling" ) ),
			         Field::make( 'separator', 'vis', __( "Taxonomy visibility", "jgambling" ) ),
			         Field::make( 'checkbox', 'page_dm', __( "Don't create pages for taxonomy terms 'Deposit Methods'", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'page_cyr', __( "Don't create pages for taxonomy terms 'Currency'", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'page_cashout', __( "Don't create pages for taxonomy terms 'Cashout'", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'page_soft', __( "Don't create pages for taxonomy terms 'Soft'(Casino)", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'page_restricted', __( "Don't create pages for taxonomy terms 'Restricted Country'", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'page_license', __( "Don't create pages for taxonomy terms 'License'", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'page_software', __( "Don't create pages for taxonomy terms 'Software'(Slots)", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'page_type', __( "Don't create pages for taxonomy terms 'Bonus Type'", "jgambling" ) )->set_option_value( 'yes' ),

		         ) )
		         ->add_tab( __( "Casinos", "jgambling" ), array(
			         Field::make( 'text', 'h1_casino', __( "H1 on casino archive page", "jgambling" ) ),
			         Field::make( 'rich_text', 'before_list_casino', __( "Text before casino table on archive page", "jgambling" ) ),
			         Field::make( 'rich_text', 'after_list_casino', __( "Text after casino table on archive page", "jgambling" ) ),
			         Field::make( 'checkbox', 'shema_casino', __( "Hide shema from casino page", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'hide_reviews_and_form', __( "Hide reviews(and form)", "jgambling" ) )->set_option_value( 'yes' ),

		         ) )
		         ->add_tab( __( "Slots", "jgambling" ), array(
			         Field::make( 'text', 'slot_count', __( "Slot count on slots archive page", "jgambling" ) ),
			         Field::make( 'text', 'slot_h1', __( "H1 on slots archive page", "jgambling" ) ),
			         Field::make( 'rich_text', 'before_list', __( "Text before slots list on archive page", "jgambling" ) ),
			         Field::make( 'rich_text', 'after_list', __( "Text after slots list on archive page", "jgambling" ) ),
			         Field::make( 'image', 'nobackslot', __( "Background image under game frame on slot page", "jgambling" ) ),
		         ) )
		         ->add_tab( __( "Bonuses", "jgambling" ), array(
			         Field::make( 'checkbox', 'show_bonus_casino_img', __( "Show on bonus item casino logo", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'text', 'bonus_count', __( "Count of bonus items per AJAX load on archive page", "jgambling" ) ),
			         Field::make( 'text', 'bonus_h1', __( "H1 on bonus archive page", "jgambling" ) ),
			         Field::make( 'rich_text', 'before_bonus', __( "Text before bonus list on archive page", "jgambling" ) ),
			         Field::make( 'rich_text', 'after_bonus', __( "Text after bonus list on archive page", "jgambling" ) ),
			         Field::make( 'color', 'bonus_back', __( "Bonus item background color", "jgambling" ) ),
			         Field::make( 'color', 'bonus_text_color', __( "Bonus item text color", "jgambling" ) ),
			         Field::make( 'checkbox', 'show_bonuses_on_casino_review', __( "Show casino from CPT in casino review page", "jgambling" ) )->set_option_value( 'yes' ),

			         Field::make( 'association', 'w_tax', __( "Select taxonomy WELCOME BONUS", "jgambling" ) )
			              ->set_types( array(
				              array(
					              'type'     => 'term',
					              'taxonomy' => 'type',
				              )
			              ) )->set_min( 1 )->set_max( 1 )->set_conditional_logic( array(
					         array(
						         'field' => 'show_bonuses_on_casino_review',
						         'value' => 1,
					         )
				         ) ),

			         Field::make( 'association', 'fs_tax', __( "Select taxonomy FREESPINS", "jgambling" ) )
			              ->set_types( array(
				              array(
					              'type'     => 'term',
					              'taxonomy' => 'type',
				              )
			              ) )->set_min( 1 )->set_max( 1 )->set_conditional_logic( array(
					         array(
						         'field' => 'show_bonuses_on_casino_review',
						         'value' => 1,
					         )
				         ) ),
			         Field::make( 'association', 'nd_tax', __( "Select taxonomy NO DEPOSIT BONUS", "jgambling" ) )
			              ->set_types( array(
				              array(
					              'type'     => 'term',
					              'taxonomy' => 'type',
				              )
			              ) )->set_min( 1 )->set_max( 1 )->set_conditional_logic( array(
					         array(
						         'field' => 'show_bonuses_on_casino_review',
						         'value' => 1,
					         )
				         ) ),
			         Field::make( 'association', 'r_tax', __( "Select taxonomy RELOAD", "jgambling" ) )
			              ->set_types( array(
				              array(
					              'type'     => 'term',
					              'taxonomy' => 'type',
				              )
			              ) )->set_min( 1 )->set_max( 1 )->set_conditional_logic( array(
					         array(
						         'field' => 'show_bonuses_on_casino_review',
						         'value' => 1,
					         )
				         ) ),

			         Field::make( 'association', 'c_tax', __( "Select taxonomy CASHBACK", "jgambling" ) )
			              ->set_types( array(
				              array(
					              'type'     => 'term',
					              'taxonomy' => 'type',
				              )
			              ) )->set_min( 1 )->set_max( 1 )->set_conditional_logic( array(
					         array(
						         'field' => 'show_bonuses_on_casino_review',
						         'value' => 1,
					         )
				         ) ),

		         ) )
		         ->add_tab( __( "Theme colors", "jgambling" ), array(
			         Field::make( 'color', 'menucolor', __( "Menu background", "jgambling" ) ),
			         Field::make( 'color', 'menucolor_v2', __( "Menu background(v2)", "jgambling" ) ),
			         Field::make( 'separator', 'bu', __( "Buttons", "jgambling" ) ),
			         Field::make( 'color', 'table', __( "Button colors in tables", "jgambling" ) ),
			         Field::make( 'color', 'table_hover', __( "Button colors on hover in table", "jgambling" ) ),
			         Field::make( 'color', 'top10', __( "Button color in TOP widget", "jgambling" ) ),
			         Field::make( 'color', 'top10_hover', __( "Button color on hover in TOP widget", "jgambling" ) ),
			         Field::make( 'color', 'grid', __( "Button color in casino grid", "jgambling" ) ),
			         Field::make( 'color', 'grid_hover', __( "Buton color on hover in grid casino", "jgambling" ) ),
			         Field::make( 'color', 'other', __( "Others buttons color", "jgambling" ) ),
			         Field::make( 'color', 'other_hover', __( "Others buttons color on hover", "jgambling" ) ),
			         Field::make( 'separator', 'bu1', __( "Bonus blocks color in single casino page", "jgambling" ) ),
			         Field::make( 'color', 'color-no-deposit', __( "No-deposit bonus backgound color", "jgambling" ) ),
			         Field::make( 'color', 'color-welcome', __( "Welcome bonus backgound color", "jgambling" ) ),
			         Field::make( 'color', 'color-reload', __( "Reload bonus backgound color", "jgambling" ) ),
			         Field::make( 'color', 'color-freespins', __( "FreeSpins bonus backgound color", "jgambling" ) ),
			         Field::make( 'color', 'color-cashback', __( "Cashback bonus backgound color", "jgambling" ) ),
			         Field::make( 'separator', 'bu2', __( "Stars color", "jgambling" ) ),
			         Field::make( 'color', 'color-stars', __( "Stars color", "jgambling" ) ),
		         ) )
		         ->add_tab( __( "Social networks", "jgambling" ), array(
			         Field::make( 'text', 'vk', "Vkontakte" ),
			         Field::make( 'text', 'fb', "FaceBook" ),
			         Field::make( 'text', 'tw', "Twitter" ),
		         ) );

		/*Reviews field*/
		Container::make( 'comment_meta', __( "Review fields", "jgambling" ) )
		         ->add_fields( array(
			         Field::make( 'text', 'rating', __( "User rating", "jgambling" ) ),
			         Field::make( 'textarea', 'plus', __( "Positive", "jgambling" ) ),
			         Field::make( 'textarea', 'minus', __( "Negative", "jgambling" ) ),
		         ) );

		/*Categories*/
		Container::make( 'term_meta', __( "Category fields", "jgambling" ) )
		         ->where( 'term_taxonomy', '=', 'category' )
		         ->add_fields( array(
			         Field::make( 'rich_text', 'before', __( "Text before posts list", "jgambling" ) ),
			         Field::make( 'rich_text', 'after', __( "Text after post list", "jgambling" ) ),
		         ) );


		/* Casino review */
		Container::make( 'post_meta', __( "Casino fields", "jgambling" ) )
		         ->where( 'post_type', '=', 'casino' )
		         ->or_where( 'post_template', '=', 'template-page-casino-review.php' )
		         ->add_tab( __( "General information", "jgambling" ), array(
				         Field::make( 'text', 'ref', __( "Refferal link to casino(or redirect page)", "jgambling" ) ),
				         Field::make( 'text', 'ref_text', __( "Refferal button text", "jgambling" ) ),
				         Field::make( 'text', 'custom_h1', __( "Custom H1 title. Leave blank if need to use casino name.", "jgambling" ) ),
				         Field::make( 'text', 'rating', __( "Rating", "jgambling" ) ),
				         Field::make( 'image', 'img_grid', __( "Logo casino for grid(211*84)", "jgambling" ) ),
				         Field::make( 'image', 'img_table', __( "Logo casino for table(40*40)", "jgambling" ) ),
				         Field::make( 'image', 'img_single', __( "Logo casino for single page(194*108)", "jgambling" ) ),
				         Field::make( 'text', 'about_register', __( "Link 'All about ... casino'", "jgambling" ) ),
				         Field::make( 'checkbox', 'aval_pc', __( "Available from PC", "jgambling" ) )->set_option_value( 'yes' ),
				         Field::make( 'checkbox', 'aval_tablet', __( "Available from tablet", "jgambling" ) )->set_option_value( 'no' ),
				         Field::make( 'checkbox', 'aval_phone', __( "Available from phone", "jgambling" ) )->set_option_value( 'no' ),
				         Field::make( 'text', 'site', __( "Official site", "jgambling" ) ),
				         Field::make( 'text', 'founded', __( "Founded age", "jgambling" ) ),
				         Field::make( 'text', 'min_deposit', __( "Minimun deposit amount", "jgambling" ) ),
				         Field::make( 'text', 'min_cashout', __( "Minimum cash withdrawal", "jgambling" ) ),
				         Field::make( 'text', 'lang', __( "Lang", "jgambling" ) ),
				         Field::make( 'text', 'email', 'Email' ),
				         Field::make( 'text', 'live_chat', __( "Live-chat", "jgambling" ) ),
				         Field::make( 'text', 'support', __( "Support", "jgambling" ) ),
				         Field::make( 'text', 'custom_col', __( "Custom column data for table", "jgambling" ) ),
			         )
		         )
		         ->add_tab( __( __( "Custom fields", "jgambling" ) ), array(
			         Field::make( 'complex', 'c_fields_basic', __( "Fields for 'Basic information'", "jgambling" ) )
			              ->add_fields( array(
				              Field::make( 'text', 'basic_title', __( "Fields title", "jgambling" ) ),
				              Field::make( 'rich_text', 'basic_description', __( "Field description", "jgambling" ) ),
			              ) ),

			         Field::make( 'complex', 'c_fields_payment', __( "Fields for 'Payment info'", "jgambling" ) )
			              ->add_fields( array(
				              Field::make( 'text', 'payment_title', __( "Fields title", "jgambling" ) ),
				              Field::make( 'rich_text', 'payment_description', __( "Field description", "jgambling" ) ),
			              ) ),

			         Field::make( 'complex', 'c_fields_support', __( "Fields for 'Support'", "jgambling" ) )
			              ->add_fields( array(
				              Field::make( 'text', 'support_title', __( "Fields title", "jgambling" ) ),
				              Field::make( 'rich_text', 'support_description', __( "Field description", "jgambling" ) ),
			              ) ),


		         ) )
		         ->add_tab( __( __( "Casino advantages", "jgambling" ) ), array(
			         Field::make( 'complex', 'tab1', __( "Casino advantages(list)", "jgambling" ) )
			              ->set_layout( "grid" )
			              ->add_fields( array(
				              Field::make( 'text', 'plus', __( "Advantage", "jgambling" ) ),
			              ) ),


		         ) )
		         ->add_tab( __( __( "Casino cons", "jgambling" ) ), array(
			         Field::make( 'complex', 'tab2', __( "Casino cons(list)", "jgambling" ) )
			              ->set_layout( "grid" )
			              ->add_fields( array(
				              Field::make( 'text', 'plus', __( "Cons", "jgambling" ) ),
			              ) ),


		         ) )
		         ->add_tab( __( __( "Casino bonuses", "jgambling" ) ), array(
			         Field::make( 'separator', 'crb_style_options11', __( "Welcome bonus", "jgambling" ) ),
			         Field::make( 'text', 'welcome', __( "Welcome bonus amount", "jgambling" ) ),
			         Field::make( 'text', 'welcome_ref', __( "Welcome bonus refferal", "jgambling" ) ),
			         Field::make( 'rich_text', 'welcome_desc', __( "Welcome bonus description", "jgambling" ) ),
			         Field::make( 'separator', 'crb_style_options22', __( "Free spins", "jgambling" ) ),
			         Field::make( 'text', 'freespins', __( "Free Spins count", "jgambling" ) ),
			         Field::make( 'text', 'freespins_ref', __( "Free Spins refferal", "jgambling" ) ),
			         Field::make( 'rich_text', 'freespins_desc', __( "Free Spins description", "jgambling" ) ),
			         Field::make( 'separator', 'crb_style_options33', __( "No-deposit bonus", "jgambling" ) ),
			         Field::make( 'text', 'no_deposit', __( "No-deposit bonus amount", "jgambling" ) ),
			         Field::make( 'text', 'no_deposit_ref', __( "No-deposit bonus refferal", "jgambling" ) ),
			         Field::make( 'rich_text', 'no_deposit_desc', __( "No-deposit bonus description", "jgambling" ) ),
			         Field::make( 'separator', 'crb_style_options44', __( "Reload bonus", "jgambling" ) ),
			         Field::make( 'text', 'reload', __( "Reload bonus amount", "jgambling" ) ),
			         Field::make( 'text', 'reload_ref', __( "Reload bonus refferal", "jgambling" ) ),
			         Field::make( 'rich_text', 'reload_desc', __( "Reload bonus description", "jgambling" ) ),
			         Field::make( 'separator', 'crb_style_options55', __( "Cashback bonus", "jgambling" ) ),
			         Field::make( 'text', 'cashback', __( "Cashback bonus amount", "jgambling" ) ),
			         Field::make( 'text', 'cashback_ref', __( "Cashback bonus refferal", "jgambling" ) ),
			         Field::make( 'rich_text', 'cashback_desc', __( "Cashback bonus description", "jgambling" ) ),
		         ) );


		/* Slots review */
		Container::make( 'post_meta', __( "Slots field", "jgambling" ) )
		         ->where( 'post_type', '=', 'slots' )
		         ->add_tab( __( "General information", "jgambling" ), array(
			         Field::make( 'text', 'play_for_real', __( "Button 'Play for real'", "jgambling" ) ),
			         Field::make( 'image', 'slot_img_grid', __( "Slot image for grid list(165*245)", "jgambling" ) ),
			         Field::make( 'checkbox', 'bonus_game', __( "Bonus game", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'free_spins', __( "Free Spins", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'scatter_symbol', __( "Scatter symbol", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'wild_symbol', __( "Wild symbol", "jgambling" ) )->set_option_value( 'yes' ),
			         Field::make( 'checkbox', 'fast_spin', __( "Fast spin", "jgambling" ) )->set_option_value( 'yes' ),
		         ) )
		         ->add_tab( __( "Slot demo", "jgambling" ), array(
				         Field::make( 'textarea', 'demo', __( "Slot IFRAME(1200*600)", "jgambling" ) ),
			         )
		         );


		/* Bonus review */
		Container::make( 'post_meta', __( "Bonus fields", "jgambling" ) )
		         ->where( 'post_type', '=', 'bonus' )
		         ->add_tab( __( "General information", "jgambling" ), array(
			         Field::make( 'association', 'cas', __( "Select casino to which the bonus applies", "jgambling" ) )
			              ->set_types( array(
				              array(
					              'type'      => 'post',
					              'post_type' => 'casino',
				              )
			              ) )->set_min( 1 )->set_max( 1 ),
			         Field::make( 'rich_text', 'descr', __( "Bonus short description", "jgambling" ) ),
			         Field::make( 'text', 'wager', __( "Wager", "jgambling" ) ),
			         Field::make( 'text', 'bcode', __( "Bonus code (or n/a)", "jgambling" ) ),
			         Field::make( 'text', 'summa', __( "Bonus amount", "jgambling" ) ),
			         Field::make( 'text', 'ref_bonus', __( "Reffelar link(or from casino)", "jgambling" ) ),
		         ) );
		/*Deposit method*/
		Container::make( 'term_meta', __( "Deposit method fields", "jgambling" ) )
		         ->where( 'term_taxonomy', '=', 'deposit' )
		         ->add_fields( array(
			         Field::make( 'image', 'mini_img', __( "Mini image for sidebar in widget", "jgambling" ) ),
			         Field::make( 'image', 'big_img', __( "Image for archive page(195*127)", "jgambling" ) ),
			         Field::make( 'text', 'h1', __( "Custom H1", "jgambling" ) ),
			         Field::make( 'rich_text', 'before', __( "Text before table", "jgambling" ) ),
			         Field::make( 'checkbox', 'hide_link', __( "Hide link to taxonomy on single-casino page", "jgambling" ) )->set_option_value( 'yes' ),
		         ) );


		/*Currency*/
		Container::make( 'term_meta', __( "Currency fields", "jgambling" ) )
		         ->where( 'term_taxonomy', '=', 'currency' )
		         ->add_fields( array(
			         Field::make( 'text', 'h1', __( "Custom H1", "jgambling" ) ),
			         Field::make( 'image', 'big_img', __( "Image for archive page(195*127)", "jgambling" ) ),
			         Field::make( 'rich_text', 'before', __( "Text before table", "jgambling" ) ),
			         Field::make( 'checkbox', 'hide_link', __( "Hide link to taxonomy on single-casino page", "jgambling" ) )->set_option_value( 'yes' ),
		         ) );

		/*Withdrawal methods*/
		Container::make( 'term_meta', __( "Withdrawal method fields", "jgambling" ) )
		         ->where( 'term_taxonomy', '=', 'cashout' )
		         ->add_fields( array(
			         Field::make( 'text', 'h1', __( "Custom H1", "jgambling" ) ),
			         Field::make( 'rich_text', 'before', __( "Text before table", "jgambling" ) ),
			         Field::make( 'checkbox', 'hide_link', __( "Hide link to taxonomy on single-casino page", "jgambling" ) )->set_option_value( 'yes' ),
		         ) );


		/*Soft*/
		Container::make( 'term_meta', __( "Soft fields", "jgambling" ) )
		         ->where( 'term_taxonomy', '=', 'soft' )
		         ->add_fields( array(
			         Field::make( 'text', 'h1', __( "Custom H1", "jgambling" ) ),
			         Field::make( 'image', 'big_img', __( "Image for archive page(195*127)", "jgambling" ) ),
			         Field::make( 'rich_text', 'before', __( "Text before table", "jgambling" ) ),
			         Field::make( 'checkbox', 'hide_link', __( "Hide link to taxonomy on single-casino page", "jgambling" ) )->set_option_value( 'yes' ),
		         ) );
		/*Soft for slots*/
		Container::make( 'term_meta', __( "Soft fields", "jgambling" ) )
		         ->where( 'term_taxonomy', '=', 'software' )
		         ->add_fields( array(
			         Field::make( 'image', 'mini_img', __( "Mini image for sidebar", "jgambling" ) ),
			         Field::make( 'image', 'big_img', __( "Image for archive page(195*127)", "jgambling" ) ),
			         Field::make( 'text', 'h1', __( "Custom H1", "jgambling" ) ),
			         Field::make( 'rich_text', 'before', __( "Text before slots grid", "jgambling" ) ),

		         ) );


		/*Bonus type*/
		Container::make( 'term_meta', __( "Bonus type", "jgambling" ) )
		         ->where( 'term_taxonomy', '=', 'type' )
		         ->add_fields( array(
			         Field::make( 'text', 'h1', __( "Custom H1", "jgambling" ) ),
			         Field::make( 'rich_text', 'before', __( "Text before bonus list", "jgambling" ) ),
		         ) );


		/*Restricted country*/
		Container::make( 'term_meta', __( "Restricted country fields", "jgambling" ) )
		         ->where( 'term_taxonomy', '=', 'restricted' )
		         ->add_fields( array(
			         Field::make( 'text', 'h1', __( "Custom H1", "jgambling" ) ),
			         Field::make( 'image', 'big_img', __( "Image for archive page(195*127)", "jgambling" ) ),
			         Field::make( 'rich_text', 'before', __( "Text before table", "jgambling" ) ),
			         Field::make( 'text', 'iso', __( "Country ISO code", "jgambling" ) ),
			         Field::make( 'image', 'country_image', __( "Country image(for GEO)", "jgambling" ) ),
			         Field::make( 'checkbox', 'hide_link', __( "Hide link to taxonomy on single-casino page", "jgambling" ) )->set_option_value( 'yes' ),
		         ) );

		/*license*/
		Container::make( 'term_meta', __( "Casino license fields", "jgambling" ) )
		         ->where( 'term_taxonomy', '=', 'license' )
		         ->add_fields( array(
			         Field::make( 'text', 'h1', __( "Custom H1", "jgambling" ) ),
			         Field::make( 'image', 'big_img', __( "Image for archive page(195*127)", "jgambling" ) ),
			         Field::make( 'rich_text', 'before', __( "Text before table", "jgambling" ) ),
			         Field::make( 'checkbox', 'hide_link', __( "Hide link to taxonomy on single-casino page", "jgambling" ) )->set_option_value( 'yes' ),
		         ) );

		/*Casino type*/
		Container::make( 'term_meta', __( "Casino type fields", "jgambling" ) )
		         ->where( 'term_taxonomy', '=', 'casino_type' )
		         ->add_fields( array(
			         Field::make( 'text', 'h1', __( "Custom H1", "jgambling" ) ),
			         Field::make( 'image', 'big_img', __( "Image for archive page(195*127)", "jgambling" ) ),
			         Field::make( 'rich_text', 'before', __( "Text before table", "jgambling" ) ),
			         Field::make( 'checkbox', 'hide_link', __( "Hide link to taxonomy on single-casino page", "jgambling" ) )->set_option_value( 'yes' ),
		         ) );


	endif;
}

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
	require_once( get_template_directory() . '/includes/libs/carbon-fields/vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}
