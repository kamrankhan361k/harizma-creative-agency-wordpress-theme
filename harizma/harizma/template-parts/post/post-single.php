<article <?php post_class( 'post' ); ?> id="post-<?php the_ID(); ?>">
	<div class="post__content clearfix">
		<?php the_content(); ?>
		<?php
			wp_link_pages(
				array(
					'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'harizma' ),
					'after'       => '</div>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				)
			);
			?>
	</div>
	<!-- .post__content -->

	<?php if ( wp_get_post_tags( $post->ID ) ) : ?>
		<div class="post__footer">
			<div class="post__properties post__tags">
				<div class="tagcloud">
					<?php the_tags( '', ', ', '' ); ?>
				</div>
			</div>
		</div>
		<!-- .post__tags -->
	<?php endif; ?>

	<?php if ( comments_open() || get_comments_number() ) : ?>
		<div class="post__comments">
			<?php comments_template(); ?>
		</div>
		<!-- .post__comments -->
	<?php endif; ?>
</article>
