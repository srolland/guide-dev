<?php get_header(); ?>

	<div id="primary" class="c8">

		<article id="post-0" class="post error404 not-found">

			<!--
<i class="icon-exclamation-sign"></i>

	    	<header>
	    	   	<h1 class="post-title">Error 404</h1>
	        </header>
-->

	        <div class="post-content">
	            <p>We&rsquo;re sorry&#33; The page you’re looking for doesn’t seem to exist.</p>
				<p>There may be a misspelling in your web address or you may have clicked a link for content that no longer exists. If you followed a link on this site to get here, please contact the administrator at <?php echo '<a href="mailto:'.antispambot('webfeedback@postmedia.com').'">'.antispambot('webfeedback@postmedia.com').'</a>'; ?> so it can be corrected.
				</p>
				<p>While you’re here, why not check out the great stories below?</p>
	        </div>

	    </article>
	    
	    
	    
	    <?php 
		/* show Rotator posts  */
		$carousel = postmedia_get_zone_posts( 'homepage_rotator', false );

		$query = pm_check_cached_posts('pm_rotator_query', array( 'post_type' => array('post','video','gallery'),'posts_per_page' => '4', 'ignore_sticky_posts' => true, 'orderby' => 'post__in', 'post__in'=> array($carousel[ 0 ],$carousel[ 1 ],$carousel[ 2 ],$carousel[ 3 ]) ));

		 
		 
		 
		
		if ( $query->have_posts() ) { ?>

		<?php while ($query->have_posts()) : $query->the_post(); 
			
			
		?>
		
			

		<?php 
				
			if( $query->current_post == 0 ||  $query->current_post == 2 ){ ?>
						<div class="row">
		<?php		}//end if posts 0 || 2
		?>
				
			<div class="c6" >

				<?php get_template_part( 'content',  'main'  ); ?>
		
			</div>
			
			<?php if( $query->current_post == 1 ||  $query->current_post == 3 ) { ?>
			
			</div>
			<!-- end .row -->
			
		<?php 	}//end if posts 1 || 3
			
			
		
			endwhile; ?>

	<?php } ?> <!-- #End of if $pm_latest_post->have_posts() -->
	
	

	</div><!-- #primary.c8 -->

<?php get_footer(); ?>


