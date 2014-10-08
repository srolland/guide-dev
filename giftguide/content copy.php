<?php
global $wp_query;
$post_id = get_the_ID();
$first_post = ( is_archive() && 0 == $wp_query->current_post )	? 'first-post' : '';
?>
	<article id="post-<?php echo $post_id; ?>" <?php post_class( $first_post ); ?>>

		<header>
			<h1 class="post-title" itemprop=”headline”>
				<?php
				$title = get_the_title();
				$clean_title = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
				$url = get_permalink();
				$thumbnail_id = get_post_thumbnail_id( $post_id );

				if ( ! is_singular() ) { ?>
					<a href="<?php echo $url; ?>" title="<?php printf( esc_attr__( '%s' ), $title ); ?>" rel="bookmark">
				<?php } ?>
					<?php echo $title; ?>
				<?php
				if ( ! is_singular() )
					echo '</a>';
				?>
			</h1>
		</header>

		<?php
		if ( is_single() ) {
			if ( $featured_video_id = get_post_meta( $post_id, 'pn_featured_video_id', true ) ) {
				echo do_shortcode( '[kaltura-widget entryid=' . esc_attr( $featured_video_id ) . ']' );
			} else if ( is_singular('gallery') ) {
			
				//No Featured image on galleries
				
			} else {
				$thumb = pm_get_post_thumbnail( 'main@2x' );
				$distributor = get_post_meta( $thumb->id, 'drv_attachment_distributor', true );
				
				if( $thumb && 'gallery' != get_post_format() ) {
					//the_post_thumbnail( 'single-story', array( 'class' => 'alignnone' ) );
					echo "
					
					<figure>
					<span itemprop=\"associatedMedia\" itemscope itemid=\"" . esc_url( $thumb->url ) . "\" itemtype=\"http://schema.org/ImageObject\">	
					<img class='alignone wp-post-image' src=\"" . esc_url( $thumb->url ) . "\" alt=\"" . esc_attr( $thumb->alt ) . "\" title=\"" . esc_attr( $thumb->title ) . "\" itemprop=\"url\">
					<meta itemprop=\"copyrightHolder\" content=\"distributer field\" />";
					
					if ( $thumb->credit || $thumb->caption ) { 
						echo "<div class=\"credit_box\"> ";						
					} else {
						echo "<div> ";
					}
 
					
					if ( $thumb->credit ) echo '<span class="image-credit">PHOTO: ' . $thumb->credit . ', ' . $distributor . '</span>';
					
					echo '<figcaption><span class="image-caption">' . $thumb->caption . '</span></figcaption>
					</div>
</figure>';
				}
			}
			?>
			
			<h2 itemprop="alternativeheadline" class="subhead">
              <?php
				  if( function_exists( 'the_subheading' ) ) {
                  	echo get_the_subheading( get_the_ID() );
                   }
              ?>
			</h2>
				
			<div id="social-bar" class="social-bar">
				<ul class="fl">
					<li class="share"><a href="#" class="share-button btn sochi-btn"><i class="icon-share-sign"></i> Share</a></li>
					
					<?php if (comments_open() ) { ?>
						<li><a href="#" class="comments-button btn sochi-btn"><i class="icon-comment"></i> Comments</a></li>
					<?php } ?>
					<li><a href="mailto:?subject=<?php
						echo rawurlencode( 'A suggestion from TheGiftGuide.ca' );
						?>&body=<?php
						echo rawurlencode( 'I want to share a story with you from Postmedia\'s The Gift Guide site; ' . $clean_title . ' (See the details at ' . $url . ')' );
						?>" class="email-button btn sochi-btn"><i class="icon-envelope"></i> Email</a></li>
				</ul>
				<ul id="social-share" class="fr">
					<!--
<li><div class="fb-like" data-href="<?php echo $url; ?>" data-send="false" data-layout="button_count" data-width="200" data-show-faces="false"></div></li>
					<li><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo esc_url( $url ); ?>" data-text="<?php echo esc_attr( $clean_title ); ?>" data-via="canadadotcom">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></li>
					<li class="google-plus"><div class="g-plusone" data-size="medium"></div><script type="text/javascript">(function() { var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/plusone.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s); })();</script></li>
					
					<li style="width:70px;"><a href="http://pinterest.com/pin/create/button/?url=<?php echo $url; ?>&media=<?php echo esc_url( wp_get_attachment_url( $thumbnail_id ) ); ?>&description=<?php echo esc_attr( $clean_title ); ?>" class="pin-it-button" count-layout="horizontal">Pin It</a></li>
-->

					<!-- AddThis Button BEGIN -->
		<div class="addthis-button-wrapper">
			<div class="addthis_toolbox addthis_default_style add-this-box-1">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count" style="width:84px;"></a>
				<a class="addthis_button_tweet" style="width:84px;"></a>
				<a class="addthis_button_google_plusone" g:plusone:annotation="bubble" g:plusone:size="medium" style="width:68px; margin-right:0;"></a>
				<a class="addthis_button_pinterest_pinit" style="width:46px"></a>
			</div>
		</div>
		
		<!-- Twitter Tweet customization -->
		<script type="text/javascript">
			var addthis_share = addthis_share || {}
			addthis_share = {
				passthrough : {
					twitter: {
						text: "<?php echo $post->post_title; ?>",
						url: "<?php echo get_permalink( $post->ID ); ?>",
						via: "canadadotcom"
					}
				}
			}
		</script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51116f030e11b056"></script>
				
				
				</ul>
			</div>	
			
			<?php
		}
		?>

		<div class="post-content clearfix" itemprop="articleBody">
			<?php
			if ( is_singular() ) {
				the_content( '' );
			} elseif ( ! is_page() ) {
				global $wp_query;

				$size = ( is_archive() ) ? 'medium' : 'thumbnail';
				$size = ( is_archive() && ! is_author() && 0 == $wp_query->current_post ) ? 'large' : $size;
				echo postmedia_featured_thumbnail( $post_id, $size, $url, $title );

				the_excerpt();
			}
			?>
		</div><!-- .post-content -->

	    <?php if ( is_singular() ) : ?>
	    <footer class="article">
		    <?php the_tags( '<p class="tags"><strong>Tags:</strong> ', ', ', '</p>' ); ?>
		    <?php edit_post_link( __( '(edit)' ), '<p>', '</p>' ); ?>
		</footer><!-- .article -->
		<?php endif ?>

	</article><!-- #post-<?php echo $post_id; ?> -->