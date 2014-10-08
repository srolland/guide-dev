<?php
global $wp_query;
$post_id = get_the_ID();
$first_post = ( is_archive() && 0 == $wp_query->current_post )	? 'first-post' : '';
?>
	<article id="post-<?php echo $post_id; ?>" <?php post_class( $first_post ); ?>>

		

		<?php
			
		$title = get_the_title();
		$url = get_permalink();
		$thumbnail_id = get_post_thumbnail_id( $post_id );	
		
		?>

		<div class="post-content clearfix">
			<?php

				global $wp_query;

				$size = ( is_archive() ) ? 'medium' : 'thumbnail';
				$size = ( is_archive() && ! is_author() && 0 == $wp_query->current_post ) ? 'large' : $size;
				$size = 'index-small';
				echo postmedia_featured_thumbnail( $post_id, $size, $url, $title, true ); 
			?>

				<?php if( is_tax() == false && is_category() == false  ){ ?>
				
				<h5 class="category_label">	 <?php postmedia_get_label( $post_id, 'events'  ) ?> </h5>
				
				<?php } ?>

				<header>
					<h1 class="post-title">
						
							<a href="<?php echo $url; ?>" title="<?php printf( esc_attr__( '%s' ), $title ); ?>" rel="bookmark">
							<?php echo $title; ?>
							</a>
					</h1>
					<time><?php echo drv_get_time_since_posted( $post_id ); ?>
					</time>
				</header>
		</div> <!-- .post-content -->

	    

	</article><!-- #post-<?php echo $post_id; ?> -->