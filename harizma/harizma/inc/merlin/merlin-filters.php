<?php

/**
 * Import Demo Data
 */
add_filter( 'merlin_import_files', 'arts_merlin_import_files' );
function arts_merlin_import_files() {
	return array(
		array(
			'import_file_name'           => 'Demo Import',
			'import_file_url'            => 'https://artemsemkin.com/' . ARTS_THEME_SLUG . '/demo-content/demo-content.xml',
			'import_widget_file_url'     => 'https://artemsemkin.com/' . ARTS_THEME_SLUG . '/demo-content/widgets.wie',
			'import_customizer_file_url' => 'https://artemsemkin.com/' . ARTS_THEME_SLUG . '/demo-content/customizer.dat',
			'preview_url'                => 'https://artemsemkin.com/' . ARTS_THEME_SLUG . '/wp/',
		),
	);
}

/**
 * Setup Elementor
 */
add_filter( 'merlin_after_all_import', 'arts_merlin_setup_elementor' );
add_filter( 'pt-ocdi/after_import', 'arts_merlin_setup_elementor' );
function arts_merlin_setup_elementor() {

	$cpt_support = get_option( 'elementor_cpt_support' );

	// Update CPT Support
	if ( ! $cpt_support ) {

		$cpt_support = [ 'page', 'post', 'arts_portfolio_item', 'arts_service' ];
		update_option( 'elementor_cpt_support', $cpt_support );

	} elseif ( ! in_array( 'arts_portfolio_item', $cpt_support ) ) {

		$cpt_support[] = 'arts_portfolio_item';
		update_option( 'elementor_cpt_support', $cpt_support );

	} elseif ( ! in_array( 'arts_service', $cpt_support ) ) {

		$cpt_support[] = 'arts_service';
		update_option( 'elementor_cpt_support', $cpt_support );

	}

	// Update Default space between widgets
	update_option( 'elementor_space_between_widgets', '30' );

	// Update Content width
	update_option( 'elementor_container_width', '1140' );

	// Update Breakpoints
	update_option( 'elementor_viewport_lg', '1025' );
	update_option( 'elementor_viewport_md', '768' );

	// Update Disable default color schemes and fonts
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );

}

/**
 * Setup Menu
 */
add_filter( 'merlin_after_all_import', 'arts_merlin_setup_menu' );
add_filter( 'pt-ocdi/after_import', 'arts_merlin_setup_menu' );
function arts_merlin_setup_menu() {

	$top_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );

	set_theme_mod(
		'nav_menu_locations', array(
			'main_menu' => $top_menu->term_id,
		)
	);
}

/**
 * Setup Front/Blog Pages
 */
add_filter( 'merlin_after_all_import', 'arts_merlin_setup_front_blog_pages' );
add_filter( 'pt-ocdi/after_import', 'arts_merlin_setup_front_blog_pages' );
function arts_merlin_setup_front_blog_pages() {

	$front_page_id = get_page_by_title( 'Homepage' );
	$blog_page_id  = get_page_by_title( 'News' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}

/**
 * Setup Date Format
 */
add_filter( 'merlin_after_all_import', 'arts_merlin_setup_date_format' );
add_filter( 'pt-ocdi/after_import', 'arts_merlin_setup_date_format' );
function arts_merlin_setup_date_format() {

	update_option( 'date_format', 'd M Y' );

}

/**
 * Setup Intuitive Custom Post Order
 * Define sortable post types
 */
add_filter( 'merlin_after_all_import', 'arts_merlin_setup_hicpo' );
add_filter( 'pt-ocdi/after_import', 'arts_merlin_setup_hicpo' );
function arts_merlin_setup_hicpo() {

	$hicpo_options = get_option( 'hicpo_options' );

	if ( ! $hicpo_options ) {
		return;
	}

	$hicpo_objects = $hicpo_options['objects'];

	if ( ! $hicpo_objects ) {

		$hicpo_objects            = [ 'arts_portfolio_item', 'arts_service' ];
		$hicpo_options['objects'] = $hicpo_objects;
		update_option( 'hicpo_options', $hicpo_options );

	} elseif ( ! in_array( 'arts_portfolio_item', $hicpo_objects ) ) {

		$hicpo_objects[]          = 'arts_portfolio_item';
		$hicpo_options['objects'] = $hicpo_objects;
		update_option( 'hicpo_options', $hicpo_options );

	} elseif ( ! in_array( 'arts_service', $hicpo_objects ) ) {

		$hicpo_objects[]          = 'arts_service';
		$hicpo_options['objects'] = $hicpo_objects;
		update_option( 'hicpo_options', $hicpo_objects );

	}

}

/**
 * Unset all widgets
 * from default blog sidebar
 */
add_action( 'merlin_widget_importer_before_widgets_import', 'arts_unset_default_sidebar_widgets' );
add_action( 'pt-ocdi/widget_importer_before_widgets_import', 'arts_unset_default_sidebar_widgets' );
function arts_unset_default_sidebar_widgets() {

	// empty default blog sidebar
	$widget_areas = array(
		'blog-sidebar' => array(),
	);
	update_option( 'sidebars_widgets', $widget_areas );

}
