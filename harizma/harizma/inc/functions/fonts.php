<?php

require_once ARTS_THEME_PATH . '/inc/classes/class-arts-add-custom-fonts.php';

/**
 * Create Instance
 */
function arts_add_custom_fonts() {
	return Arts_Add_Custom_Fonts::instance();
}
arts_add_custom_fonts();

/**
 * Add custom fonts choice
 */
function arts_add_custom_choice() {
	return array(
		'fonts' => apply_filters( 'arts/kirki_font_choices', array() ),
	);
}

/**
 * Force Load all fonts variations (Kirki)
 */
add_action( 'after_setup_theme', 'arts_font_add_all_variants', 100 );
function arts_font_add_all_variants() {

	$force_load_all_fonts_variations = get_theme_mod( 'force_load_all_fonts_variations', false );

	if ( class_exists( 'Kirki_Fonts_Google' ) && $force_load_all_fonts_variations ) {
		Kirki_Fonts_Google::$force_load_all_variants = true;
	}

}


/**
 * Collect all the theme fonts to be loaded
 * into an array. Used on frontend with
 * Fontface Observer
 *
 * @return array
 */
function arts_get_fonts_to_load() {
	// default family values
	$font_options_customizer = array(
		'font_primary'   => array(
			'font-family' => 'Open Sans',
		),
		'font_secondary' => array(
			'font-family' => 'Montserrat',
		),
	);
	$fonts                   = array();

	foreach ( $font_options_customizer as $key => $value ) {
		$font = get_theme_mod( $key, $value );
		if ( ! empty( $font ) && is_array( $font ) && key_exists( 'font-family', $font ) && ! in_array( $font['font-family'], $fonts ) ) {
			$fonts[] = $font['font-family'];
		}
	};

	// filter out system fonts and CSS fallbacks
	$fonts = array_values(
		array_filter(
			$fonts, function( $key ) {
				return $key !== 'initial' &&
					! empty( $key ) &&
					$key !== 'inherit' &&
					$key !== 'Georgia,Times,"Times New Roman",serif' &&
					! strpos( $key, 'sans-serif' ) &&
					! strpos( $key, 'monospace' );
			}
		)
	);

	$fonts = apply_filters( 'harizma/frontend/fonts', $fonts );

	return $fonts;
}
