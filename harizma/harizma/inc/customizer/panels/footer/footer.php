<?php

$priority = 1;

/**
 * Section Layout
 */
Kirki::add_section(
	'footer_layout',
	array(
		'title'    => esc_html__( 'Layout', 'harizma' ),
		'priority' => $priority ++,
		'panel'    => 'footer',
	)
);
get_template_part( '/inc/customizer/panels/footer/sections/layout' );

Kirki::add_section(
	'footer_options',
	array(
		'title'    => esc_html__( 'Options', 'harizma' ),
		'priority' => $priority ++,
		'panel'    => 'footer',
	)
);
get_template_part( '/inc/customizer/panels/footer/sections/options' );
