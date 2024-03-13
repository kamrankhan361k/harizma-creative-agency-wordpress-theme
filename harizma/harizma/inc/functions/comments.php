<?php

/**
 * Custom Fields (author, email, url) for Comment Form
 */
add_filter( 'comment_form_default_fields', 'arts_filter_comment_form_default_fields' );
function arts_filter_comment_form_default_fields( $args = array(), $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	// Exit the function when comments for the post are closed.
	if ( ! comments_open( $post_id ) ) {
		/**
		 * Fires after the comment form if comments are closed.
		 *
		 * @since 3.0.0
		 */
		do_action( 'comment_form_comments_closed' );

		return;
	}

	$commenter     = wp_get_current_commenter();
	$user          = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$args = wp_parse_args( $args );

	if ( ! isset( $args['format'] ) ) {
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	}

	$req      = get_option( 'require_name_email' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = 'html5' === $args['format'];

	$fields = array(
		'author' => '
			<div class="row form__row">
				<div class="col form__col">
					<label class="form-control">' .
						'<span class="form-control__label">' . esc_html__( 'Name', 'harizma' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</span>
							<span class="form-control__wrapper-input"><input class="form-control__input form-control__input_light" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $html_req . '/></span>' .
					'</label>
				</div>
			</div>
		',
		'email'  => '
			<div class="row form__row">
				<div class="col form__col">
					<label class="form-control">' .
						'<span class="form-control__label">' . esc_html__( 'Email', 'harizma' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</span>
						<span class="form-control__wrapper-input"><input class="form-control__input form-control__input_light" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $html_req . ' /></span>' .
					'</label>
				</div>
			</div>
		',
		'url'    => '
			<div class="row form__row">
				<div class="col form__col">
					<label class="form-control">' .
						'<span class="form-control__label">' . esc_html__( 'Website', 'harizma' ) . '</span>
						<span class="form-control__wrapper-input"><input class="form-control__input form-control__input_light" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></span>' .
					'</label>
				</div>
			</div>
		',
	);

	return $fields;
}

/**
 * Custom Textarea & Submit Button for Comment Form
 */
add_filter( 'comment_form_defaults', 'arts_comment_form_defaults' );
function arts_comment_form_defaults() {
	$args = array(
		'comment_field' => '
		<div class="row form__row">
			<div class="col form__col">
				<label class="form-control">' .
					'<span class="form-control__label">' . _x( 'Comment', 'noun', 'harizma' ) . '</span>' .
					'<span class="form-control__wrapper-input"><textarea id="comment" name="comment" class="form-control__input form-control__input_textarea form-control__input_light" cols="45" rows="8" maxlength="65525" required="required"></textarea></span>
				</label>
			</div>
		</div>
	',
		'class_submit'  => 'button button_solid button_accent',
		'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
		'submit_field'  => '
		<div class="row form__row text-left">
			<div class="col form__col">
				%1$s %2$s
			</div>
		</div>
	',
	);

	return $args;
}
