<?php get_header(); 

$open_rotator = true;	
$open_row = false;

?>

		
<div id="" class="c12">
	
	
		
	<h3 class="section-title"><a href="<?php echo get_home_url(); ?>">Latest Additions</a></h3>
	
	<div class="row" id="container">
	<?php 
		/* show the latest Zone posts  */
		$query = pm_check_cached_posts('gg_index_query', array( 'posts_per_page' => '20', 'ignore_sticky_posts' => true));
		
		if ( $query->have_posts() ) { ?>

		<?php while ($query->have_posts()) : $query->the_post(); 
			
			if( $query->current_post == 0 && !is_paged() ){
		?>
			
			<div class="c12 item">
			
			<?php get_template_part( 'content', 'main' ); ?>
			
			</div>
				<!-- end .c12 -->
		<?php } else if( $query->current_post == 6 || $query->current_post == 12 ){
		?>
			
			<div class="c3 item">
			
			  <img src="http://placehold.it/300x250&text=Ad">
			
			</div>
				<!-- end .c3 -->
		<?php } else { 
		
					/*
if( $query->current_post == 1 ||  $query->current_post == 5 ){ ?>

						<div class="row">

		<?php			$open_row = true;
					}//end if posts 1 || 5
*/
		?>
				
			<div class="c3 item" >

				<?php get_template_part( 'content',  'main'  ); ?>
		
			</div>
			
			<?php	/*
if( $query->current_post == 4 ||  $query->current_post == 8 ) { ?>
			
			</div>
			<!-- end .row -->
			
		<?php 
						$open_row = false;
			
					}//end if posts 4 || 8
*/
				
				
			
			}//end have_posts if
		
			endwhile; 
			
			if ( $open_row ) {   
				echo "</div>
				<!-- end .row -->";
			}

		} ?> <!-- #End of if $pm_latest_post->have_posts() -->
		
		</div>
				<!-- end .row -->

	<!-- <a href="<?php echo get_home_url(); ?>/page" class="more_link"> More Faces of War</a> -->

	<?php postmedia_pagination(); ?>

	</div><!-- .primary.c12 -->



<?php get_footer(); ?>