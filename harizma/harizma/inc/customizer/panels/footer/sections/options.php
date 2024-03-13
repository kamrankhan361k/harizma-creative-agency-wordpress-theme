<?php

$priority = 1;

Kirki::add_field(
	'arts',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'footer_container',
		'label'     => esc_html__( 'Container', 'harizma' ),
		'section'   => 'footer_options',
		'default'   => 'container',
		'priority'  => $priority++,
		'choices'   => array(
			'container-fluid' => esc_html__( 'Fullwidth', 'harizma' ),
			'container'       => esc_html__( 'Boxed', 'harizma' ),
		),
		'transport' => 'postMessage',
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'        => 'switch',
		'settings'    => 'enable_footer_divider',
		'label'       => esc_html__( 'Enable divider', 'harizma' ),
		'description' => esc_html__( 'Show a thin line between top and bottom widgets sections', 'harizma' ),
		'section'     => 'footer_options',
		'default'     => false,
		'priority'    => $priority++,
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'      => 'switch',
		'settings'  => 'enable_footer_padding_top',
		'label'     => esc_html__( 'Footer Top Padding', 'harizma' ),
		'section'   => 'footer_options',
		'default'   => true,
		'priority'  => $priority++,
		'transport' => 'postMessage',
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'      => 'switch',
		'settings'  => 'enable_footer_padding_bottom',
		'label'     => esc_html__( 'Footer Bottom Padding', 'harizma' ),
		'section'   => 'footer_options',
		'default'   => true,
		'priority'  => $priority++,
		'transport' => 'postMessage',
	)
);
