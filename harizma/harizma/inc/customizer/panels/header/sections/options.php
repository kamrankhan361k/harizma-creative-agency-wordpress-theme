<?php

$priority = 1;

Kirki::add_field(
	'arts',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'header_container',
		'label'     => esc_html__( 'Container', 'harizma' ),
		'section'   => 'header_options',
		'default'   => 'container-fluid',
		'priority'  => $priority++,
		'choices'   => array(
			'container-fluid' => esc_html__( 'Fullwidth', 'harizma' ),
			'container'       => esc_html__( 'Boxed', 'harizma' ),
		),
		'transport' => 'postMessage',
	)
);
