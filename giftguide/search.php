<?php get_header(); ?>

	<section id="primary" class="c8">

		<?php if ( have_posts() ) : ?>

			<header id="search-header">
				<h1 class="page-title"><?php
				global $wp_query;
				printf( '%1$s "%2$s"',
					$wp_query->found_posts . ' search results for',
				    get_search_query()
				);
				?></h1>
			</header><!-- #search-header -->

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'main' ); ?>

			<?php endwhile; ?>

			<?php postmedia_pagination(); ?>

		<?php else : ?>

			<article id="post-0" class="post error404 not-found">

		    	<header>
		    	   	<h1 class="post-title">Nothing found</h1>
		        </header>

		        <div class="entry">
		            <p>You searched for "<?php echo get_search_query(); ?>." No results were found for your search. Please try again.</p>
		        </div>

		    </article><!-- #post-0 -->

		<?php endif; ?>

	</section><!-- #primary.c8 -->

<?php get_footer(); ?>