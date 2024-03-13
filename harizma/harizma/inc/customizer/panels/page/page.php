<?php

$priority = 1;

/**
 * Scroll Up Button
 */
Kirki::add_section(
	'scroll_up',
	array(
		'title'    => esc_html__( 'Scroll Up', 'harizma' ),
		'priority' => $priority ++,
		'panel'    => 'page',
	)
);
get_template_part( '/inc/customizer/panels/page/sections/scroll_up' );

/**
 * Section Page 404
 */
Kirki::add_section(
	'404',
	array(
		'title'    => esc_html__( 'Page 404', 'harizma' ),
		'priority' => $priority ++,
		'panel'    => 'page',
	)
);
get_template_part( '/inc/customizer/panels/page/sections/404' );

/**
 * Section CF7
 */
Kirki::add_section(
	'contact_form_7',
	array(
		'title'    => esc_html__( 'Contact Form 7', 'harizma' ),
		'priority' => $priority ++,
		'panel'    => 'page',
	)
);
get_template_part( '/inc/customizer/panels/page/sections/contact-form-7' );

/**
 * Section Outdated Browsers
 */
Kirki::add_section(
	'outdated_browsers',
	array(
		'title'    => esc_html__( 'Outdated Browsers', 'harizma' ),
		'priority' => $priority ++,
		'panel'    => 'page',
	)
);
get_template_part( '/inc/customizer/panels/page/sections/outdated-browsers' );
