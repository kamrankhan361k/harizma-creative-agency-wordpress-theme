<?php

/**
 * Register Theme Menus
 *
 * @return void
 */
add_action( 'after_setup_theme', 'arts_init_navigation' );
function arts_init_navigation() {

	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
				'main_menu' => esc_html__( 'Main Menu', 'harizma' ),
			)
		);
	}

}

/**
 * Add pages/posts ID to links data-attributes
 * This is used for hover background effect
 * in fullscreen overlay menu
 */
add_filter( 'nav_menu_link_attributes', 'arts_menu_item_atts', 10, 3 );
function arts_menu_item_atts( $atts ) {
	$atts['data-post-id'] = url_to_postid( $atts['href'] );

	return $atts;
}
