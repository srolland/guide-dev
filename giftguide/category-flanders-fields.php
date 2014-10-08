<?php get_header(); ?>

<div id="primary" class="c8">

	<p class="intro-intro">In a few short lines of poetry, Canadian physician Lieutenant Colonel John McCrae captured the futility of the Great War. We asked prominent Canadians to recite the poem as an act of remembrance. We encourage you to record your own version and share it using the hashtag <strong>#inflandersfields</strong>.</p>
	
	<div id="intro_box">
		<div>
			<h3>Introduction</h3>
			<p>In Flanders fields the poppies blow,<br/>
			Between the crosses, row on row,<br/>
			That mark our place; and in the sky<br/>
			The larks, still bravely singing, fly<br/>
			Scarce heard amid the guns below.</p>
					
			<p>We are the Dead. Short days ago<br/>
			We lived, felt dawn, saw sunset glow,<br/>
			Loved and were loved, and now we lie<br/>
			In Flanders fields.</p>
			
			
			<p>Take up our quarrel with the foe:<br/>
			To you from failing hands we throw<br/>
			The torch; be yours to hold it high.<br/>
			If ye break faith with us who die<br/>
			We shall not sleep, though poppies grow<br/>
			In Flanders fields.</p>
		</div>
	</div>


	<?php if( is_category() && is_paged() != true ) { 
		
			$count = 1;
			$open_row = false;
			$current_cat = get_queried_object()->slug;
			
			$current_cat_cache = "pm_" . $current_cat . "_query";
	?>

		<?php if( function_exists( 'postmedia_get_zone_posts' ) ) { 

		
		$carousel = postmedia_get_zone_posts( $current_cat, false );
		
		if ( empty($carousel) == false ) { 
		
		$query = pm_check_cached_posts($current_cat_cache, array( 'post_type' => array('post','video','gallery'),'ignore_sticky_posts' => true, 'orderby' => 'post__in', 'post__in'=> $carousel ));
		
		if ( $query->have_posts() ) { ?>

		<?php while ($query->have_posts()) : $query->the_post(); 
			
			if( $query->current_post == 0 && !is_paged() ){
		?>
		
			<?php get_template_part( 'content', 'main' ); ?>

		<?php } else if( $count > 1 && ($count & 1) == false ){ 
				
				 $open_row = true;
				
			?>
								
			<div class="row">
				
				<div class="c6" >

					<?php get_template_part( 'content',  'main'  ); ?>
		
				</div>
			
			<?php } 
					
					if (  $count > 1 && $count & 1 ) { 	?>
			
				<div class="c6" >

					<?php get_template_part( 'content',  'main'  ); ?>
		
				</div>
			</div>
			<!-- end .row -->
			
		<?php $open_row = false;
		
				} //end if posts even
				
			$count++;

			endwhile;  ?>

	<?php } // end of if have posts  
		
		
		} // end if $carrousel is empty
		?>
		
		
		

		<?php } ?>

	<?php } ?> <!-- #End of if the page is_category() condition -->
	
	<?php if ( have_posts() ) { ?>

		<?php while ( have_posts() ) : the_post(); 
		
			if( $count === 1 ) {
				 get_template_part( 'content', 'main' ); 
			}
			
				
			else if( $count > 1 && ($count & 1) == false ){ 
				
				 $open_row = true;
				
			?>
								
			<div class="row">
				
				<div class="c6" >

					<?php get_template_part( 'content',  'main'  ); ?>
		
				</div>
			
			<?php } 
					
					if (  $count > 1 && $count & 1 ) { 	?>
			
				<div class="c6" >

					<?php get_template_part( 'content',  'main'  ); ?>
		
				</div>
			</div>
			<!-- end .row -->
			
		<?php $open_row = false;
		
				} //end if posts even
				
			$count++;

			endwhile; 
		
			if ( $open_row ) {   
				echo "</div>
				<!-- end .row -->";
			}

		}  ?> <!-- #End of if have_posts() -->

	<?php postmedia_pagination(); ?>

</div><!-- #primary.c8 -->

<?php get_footer(); ?>