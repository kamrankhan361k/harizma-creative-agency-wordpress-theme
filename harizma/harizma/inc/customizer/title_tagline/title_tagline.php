<?php

$priority = 9;

$lg = get_option( 'elementor_viewport_lg', 992 );
$md = get_option( 'elementor_viewport_md', 768 );
$sm = get_option( 'elementor_viewport_sm', 480 );

if ( empty( $lg ) ) {
	$lg = 992;
}

if ( empty( $md ) ) {
	$md = 768;
}

if ( empty( $sm ) ) {
	$sm = 480;
}

/**
 * Retina Logo
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'image',
		'settings'        => 'custom_logo_retina_url',
		'label'           => esc_html__( 'Retina Logo', 'harizma' ),
		'description'     => esc_html__( 'Upload logo in @2x resolution for smooth display on high-dpi screens.', 'harizma' ),
		'section'         => 'title_tagline',
		'default'         => '',
		'priority'        => $priority,
		'active_callback' => array(
			array(
				'setting'  => 'custom_logo',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);

/**
 * White Logo
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'image',
		'settings'        => 'custom_logo_white_url',
		'label'           => esc_html__( 'White Logo', 'harizma' ),
		'description'     => esc_html__( 'Upload white version of logo. Used in the header for better style & contrast.', 'harizma' ),
		'section'         => 'title_tagline',
		'default'         => '',
		'priority'        => $priority,
		'active_callback' => array(
			array(
				'setting'  => 'custom_logo',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);

/**
 * White Retina Logo
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'image',
		'settings'        => 'custom_logo_retina_white_url',
		'label'           => esc_html__( 'White Retina Logo', 'harizma' ),
		'description'     => esc_html__( 'Upload white version of logo in @2x resolution for smooth display on high-dpi screens.', 'harizma' ),
		'section'         => 'title_tagline',
		'default'         => '',
		'priority'        => $priority,
		'active_callback' => array(
			array(
				'setting'  => 'custom_logo',
				'operator' => '!=',
				'value'    => false,
			),
			array(
				'setting'  => 'custom_logo_white_url',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);

/**
 * Logo Max Height Desktop
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'slider',
		'settings'        => 'custom_logo_max_height',
		'label'           => esc_html__( 'Logo Max Height', 'harizma' ),
		'description'     => esc_html__( 'Desktop screens', 'harizma' ),
		'section'         => 'title_tagline',
		'default'         => 110,
		'choices'         => array(
			'min'  => 0,
			'max'  => 512,
			'step' => 1,
		),
		'priority'        => $priority,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'     => '.header .logo',
				'property'    => 'height',
				'units'       => 'px',
				'media_query' => '@media (min-width: ' . esc_attr( $md + 1 ) . 'px)',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_logo',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);

/**
 * Logo Max Height Tablet
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'slider',
		'settings'        => 'custom_logo_max_height_tablet',
		'label'           => esc_html__( 'Logo Max Height', 'harizma' ),
		'description'     => sprintf(
			'%1s %2s%3s %4s',
			esc_html__( 'Tablet screens', 'harizma' ),
			esc_attr( $md ),
			esc_html__( 'px', 'harizma' ),
			esc_html__( 'and lower', 'harizma' )
		),
		'section'         => 'title_tagline',
		'default'         => 80,
		'choices'         => array(
			'min'  => 0,
			'max'  => 512,
			'step' => 1,
		),
		'priority'        => $priority,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'     => '.header .logo',
				'property'    => 'height',
				'units'       => 'px',
				'media_query' => '@media (max-width: ' . esc_attr( $md ) . 'px)',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_logo',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);

/**
 * Logo Max Height Mobile
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'slider',
		'settings'        => 'custom_logo_max_height_mobile',
		'label'           => esc_html__( 'Logo Max Height', 'harizma' ),
		'description'     => sprintf(
			'%1s %2s%3s %4s',
			esc_html__( 'Mobile screens', 'harizma' ),
			esc_attr( $sm ),
			esc_html__( 'px', 'harizma' ),
			esc_html__( 'and lower', 'harizma' )
		),
		'section'         => 'title_tagline',
		'default'         => 60,
		'choices'         => array(
			'min'  => 0,
			'max'  => 512,
			'step' => 1,
		),
		'priority'        => $priority,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'     => '.header .logo',
				'property'    => 'height',
				'units'       => 'px',
				'media_query' => '@media (max-width: ' . esc_attr( $sm ) . 'px)',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'custom_logo',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);

