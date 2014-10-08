<?php
global $wp_query;
$post_id = get_the_ID();
$first_post = ( is_archive() && 0 == $wp_query->current_post )	? 'first-post' : '';

?>
	<article id="post-<?php echo $post_id; ?>" <?php post_class( $first_post ); ?>>
<style>
#disaster_template { padding-top: 18px; text-align: center; margin-bottom: 20px; }

#disaster_template a.full-coverage { color:#e7240a; font-family: 'Roboto Condensed', 'Arial Narrow', sans-serif !important; font-size:16px; font-weight: bold; text-transform: uppercase;  }

#disaster_template a.full-coverage:hover { color:#124872;  }

#disaster_template .wp-post-image {
margin: 0;
}

#disaster_template header {
margin-bottom: 10px;
}

</style>
		

		<?php
			
		$title = get_post_meta( $post_id, 'cdc_discussion_headline', true );
		if ( empty($title) ){ $title = get_the_title(); }
		$url = get_permalink();
		$thumbnail_id = get_post_thumbnail_id( $post_id );	
		?>	

		<div class="post-content clearfix">
			
			<header>
					<h1 class="post-title">

							<a href="<?php echo $url; ?>" title="Full coverage" rel="bookmark">			
							<?php echo $title; ?>			
							</a>
					</h1>
					
					<a href="<?php echo $url; ?>" title="<?php printf( esc_attr__( '%s' ), $title ); ?>" rel="bookmark"  class="full-coverage">Read the full coverage <span>»</span></a>
							
				</header>
			
			<?php
					$size = 'index-disaster';
					
					if ( function_exists( 'jetpack_is_mobile' ) ){
				     
				     	$iPadcheck = new Jetpack_User_Agent_Info();    
				 	
					 	if (!jetpack_is_mobile() && !$iPadcheck->is_tablet() ) {
						 	
						 	$size = 'index-disaster';
					 	
					 	} else if (jetpack_is_mobile()) {
						 	
						 	$size = 'index-mobile';
						 	
					 	}
					 	
					} 
					

				
				echo postmedia_featured_thumbnail( $post_id, $size, $url, $title, true );
			?>
			
		</div><!-- .post-content -->

	</article><!-- #post-<?php echo $post_id; ?> -->