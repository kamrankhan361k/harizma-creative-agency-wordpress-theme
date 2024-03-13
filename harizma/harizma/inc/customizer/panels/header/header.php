<?php

$priority = 1;

Kirki::add_section(
	'menu',
	array(
		'title'    => esc_html__( 'Menu', 'harizma' ),
		'priority' => $priority ++,
		'panel'    => 'header',
	)
);
get_template_part( '/inc/customizer/panels/header/sections/menu' );

Kirki::add_section(
	'header_options',
	array(
		'title'    => esc_html__( 'Options', 'harizma' ),
		'panel'    => 'header',
		'priority' => $priority ++,
	)
);
get_template_part( '/inc/customizer/panels/header/sections/options' );

Kirki::add_section(
	'social',
	array(
		'title'    => esc_html__( 'Social Links', 'harizma' ),
		'priority' => $priority ++,
		'panel'    => 'header',
	)
);
get_template_part( '/inc/customizer/panels/header/sections/social_links' );
