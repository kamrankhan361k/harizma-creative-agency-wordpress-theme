<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Harizma for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once ARTS_THEME_PATH . '/inc/classes/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'arts_register_required_plugins' );
function arts_register_required_plugins() {

	$source = ARTS_THEME_PLUGINS_REMOTE_SOURCE ? 'https://artemsemkin.com/wp-content/themes/' . ARTS_THEME_SLUG . '/plugins' : ARTS_THEME_PATH . '/plugins';
	$source = trailingslashit( $source );

	$source_common_plugins = ARTS_THEME_PLUGINS_REMOTE_SOURCE ? 'https://artemsemkin.com/common-plugins' : ARTS_THEME_PATH . '/plugins';
	$source_common_plugins = trailingslashit( $source_common_plugins );

	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'     => esc_html__( 'Advanced Custom Fields PRO', 'harizma' ),
			'slug'     => 'advanced-custom-fields-pro',
			'source'   => esc_url( $source_common_plugins . 'advanced-custom-fields-pro.zip' ),
			'required' => false,
			'version'  => '5.8.4',
		),

		array(
			'name'     => esc_html__( 'Harizma Core', 'harizma' ),
			'slug'     => 'harizma-core',
			'source'   => esc_url( $source . 'harizma-core.zip' ),
			'required' => true,
			'version'  => '2.3.0',
		),

		array(
			'name'     => esc_html__( 'Contact Form 7', 'harizma' ),
			'slug'     => 'contact-form-7',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Custom Icons for Elementor', 'harizma' ),
			'slug'     => 'custom-icons-for-elementor',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Elementor', 'harizma' ),
			'slug'     => 'elementor',
			'required' => true,
		),

		array(
			'name'     => esc_html__( 'Envato Market', 'harizma' ),
			'slug'     => 'envato-market',
			'source'   => ARTS_THEME_PLUGINS_REMOTE_SOURCE ? esc_url( 'https://envato.github.io/wp-envato-market/dist/envato-market.zip' ) : esc_url( ARTS_THEME_PATH . '/plugins/' . 'envato-market.zip' ),
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Kirki', 'harizma' ),
			'slug'     => 'kirki',
			'required' => true,
		),

		array(
			'name'     => esc_html__( 'Intuitive Custom Post Order', 'harizma' ),
			'slug'     => 'intuitive-custom-post-order',
			'source'   => esc_url( $source_common_plugins . 'intuitive-custom-post-order.zip' ),
			'required' => false,
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 */
	$config = array(
		'id'           => 'harizma',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
