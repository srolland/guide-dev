<?php
global $query;
$post_id = get_the_ID();
$first_post = ( 0 == $query->current_post )	? 'first-post' : '';

if( $query->current_post ==0 && !is_paged() ) {
	$first_post = 'first-post';
} else {
	$first_post = '';	
};

$classes = array(
    $first_post,
    'main'
  );

?>
	<article id="post-<?php echo $post_id; ?>" <?php post_class( $classes ); ?>>

		

		<?php
			
		$title = get_post_meta( $post_id, 'cdc_discussion_headline', true );
		if ( empty($title) ){ $title = get_the_title(); }
		$url = get_permalink();
		$thumbnail_id = get_post_thumbnail_id( $post_id );	
		
		
		?>

		<div class="post-content clearfix">
			<?php

				/*
$size = ( is_archive() ) ? 'medium' : 'thumbnail';
				$size = ( is_archive() && ! is_author() && 0 == $wp_query->current_post ) ? 'large' : $size;
*/
				if ( $first_post != '' ) {
						$size = 'index-large';
					}
					else
					{
						$size = 'index-large';
					}
				echo postmedia_featured_thumbnail( $post_id, $size, $url, $title, true ); 
			?>

				<header>
				
				<h5 class="category_label">	 <?php postmedia_get_label( $post_id, 'events'  ) ?> </h5>
				
					<h4 class="post-title">
						<a href="<?php echo $url; ?>" title="<?php printf( esc_attr__( '%s' ), $title ); ?>" rel="bookmark">
						<?php echo $title; ?>
						</a>
					</h4>

			</header>
		</div> <!-- .post-content -->

	    

	</article><!-- #post-<?php echo $post_id; ?> -->