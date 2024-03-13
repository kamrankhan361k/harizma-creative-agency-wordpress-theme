<?php

/**
 * Style Password Form in Protected Posts
 */
add_filter( 'the_password_form', 'arts_password_form' );
function arts_password_form() {

	global $post;
	$post   = get_post( $post );
	$label  = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
	$output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
	<p>' . esc_html__( 'This content is password protected. To view it please enter your password below:', 'harizma' ) . '</p>
	<label class="form-control form-control_inline"><span class="form-control__label form-control__label_inline">' . esc_html__( 'Password', 'harizma' ) . '</span><span class="form-control__wrapper-input">' . ' <input class="form-control__input form-control__input_inline" name="post_password" id="' . $label . '" type="password" size="20" /><button type="submit" class="form-control__search-submit"><i class="elegant-icons arrow_right"></i></button></span></label></form>
	';

	return $output;

}

