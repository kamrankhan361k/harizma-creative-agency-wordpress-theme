<?php

$priority = 1;

/**
 * Colors
 */
Kirki::add_section(
	'theme_colors',
	array(
		'title'    => esc_html__( 'Colors', 'harizma' ),
		'panel'    => 'general-style',
		'priority' => $priority ++,
	)
);
get_template_part( '/inc/customizer/panels/general-style/sections/colors' );

/**
 * Typography
 */
Kirki::add_section(
	'typography',
	array(
		'title'    => esc_html__( 'Typography', 'harizma' ),
		'panel'    => 'general-style',
		'priority' => $priority ++,
	)
);
get_template_part( '/inc/customizer/panels/general-style/sections/typography' );
