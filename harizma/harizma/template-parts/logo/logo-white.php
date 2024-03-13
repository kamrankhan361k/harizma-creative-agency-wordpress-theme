<?php

$title                 = get_bloginfo( 'name' );
$logo_white_url        = get_theme_mod( 'custom_logo_white_url' );
$logo_white_retina_url = get_theme_mod( 'custom_logo_retina_white_url' );
$srcset                = $logo_white_url . ' 1x';

if ( $logo_white_retina_url ) {
	$srcset = $logo_white_retina_url . ' 2x';
}

?>

<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
	<img src="<?php echo esc_attr( $logo_white_url ); ?>" srcset="<?php echo esc_attr( $srcset ); ?>" alt="<?php echo esc_attr( $title ); ?>">
</a>
