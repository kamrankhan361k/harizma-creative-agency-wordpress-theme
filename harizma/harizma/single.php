<?php

$is_elementor_page    = arts_is_built_with_elementor();
$enable_portfolio_nav = get_theme_mod( 'enable_portfolio_nav', true );
$post_type            = get_post_type();

get_header();
get_template_part( 'template-parts/masthead/masthead' );

the_post();
the_content();

if ( $post_type == 'arts_portfolio_item' && $is_elementor_page && $enable_portfolio_nav ) {

	get_template_part( 'template-parts/nav/nav', 'portfolio' );

}

get_footer();
