<?php
global $wp_query;
$post_id = get_the_ID();
$first_post = ( is_archive() && 0 == $wp_query->current_post )	? 'first-post' : '';
?>
	<div id="post-<?php echo $post_id; ?>" <?php post_class( 'element' ); ?>>

		<?php
			
		$title = str_replace("&nbsp;", " ", get_the_title());
		$url = get_permalink();
		$img_id = get_post_thumbnail_id($post_id);
		$img_url = wp_get_attachment_image_src( $img_id, "memory-project-full" );	
		$str = get_the_content();
		
		?>

		<div class="pinterest-box">
			<?php 
			
				$size = 'memory-project-lg';
				//echo postmedia_featured_thumbnail( $post_id, $size, $url, $title, true );  
				
				
				echo postmedia_featured_memory_thumbnail( $post_id, "memory-project-full", $img_url, $url, $title, $str, true );

		
				
			?>				
					<h3 class="post-title memory">
							<!-- <a href="<?php echo $url; ?>" title="<?php printf( esc_attr__( '%s' ), $title ); ?>" rel="bookmark"> --> <?php echo $title; ?><!-- </a> -->						
					</h3>
							
		</div> <!-- .post-content -->
	</div><!-- #post-<?php echo $post_id; ?> -->