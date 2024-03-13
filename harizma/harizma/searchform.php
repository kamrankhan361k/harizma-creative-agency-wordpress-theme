<?php

$unique_id = uniqid( 'search-form-' );

?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="form-control">
		<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="form-control__input" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'harizma' ); ?>"/>
		<button type="submit" class="form-control__search-submit"><i class="elegant-icons icon_search"></i></button>
	</div>
</form>
