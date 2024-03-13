<?php

$prev_post           = get_next_post();
$next_post           = get_previous_post();
$enable_archive_link = get_theme_mod( 'enable_portfolio_archive_link', true );
$archive_link        = get_theme_mod( 'portfolio_archive_link', '' );

?>

<!-- aside PROJECTS NAV -->
<aside class="aside aside-projects-nav">
	<div class="container">
		<div class="row align-items-center justify-content-between">
			<div class="col-md-4 aside-projects-nav__wrapper-left aside-projects-nav__col">
				<?php if ( $prev_post ) : ?>
					<?php
						$prev_link  = get_permalink( $prev_post );
						$prev_title = get_the_title( $prev_post );
					?>
					<a class="aside-projects-nav__prev" href="<?php echo esc_url( $prev_link ); ?>"><?php echo esc_html( $prev_title ); ?></a>
				<?php endif; ?>
			</div>
			<?php if ( $enable_archive_link && ! empty( $archive_link ) ) : ?>
				<div class="col-md-4 aside-projects-nav__wrapper-center aside-projects-nav__col">
					<a class="aside-projects-nav__all" href="<?php echo esc_url( $archive_link ); ?>"></a>
				</div>
			<?php endif; ?>
			<div class="col-md-4 aside-projects-nav__wrapper-right aside-projects-nav__col">
				<?php if ( $next_post ) : ?>
					<?php
						$next_link  = get_permalink( $next_post );
						$next_title = get_the_title( $next_post );
					?>
					<a class="aside-projects-nav__next" href="<?php echo esc_url( $next_link ); ?>"><?php echo esc_html( $next_title ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</aside>
<!-- - aside PROJECTS NAV -->
