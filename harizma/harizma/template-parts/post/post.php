<?php

$post_show_readmore = get_theme_mod( 'post_show_read_more', true );

?>

<article <?php post_class( 'post figure-post figure-post_preview' ); ?> id="post-<?php the_ID(); ?>">

	<?php if ( has_post_thumbnail() ) : ?>
		<a class="figure-post__wrapper-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'arts-760x430-crop' ); ?></a>
		<!-- - post__media-->
	<?php endif; ?>

	<div class="figure-post__inner">
		<div class="figure-post__header">
			<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<?php get_template_part( 'template-parts/post/partials/post_info' ); ?>
		</div>
		<div class="figure-post__wrapper-content">
			<?php get_template_part( 'template-parts/content/content', get_post_format() ); ?>
		</div>
		<!-- - post__content-->
		<?php if ( $post_show_readmore ) : ?>
			<div class="figure-post__wrapper-readmore">
				<?php get_template_part( 'template-parts/post/partials/post_read_more' ); ?>
			</div>
		<?php endif; ?>
	</div>

</article>
