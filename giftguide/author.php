<?php
/**
 * The author page
 *
 * @since 0.1.2
 * @author c.bavota
 */
?>
<?php get_header(); ?>

	<div id="primary" class="c8">

		<header class="author-info">
			<?php
			$author_id = get_queried_object_id();
			$email = get_the_author_meta( 'user_email', $author_id );
			$count = 1;
			$open_row = false;
			?>
			<a href="<?php echo get_author_posts_url( $author_id ); ?>" rel="author"><?php echo get_avatar( $author_id, 150 ); ?></a>
			<div class="author-text">
				<h1><?php the_author(); ?></h1>
				<a class="author-email" href="<?php echo antispambot( 'mailto:' . $email ); ?>"><?php echo antispambot( $email ); ?></a>
				<p class="author-bio"><?php echo postmedia_get_gravatar_profile( $author_id ); ?></p>
			</div>
		</header>

		<?php if ( have_posts() ) :	?>
			<section>
				<h4 class="section-heading">Latest Stories</h4>

				<?php while ( have_posts() ) : the_post(); 

					if( $count & 1 ){ 
				
				$open_row = true;
				
			?>
								
			<div class="row">
				
				<div class="c6" >

					<?php get_template_part( 'content',  'main'  ); ?>
		
				</div>
			
			<?php } 
					
					if ( ($count & 1) == 0 )  { 	?>
			
				<div class="c6" >

					<?php get_template_part( 'content',  'main'  ); ?>
		
				</div>
			</div>
			<!-- end .row -->
			
		<?php $open_row = false;
		
				} //end if posts even
			
				
			$count++;
			
			// get_template_part( 'content', 'main' ); 

			endwhile; 
				 
			if ( $open_row ) { ?>
				</div>
				<!-- end .row -->
			<?php } ?>

				<?php postmedia_pagination(); ?>

			</section>
		<?php endif; ?>

	</div><!-- #primary.c8 -->

<?php get_footer(); ?>