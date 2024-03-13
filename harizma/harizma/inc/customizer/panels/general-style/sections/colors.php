<?php

$priority = 1;

/**
 * Primary Accent Color
 */
Kirki::add_field(
	'arts',
	array(
		'section'     => 'theme_colors',
		'type'        => 'color',
		'label'       => esc_html__( 'Primary Accent Color', 'harizma' ),
		'description' => esc_html__( 'Used for interactive elements, decorations, etc', 'harizma' ),
		'default'     => '#1869ff',
		'settings'    => 'color_accent_primary',
		'priority'    => $priority ++,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element'  => ':root',
				'property' => '--color-accent-primary',
			),
		),
	)
);

/**
 * Secondary Accent Color
 */
Kirki::add_field(
	'arts',
	array(
		'section'     => 'theme_colors',
		'type'        => 'color',
		'label'       => esc_html__( 'Secondary Accent Color', 'harizma' ),
		'description' => esc_html__( 'Rarely used for additonal elements styling.', 'harizma' ),
		'default'     => '#b388ff',
		'settings'    => 'color_accent_secondary',
		'priority'    => $priority ++,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element'  => ':root',
				'property' => '--color-accent-secondary',
			),
		),
	)
);
