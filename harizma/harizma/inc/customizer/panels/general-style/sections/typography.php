<?php

$priority = 1;

$variant_primary = array(
	'300',
	'regular',
	'italic',
	'700',
);

$variant_secondary = array(
	'700',
);

$choices_primary   = arts_add_custom_choice();
$choices_secondary = arts_add_custom_choice();

$choices_primary['variant']   = $variant_primary;
$choices_secondary['variant'] = $variant_secondary;

/**
 * Primary Font
 */
Kirki::add_field(
	'arts',
	array(
		'type'        => 'typography',
		'settings'    => 'font_primary',
		'label'       => esc_html__( 'Primary Font', 'harizma' ),
		'description' => esc_html__( 'Used thoughout the theme for paragraph text and labels', 'harizma' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family' => 'Open Sans',
			'font-size'   => '15px',
			'line-height' => '1.53',
		),
		'priority'    => $priority++,
		'choices'     => $choices_primary,
		'output'      => array(
			array(
				'element' => 'body',
			),
		),
	)
);

/**
 * Secondary Font
 */
Kirki::add_field(
	'arts',
	array(
		'type'        => 'typography',
		'settings'    => 'font_secondary',
		'label'       => esc_html__( 'Secondary Font', 'harizma' ),
		'description' => esc_html__( 'Used for headings', 'harizma' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family' => 'Montserrat',
			'font-size'   => '20px',
			'line-height' => '1.33',
		),
		'priority'    => $priority++,
		'choices'     => $choices_secondary,
		'output'      => array(
			array(
				'element' => 'h1, h2, h3, h4, h5, h6',
			),
		),
	)
);

/**
 * Force Load All Fonts Variations
 */
Kirki::add_field(
	'arts',
	array(
		'type'        => 'switch',
		'settings'    => 'force_load_all_fonts_variations',
		'label'       => esc_html__( 'Force Load All Selected Fonts Variations', 'harizma' ),
		'description' => esc_html__( 'Please also note that this may significantly decrease site loading speed if your font contains a lot of weights & styles.', 'harizma' ),
		'section'     => 'typography',
		'default'     => false,
		'priority'    => $priority++,
	)
);
