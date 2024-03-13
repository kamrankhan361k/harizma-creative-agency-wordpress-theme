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

Kirki::add_field(
	'arts',
	array(
		'type'     => 'switch',
		'settings' => 'show_scroll_up',
		'label'    => esc_html__( 'Show floating scroll-up button in the bottom right page corner', 'harizma' ),
		'section'  => 'scroll_up',
		'default'  => true,
		'priority' => $priority++,
	)
);
