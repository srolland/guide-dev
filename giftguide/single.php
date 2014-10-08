<?php get_header(); ?>

	<div id="" class="c12">
	
	<div class="story-nav">
                        <?php previous_post_link('%link', '<button class="previous icon-chevron-left icon-2x" title="Previous Story"></button>', TRUE); ?>
                        <?php next_post_link('%link', '<button class="next icon-chevron-right icon-2x" title="Next Story"></button>', TRUE); ?>
		</div>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>


	</div><!-- #primary.c12 -->

<?php get_footer(); ?>