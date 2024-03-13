<?php

$footer_columns                 = get_theme_mod( 'footer_columns', 1 );
$footer_widgets_id              = 'footer-widgets'; // single column
$footer_hide                    = false;
$has_widgets                    = is_active_sidebar( $footer_widgets_id ); // single column
$has_multiple_columns_widgets   = arts_footer_has_active_sidebars();
$has_divider                    = get_theme_mod( 'enable_footer_divider', false );
$class_footer                   = '';
$class_container                = get_theme_mod( 'footer_container', 'container' );
$class_row                      = '';
$class_col                      = '';
$enable_footer_padding_top      = get_theme_mod( 'enable_footer_padding_top', true );
$enable_footer_padding_bottom   = get_theme_mod( 'enable_footer_padding_bottom', true );
$enable_footer_mobile_centering = get_theme_mod( 'enable_footer_mobile_centering', true );

$show_scroll_up = get_theme_mod( 'show_scroll_up', true );

switch ( $footer_columns ) {
	case 1: {
		$class_col  = 'col-lg-4 text-center';
		$class_row .= ' justify-content-center';
		break;
	}
	case 2: {
		$class_col = 'col-lg-6';
		break;
	}
	case 3: {
		$class_col = 'col-lg-4';
		break;
	}
	case 4: {
		$class_col = 'col-lg-3';
		$class_row = '';
		break;
	}
}

if ( $enable_footer_padding_top ) {
	$class_footer .= ' footer_pt';
}

if ( $enable_footer_padding_bottom ) {
	$class_footer .= ' footer_pb';
}

if ( $enable_footer_mobile_centering ) {
	$class_footer .= ' footer_mobile-content-center';
}

?>
			<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) : ?>
				<?php if ( $has_widgets || $has_multiple_columns_widgets ) : ?>
					<footer class="section footer bg-light <?php echo esc_attr( $class_footer ); ?>">
						<div class="<?php echo esc_attr( $class_container ); ?> footer__container">
							<?php if ( $has_multiple_columns_widgets ) : ?>
								<div class="footer__row row <?php echo esc_attr( $class_row ); ?>">
									<?php for ( $i = 1; $i <= $footer_columns; $i++ ) : ?>
										<?php
										if ( is_active_sidebar( 'footer-sidebar-' . $i ) ) {

											$class_col_order = ' order-lg-' . $i;
											if ( $footer_columns == 2 && $i == 1 ) {
												$class_col = 'col-lg-6';
											}
											if ( $footer_columns == 2 && $i == 2 ) {
												$class_col = 'col-lg-6';
											}
											if ( $footer_columns == 3 && $i == 1 ) {
												$class_col = 'col-lg-4';
											}
											if ( $footer_columns == 3 && $i == 2 ) {
												$class_col = 'col-lg-4';
											}
											if ( $footer_columns == 3 && $i == 3 ) {
												$class_col = 'col-lg-4';
											}
											if ( get_theme_mod( 'order_column_' . $i ) > 1 ) {
												$order           = get_theme_mod( 'order_column_' . $i );
												$class_col_order = ' order-lg-' . $i . ' order-' . $order;
											}
											?>
											<div class="<?php echo esc_attr( $class_col . $class_col_order ); ?> footer__column">
												<?php dynamic_sidebar( 'footer-sidebar-' . $i ); ?>
											</div>
										<?php } ?>
									<?php endfor; ?>
								</div>
							<?php endif; ?>
							<?php if ( $has_divider ) : ?>
								<div class="footer__divider"></div>
							<?php endif; ?>
							<?php if ( $has_widgets ) : ?>
								<div class="footer__row row justify-content-center text-center">
									<div class="col-lg-6">
										<?php dynamic_sidebar( $footer_widgets_id ); ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</footer>
				<?php endif; ?>
			<?php endif; ?>
		</div><!-- - page-wrapper -->
		<?php if ( $show_scroll_up == true ) : ?>
			<div class="scroll-up js-scroll-up">
				<div class="scroll-up__icon arrow_up"></div>
			</div>
		<?php endif; ?>
		<?php wp_footer(); ?>
	</body>
</html>
