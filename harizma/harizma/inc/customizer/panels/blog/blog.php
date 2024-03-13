<?php

$priority = 1;

/**
 * Section Post
 */
Kirki::add_section(
	'post',
	array(
		'title'    => esc_html__( 'Post Display', 'harizma' ),
		'priority' => $priority ++,
		'panel'    => 'blog',
	)
);
get_template_part( '/inc/customizer/panels/blog/sections/post' );

/**
 * Section Sidebar
 */
Kirki::add_section(
	'sidebar',
	array(
		'title'    => esc_html__( 'Sidebar Display', 'harizma' ),
		'priority' => $priority ++,
		'panel'    => 'blog',
	)
);
get_template_part( '/inc/customizer/panels/blog/sections/sidebar' );
