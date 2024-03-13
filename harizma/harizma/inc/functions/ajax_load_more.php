<?php

function arts_ajax_load_more() {
	$post_type = sanitize_key( $_POST['post_type'] );
	$page      = sanitize_key( $_POST['page'] );
	$posts     = array();
	$counter   = 0;

	$args['post_type']   = $post_type;
	$args                = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged']       = $page + 1;
	$args['post_status'] = 'publish';

	$query = query_posts( $args );

	if ( have_posts() ) {

		while ( have_posts() ) {

			the_post();

			$post_id                         = get_the_ID();
			$posts[ $counter ]['title']      = get_the_title();
			$posts[ $counter ]['link']       = get_the_permalink();
			$post_image_id                   = get_post_thumbnail_id();
			$posts[ $counter ]['categories'] = get_the_terms( $post_id, 'portfolio_category' );
			$posts[ $counter ]['image']      = wp_get_attachment_image_src( $post_image_id, 'arts-800x800-crop' );
			$posts[ $counter ]['image_full'] = wp_get_attachment_image_src( $post_image_id, 'full' );

			$counter++;

		};

		echo json_encode( $posts );

	};

	wp_die();
}
add_action( 'wp_ajax_loadmore', 'arts_ajax_load_more' );
add_action( 'wp_ajax_nopriv_loadmore', 'arts_ajax_load_more' );
