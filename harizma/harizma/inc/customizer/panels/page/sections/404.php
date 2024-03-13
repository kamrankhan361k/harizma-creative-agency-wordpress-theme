<?php

$priority = 1;

/**
 * 404 Preview Link
 */
Kirki::add_field(
	'arts',
	array(
		'type'     => 'generic',
		'settings' => '404_preview_link',
		'label'    => esc_html__( 'Preview', 'harizma' ),
		'section'  => '404',
		'priority' => $priority++,
		'default'  => esc_html__( 'Load Page', 'harizma' ),
		'choices'  => array(
			'element' => 'input',
			'type'    => 'button',
			'class'   => 'button button-secondary',
			'onclick' => 'javascript:wp.customize.previewer.previewUrl.set( "../not-found-" + String( Math.random() ) + "/" );',
		),
	)
);

/**
 * 404 Title
 */
Kirki::add_field(
	'arts',
	array(
		'type'      => 'text',
		'settings'  => '404_title',
		'label'     => esc_html__( 'Title', 'harizma' ),
		'section'   => '404',
		'default'   => esc_html__( 'Oops! Page not found', 'harizma' ),
		'priority'  => $priority++,
		'transport' => 'postMessage',
	)
);

/**
 * 404 Message
 */
Kirki::add_field(
	'arts',
	array(
		'type'      => 'textarea',
		'settings'  => '404_message',
		'label'     => esc_html__( 'Message', 'harizma' ),
		'section'   => '404',
		'default'   => esc_html__( 'The page not found this could be a spelling error or a removed page', 'harizma' ),
		'priority'  => $priority++,
		'transport' => 'postMessage',
	)
);

/**
 * 404 Big
 */
Kirki::add_field(
	'arts',
	array(
		'type'      => 'text',
		'settings'  => '404_big',
		'label'     => esc_html__( 'Big Text', 'harizma' ),
		'section'   => '404',
		'default'   => esc_html__( '404', 'harizma' ),
		'priority'  => $priority++,
		'transport' => 'postMessage',
	)
);

/**
 * 404 Button
 */
Kirki::add_field(
	'arts',
	array(
		'type'      => 'text',
		'settings'  => '404_button',
		'label'     => esc_html__( 'Button Text', 'harizma' ),
		'section'   => '404',
		'default'   => esc_html__( 'Back to home page', 'harizma' ),
		'priority'  => $priority++,
		'transport' => 'postMessage',
	)
);

/**
 * Background Image
 */
Kirki::add_field(
	'arts',
	array(
		'type'     => 'image',
		'settings' => '404_background_url',
		'label'    => esc_html__( 'Background Image', 'harizma' ),
		'section'  => '404',
		'default'  => '',
		'priority' => $priority++,
	)
);
