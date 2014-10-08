<?php get_header(); ?>

<div id="" class="c12">

	<?php if( is_category() ) { 
		
			$count = 1;
			$open_row = false;
		
		
		 } ?> <!-- #End of if the page is_category() condition -->
	
	<div class="row">
	
	<?php if ( have_posts() ) { ?>

		<?php while ( have_posts() ) : the_post(); 
		
			if( $count === 1 ) {
				 get_template_part( 'content', 'main' ); 
			}
			 
			else {
				
			?>
								
				<div class="c3" >

				<?php get_template_part( 'content',  'main'  ); ?>
		
			</div>
					
		<?php 
			}
				
			$count++;
			

			endwhile; 

		}  ?> <!-- #End of if have_posts() -->
		
		</div>

	<?php postmedia_pagination(); ?>

</div><!-- #primary.c8 -->

<?php get_footer(); ?>