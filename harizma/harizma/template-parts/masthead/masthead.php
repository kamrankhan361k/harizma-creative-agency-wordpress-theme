<?php

$page_title         = '';
$post_id            = get_the_ID();
$post_type          = get_post_type( $post_id );
$page_subtitle      = '';
$class_section      = '';
$class_header       = '';
$has_post_thumbnail = has_post_thumbnail();
$background_img     = '';
$hide_section       = arts_get_document_option( 'hide_title' );

if ( is_category() ) {

	$page_subtitle      = get_category( get_query_var( 'cat' ) )->name;
	$page_title         = esc_html__( 'Posts in category', 'harizma' );
	$post_id            = get_option( 'page_for_posts' );
	$has_post_thumbnail = has_post_thumbnail( $post_id );

} elseif ( is_author() ) {

	$page_subtitle      = get_userdata( get_query_var( 'author' ) )->display_name;
	$page_title         = esc_html__( 'Posts by author', 'harizma' );
	$post_id            = get_option( 'page_for_posts' );
	$has_post_thumbnail = has_post_thumbnail( $post_id );

} elseif ( is_tag() ) {

	$page_subtitle      = single_tag_title( '', false );
	$page_title         = esc_html__( 'Posts with tag', 'harizma' );
	$post_id            = get_option( 'page_for_posts' );
	$has_post_thumbnail = has_post_thumbnail( $post_id );

} elseif ( is_day() ) {

	$page_subtitle      = get_the_date();
	$page_title         = esc_html__( 'Day archive', 'harizma' );
	$post_id            = get_option( 'page_for_posts' );
	$has_post_thumbnail = has_post_thumbnail( $post_id );

} elseif ( is_month() ) {

	$page_subtitle      = get_the_date( 'F Y' );
	$page_title         = esc_html__( 'Month archive', 'harizma' );
	$post_id            = get_option( 'page_for_posts' );
	$has_post_thumbnail = has_post_thumbnail( $post_id );


} elseif ( is_year() ) {

	$page_subtitle      = get_the_date( 'Y' );
	$page_title         = esc_html__( 'Year archive', 'harizma' );
	$post_id            = get_option( 'page_for_posts' );
	$has_post_thumbnail = has_post_thumbnail( $post_id );


} elseif ( is_home() ) {

	$post_id            = get_option( 'page_for_posts' );
	$page_title         = wp_title( '', false );
	$page_subtitle      = get_post_meta( $post_id, 'additonal_content_subtitle', true );
	$has_post_thumbnail = has_post_thumbnail( $post_id );

} elseif ( is_search() ) {

	$default_title      = esc_html__( 'Search', 'harizma' );
	$page_title         = get_theme_mod( 'search_title', $default_title );
	$has_post_thumbnail = false;

} else {

	$page_title    = get_the_title();
	$page_subtitle = get_post_meta( $post_id, 'additonal_content_subtitle', true );
}

if ( ! $page_title ) {
	$page_title = esc_html__( 'Blog', 'harizma' );
}

if ( $hide_section ) {
	$class_section .= 'd-none ';
}

if ( $has_post_thumbnail ) {
	$background_img = get_the_post_thumbnail_url( $post_id );
	$class_section .= 'art-parallax color-white bg-dark ';
	$class_header  .= 'section-masthead__header_background ';
} else {
	$class_section .= 'bg-light ';
}

if ( $post_type == 'arts_portfolio_item' ) {
	$categories = wp_get_post_terms(
		$post_id,
		'portfolio_category',
		array(
			'fields' => 'names',
		)
	);

	$categories = implode( ' | ', $categories );
}

?>

<section class="section section-masthead text-center <?php echo esc_attr( $class_section ); ?>" data-art-parallax="true" data-art-parallax-factor="0.5">
	<?php if ( $has_post_thumbnail ) : ?>
		<div class="art-parallax__bg lazy-bg" data-src="<?php echo esc_attr( $background_img ); ?>"></div>
	<?php endif; ?>
	<header class="section-masthead__header container <?php echo esc_attr( $class_header ); ?>">
		<div class="row">
			<div class="col">
				<?php if ( ! empty( $page_title ) && ! empty( $page_subtitle ) ) : ?>
					<?php if ( ! empty( $categories ) ) : ?>
						<div class="section-masthead__subheading"><?php echo esc_html( $categories ); ?></div>
					<?php endif; ?>
					<h1><?php echo esc_html( $page_title ); ?></h1>
				<?php endif; ?>
				<?php if ( ! empty( $page_subtitle ) ) : ?>
					<div class="section-masthead__subheading"><?php echo esc_html( $page_subtitle ); ?></div>
				<?php elseif ( ! empty( $page_title ) ) : ?>
					<?php if ( ! empty( $categories ) ) : ?>
						<div class="section-masthead__categories"><?php echo esc_html( $categories ); ?></div>
					<?php endif; ?>
					<h1 class="section-masthead__subheading"><?php echo esc_html( $page_title ); ?></h1>
				<?php endif; ?>
				<?php if ( is_singular( 'post' ) ) : ?>
					<div class="section-masthead__meta">
						<?php get_template_part( 'template-parts/post/partials/post_info' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</header>
	<?php if ( $has_post_thumbnail ) : ?>
		<div class="overlay overlay_dark"></div>
	<?php endif; ?>
</section>
