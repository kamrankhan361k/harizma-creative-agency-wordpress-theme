<?php

/**
 * Enqueue Theme CSS Files
 */
add_action( 'wp_enqueue_scripts', 'arts_enqueue_styles', 20 );
function arts_enqueue_styles() {
	$enable_cf_7_modals   = get_theme_mod( 'enable_cf_7_modals', true );
	$typography_primary   = get_theme_mod( 'font_primary', array( 'font-family' => 'Open Sans' ) );
	$typography_secondary = get_theme_mod( 'font_secondary', array( 'font-family' => 'Montserrat' ) );

	// fallback font if fonts are not set
	if ( ! class_exists( 'Kirki' ) || ! $typography_primary || ! $typography_secondary ) {
		wp_enqueue_style( 'harizma-fonts', '//fonts.googleapis.com/css?family=Montserrat:700%7COpen+Sans:300,400,400i,700subset=cyrillic', array(), ARTS_THEME_VERSION );
	}

	if ( ! arts_is_elementor_feature_active( 'e_optimized_assets_loading' ) ) {
		wp_enqueue_style( 'swiper', ARTS_THEME_URL . '/css/swiper.min.css', array(), '4.4.6' );
	}

	wp_enqueue_style( 'bootstrap-reboot', ARTS_THEME_URL . '/css/bootstrap-reboot.min.css', array(), '4.1.2' );
	wp_enqueue_style( 'bootstrap-grid', ARTS_THEME_URL . '/css/bootstrap-grid.min.css', array(), '4.1.2' );
	wp_enqueue_style( 'elegant-icons', ARTS_THEME_URL . '/css/elegant-icons.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'font-awesome', ARTS_THEME_URL . '/css/font-awesome.min.css', array(), '4.7.0' );
	wp_enqueue_style( 'harizma-icons', ARTS_THEME_URL . '/css/hrz.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'themify-icons', ARTS_THEME_URL . '/css/themify-icons.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'harizma-main-style', ARTS_THEME_URL . '/css/main.css', array(), ARTS_THEME_VERSION );
	wp_enqueue_style( 'harizma-theme-style', ARTS_THEME_URL . '/style.css', array(), ARTS_THEME_VERSION );

	// hide default Contact Form 7 response boxes if custom modals are enabled
	if ( $enable_cf_7_modals ) {
		wp_enqueue_script( 'bootstrap-modal', ARTS_THEME_URL . '/js/bootstrap-modal.min.js', array( 'jquery', 'bootstrap-util' ), '4.1.3', true );
		wp_enqueue_script( 'bootstrap-util', ARTS_THEME_URL . '/js/bootstrap-util.min.js', array( 'jquery' ), '4.1.3', true );
		wp_add_inline_style( 'contact-form-7', trim( '.wpcf7-mail-sent-ok, .wpcf7 form.sent .wpcf7-response-output, .wpcf7-mail-sent-ng, .wpcf7 form.failed .wpcf7-response-output { display: none !important; }' ) );
	}
}

/**
 * Enqueue Modernizr & Polyfills
 */
add_action( 'wp_enqueue_scripts', 'arts_enqueue_polyfills', 20 );
function arts_enqueue_polyfills() {
	$outdated_browsers_enabled = get_theme_mod( 'outdated_browsers_enabled', false );

	if ( $outdated_browsers_enabled ) {
		wp_enqueue_script( 'outdated-browser-rework', ARTS_THEME_URL . '/js/outdated-browser-rework.min.js', array(), '1.1.0', false );
	}

	wp_enqueue_script( 'modernizr', ARTS_THEME_URL . '/js/modernizr.custom.min.js', array(), '2.8.3', false );
}

/**
 * Enqueue Theme JS Files
 */
add_action( 'wp_enqueue_scripts', 'arts_enqueue_scripts', 50 );
function arts_enqueue_scripts() {
	$main_script_deps = array( 'modernizr', 'jquery', 'isotope', 'imagesloaded' );

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( ! arts_is_elementor_feature_active( 'e_optimized_assets_loading' ) ) {
		wp_enqueue_script( 'swiper', ARTS_THEME_URL . '/js/swiper.min.js', array(), '4.4.6', true );
		$main_script_deps [] = 'swiper';
	}

	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'animation-gsap', ARTS_THEME_URL . '/js/animation.gsap.min.js', array( 'scrollmagic', 'tweenmax' ), '2.0.5', true );
	wp_enqueue_script( 'isotope', ARTS_THEME_URL . '/js/isotope.pkgd.min.js', array(), '3.0.6', true );
	wp_enqueue_script( 'jquery-alterclass', ARTS_THEME_URL . '/js/jquery.alterclass.min.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'jquery-lazy', ARTS_THEME_URL . '/js/jquery.lazy.min.js', array( 'jquery' ), '1.7.10', true );
	wp_enqueue_script( 'jquery-lazy-plugins', ARTS_THEME_URL . '/js/jquery.lazy.plugins.min.js', array( 'jquery', 'jquery-lazy' ), '1.7.10', true );
	wp_enqueue_script( 'scrollmagic', ARTS_THEME_URL . '/js/ScrollMagic.min.js', array(), '2.0.5', true );
	wp_enqueue_script( 'jquery-scrollmagic', ARTS_THEME_URL . '/js/jquery.ScrollMagic.min.js', array( 'scrollmagic' ), '2.0.5', true );
	wp_enqueue_script( 'tweenmax', ARTS_THEME_URL . '/js/TweenMax.min.js', array(), '2.0.2', true );
	wp_enqueue_script( 'harizma-components', ARTS_THEME_URL . '/js/components.js', $main_script_deps, ARTS_THEME_VERSION, true );
}

/**
 * Localize Theme Options
 */
add_action( 'wp_enqueue_scripts', 'arts_localize_data', 60 );
function arts_localize_data() {
	$color_accent_primary = get_theme_mod( 'color_accent_primary', '#1869ff' );
	$typography_primary   = get_theme_mod( 'font_primary', array( 'font-family' => 'Open Sans' ) );
	$typography_secondary = get_theme_mod( 'font_secondary', array( 'font-family' => 'Montserrat' ) );
	$fonts_to_load        = arts_get_fonts_to_load();
	$enable_cf_7_modals   = get_theme_mod( 'enable_cf_7_modals', true );

	wp_localize_script(
		'harizma-components',
		'theme',
		array(
			'themeURL'     => esc_js( ARTS_THEME_URL ),
			'colors'       => array(
				'accentPrimary' => $color_accent_primary,
			),
			'fonts'        => $fonts_to_load,
			'contactForm7' => array(
				'customModals' => esc_js( $enable_cf_7_modals ),
			),
		)
	);

	$css = "
		:root {
			--font-primary: {$typography_primary['font-family']};
			--font-secondary: {$typography_secondary['font-family']};
		}
	";
	wp_add_inline_style( 'harizma-main-style', trim( $css ) );
}

/**
 * Enqueue Customizer Live Preview Script
 */
add_action( 'customize_preview_init', 'arts_customize_preview_script' );
function arts_customize_preview_script() {
	wp_enqueue_script( 'harizma-customizer-preview', ARTS_THEME_URL . '/js/customizer.js', array(), ARTS_THEME_VERSION, true );
}

/**
 * Exclude certain JS from the aggregation
 * function of Autoptimize plugin
 */
add_filter( 'autoptimize_filter_js_exclude', 'arts_ao_override_jsexclude', 30, 1 );
/**
 * JS optimization exclude strings, as configured in admin page.
 *
 * @param $exclude: comma-seperated list of exclude strings
 * @return: comma-seperated list of exclude strings
 */
function arts_ao_override_jsexclude( $exclude ) {
	return $exclude . ', outdated-browser-rework';
}
