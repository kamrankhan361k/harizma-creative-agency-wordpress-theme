<?php

/**
 * Register Widget Areas
 *
 * @return void
 */
add_action( 'widgets_init', 'arts_register_widget_areas' );
function arts_register_widget_areas() {

	$footer_columns = get_theme_mod( 'footer_columns', 1 );

	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'harizma' ),
			'id'            => 'blog-sidebar',
			'description'   => esc_html__( 'Appears in blog.', 'harizma' ),
			'before_widget' => '<section class="widget %2$s">',
			'after_widget'  => '</section>',
		)
	);

	if ( $footer_columns > 1 ) {

		for ( $i = 1; $i <= $footer_columns; $i++ ) {

			register_sidebar(
				array(
					'name'          => sprintf( esc_html__( 'Footer %s Column', 'harizma' ), $i ),
					'id'            => 'footer-sidebar-' . $i,
					'description'   => esc_html__( 'Appears in page footer (Top Multiple Columns).', 'harizma' ),
					'before_widget' => '<div class="widget %2$s footer__wrapper-widget">',
					'after_widget'  => '</div>',
				)
			);

		}
	}

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widgets Bottom', 'harizma' ),
			'id'            => 'footer-widgets',
			'description'   => esc_html__( 'Appears in the page footer (Bottom Single Column).', 'harizma' ),
			'before_widget' => '<div class="widget %2$s footer__wrapper-widget">',
			'after_widget'  => '</div>',
		)
	);

	if ( class_exists( 'SitePress' ) || class_exists( 'Polylang' ) || class_exists( 'TRP_Translate_Press' ) ) {

		register_sidebar(
			array(
				'name'          => esc_html__( 'Language Switcher Area', 'harizma' ),
				'id'            => 'lang-switcher-sidebar',
				'description'   => esc_html__( 'Appears in the top menu.', 'harizma' ),
				'before_widget' => '<section class="widget %2$s">',
				'after_widget'  => '</section>',
			)
		);

	}

}

