<?php get_header(); ?>

	<div id="primary" class="c8">
	
	<?php
		
		global $wp_query;
		$post_id = get_the_ID();
		$url =  site_url() . "/memory-project?mem=". $post_id ."#post-" . $post_id ; 
		
			$title = get_post_meta( $post_id, 'cdc_discussion_headline', true );
			if ( empty($title) ){ $title = get_the_title(); }
			$post_url = get_permalink();
			$size = "memory-project-full";
			
			
			echo postmedia_featured_thumbnail( $post_id, $size, $post_url, $title, true ); 
			
			
			$string = '<script type="text/javascript">';
			$string .= 'window.location = "' . $url . '"';
			$string .= '</script>';

			echo $string;
			
			
			
	?>
	</div><!-- #primary.c8 -->

<?php get_footer(); ?>