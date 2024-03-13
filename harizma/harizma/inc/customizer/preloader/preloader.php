<?php

$priority = 1;

Kirki::add_section(
	'preloader',
	array(
		'title'    => esc_html__( 'Preloader', 'harizma' ),
		'priority' => $priority ++,
		'icon'     => 'dashicons-image-filter',
	)
);

/**
 * Preloader Type
 */
Kirki::add_field(
	'harizma',
	array(
		'type'     => 'radio-buttonset',
		'settings' => 'preloader_type',
		'label'    => esc_html__( 'Type', 'harizma' ),
		'tooltip'  => esc_html__( 'This option may be overriden for the current page from Elementor document settings.', 'harizma' ),
		'section'  => 'preloader',
		'default'  => 'fadein',
		'priority' => $priority++,
		'choices'  => array(
			'curtains' => esc_html__( 'Curtains', 'harizma' ),
			'fadein'   => esc_html__( 'Fade In', 'harizma' ),
		),
	)
);

