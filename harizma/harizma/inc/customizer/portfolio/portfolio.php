<?php

$priority = 1;

Kirki::add_section(
	'portfolio',
	array(
		'title'    => esc_html__( 'Portfolio', 'harizma' ),
		'priority' => $priority ++,
		'icon'     => 'dashicons-art',
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'     => 'switch',
		'settings' => 'enable_portfolio_nav',
		'label'    => esc_html__( 'Show prev / next portfolio navigation on portfolio item pages', 'harizma' ),
		'section'  => 'portfolio',
		'default'  => true,
		'priority' => $priority++,
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'switch',
		'settings'        => 'enable_portfolio_archive_link',
		'label'           => esc_html__( 'Enable archive link', 'harizma' ),
		'section'         => 'portfolio',
		'default'         => 'on',
		'priority'        => $priority++,
		'choices'         => array(
			true  => esc_html__( 'On', 'harizma' ),
			false => esc_html__( 'Off', 'harizma' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'enable_portfolio_nav',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'link',
		'settings'        => 'portfolio_archive_link',
		'description'     => esc_html__( 'Insert a link to the page where all your portfolio items are listed.', 'harizma' ),
		'section'         => 'portfolio',
		'default'         => '',
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_portfolio_nav',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'enable_portfolio_archive_link',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

/**
 * Portfolio Custom Slug Option
 */
Kirki::add_field(
	'arts',
	array(
		'type'     => 'switch',
		'settings' => 'enable_custom_portfolio_slug',
		'label'    => esc_html__( 'Enable custom portfolio slug', 'harizma' ),
		'section'  => 'portfolio',
		'default'  => false,
		'priority' => $priority++,
	)
);

Kirki::add_field(
	'arts',
	array(
		'type'            => 'text',
		'settings'        => 'portfolio_slug',
		'label'           => esc_html__( 'Portfolio Slug', 'harizma' ),
		'description'     => sprintf(
			'%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
			esc_html__( 'Note: you will need to', 'harizma' ),
			admin_url( 'options-permalink.php' ),
			esc_html__( 'update your permalinks', 'harizma' ),
			esc_html__( 'each time you change the slug.', 'harizma' )
		),
		'section'         => 'portfolio',
		'default'         => esc_html__( 'portfolio', 'harizma' ),
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'enable_custom_portfolio_slug',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
