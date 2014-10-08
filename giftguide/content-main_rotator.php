<?php
global $wp_query;
$post_id = get_the_ID();
$first_post = ( is_archive() && 0 == $wp_query->current_post )	? 'first-post' : '';
?>
	<article id="post-<?php echo $post_id; ?>" <?php post_class( $first_post ); ?>>

		

		<?php
			
		$title = get_post_meta( $post_id, 'cdc_discussion_headline', true );
		if ( empty($title) ){ $title = get_the_title($post_id); }
		$url = get_permalink($post_id);
		$thumbnail_id = get_post_thumbnail_id( $post_id );	
		?>	

		<div class="post-content clearfix">
			<?php
				$size = 'index-large';
				echo postmedia_featured_thumbnail( $post_id, $size, $url, $title, true );
			?>
				
								
				<header>
				
					<?php if( is_tax() == false && is_category() == false ){ ?>
				
				<h5 class="category_label">	 <?php postmedia_get_label( $post_id, 'events'  ) ?> </h5>
				
				<?php } ?>

					<h1 class="post-title">
						<?php
						
						if ( ! is_singular() ) { ?>
							<a href="<?php echo $url; ?>" title="<?php printf( esc_attr__( '%s' ), $title ); ?>" rel="bookmark">
						<?php } ?>
							<?php echo $title; ?>
						<?php
						if ( ! is_singular() ){
							echo '</a>';
						?>
					</h1>
					<?php the_excerpt();	?>
					<!--
<time><?php echo drv_get_time_since_posted( $post_id ); ?>
					</time>
-->
				</header>
				<?php	}	?>

			
		</div><!-- .post-content -->

	</article><!-- #post-<?php echo $post_id; ?> -->