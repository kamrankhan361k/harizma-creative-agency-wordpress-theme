<?php

$post_id                   = get_the_ID();
$menu_style                = get_theme_mod( 'menu_style', 'regular' );
$has_menu                  = has_nav_menu( 'main_menu' );
$class_header              = '';
$class_wrapper_burger      = '';
$class_container           = get_theme_mod( 'header_container', 'container-fluid' );
$preloader                 = get_theme_mod( 'preloader_type', 'fadein' );
$header_widgets_id         = 'header-widgets';
$has_custom_logo           = has_custom_logo();
$has_custom_white_logo     = get_theme_mod( 'custom_logo_white_url' );
$has_post_thumbnail        = has_post_thumbnail();
$locations                 = get_nav_menu_locations();
$menu_name                 = 'main_menu';
$menu_object               = wp_get_nav_menu_object( $locations[ $menu_name ] );
$menu_items                = wp_get_nav_menu_items( $menu_object );
$page_header_settings      = arts_get_document_option( 'page_header_settings' );
$site_title                = get_bloginfo( 'name' );
$site_description          = get_bloginfo( 'description' );
$social_links              = get_theme_mod( 'social_links', null );
$header_has_lang_switcher  = is_active_sidebar( 'lang-switcher-sidebar' ) && ( class_exists( 'SitePress' ) || class_exists( 'Polylang' ) );
$outdated_browsers_enabled = get_theme_mod( 'outdated_browsers_enabled', false );

/**
 * Use Individual Page Header Settings from Elementor
 * Or Use Global Settings from Customizer
 */
if ( $page_header_settings ) {

	$page_header_theme = arts_get_document_option( 'page_header_theme' );
	$page_menu_style   = arts_get_document_option( 'page_menu_style' );

	if ( $page_header_theme ) {
		$class_header      .= $page_header_theme . ' ';
		$has_post_thumbnail = true;
	}

	if ( $page_menu_style ) {
		$menu_style = $page_menu_style;
	}
}

$args_menu_regular = array(
	'theme_location' => $menu_name,
	'container'      => false,
);

$args_menu_fullscreen = array(
	'theme_location' => $menu_name,
	'container'      => false,
	'menu_class'     => 'container menu-overlay js-menu-overlay',
	'link_before'    => '<div class="menu-overlay__item-wrapper"><span>',
	'link_after'     => '</span></div>',
);

if ( $menu_style == 'regular' ) {

	$class_wrapper_burger = 'd-xl-none';

}

if ( is_home() ) {
	$post_id            = get_option( 'page_for_posts' );
	$has_post_thumbnail = has_post_thumbnail( $post_id );
}

if ( is_search() ) {
	$has_post_thumbnail = false;
	$class_header       = '';
}

if ( $has_post_thumbnail ) {

	$class_header .= 'header_white ';

}

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		}
		?>
		<?php if ( $outdated_browsers_enabled ) : ?>
			<div id="outdated"></div>
		<?php endif; ?>
		<?php if ( $preloader == 'curtains' ) : ?>
			<!-- PAGE PRELOADER -->
			<?php get_template_part( 'template-parts/preloader/preloader' ); ?>
			<!-- - PAGE PRELOADER -->
		<?php endif; ?>
		<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) : ?>
			<!-- PAGE HEADER -->
			<header class="header header_absolute <?php echo esc_attr( $class_header ); ?>">
				<div class="<?php echo esc_attr( $class_container ); ?> header__container">
					<div class="row align-items-center header__row">
						<div class="col-auto header__wrapper-left header__col">
							<?php if ( $has_custom_white_logo && $has_post_thumbnail ) : ?>
								<?php get_template_part( 'template-parts/logo/logo', 'white' ); ?>
							<?php elseif ( $has_custom_logo ) : ?>
								<?php get_template_part( 'template-parts/logo/logo' ); ?>
							<?php else : ?>
								<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $site_title ); ?></a>
							<?php endif; ?>
						</div>
						<?php if ( $has_menu && $menu_style == 'regular' ) : ?>
							<div class="col-auto header__wrapper-center header__col d-none d-xl-block">
								<?php wp_nav_menu( $args_menu_regular ); ?>
							</div>
							<?php if ( $social_links ) : ?>
								<div class="col-auto header__wrapper-right header__col d-none d-xl-block">
									<ul class="social">
										<?php foreach ( $social_links as $item ) : ?>
											<li class="social__item">
												<a class="social__icon <?php echo esc_attr( $item['social_icon'] ); ?>" href="<?php echo esc_url( $item['social_url'] ); ?>" target="_blank"></a>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						<?php endif; ?>
						<?php if ( $header_has_lang_switcher ) : ?>
							<div class="col-auto header__wrapper-right header__col">
								<div class="lang-switcher">
									<?php dynamic_sidebar( 'lang-switcher-sidebar' ); ?>
								</div>
							</div>
						<?php endif; ?>
						<div class="col-auto header__wrapper-right header__col <?php echo esc_attr( $class_wrapper_burger ); ?>">
							<div class="burger js-burger">
								<div class="burger__line"></div>
								<div class="burger__line"></div>
								<div class="burger__line"></div>
							</div>
						</div>
					</div>
					<div class="header__wrapper-overlay-menu">
						<div class="header__overlay-menu-back elegant-icons arrow_back js-submenu-back"></div>
						<?php wp_nav_menu( $args_menu_fullscreen ); ?>
						<?php if ( $social_links ) : ?>
							<div class="header__wrapper-overlay-widgets">
								<ul class="social">
									<?php foreach ( $social_links as $item ) : ?>
										<li class="social__item">
											<a class="social__icon <?php echo esc_attr( $item['social_icon'] ); ?>" href="<?php echo esc_url( $item['social_url'] ); ?>" target="_blank"></a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
						<div class="header__wrapper-background">
							<?php foreach ( $menu_items as $item ) : ?>
								<?php
									$post_id = url_to_postid( $item->url );
									$image   = has_post_thumbnail( $post_id );
								?>
								<?php if ( $image ) : ?>
									<?php $image_url = get_the_post_thumbnail_url( $post_id ); ?>
									<div class="header__background lazy-bg" data-src="<?php echo esc_attr( $image_url ); ?>" data-header-background-for="<?php echo esc_attr( $post_id ); ?>"></div>
								<?php endif; ?>
							<?php endforeach; ?>
							<div class="header__diagonal-curtain-1"></div>
							<div class="header__diagonal-curtain-2"></div>
							<div class="overlay overlay_accent header__overlay"></div>
						</div>
					</div>
				</div>
			</header>
			<!-- - PAGE HEADER -->
		<?php endif; ?>
		<div class="page-wrapper page-wrapper_hidden" id="page-wrapper">
