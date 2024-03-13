<?php

$post_show_info             = get_theme_mod( 'post_show_info', true );
$post_show_date             = get_theme_mod( 'post_show_date', true );
$post_show_categories       = get_theme_mod( 'post_show_categories', true );
$post_show_comments_counter = get_theme_mod( 'post_show_comments_counter', true );
$post_show_author           = get_theme_mod( 'post_show_author', true );
$date_link                  = get_month_link( get_post_time( 'Y' ), get_post_time( 'm' ) );
$author                     = arts_get_post_author();
?>

<?php if ( $post_show_info ) : ?>

	<ul class="post-meta">

		<?php if ( $post_show_date ) : ?>
			<li class="post-meta__item">
				<div class="post-meta__item-icon elegant-icons icon_clock_alt"></div>
				<a href="<?php echo esc_attr( $date_link ); ?>"><?php echo esc_html( get_the_date() ); ?></a>
			</li>
		<?php endif; ?>

		<?php if ( $post_show_categories ) : ?>
			<?php if ( has_category() ) : ?>
				<li class="post-meta__item">
					<div class="post-meta__item-icon elegant-icons icon_tag_alt"></div>
					<span class="post-meta__item-text"><?php esc_html_e( 'in', 'harizma' ); ?></span>
					<?php the_category( ',&nbsp;' ); ?>
				</li>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( $post_show_comments_counter ) : ?>
			<li class="post-meta__item">
				<div class="post-meta__item-icon elegant-icons icon_comment_alt"></div>
				<a href="<?php echo get_comments_link( get_the_ID() ); ?>"><?php comments_number(); ?></a>
			</li>
		<?php endif; ?>

		<?php if ( ! empty( $author['name'] ) && $post_show_author ) : ?>
			<li class="post-meta__item">
				<div class="post-meta__item-icon elegant-icons icon_profile"></div>
				<span class="post-meta__item-text"><?php esc_html_e( 'Posted by', 'harizma' ); ?></span>
				<a href="<?php echo esc_url( $author['url'] ); ?>"><?php echo esc_html( $author['name'] ); ?></a>
			</li>
		<?php endif; ?>

	</ul>

<?php endif; ?>
