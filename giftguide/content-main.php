<?php
global $query;
$post_id = get_the_ID();
$current_post_num = $query->current_post;
$first_post = ( 0 == $current_post_num )	? 'first-post' : '';

if( $query->current_post ==0 /* && !is_paged() */ ) {
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
		$slug = $query->post->post_title;
		$thumbnail_id = get_post_thumbnail_id( $post_id );
		$thumb_url = wp_get_attachment_image_src($thumbnail_id,'main', true);
		$size = 'item@2x';	
		$content = get_the_content();
		
		
		?>

		<div class="post-content clearfix">
			<?php

						
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
					
					<a class="facebook facebook-share" data-share="facebook" data-title="<?php printf( esc_attr__( '%s' ), $title ); ?>" data-description="<?php echo $content; ?>" data-image="<?php echo $thumb_url; ?>" data-link="<?php echo $url; ?>" data-pub-date="2014-09-30T08:30:20-05:00" href="#<?php echo $slug; ?>" sl-processed="1">
							<span class="like">Like</span>
						</a>
					
					<a class="twitter twitter-share" data-share="twitter" data-title="BlazingBlock" data-link="http://uncrate.com/stuff/blazingblock/" href="#share-tw-94530" sl-processed="1">
							<span class="tweet">Tweet</span>
						</a>
						
						<a href="http://pinterest.com/pin/create/button/?url={URI-encoded URL of the page to pin}&media={URI-encoded URL of the image to pin}&description={optional URI-encoded description}" class="pin-it-button" count-layout="horizontal">
    Pin this
</a>
					
				
				<?php	}	?>

			</header>
		</div> <!-- .post-content -->

	    

	</article><!-- #post-<?php echo $post_id; ?> -->