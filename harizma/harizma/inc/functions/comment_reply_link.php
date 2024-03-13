<?php

/**
 * Add custom classes to comments reply link
 */
add_filter( 'comment_reply_link', 'arts_replace_reply_link_class' );
function arts_replace_reply_link_class( $class ) {
	$class = str_replace( "class='comment-reply-link", "class='comment-reply-link button button_solid button_light button_shadow", $class );
	return $class;
}
