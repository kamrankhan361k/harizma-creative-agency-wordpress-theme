<?php

$priority    = 1;
$max_columns = 4;

/**
 * Footer Layout
 */
Kirki::add_field(
	'arts',
	array(
		'type'        => 'slider',
		'settings'    => 'footer_columns',
		'label'       => esc_html__( 'Number of Columns', 'harizma' ),
		'description' => esc_html__( 'This setting creates a widget area per each column. You can edit your widgets in WordPress admin panel.', 'harizma' ),
		'section'     => 'footer_layout',
		'default'     => 1,
		'priority'    => $priority++,
		'choices'     => array(
			'min'  => '1',
			'max'  => $max_columns,
			'step' => '1',
		),
		'transport'   => 'refresh',
	)
);

/**
 * Mobile Ordering Info
 */
Kirki::add_field(
	'arts',
	array(
		'type'            => 'custom',
		'settings'        => 'footer_columns_info',
		'label'           => esc_html__( 'Mobile Columns Stack Order', 'harizma' ),
		'description'     => esc_html__( 'You can control how your columns stack on mobile screens. For example, you can place copyright column very first on desktop and reorder it as very last on mobile.', 'harizma' ),
		'section'         => 'footer_layout',
		'priority'        => $priority++,
		'active_callback' => array(
			array(
				'setting'  => 'footer_columns',
				'operator' => '>',
				'value'    => '1',
			),
		),
	)
);

/**
 * Mobile Column Order
 */

for ( $i = 1; $i <= $max_columns; $i++ ) {

	$descr = sprintf( '%1$s (%2$s %3$s)', esc_html__( 'Mobile Order', 'harizma' ), esc_html__( 'Column', 'harizma' ), $i );

	Kirki::add_field(
		'arts',
		array(
			'type'            => 'slider',
			'settings'        => 'order_column_' . $i,
			'description'     => $descr,
			'section'         => 'footer_layout',
			'default'         => 1,
			'priority'        => $priority++,
			'choices'         => array(
				'min'  => '1',
				'max'  => $max_columns,
				'step' => '1',
			),
			'active_callback' => array(
				array(
					'setting'  => 'footer_columns',
					'operator' => '>=',
					'value'    => $i,
				),
				array(
					'setting'  => 'footer_columns',
					'operator' => '!=',
					'value'    => 1,
				),
			),
		)
	);

}

/**
 * Mobile Centering
 */
Kirki::add_field(
	'arts',
	array(
		'type'      => 'switch',
		'settings'  => 'enable_footer_mobile_centering',
		'label'     => esc_html__( 'Mobile Columns Content Centering', 'harizma' ),
		'section'   => 'footer_layout',
		'default'   => true,
		'priority'  => $priority++,
		'transport' => 'postMessage',
	)
);
