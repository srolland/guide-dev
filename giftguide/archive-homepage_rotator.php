<?php get_header(); ?>

<div id="primary" class="c8">

	<?php if( is_category() && is_paged() != true ) { ?>

		<?php if( function_exists( 'postmedia_display_zone_posts' ) ) { ?>

		<?php postmedia_display_zone_posts(); ?>

		<?php } ?>

	<?php } ?> <!-- #End of if the page is_category() condition -->

	<?php if ( have_posts() ) { ?>

		<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'main_first' ); ?>

		<?php endwhile; ?>

	<?php } ?> <!-- #End of if have_posts() -->

	<?php postmedia_pagination(); ?>

</div><!-- #primary.c8 -->

<?php get_footer(); ?>