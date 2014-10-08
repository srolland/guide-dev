<?php

/**
 * Class for custom atom feed
 *
 * @since 1.0.0
 * @author c.bavota
 *
 * @todo	Need to create Atom feed for disussions after figuring out what information will be required
 *
 * **** NB: Sochi Modifications on line 396-398 
 *
 */
class Postmedia_Custom_Atom_Feed {

	public function __construct() {

		add_action( 'init', array( $this, 'add_custom_atom_feeds' ) );

	}

	/**
	 * Hook to add the new custom Atom feeds
	 *
	 * Ex. http://canada.com/feed/images/
	 *
	 * @default	orderby  modified
	 * @default	order  DESC
	 *
	 * @since 1.0.0
	 * @author c.bavota
	 */
	public function add_custom_atom_feeds() {

		add_feed( 'feed/usergroup', array( $this, 'usergroup_custom_atom_feed' ) );

	}

	/**
	 * Custom Atom feed used to feed the usergroups to southparc and quickwire
	 * it supplies a given usergroup's atom feed and can also supply the 'inverse' of that usergroup's feed by using
	 * http://o.canada.com/feed/usergroup?group=Postmedia%20News%20Writers&noindex=inverse for use with fast ( so as not to produce duplicate results )
	 *
	 *
	 * @uses feed-atom.php as a base
	 * @uses postmedia_get_voices_usergroup to display the correct author from the user group being queried
	 * @uses postmedia_get_attachment_caption to get the image caption if thumbnail image exists.
	 *
	 * @since 1.0.0
	 * @author jbracken
	 */
	public function usergroup_custom_atom_feed() {

		if ( function_exists( 'wpcom_vip_remove_feed_tracking_bug' ) )
			wpcom_vip_remove_feed_tracking_bug();

		header( 'Content-Type: ' . feed_content_type( 'atom' ) . '; charset=' . get_option( 'blog_charset'), true );
		$more = 1;

		if ( ! empty( $_GET['seekret'] ) && $_GET['seekret'] == 'f4X41W087y3f289836JG2KTu' ) {

			echo '<?xml version="1.0" encoding="' . get_option( 'blog_charset' ) . '"?' . '>';
		?><feed
	  xmlns="http://www.w3.org/2005/Atom"
	  xmlns:thr="http://purl.org/syndication/thread/1.0"
	  xml:lang="<?php echo get_option( 'rss_language' ); ?>"
	  xml:base="<?php bloginfo_rss( 'url' ) ?>/wp-atom.php"
	  xmlns:media="http://search.yahoo.com/mrss/"
		>
			<title type="text"><?php bloginfo_rss( 'name' ); wp_title_rss(); ?></title>
			<subtitle type="text"><?php bloginfo_rss( 'description' ) ?></subtitle>

			<updated><?php echo mysql2date('Y-m-d\TH:i:s\Z', get_lastpostmodified('GMT'), false); ?></updated>

			<link rel="alternate" type="text/html" href="<?php bloginfo_rss( 'url' ) ?>" />
			<id><?php bloginfo( 'atom_url' ); ?></id>
			<link rel="self" type="application/atom+xml" href="<?php self_link(); ?>" />
			<?php

			$publish_status = ! empty( $_GET['post_status'] ) && $_GET['post_status'] == 'scheduled' ? 'future, scheduled' : 'publish';
			$video_only = ! empty( $_GET['video'] ) && $_GET['video'] == 'true' ? true : false;
			$postmedia_meta_key = ! empty( $_GET['video'] ) && $_GET['video'] == 'true' ? 'postmedia_featured_video_id' : '';
			$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
			$order_array = array( 'DESC', 'ASC' );
			$order = ! empty( $_GET['order'] ) && in_array( $_GET['order'], $order_array ) ? $_GET['order'] : 'DESC';
			$orderby_array = array( 'modified', 'author', 'title' );
			$orderby = ! empty( $_GET['orderby'] ) && in_array( $_GET['orderby'], $orderby_array ) ? $_GET['orderby'] : 'modified';

			$tag_ccnetwork = get_term_by( 'slug', 'ccnetwork', 'post_tag' );
			$tag_ccnetwork_id = isset( $tag_ccnetwork->term_id ) ? $tag_ccnetwork->term_id : '';

			if ( $postmedia_meta_key == 'postmedia_featured_video_id' ){

				$args = array(
					'post_status' 			=> $publish_status,
					'post_type' 			=> 'post',
					'orderby' 				=> $orderby,
					'order' 				=> $order,
					'posts_per_page' 		=> 20,
					'ignore_sticky_posts' 	=> 1,
					'paged' => (int) $paged,
					'ignore_sticky_posts' 	=> 1,
					'meta_key'				=> $postmedia_meta_key
				);

			} else {

				$posts_not_in_array = array(
					'post_status' 			=> $publish_status,
					'post_type' 			=> 'post',
					'orderby' 				=> $orderby,
					'order' 				=> $order,
					'posts_per_page' 		=> 20,
					'ignore_sticky_posts' 	=> 1,
					'paged' => (int) $paged,
					'ignore_sticky_posts' 	=> 1,
					'meta_key'				=> 'postmedia_featured_video_id'

				);


				$exclude_video_posts = get_posts( $posts_not_in_array );

				$exclude_array = array();

				foreach ( $exclude_video_posts as $exclude_id ){

					array_push( $exclude_array, $exclude_id->ID );

				}

				$args = array(
					'post_status' 			=> $publish_status,
					'post_type' 			=>  array('post','gallery'),
					'orderby' 				=> $orderby,
					'order' 				=> $order,
					'posts_per_page' 		=> 20,
					'ignore_sticky_posts' 	=> 1,
					'paged' => (int) $paged,
					'ignore_sticky_posts' 	=> 1,
					'post__not_in'			=> $exclude_array

				);

			}

			if ( ! empty( $_GET['group'] ) && ! isset($_GET['noindex'] ) ) {

				//include the usergroup and exclude the ccnetwork tagged articles
				$author_ids = postmedia_get_voices_usergroup( sanitize_text_field( $_GET['group'] ) );
				$author_ids = is_array( $author_ids ) ? implode( ',', $author_ids ) : '';
				$args['author'] = $author_ids;
				$args['tag__not_in'] = $tag_ccnetwork_id;
				$pm_byline = 'Postmedia News';

			} elseif ( ! empty( $_GET['noindex'] ) && $_GET['noindex'] == 'true' ) {

				//exclude the usergroup authors and ccnetwork tagged articles
				$author_ids = postmedia_get_voices_usergroup( sanitize_text_field( $_GET['group'] ) );
				//add the filter to exclude authors from thids usergroup
				add_filter( 'posts_where', 'filter_exclude_authors' );
				$args['tag__not_in'] = $tag_ccnetwork_id;

			}

			if ( ! empty( $_GET['tag'] ) && $_GET['tag'] == 'ccnetwork' ) {

				//show only the network tagged articles
				$args['tag__in'] = $tag_ccnetwork_id;

			}

			//print_r($args);

			/**
			 * Create a new filtering function for use only in this feed,
			 * that will add our where clause to the query and exclude the authors
			 * excluding an array of authors is a know bug with wordpress current version
			 *
			 * see http://core.trac.wordpress.org/ticket/16854
			 *
			 * @return string that's added to our wp_query to exclude each author of a given usergroup
			 * @uses postmedia_get_voices_usergroup to generate our list of authors
			 *
			 * @author jbracken
			 */

			function filter_exclude_authors( $where = '' ) {

				$author_ids = isset( $_GET['group'] ) ? postmedia_get_voices_usergroup( sanitize_text_field( $_GET['group'] ) ) : '';

				if ( is_array( $author_ids ) ){

					foreach ( $author_ids as $exclude_author ){

					//loop through our voices group and exclude each
					$where .= " AND post_author != '" . $exclude_author . "'";

					}

				}

				return $where;

			}

			// coauthors_plus::posts_join_filter() will modify this query since is_author().
			// As a temporary fix, remove that filter so it doesn't break this query.
			// See http://vip-support.automattic.com/tickets/11832
			global $coauthors_plus;
			remove_filter( 'posts_join', array( $coauthors_plus, 'posts_join_filter' ), 10, 2 );

			$usergroup_entries = new WP_Query( $args );

			remove_filter( 'posts_where', 'filter_exclude_authors' );

			while ( $usergroup_entries->have_posts() ) : $usergroup_entries->the_post();

				if ( $video_only == true && ( $featured_video = get_post_meta( get_the_ID(), 'postmedia_featured_video_id', true ) ) ) {

					$featured_video = get_post_meta( get_the_ID(), 'postmedia_featured_video_id', true );
					$featured_video_image = get_post_meta( get_the_ID(), 'postmedia_featured_video_image', true );
					echo 'true';

					$continue = false;


				}

			add_filter( 'the_content' , 'postmedia_clean_atom_content' );

			$authors = get_coauthors();
			$author_names = '';

			$author_count = count( $authors );
			$author_number = 0;

			foreach ( $authors as $author ){

				$author_id = $author->ID;

				$author_names .= get_the_author_meta( 'first_name', $author_id ) . ' ' . get_the_author_meta( 'last_name', $author_id );

				$author_number++;

				if ( $author_number != $author_count ){

					$author_names .= ' & ';

				}

			}

			?>

			<entry>

				<author>
					<name><![CDATA[<?php echo $author_names; ?>]]></name>
					<?php

					$author_url = get_the_author_meta( 'url' );

					if ( ! empty( $author_url ) ) : ?>
						<uri><?php the_author_meta('url')?></uri>
					<?php endif; ?>

				</author>

				<?php

					if( isset( $pm_byline ) )
						echo "\n\t\t\t\t<contributor><name>". $pm_byline . "</name></contributor>\n";

				?>

				<title type="<?php html_type_rss(); ?>"><![CDATA[<?php the_title_rss(); ?>]]></title>

				<link rel="alternate" type="text/html" title="<?php echo esc_attr( get_post_meta( get_the_ID(), 'postmedia_syndication_slug', true ) ); ?>" href="<?php the_permalink_rss() ?>" />

				<id><?php the_guid(); ?></id>

				<updated><?php echo get_post_modified_time('Y-m-d\TH:i:s\Z', true); ?></updated>
				<published><?php echo get_post_time('Y-m-d\TH:i:s\Z', true); ?></published>

				<?php

				echo "\n\t\t\t\t" . postmedia_get_the_category_and_tag_rss('atom') . "\n\t\t\t\t";

				
				$topic = esc_attr( get_post_meta( get_the_ID(), 'postmedia_syndication_topic', true ) );
				
				if ( empty($topic) == false ) {
					echo sprintf( "\n\t\t\t\t" . '<category scheme="%1$s" term="%2$s" label="Topic" />', esc_attr( apply_filters( 'get_bloginfo_rss', get_bloginfo( 'url' ) ) ), $topic );
				} else {
					echo sprintf( "\n\t\t\t\t" . '<category scheme="%1$s" term="%2$s" label="Topic" />', esc_attr( apply_filters( 'get_bloginfo_rss', get_bloginfo( 'url' ) ) ), esc_attr( postmedia_get_label( $post->ID, 'events', true ) ) );	
				}
				

				?>

				<summary type="<?php html_type_rss(); ?>"><![CDATA[<?php the_excerpt_rss(); ?>]]></summary>

				<content type="<?php html_type_rss(); ?>" xml:base="<?php the_permalink_rss() ?>"><![CDATA[<?php

				the_content_feed( 'atom' );

				?>]]></content>

				<?php atom_enclosure(); ?>
				<?php do_action( 'atom_entry' ); ?>
				<link rel="replies" type="text/html" href="<?php the_permalink_rss() ?>#comments" thr:count="<?php echo get_comments_number()?>"/>
				<link rel="replies" type="application/atom+xml" href="<?php echo get_post_comments_feed_link(0,'atom') ?>" thr:count="<?php echo get_comments_number()?>"/>

				<?php

				remove_filter( 'the_content' , 'postmedia_clean_atom_content' );

				global $post;

				// first show featured video media element to indicate this as a video post
				if ( $postmedia_meta_key == 'postmedia_featured_video_id' ) {

					?>

						<media:content url="<?php echo esc_url( $featured_video ); ?>"
						type="application/vnd.ooyala"
						medium="featuredvideo">

						<media:thumbnail url="<?php echo esc_url( $featured_video_image ); ?>" />
						<media:title><![CDATA[<?php echo esc_attr( $post->post_title ); ?>]]></media:title>
						<media:caption><![CDATA[<?php echo esc_attr( $post->post_content ); ?>]]></media:caption>
						</media:content>

					<?php

				}



				# track video codes to avoid duplication
				$codes = array();

				# add embedded videos to atom feed
				preg_match_all( "/\\[(ooyala|pd-ooyala|post-ooyala)[^\\]]*code=\"?([\\w\\-]+)\"?/ui", $post->post_content, $matches, PREG_PATTERN_ORDER );
				foreach ( $matches[2] as $ooyala_code ) {

					# don't output duplicate videos
					if ( !in_array( $ooyala_code, $codes ) ) {

					?>

						<media:content url="<?php echo esc_url( $ooyala_code ); ?>"
						type="application/vnd.ooyala"
						medium="video">

						<media:title><![CDATA[<?php echo esc_attr( $post->post_title ); ?>]]></media:title>
						<media:caption><![CDATA[<?php echo esc_attr( $post->post_title ); ?>]]></media:caption>
						</media:content>
						<?php

						$codes[] = $ooyala_code;

					}

				}

				# track images to avoid duplication
				$images = array();

				# add featured image to atom feed
				if ( has_post_thumbnail() ) {

					$thumbnail_id = get_post_thumbnail_id();
					$images[] = postmedia_the_media_element_xml( $thumbnail_id );

				}

				# add embedded images to atom feed as <media:element/>
				preg_match_all( "/<img [^>]*wp-image-(\\d+)/ui", $post->post_content, $matches, PREG_PATTERN_ORDER );

				foreach ( $matches[1] as $attachment_id ) {

					# don't output duplicate images
					if ( !in_array( $attachment_id, $images ) ) {

						$images[] = postmedia_the_media_element_xml( $attachment_id );

					}
				}

				//Setup the editorial comments for display in our feed.
				$editorial_comments = array(
										'post_id' => get_the_ID(),
										'comment_type' => 'editorial-comment',
										'orderby' => 'comment_date',
										'order' => 'ASC',
										'status' => 'editorial-comment'
									);

				$media_comments = ef_get_comments_plus( $editorial_comments );

				$author_comments = '';

				if ( !empty( $media_comments ) ){

					$author_comments = "\n\t\t\t\t<media:comments>\r\t\t\t\t";

					foreach ( $media_comments as $author_comment ){

						$author_comments .=  "\n\t\t\t\t\t<media:comment><![CDATA[" . $author_comment->comment_content .  "]]></media:comment>\n";

					}

					$author_comments .= "\n\t\t\t\t</media:comments>\r\t\t\t\t";

					echo $author_comments;

				}

			?>

		</entry>

			<?php

			endwhile;

			?>

		</feed>

			<?php

		}

	}


	/**
	 * Custom Atom feed for parsing gallery information to FAST
	 *
	 * Ex. http://canada.com/feed/galleries/
	 *
	 * For pagination add param ?paged=2
	 *
	 * @uses	get_the_ID  Get the post ID
	 * @uses	get_children()  Get post image attachments
	 * @uses	wp_get_attachment_image_src  Get thumbnail src URL
	 * @uses	wp_get_attachment_metadata  Get thumbnail meta for credit
	 * @uses	get_post_mime_type  Get thumbnail mime type
	 * @uses	get_post_field  Get thumbnail caption
	 *
	 * @since 1.0.0
	 * @author c.bavota
	 */
	public function galleries_custom_atom_entry() {

		$images =& get_children( 'post_parent=' . get_the_ID() . '&post_mime_type=image' );

		if ( empty ( $images ) ) {

			return;

		} else {

			foreach( $images as $attachment_id => $attachment ) {

				$post_image_src = wp_get_attachment_image_src( $attachment_id, 'full' );
				$post_image_type = get_post_mime_type( $attachment_id );
				$post_image_meta = (array) wp_get_attachment_metadata( $attachment_id );
				$post_thumbnail_src = wp_get_attachment_image_src( $attachment_id, 'search' );

				if ( $post_image_credit = get_post_meta( $attachment_id, 'postmedia_attachment_credit', true ) )
					$post_image_credit = '<media:credit><![CDATA[' . $post_image_credit . ']]></media:credit>';

				if ( $post_image_caption = postmedia_get_attachment_caption( $attachment_id ) )
					$post_image_caption = '<media:description><![CDATA[' . $post_image_caption . ']]></media:description>';
				?>

				<media:content url="<?php echo esc_url( $post_image_src[0] ); ?>" type="<?php echo esc_attr( $post_image_type ); ?>" height="<?php echo esc_attr( $post_image_meta['height'] ); ?>" width="<?php echo esc_attr( $post_image_meta['width'] ); ?>" medium="image" isDefault="true">
				<media:title><![CDATA[<?php echo get_the_title( $attachment_id ); ?>]]></media:title>
				<?php echo $post_image_caption; ?>
				<?php echo $post_image_credit; ?>

				<?php
				$height = empty( $post_image_meta['sizes']['search']['height'] ) ? '' : $post_image_meta['sizes']['search']['height'];
				$width = empty( $post_image_meta['sizes']['search']['width'] ) ? '' : $post_image_meta['sizes']['search']['width'];
				?>

				<media:thumbnail url="<?php echo esc_url( $post_thumbnail_src[0] ); ?>" height="<?php echo esc_attr( $height ); ?>" width="<?php echo esc_attr( $width ); ?>"/>
				</media:content>

				<?php

			}

		}

	}

	/**
	 * Custom Atom feed query for parsing discussion || videopost || photo_gallery post type information to FAST
	 *
	 * @since 1.0.0
	 * @author c.bavota
	 */
	public function custom_atom_head() {

		$type = is_feed( 'feed/discussions' ) ? 'discussion' : 'photo_gallery';
		$type = is_feed( 'feed/videoposts' ) || is_feed( 'feed/usergroup' ) ? 'post' : $type;

		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		$order_array = array( 'DESC', 'ASC' );
		$order = ! empty( $_GET['order'] ) && in_array( $_GET['order'], $order_array ) ? $_GET['order'] : 'DESC';
		$orderby_array = array( 'date', 'modified', 'author', 'title' );
		$orderby = ! empty( $_GET['orderby'] ) && in_array( $_GET['orderby'], $orderby_array ) ? $_GET['orderby'] : 'modified';

		$args = array(
			'post_status' => 'publish',
			'post_type' => $type,
			'orderby' => $orderby,
			'order' => $order,
			'posts_per_page' => 10,
			'paged' => (int) $paged,
			'ignore_sticky_posts' => 1
		);

		if ( ! empty( $_GET['group'] ) ) {
			$author_ids = postmedia_get_voices_usergroup( sanitize_text_field( $_GET['group'] ) );
			$author_ids = is_array( $author_ids ) ? implode( ',', $author_ids ) : '';
			$args['author'] = $author_ids;
		}

		$args['meta_key'] = is_feed( 'feed/videoposts' ) ? 'postmedia_featured_video_id' : '';

		query_posts( $args );

	}

	/**
	 * Custom Atom feed query for parsing posts (excluding video posts) information to FAST
	 *
	 * @since 1.0.0
	 * @author c.bavota
	 */
	public function post_custom_atom_head() {

		$videoposts = new WP_Query( array( 'meta_key' => 'postmedia_featured_video_id', 'numberposts' => 250, 'fields' => 'ids' ) );
		$exclude = $videoposts->get_posts();

      	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$order = ( !empty( $_GET['order'] ) && $_GET['order'] == 'ASC' ) ? 'ASC' : 'DESC';
		$orderby = ( !empty( $_GET['orderby'] ) && in_array( $_GET['orderby'], array( 'date', 'author', 'title' ) ) ) ? $_GET['orderby'] : 'modified';

		$args = array(
			'post_status'			=> 'publish',
			'orderby' 			=> $orderby,
			'order' 				=> $order,
			'posts_per_page' 		=> 10,
			'paged' 				=> $paged,
			'ignore_sticky_posts'	=> 1,
			'post__not_in' 		=> $exclude
		);

		query_posts( $args );

	}

	/**
	 * Filter hook to remove tags from Atom feed
	 *
	 * @uses	get_the_category()  Get the post's categories
	 * @uses	get_option()  Retrieve value from options table
	 * @uses	get_bloginfo()  Retrieve blog setting
	 * @uses	apply_filters()  Apply a WP filter
	 *
	 * @return	string  Categories
	 *
	 * @since 1.0.0
	 * @author c.bavota
	 */
	public function remove_tags() {

	    $categories = get_the_category();
	    $the_list = '';
	    $cat_names = array();

	    $filter = 'raw';

	    if ( ! empty( $categories ) ) {

	    	foreach ( (array) $categories as $category ) {

			    $cat_names[] = sanitize_term_field( 'name', $category->name, $category->term_id, 'category', $filter );

			}

	    	$cat_names = array_unique( $cat_names );

			foreach ( $cat_names as $cat_name ) {

				$the_list .= sprintf( '<category scheme="%1$s" term="%2$s" />',
					esc_attr( apply_filters( 'get_bloginfo_rss', get_bloginfo( 'url' ) ) ),
					esc_attr( $cat_name )
				);

			}

			return $the_list . "\n";

		}

	}

}

$postmedia_custom_atom_feed = new postmedia_Custom_Atom_Feed;

/**
 * Outputs the media element for atom 'Tag' feed
 *
 * @author jbracken
 *
 */
function postmedia_the_media_element_xml( $attachment_id ) {

	$image = get_post( $attachment_id );

	# ensure the attachment actually exists
	if ( $image != null ) {

		$image_src = wp_get_attachment_image_src( $image->ID , 'full' );
		$title = $image->post_title;

		# caption is required for SouthPARC import, so use title as the default value
		$caption = $image->post_content;
		if ( empty( $caption ) )
			$caption = $title;

		$credit = get_post_meta( $attachment_id, '_postmedia_attachment_credit', true );
		if ( empty( $credit ) )
			$credit = '';

		?>

		<media:content id="<?php echo esc_attr( $image->ID ); ?>"
		url="<?php echo esc_url( $image_src[0] ); ?>"
		type="<?php echo esc_attr( $image->post_mime_type ); ?>"
		width="<?php echo esc_attr( $image_src[1] ); ?>"
		height="<?php echo esc_attr( $image_src[2] ); ?>"
		medium="image">

		<media:title><![CDATA[<?php echo esc_attr( $title ); ?>]]></media:title>
		<media:caption><![CDATA[<?php echo esc_attr( $caption ); ?>]]></media:caption>
		<media:credit><![CDATA[<?php echo esc_attr( $credit ); ?>]]></media:credit>
		</media:content>

	<?php

	}

	return $attachment_id;
}

function postmedia_the_media_element_rss2( $attachment_id ) {

	$image = get_post( $attachment_id );

	# ensure the attachment actually exists
	if ( $image != null ) {

		$image_src = wp_get_attachment_image_src( $image->ID , 'full' );
		$image_src_thumb = wp_get_attachment_image_src( $image->ID , 'thumbnail' );
		$title = $image->post_title;

		# caption is required for SouthPARC import, so use title as the default value
		$caption = $image->post_content;
		if ( empty( $caption ) )
			$caption = $title;

		$credit = get_post_meta( $attachment_id, '_postmedia_attachment_credit', true );
		if ( empty( $credit ) )
			$credit = '';

		?>

		<media:thumbnail url="<?php echo esc_url( $image_src_thumb[0] ); ?>" />

		<media:content url="<?php echo esc_url( $image_src[0] ); ?>" medium="image" >

		<media:title><![CDATA[<?php echo esc_attr( $title ); ?>]]></media:title>

		</media:content>

	<?php

	}

	return $attachment_id;
}


/**
 * Filter to remove shortcodes, blockquotes and inline images
 *
 * @author jbracken
 *
 */
function postmedia_clean_atom_content( $content ) {

	# remove shortcodes from atom content
	$content = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $content);

	# remove embeded wp images from atom content
	$content = str_replace( "&nbsp;", "&#160;", $content );
	$content = preg_replace('/<img[^>]+./','', $content);
	$content = preg_replace('/<a[^>]*><\\/a[^>]*>/','', $content);

	$content = preg_replace( '/<blockquote>(.+?)<\/blockquote>/s', '', $content );
	return $content;

}


/**
 * add namesapce to atom feed
 *
 * @author jbracken
 *
 */
function postmedia_add_media_namespace_to_atom() {
  echo ' xmlns:media="http://search.yahoo.com/mrss/" ';
}
add_action( 'atom_ns' , 'postmedia_add_media_namespace_to_atom' );