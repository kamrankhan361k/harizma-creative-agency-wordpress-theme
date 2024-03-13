<?php

$priority = 1;

Kirki::add_section(
	'services',
	array(
		'title'    => esc_html__( 'Services', 'harizma' ),
		'priority' => $priority ++,
		'icon'     => 'dashicons-hammer',
	)
);

/**
 * Services Custom Slug Option
 */
Kirki::add_field(
	'arts',
	array(
		'type'     => 'switch',
		'settings' => 'enable_custom_services_slug',
		'label'    => esc_html__( 'Enable custom services slug', 'harizma' ),
		'section'  => 'services',
		'default'  => false,
		'priority' => $priority++,
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'text',
		'settings'        => 'services_slug',
		'label'           => esc_html__( 'Services Slug', 'harizma' ),
		'description'     => sprintf(
			'%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
			esc_html__( 'Note: you will need to', 'harizma' ),
			admin_url( 'options-permalink.php' ),
			esc_html__( 'update your permalinks', 'harizma' ),
			esc_html__( 'each time you change the slug.', 'harizma' )
		),
		'section'         => 'services',
		'default'         => esc_html__( 'services', 'harizma' ),
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_custom_services_slug',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
