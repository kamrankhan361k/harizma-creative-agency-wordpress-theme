<?php

/**
 * Custom Slug for Portfolio CPT
 */
function arts_change_cpt_slug_portfolio( $args, $post_type ) {
	$enabled = get_theme_mod( 'enable_custom_portfolio_slug', false );
	$slug    = get_theme_mod( 'portfolio_slug' );

	if ( $enabled && ! empty( $slug ) && $post_type == 'arts_portfolio_item' ) {
		$args['rewrite']['slug'] = $slug;
	}

	return $args;
}
add_filter( 'register_post_type_args', 'arts_change_cpt_slug_portfolio', 10, 2 );

/**
 * Custom Slug for Services CPT
 */
function arts_change_cpt_slug_services( $args, $post_type ) {
	$enabled = get_theme_mod( 'enable_custom_services_slug', false );
	$slug    = get_theme_mod( 'services_slug' );

	if ( $enabled && ! empty( $slug ) && $post_type == 'arts_service' ) {
		$args['rewrite']['slug'] = $slug;
	}

	return $args;
}
add_filter( 'register_post_type_args', 'arts_change_cpt_slug_services', 10, 2 );
