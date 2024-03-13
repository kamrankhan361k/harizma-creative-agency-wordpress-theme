<?php

$priority = 1;

/**
 * Menu Style
 */
Kirki::add_field(
	'arts',
	array(
		'type'        => 'radio-buttonset',
		'settings'    => 'menu_style',
		'label'       => esc_html__( 'Style', 'harizma' ),
		'description' => esc_html__( 'This option has an effect only on desktop. On mobile there is always a fullscreen overlay menu.', 'harizma' ),
		'tooltip'     => esc_html__( 'This option may be overriden for the current page from Elementor document settings.', 'harizma' ),
		'section'     => 'menu',
		'default'     => 'regular',
		'priority'    => $priority++,
		'choices'     => array(
			'regular'    => esc_html__( 'Regular', 'harizma' ),
			'fullscreen' => esc_html__( 'Fullscreen Overlay', 'harizma' ),
		),
	)
);
