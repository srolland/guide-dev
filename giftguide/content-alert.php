<?php
global $wp_query;
$post_id = get_the_ID();?>

<!--[if lt IE 8]>
<style>
.bubble { position: absolute; left: 93px; top: 21px; width: 135px; height: 84px; text-align: center;}
.bubble p { position: relative;
display: inline-block;
margin-top: expression(this.offsetHeight < this.parentNode.offsetHeight ? parseInt((this.parentNode.offsetHeight - this.offsetHeight) / 2) + "px" : "0");
}
</style>
<![endif]-->

<div class="c12">
	<article id="post-<?php echo $post_id; ?>" class="alert">

		

		<?php
			
		$title = get_the_title();
		$url = get_permalink();
		$thumbnail_id = get_post_thumbnail_id( $post_id );	
		$link = "";
		$link = get_post_meta( $post_id, 'alert_linked_post_url', true );
		
			?>

		<h3>
			Breaking
		</h3>
		
		<div>
			<?php if ($link != "") {
				echo($title . "<a href=\"" . $link . "\"> Full story <i class=\"icon-caret-right\"></i></a>");
			} else {
				echo $title;	
			}  ?>
			
		</div>
		
		
	
	

	</article><!-- #post-<?php echo $post_id; ?> -->
	</div>