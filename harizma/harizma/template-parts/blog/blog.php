<?php

$sidebar_position = get_theme_mod( 'sidebar_position', 'right_side' );

$posts_col_class   = 'col-lg-8 order-lg-1';
$sidebar_col_class = 'col-lg-3 order-lg-2';
$section_class     = '';

if ( $sidebar_position == 'left_side' ) {
	$posts_col_class   = 'col-lg-8 order-lg-2';
	$sidebar_col_class = 'col-lg-3 order-lg-1';
}

if ( is_active_sidebar( 'blog-sidebar' ) ) {
	$blog_row_class = 'row justify-content-between';
} else {
	$blog_row_class = 'row justify-content-center';
}

if ( is_single() && has_post_thumbnail() ) {
	$section_class .= 'section-blog_featured-img ';
}

?>

<section class="section section_pt section_pb section-blog <?php echo esc_attr( $section_class ); ?>">
	<div class="container">
		<div class="<?php echo esc_attr( $blog_row_class ); ?>">
			<div class="section-blog__posts <?php echo esc_attr( $posts_col_class ); ?>">
				<?php if ( have_posts() ) : ?>
					<!-- posts -->
						<?php get_template_part( 'template-parts/loop/loop', 'blog' ); ?>
						<?php if ( get_the_posts_pagination() ) : ?>
							<!-- pagination -->
							<div class="section-blog__wrapper-pagination">
								<?php arts_posts_pagination(); ?>
							</div>
							<!-- - pagination -->
						<?php endif; ?>
					<!-- - posts -->
				<?php else : ?>
					<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
				<?php endif; ?>
			</div>

			<?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
				<!-- sidebar -->
				<div class="section-blog__sidebar <?php echo esc_attr( $sidebar_col_class ); ?>">
					<?php get_sidebar(); ?>
				</div>
				<!-- - sidebar -->
			<?php endif; ?>
		</div>
	</div>
</section>
