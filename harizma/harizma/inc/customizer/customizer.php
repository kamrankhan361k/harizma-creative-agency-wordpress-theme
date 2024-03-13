<?php

if ( ! class_exists( 'Kirki' ) ) {
	return;
}

add_filter( 'kirki_telemetry', '__return_false' );

$priority = 1;

Kirki::add_config(
	'arts',
	array(
		'capability'  => 'edit_theme_options',
		'option_type' => 'theme_mod',
	)
);

/**
 * Section Preloader
 */
get_template_part( '/inc/customizer/preloader/preloader' );

/**
 * Panel General Style
 */
Kirki::add_panel(
	'general-style',
	array(
		'priority' => $priority++,
		'title'    => esc_html__( 'General Style', 'harizma' ),
		'icon'     => 'dashicons-admin-appearance',
	)
);
get_template_part( '/inc/customizer/panels/general-style/general-style' );

/**
 * Panel Header
 */
Kirki::add_panel(
	'header',
	array(
		'priority' => $priority++,
		'title'    => esc_html__( 'Header', 'harizma' ),
		'icon'     => 'dashicons-arrow-up-alt',
	)
);
get_template_part( '/inc/customizer/panels/header/header' );

/**
 * Panel Footer
 */
Kirki::add_panel(
	'footer',
	array(
		'priority' => $priority++,
		'title'    => esc_html__( 'Footer', 'harizma' ),
		'icon'     => 'dashicons-arrow-down-alt',
	)
);
get_template_part( '/inc/customizer/panels/footer/footer' );

/**
 * Section Portfolio
 */
get_template_part( '/inc/customizer/portfolio/portfolio' );

/**
 * Section Services
 */
get_template_part( '/inc/customizer/services/services' );

/**
 * Panel Blog
 */
Kirki::add_panel(
	'blog',
	array(
		'priority' => $priority++,
		'title'    => esc_html__( 'Blog', 'harizma' ),
		'icon'     => 'dashicons-editor-bold',
	)
);
get_template_part( '/inc/customizer/panels/blog/blog' );

/**
 * Panel Options
 */
Kirki::add_panel(
	'page',
	array(
		'priority' => $priority++,
		'title'    => esc_html__( 'Options', 'harizma' ),
		'icon'     => 'dashicons-admin-tools',
	)
);
get_template_part( '/inc/customizer/panels/page/page' );

/**
 * Extend Title & Tagline Section
 */
get_template_part( 'inc/customizer/title_tagline/title_tagline' );
