<?php
global $wp_query;
$post_id = get_the_ID();
$first_post = ( is_archive() && 0 == $wp_query->current_post )	? 'first-post' : '';
?>
	

	
	<article id="post-<?php echo $post_id; ?>" <?php post_class( $first_post ); ?>>
		
		<div class="row">
			
		<div class="primary fl">
		
		<?php if ( is_singular() ) : ?>
	    <footer class="article">
		    <?php the_tags( '<p class="tags"><strong>Tags:</strong> ', ', ', '</p>' ); ?>
		    <?php edit_post_link( __( '(edit)' ), '<p>', '</p>' ); ?>
		</footer><!-- .article -->
		<?php endif ?>
		
		<header>
			<h1 class="post-title" itemprop=”headline”>
				<?php
				$title = get_the_title();
				$clean_title = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
				$url = get_permalink();
				$thumbnail_id = get_post_thumbnail_id( $post_id );
				$meta_values = get_post_meta( $post_id );
				
				$retailer_name_1 = $meta_values["postmedia_retailer_name_1"][0];
				$retailer_url_1 =  $meta_values["postmedia_retailer_url_1"][0];
				
				$retailer_name_2 = $meta_values["postmedia_retailer_name_2"][0];
				$retailer_url_2 =  $meta_values["postmedia_retailer_url_2"][0];
				
				$retailer_name_3 = $meta_values["postmedia_retailer_name_3"][0];
				$retailer_url_3 =  $meta_values["postmedia_retailer_url_3"][0];
				
				$retailer_name_4 = $meta_values["postmedia_retailer_name_4"][0];
				$retailer_url_4 =  $meta_values["postmedia_retailer_url_4"][0];
				
				$retailer_name_5 = $meta_values["postmedia_retailer_name_5"][0];
				$retailer_url_5 =  $meta_values["postmedia_retailer_url_5"][0];
				
				if ( ! is_singular() ) { ?>
					<a href="<?php echo $url; ?>" title="<?php printf( esc_attr__( '%s' ), $title ); ?>" rel="bookmark">
				<?php } ?>
					<?php echo $title; ?>
				<?php
				if ( ! is_singular() )
					echo '</a>';
				?>
			</h1>
			
			<h2 itemprop="alternativeheadline" class="subhead">
              <?php
				  if( function_exists( 'the_subheading' ) ) {
                  	echo get_the_subheading( get_the_ID() );
                   }
              ?>
			</h2>
			
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
		}
		?>

		<div class="post-content clearfix" itemprop="articleBody">
			<?php
			
				the_content( '' );
				
				
				if ( isset($retailer_name_1) && isset($retailer_url_1) ) {
					echo "<ul>";
					$ul_open = true;
					echo "<li><a href=\"". $retailer_url_1 ."\">Buy it on " . $retailer_name_1 ."</a></li>";
				}
				
				if ( isset($retailer_name_2) && isset($retailer_url_2) && $ul_open == true ) {
					echo "<li><a href=\"". $retailer_url_2 ."\">Buy it on " . $retailer_name_2 ."</a></li>";
				}
				
				if ( isset($retailer_name_3) && isset($retailer_url_3) && $ul_open == true ) {
					echo "<li><a href=\"". $retailer_url_3 ."\">Buy it on " . $retailer_name_3 ."</a></li>";
				}
				
				if ( isset($retailer_name_4) && isset($retailer_url_4) && $ul_open == true ) {
					echo "<li><a href=\"". $retailer_url_4 ."\">Buy it on " . $retailer_name_4 ."</a></li>";
				}
				
				if ( isset($retailer_name_5) && isset($retailer_url_5) && $ul_open == true ) {
					echo "<li><a href=\"". $retailer_url_5 ."\">Buy it on " . $retailer_name_5 ."</a></li>";
				}
				if ($ul_open){
					echo "</ul>";
				}
			
			?>
			
				
				<div id="social-bar" class="social-bar">
				<ul class="fl">
					<li><a href="mailto:?subject=<?php
						echo rawurlencode( 'A suggestion from TheGiftGuide.ca' );
						?>&body=<?php
						echo rawurlencode( 'I want to share a story with you from Postmedia\'s The Gift Guide site; ' . $clean_title . ' (See the details at ' . $url . ')' );
						?>" class="email-button btn sochi-btn"><i class="icon-envelope"></i> Email</a></li>
				</ul>
				<ul id="social-share" class="fr">

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
				
		</div><!-- .post-content -->
		
		</div><!-- end .c8 -->
		
		
		
		<div   class="secondary fr role="complementary">
		
		
		
		
		

		<?php 
		
		if ( function_exists( 'pn_dfp_ads' ) ) {
				pn_dfp_ads() -> call_ad('bigbox');	
			}
		
		?>
		
		<br/>
		<img src="http://placehold.it/300x600&text=Ad">

	    
		
		</div>
		
		
		</div>
		
	</article><!-- #post-<?php echo $post_id; ?> -->