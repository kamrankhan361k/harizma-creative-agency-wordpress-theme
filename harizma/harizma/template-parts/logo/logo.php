<?php

$title           = get_bloginfo( 'name' );
$logo            = get_theme_mod( 'custom_logo' );
$logo_url        = wp_get_attachment_url( $logo );
$logo_retina_url = get_theme_mod( 'custom_logo_retina_url' );
$srcset          = $logo_url . ' 1x';

if ( $logo_retina_url ) {
	$srcset = $logo_retina_url . ' 2x';
}

?>

<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
	<img src="<?php echo esc_attr( $logo_url ); ?>" srcset="<?php echo esc_attr( $srcset ); ?>" alt="<?php echo esc_attr( $title ); ?>">
</a>
