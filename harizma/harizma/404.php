<?php

$class_section       = '';
$class_button        = 'button_solid button_accent button_shadow';
$preloader           = get_theme_mod( 'preloader_type', 'fadein' );
$page_title          = get_theme_mod( '404_title', esc_html__( 'Oops! Page not found', 'harizma' ) );
$page_subtitle       = get_theme_mod( '404_message', esc_html__( 'The page not found this could be a spelling error or a removed page', 'harizma' ) );
$page_big            = get_theme_mod( '404_big', esc_html__( '404', 'harizma' ) );
$page_button         = get_theme_mod( '404_button', esc_html__( 'Back to home page', 'harizma' ) );
$page_background_url = get_theme_mod( '404_background_url', '' );

if ( ! empty( $page_background_url ) ) {
	$class_section .= 'lazy jarallax color-white ';
	$class_button   = 'button_bordered button_white';
}

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-transcluent">
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?>">
		<meta name="application-name" content="<?php bloginfo( 'name' ); ?>">
		<meta name="description" content="<?php bloginfo( 'description' ); ?>">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php if ( $preloader == 'curtains' ) : ?>
			<!-- PAGE PRELOADER -->
			<?php get_template_part( 'template-parts/preloader/preloader' ); ?>
			<!-- - PAGE PRELOADER -->
		<?php endif; ?>
		<div class="page-wrapper page-wrapper_hidden" id="page-wrapper">
			<!-- section 404 -->
			<section class="section section-fullheight section-404 text-center <?php echo esc_attr( $class_section ); ?>" data-src="<?php echo esc_attr( $page_background_url ); ?>">
				<div class="section-fullheight__inner section__content">
					<div class="container">
						<header class="row section-404__header">
							<div class="col">
								<?php if ( ! empty( $page_big ) ) : ?>
									<div class="section-404__big"><?php echo esc_html( $page_big ); ?></div>
								<?php endif; ?>
								<?php if ( ! empty( $page_title ) ) : ?>
									<h1><?php echo esc_html( $page_title ); ?></h1>
									<?php endif; ?>
								<?php if ( ! empty( $page_subtitle ) ) : ?>
									<p><?php echo esc_html( $page_subtitle ); ?></p>
								<?php endif; ?>
							</div>
						</header>
						<?php if ( ! empty( $page_button ) ) : ?>
							<div class="row section-404__wrapper-button">
								<div class="col"><a class="button <?php echo esc_attr( $class_button ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $page_button ); ?></a>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php if ( ! empty( $page_background_url ) ) : ?>
					<div class="overlay overlay_accent"></div>
				<?php endif; ?>
			</section>
			<!-- - section 404 -->
		</div>
		<?php wp_footer(); ?>
	</body>
</html>
