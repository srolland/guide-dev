<?php

/** Caches queries using transients. Returns cached data if the transient instance exists and hasn't expired.
 *  Otherwise runs the query and resets the transient instance. 
 *
 * @author Sebastien
 */

function pm_check_cached_posts( $cache_id, $args = array(), &$expires = 180 )	{
	
	/* Check to see if the transient hasn't expired  */
	if( false === ( $query = get_transient( $cache_id )) ) {
	
		$query = new WP_Query( $args );
		/* Set the transient.  */
		set_transient( $cache_id, $query, $expires );
	}
	
	return $query;
		
}
		

/**
* Much simpler theme prefix function
*
* @uses jetpack_is_mobile()
*
* @author Edward de Groot
*/ 
function drv_smrt_theme_prefix() {
  static $prefix = null;

  // only need to run this once
  if ( empty( $prefix ) ) {
    $prefix = ( jetpack_is_mobile() ) ? 'mob' : 'des';
  }

  return $prefix;
}


/*
* Get post content by post id
*
* @param $post_id
* @param $size, image custom or standard size
*
* @uses drv_get_image_label() function to get the label of the post
* @uses wp_get_attachment_image_src() function to get the image url
* @uses get_coauthors() function to get all authors associate to the post
* @uses drv_get_time_since_posted() to get last modified date
*
* @return array of post content
*
* @since 1.0.0
* 
*/
function drv_get_post_content( $post_id = null, $size = 'left-column-one', $length = 200 ) {
	$return = array();
	
	if( ! empty( $post_id ) ) {
		$return['title'] = get_the_title( $post_id );
		
		$url = get_post_meta( $post_id, 'drv_pointer_url', true );
		
		if( empty( $url ) ) {
		  $url = get_permalink( $post_id );
		}
		
		$return['link']	= esc_url( $url );
		
		$post = get_post( $post_id );
		
		$return['content'] = cdc_character_trim( $post->post_content, $length );
		$return['excerpt'] = cdc_character_trim( $post->post_excerpt, $length );
		//$return['feature_class'] = $return['is_video'] = '';
		
		$feature_logo_id = ( get_post_meta( $post_id, 'drv_featured_logo', true ) );
		if( ! empty( $feature_logo_id ) ) {
		    $image = wp_get_attachment_image_src( $feature_logo_id, 'sponsor' );
		    $return['feature_logo'] = $image[0];
		    $return['feature_class'] = 'sponsor';
		    
		    $feature_logo_link = get_post_meta( $post_id, 'drv_featured_logo_url', true );
		    $return['feature_logo_link'] = $feature_logo_link;
		    
		    $feature_logo_title = get_post_meta( $post_id, 'drv_featured_logo_title', true );
		    $return['feature_logo_title'] = ( empty( $feature_logo_title ) ) ? $return['title'] : $feature_logo_title;
		}
		
		$term = drv_get_image_label( $post_id );
		$return['label'] = $term->name;
		
		//$return['image'] = drv_get_timeline_post_image( $post_id, $size );
		$return['image'] = new Driving\PostImage( $size, $post_id );
		
		$video_id = get_post_meta( $post_id, 'pn_featured_video_id', true );
		if( empty( $video_id ) ) {
			$video_id = get_post_meta( $post_id, 'cdc_featured_video_id', true );
		}
		if( empty( $video_id ) ){
			$video_id = get_post_meta( $post_id, 'drv_featured_video_id', true );
		}
		
		if( ! empty( $video_id ) || ( 'on' == get_post_meta( $post_id, 'drv_content_video', true ) ) ) {
			$return['is_video'] = 'video-play';
		}
		
		$return['video_id'] = $video_id;
		

		
		$author_id = $post->post_author;
		$author_obj = get_user_by( 'id', $author_id );
		$return['author_user'] = $author_obj->user_login;
		$return['author'] = ( $name = drv_get_author_gravatar_data( $author_obj->user_email ) ) ? $name['first_name'] . ' ' . $name['last_name'] : '';
		$return['byline'] = get_post_meta( $post_id, 'pm_byline', true );
		$return['distributor'] = get_post_meta( $post_id, 'pm_distributor', true );
		$byline = ( !empty($return['byline'])) ? $return['byline'] : $return['distributor'];
				
		if(  $return['author_user']!='bloomberg105' && 
		$return['author_user']!='drivinginfo2013' && $return['author_user']!='postmedianews1' && 
		$return['author_user']!='theassociatedpresscanada' && $return['author_user']!='thecanadianpress' ) 
		{ 
		$return ['author_info'] =  esc_html($return['author']);
		} else {
		$return ['author_info'] = esc_html($byline);
		}
		
		$return['posted_date'] = drv_get_time_since_posted( $post_id );
	}
		
	return $return;
}

/**
 * Get image label
 *
 * @param $post_id
 *
 * @uses get_post_meta()	Get post meta data
 * @uses get_category()		Gets the category object
 * @uses wp_get_post_categories() Get all the categories attached to the post
 * @uses wpcom_vip_get_term_by()		Get category object by term
 *
 * @return term object
 *
 * @since 1.0.0
 *
 */
function drv_get_image_label( $post_id ) {

	$cat_id = get_post_meta( $post_id, '_pn_main_category', true );

	if( empty( $cat_id ) ) {
		$post_categories = get_the_terms( $post_id, 'category', array("fields" => "all") );
		$cats = array();
		$term = $parent_category = '';
		
		if( is_array( $post_categories ) ){
			foreach( $post_categories as $c ){
				$cat = get_category( $c );
				$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug, 'id' => $cat->cat_ID );
			}
		}
		$category_array = array_reverse( $cats );

		if( ! empty( $category_array ) ) {
			$cat_id = $category_array[0]['id'];
		}

		if( ! empty( $cat_id ) ) {
			
			$term = wpcom_vip_get_term_by( 'id', $cat_id, 'category' );
		}
	}
	else {
		$term = wpcom_vip_get_term_by( 'id', $cat_id, 'category' );
	}
	
	return $term;
}

/**
 * Get time since post was published
 *
 * @param	int|object|null $post_id  The post ID (optional)
 *
 * @uses	human_time_diff()  Return time difference in easy to read format
 * @uses	get_the_time()  Get the time when post was published
 * @uses	get_the_date()  Get the date when post was published
 * @uses	current_time()  Get current time
 * @uses	get_option()  Get option setting
 *
 * @return	string  Time since post was published or date post was published on
 *
 * @since 1.0.0
 */
function drv_get_time_since_posted( $post_id = null ) {
	
	$published = get_post_time( 'U', false, $post_id );
	
	$current_time = current_time( 'timestamp' );
	$post_date_new = human_time_diff( $published, $current_time ) . ' ago';
	
	if ( strtotime( $post_date_new ) > strtotime( '-3 days' ) ) {
		$post_date = $post_date_new;
	}else{
		$post_date = get_post_time( 'F j, Y', false, $post_id );
	}
	
	return $post_date;

}

/**
 * Get time since post was modified
 *
 * @param	int|object|null $post_id  The post ID (optional)
 *
 * @uses	human_time_diff()  Return time difference in easy to read format
 * @uses	get_the_time()  Get the time when post was published
 * @uses	get_the_date()  Get the date when post was published
 * @uses	current_time()  Get current time
 * @uses	get_option()  Get option setting
 *
 * @return	string  Time since post was published or date post was published on
 *
 * @since 1.0.0
 */
function drv_get_time_since_modified( $post_id = null ) {
	
	$published = get_post_modified_time( 'U', false, $post_id );
	
	$current_time = current_time( 'timestamp' );
	$post_date_new = human_time_diff( $published, $current_time ) . ' ago';
	
	if ( strtotime( $post_date_new ) > strtotime( '-3 days' ) ) {
		$post_date = $post_date_new;
	}else{
		$post_date = get_post_modified_time( 'F j, Y', false, $post_id );
	}
	
	return $post_date;

}



/** returns top stories on the home page
 *
 * @author vasu
 */
function cdc_get_top_stories( $number_of_days = 1, $posts_per_page = 5 ){
	$output = array();
	$cache_key = 'cdc_top_posts_' . $number_of_days . '_' . $posts_per_page;
	
	if ( function_exists( 'wpcom_vip_top_posts_array' ) ) {
		$top_posts = wp_cache_get( $cache_key );

		if( false === $top_posts ) {
			$top_posts = wpcom_vip_top_posts_array( $number_of_days, $posts_per_page );

			if( is_array( $top_posts ) ) {
				$filtered_top_posts = array();

				foreach( $top_posts as $top_post ) {
					$post = get_post( $top_post['post_id'] );

					if( $post && $post->post_type == 'post' )
						$filtered_top_posts[] = $top_post;
				}

				$top_posts = $filtered_top_posts;
			}

			wp_cache_add( $cache_key, $top_posts );
		}

		if ( is_array( $top_posts ) )
			$output = $top_posts;
	} else {
		$args = array(
			'numberposts' => (int) $posts_per_page,
			'orderby' => 'modified'
		);

		$rand_posts = get_posts( $args );
		$views = 10;

		foreach( $rand_posts as $post ) :
			$output[] = array(
				'post_id' => $post->ID,
				'post_title' => get_the_title( $post->ID ),
				'post_permalink' => get_permalink( $post->ID ),
				'views' => $views
			);

			$views--;
		endforeach;
	}
	
	return $output;
}


/** returns top stories from chartbeat
*
* @author vasu
*/
function cdc_get_chartbeat_stories( $attributes = '', $limit = 10 ) {
	
	if( empty( $attributes ) ) {
		$home_page_ids = postmedia_theme_option();
		$attributes = 'apikey=' . $home_page_ids['chartbeat_api_key'] . '&host=' . $home_page_ids['chartbeat_host'] . '&limit=' . $home_page_ids['chartbeat_limit'] . '&section=' . $home_page_ids['chartbeat_section'];// . '&types=1';
	}
	$url = 'http://api.chartbeat.com/live/toppages/v3/?' . $attributes;
	
	$chartbeat_key = 'chartbeat_top_stories';
	$get_transient = get_transient( $chartbeat_key );
	$output = array();
	$limit = 6;
       
	if( ! empty( $get_transient ) ) {
			echo"<div style=\"display:none;\">Cached</div>";
	       $output = $get_transient;
	}
	else {
	        $response = file_get_contents( $url);
	        $body = json_decode( $response );
	        if( ! empty( $body ) ) {
			$count = 1;
		        foreach( $body->pages as $val ){
				if( $count > $limit )
					break;
				
				$pos = strpos( $val->title, ' |' );
				if( $pos === false ) {
					$pos = strlen( $val->title );
				}
				$url = esc_url_raw( $val->path );
				
				$post_id = url_to_postid( $url );

				if( ! empty( $post_id ) ) {
				        $output[] = array( 'post_id' => $post_id, 'post_title' => esc_attr( substr( $val->title, 0, $pos ) ), 'post_permalink' => $url );
					$count++;
				}
		        }
		        set_transient( $chartbeat_key, $output, 5 * 60 );
	        }
	}
       
	return $output;
}


/**
 * Gets custom author description excerpt
 *
 * @since 4.0.0
 * @author vasu
 */
function cdc_get_author_excerpt( $text, $author_link ) {
	preg_match( '/^.{0,200}(?:.*?)\b/siu', $text, $matches );
	$excerpt = $matches[0];
	$start_pos = strlen( $excerpt );
	$remaining_str = substr( $text, $start_pos );
	return esc_attr( $matches[0] ) . '<a href="javascript:void(0)" class="read-more">... read more</a><span class="excerpt-more hide">' . $remaining_str . '<br/><a class="view-author-profile" href="' . $author_link .'">View author\'s profile</a></span>';
}


/**
 * Gets custom top story excerpt
 *
 * @since 4.0.0
 * @author vasu
 */
function cdc_top_story_excerpt( $text = '', $length = 35 ) {
	preg_match( '/^.{0,' . $length . '}(?:.*?)\b/siu', $text, $matches );
	if( ! empty( $matches ) ) {
		$excerpt = $matches[0];
		$start_pos = strlen( $excerpt );
		$remaining_str = substr( $text, $start_pos );
		$remaining_str = ( strlen( $remaining_str ) > 25 ) ? cdc_character_trim( $remaining_str, 25 ) : $remaining_str;
		$text = ( strlen( $text ) > 35 ) ? esc_attr( $matches[0] ) . '<span class="elipses">...</span> <span class="remain">' . esc_attr( $remaining_str ) . '</span>' : esc_attr( $text );
	}
	
	return $text;	
}


/**
 * Trims a string of words to be no longer than the specified number of characters, gracefully stopping at white spaces.
 * Also strips HTML tags, to prevent breaking in the middle of a tag.
 *
 * @param string $text The string of words to be trimmed.
 * @param int $length Maximum number of characters; defaults to 45.
 * @param string $append String to append to end, when trimmed; defaults to ellipsis.
 * @return String of words capped at specified length.
 *
 * @author 10up
 */
function cdc_character_trim( $text, $length = 100, $append = '&hellip;' ) {

	$length = (int) $length;
	$text = trim( strip_shortcodes( strip_tags( $text ) ) );

	if ( strlen( $text ) > $length ) {
		// trim it down to specified characters plus one, for possible white space detection
		$text = substr( $text, 0, $length + 1 );
		$words = preg_split( "/[\s]|&nbsp;/", $text, -1, PREG_SPLIT_NO_EMPTY );
		// if the last character is not a white space, we remove the cut off last word
		preg_match( "/[\s]|&nbsp;/", $text, $lastchar, 0, $length );
		if ( empty( $lastchar ) )
			array_pop( $words );

		$text = implode( ' ', $words ) . $append;
	}

	return $text;
}


/**
 * Get featured video, gallery or image
 *
 * @param	$post_id int
 * @param	$format string
 * @param	$video bool whether or not to display video (necessary for pinned/timeline)
 *
 * @uses	get_the_ID()  Get post ID
 * @uses	get_post_meta()  Get custom field
 * @uses	do_shortcode()  Processes the shortcode
 * @uses	the_post_thumbnail  Get the featured image
 *
 * @since 1.0.0
 * @author c.bavota, Garth Gutenberg
 */
function cdc_get_featured_media( $post_id = null, $format = 'hero', $video = true ) {
	$post_id = empty( $post_id ) ? get_the_ID() : (int) $post_id;
	$featured_media = '';
	$featured_video_id = get_post_meta( $post_id, 'cdc_featured_video_id', true );
	$featured_gallery_id = ( 'photo_gallery' == get_post_type( $post_id ) ) ? $post_id : get_post_meta( $post_id, 'cdc_featured_gallery', true );

	/**
	 * Determine which image sizes to serve up
	 */
	switch( $format ){
		case 'hero':
			$big = 'hero-2x1-1200';
			$medium = 'hero-2x1-768';
			$small = 'hero-2x1-320';
			break;
		case 'hero-32':
			$big = 'hero-3x2-1200';
			$medium = 'hero-3x2-768';
			$small = 'hero-3x2-320';
			break;
		case 'pin-feature':
			$big = 'discussion-feature-pinned-1200';
			$medium = 'discussion-feature-pinned-768';
			$small = 'discussion-feature-pinned-320';
			break;
		case 'pin':
			$big = 'discussion-pinned-1200';
			$medium = 'discussion-pinned-768';
			$small = 'discussion-pinned-320';
			break;
		case 'home':
			$big = 'home-hero-2x1-1200';
			$medium = 'home-hero-2x1-768';
			$small = 'home-hero-2x1-320';
			break;
		case 'home-small':
			$big = 'home-hero-3x2-1200';
			$medium = 'home-hero-3x2-768';
			$small = 'home-hero-3x2-320';
			break;
		case 'timeline':
			$big = $medium = $small = 'timeline';
			break;
		case 'atom':
			$big = 'atom-thumbnail-1200';
			$medium = 'atom-thumbnail-768';
			$small = 'atom-thumbnail-320';
			break;
		case 'photo-video':
			$big = 'photo-video-1200';
			$medium = 'photo-video-768';
			$small = 'photo-video-320';
			break;
		default:
			$big = 'hero-2x1-1200';
			$medium = 'hero-2x1-768';
			$small = 'hero-2x1-320';
			break;
	}
	
	// load thumb details - which follow business rules for alt,title..etc.
	$thumb = pm_get_post_thumbnail( null, $post_id );
	
	// we show a hero if calling the featured media for the current, single post
	if ( is_singular() && get_queried_object_id() == $post_id ) {
		if ( ! empty( $featured_video_id ) ) {
			$featured_media = do_shortcode( '[ooyala code=' . esc_attr( $featured_video_id ) . ' autoplay="true"]' );
		} elseif ( ! empty( $featured_gallery_id ) ) {
			if ( 'atom' == $format || 'timeline' == $format ) {
				$featured_media = cdc_get_first_gallery_image( $featured_gallery_id, array( $big, $medium, $small ) );
			} else {
				global $cdc_gallery_post;
				$featured_media = $cdc_gallery_post->cdc_hero_photo_gallery( $featured_gallery_id );
			}
		} elseif ( $thumbnail_id = get_post_thumbnail_id( $post_id ) ) {
			// Override switch() statement since we know that it's supposed to be the Hero
			if ( 'atom' != $format ) {
				$big = 'hero-2x1-1200';
				$medium = 'hero-2x1-768';
				$small = 'hero-2x1-320';
			}

			if ( $featured_image_big = wp_get_attachment_image_src( $thumbnail_id, $big ) ) {
				$featured_image_med = wp_get_attachment_image_src( $thumbnail_id, $medium );
				$featured_image_sml = wp_get_attachment_image_src( $thumbnail_id, $small );
				
				$featured_media = sprintf( '<noscript data-large="%1$s" data-medium="%2$s" data-small="%3$s" data-alt="%4$s" data-title="%5$s"><img src="%1$s" alt="%4$s" title="%5$s" /></noscript>',
					esc_attr( $featured_image_big[0] ),
					esc_attr( $featured_image_med[0] ),
					esc_attr( $featured_image_sml[0] ),
					$thumb ? esc_attr( $thumb->alt ) : '',
					$thumb ? esc_attr( $thumb->title ) : ''
				);
			}
		}
	} else {
		// Logic for displaying the featured media in timelines, pinned, H2H, etc. (non-HERO)
		if ( ! empty( $featured_video_id ) ) {
			// If a post has a featured video and a featured image, display the image ... Otherwise display the video thumbnail
			if ( $thumbnail_id = get_post_thumbnail_id( $post_id ) ) {
				$featured_image_big = wp_get_attachment_image_src( $thumbnail_id, $big );
				$featured_image_med = wp_get_attachment_image_src( $thumbnail_id, $medium );
				$featured_image_sml = wp_get_attachment_image_src( $thumbnail_id, $small );
				$featured_image_big_src = $featured_image_big[0];
				$featured_image_med_src = $featured_image_med[0];
				$featured_image_sml_src = $featured_image_sml[0];

				$featured_image_caption = $thumb->alt;
				$featured_image_title = $thumb->title;
			} else {
				$featured_image_big_src = $featured_image_med_src = $featured_image_sml_src = get_post_meta( $post_id, 'cdc_featured_video_image', true );;

				$featured_image_caption = get_post_meta( $post_id, 'cdc_featured_video_title', true );
				$featured_image_title = $featured_image_caption;
			}

			if ( ! empty( $featured_image_big_src ) ) {
				$featured_media = sprintf( '<noscript data-large="%1$s" data-medium="%2$s" data-small="%3$s" data-alt="%4$s" data-title="%5$s"><img src="%1$s" alt="%4$s" title="%5$s" /></noscript>',
					esc_attr( $featured_image_big_src ),
					esc_attr( $featured_image_med_src ),
					esc_attr( $featured_image_sml_src ),
					esc_attr( $featured_image_caption ),
					esc_attr( $featured_image_title )
				);
			}
		} elseif ( ! empty( $featured_gallery_id ) ) {
			if ( 'atom' == $format || 'timeline' == $format || 'pin-feature' == $format  || 'pin' == $format )
				$featured_media = cdc_get_first_gallery_image( $featured_gallery_id, array( $big, $medium, $small ) );
			else
				$featured_media = do_shortcode( '[photo_gallery id=' . esc_attr( $featured_gallery_id ) . ' link=0]' );
		} elseif ( $thumbnail_id = get_post_thumbnail_id( $post_id ) ) {
			if ( $featured_image_big = wp_get_attachment_image_src( $thumbnail_id, $big ) ) {
				$featured_image_med = wp_get_attachment_image_src( $thumbnail_id, $medium );
				$featured_image_sml = wp_get_attachment_image_src( $thumbnail_id, $small );

				$featured_media = sprintf( '<noscript data-large="%1$s" data-medium="%2$s" data-small="%3$s" data-alt="%4$s" data-title="%5$s"><img src="%1$s" alt="%4$s" title="%5$s" /></noscript>',
					esc_attr( $featured_image_big[0] ),
					esc_attr( $featured_image_med[0] ),
					esc_attr( $featured_image_sml[0] ),
					$thumb ? esc_attr( $thumb->alt ) : '',
					$thumb ? esc_attr( $thumb->title ) : ''
				);
			}
		}
	}

	return $featured_media;
}

/**
 * Get featured media credit
 *
 * @uses	get_the_ID()  The post ID
 * @uses	has_post_thumbnail()  Check for featured image
 * @uses	get_post_thumbnail_id()  The featured image ID
 * @uses	get_post_meta()  Get custom field value
 *
 * @return	string  The featured media credit
 *
 * @since 1.0.0
 * @author c.bavota
 *
 * @todo	This needs to be adapted to work with video and gallery options
 */
function cdc_get_featured_media_credit() {
	if ( $thumbnail_id = get_post_thumbnail_id() )
		return get_post_meta( $thumbnail_id, '_cdc_attachment_credit', true );
}

/**
 * Get featured media caption
 *
 * @uses	get_the_ID()  The post ID
 * @uses	has_post_thumbnail()  Check for featured image
 * @uses	get_post_thumbnail_id()  The featured image ID
 * @uses	get_post_meta()  Get custom field value
 *
 * @return	string  The featured media caption
 *
 * @since 1.0.0
 * @author c.bavota
 *
 * @todo	This needs to be adapted to work with video and gallery options
 */
function cdc_get_featured_media_caption() {
	if ( $thumbnail_id = get_post_thumbnail_id( get_the_ID() ) )
		return cdc_get_attachment_caption( $thumbnail_id );
}

/**
 * Get featured media description
 *
 * @uses	get_the_ID()  The post ID
 * @uses	has_post_thumbnail()  Check for featured image
 * @uses	get_post_thumbnail_id()  The featured image ID
 * @uses	get_post_meta()  Get custom field value
 *
 * @return	string  The featured media caption
 *
 * @since 1.0.0
 * @author c.bavota/jbracken
 *
 * @todo	This needs to be adapted to work with video and gallery options
 */
function cdc_get_featured_media_description() {
	if ( $thumbnail_id = get_post_thumbnail_id( get_the_ID() ) )
		return cdc_get_attachment_description( $thumbnail_id );
}

/**
 * Get the attachment caption
 *
 * @param	int $attachment_id  The attachment ID
 *
 * @uses	get_post_field()  Get the post field
 *
 * @return	string  Attachment caption
 *
 * @since 1.0.0
 * @author c.bavota
 */
function cdc_get_attachment_caption( $attachment_id ) {
	return get_post_field( 'post_excerpt', $attachment_id );
}

/**
 * Get the attachment description
 *
 * @param	int $attachment_id  The attachment ID
 *
 * @uses	get_post_field()  Get the post field
 *
 * @return	string  Attachment caption
 *
 * @since 1.0.0
 * @author c.bavota/jbracken
 */
function cdc_get_attachment_description( $attachment_id ) {
	return get_post_field( 'post_content', $attachment_id );
}




add_filter('pn_dfpads_slot', 'drv_define_adslot', 10, 3);
function drv_define_adslot( $o_ad ) {
	
	$theme_prefix = drv_smrt_theme_prefix();
	$url =  $_SERVER["REQUEST_URI"];
	$segments = substr( $url, 1 );
	$segments = explode( '/', $segments );
	
	if( 'mob' == $theme_prefix ) {
		$o_ad->slot = str_replace( 'ccn_news.com', 'ccn.m', $o_ad->slot );
	}
	
	$a_slot = array( "war","ww1" );
	
	if ( is_post_type_archive('memory') ){
		$a_slot[] = "memory-project";
	}
	
	if ( is_404() ){
		$a_slot[] = "404";
	}
	
	if ( is_search() ){
		$a_slot[] = "search";
	}
	
	// the ad slot is handled as a string, but is useful to manipulate
	// as a "/" delimited array (first element empty for sake of leading slash as required in adsite value)
	$a_slot_in = explode( '/', $o_ad->slot );
	
	//Splicing in the new zone values
	array_splice($a_slot_in, 3, 0, $a_slot);
	
	// override default plug-in behaviour as needed using taxonomy slugs
	//$a_slot = array_merge( array_slice( $a_slot_in, 0, -1 ), $a_slot, array_slice( $a_slot_in, -1 ) );
	
	// set it as a string
	$o_ad->slot = str_replace( '//', '/', implode( '/', $a_slot_in ) );
	
	return $o_ad;
}

add_filter('pn_dfpads_keyvalue', 'drv_add_key_param_values', 10, 3);
function drv_add_key_param_values( array $a_defaults, $s_key, $o_ad ) {
	
	global $np_a_cats, $post; // JSYK, $np_a_cats is a heirarchical array of categories used by our theme
	
	// you can append or overwrite; governed by "global/per-unit/multiple" settings; always array, even when single value
	$a_values = $a_defaults;
	
	$url =  $_SERVER["REQUEST_URI"];
	$segments = substr( $url, 1 );
	$segments = explode( '/', $segments );
	
	/*
if ( $segments[0] === 'olympics' ) {
		//remove first part of array
		array_shift($segments);
	}
*/
	
	// per-ad
	if ( $o_ad ) {
		

		
	// global
	} else {
		
		// alter by param key
		switch ($s_key) {
		
			case 'ck':
				$s_value = 'war'; 
				break;
	
			case 'sck':
				
				$a_values[] = 'ww1';
				
				if( is_home() ) {
					$a_values[] = 'index';
				}
				
				if( is_category() ) {	
					if( ! empty( $segments[1] ) ) {
						$a_values[] = $segments[1];
					}
				}
				
				if( is_single() ) {
					if( ! empty( $segments[0] ) ) {
						$a_values[] = $segments[0];
					}
					if( ! empty( $segments[1] ) ) {
						$a_values[] = $segments[1];
					}
				}
				
				if ( is_post_type_archive('memory') ) {
					$a_values[] = 'memory-project';
				}
				
				if( ! empty( $s_value ) ) {
					if ( ! in_array( $s_value, $a_values ) ) {
						if( ! is_home() ) {
							$a_values[] = $s_value;
						}
					}
				}
				if( is_404() ) {
					$a_values[] = '404';
				}
				
				if( is_search() ) {
					$a_values[] = 'search';
				}
				
				break;
			
			case 'imp':
				
				if( is_home() ) {
					$s_value = 'ww1';
				}
				else if( is_page() ) {
					$s_value = $segments[0];
				}
				else if( is_search() ) {
					$s_value = 'search';
				}
				else if( is_author() ) {
					$author = get_queried_object();
					$gravatar= drv_get_author_gravatar_data( $author->user_email, false, false );
					$a_values[] = sanitize_title( $gravatar['name'] );
				}
				else if( is_post_type_archive('video')) {
					$s_value = 'video';
				}
				else if( is_post_type_archive('gallery')) {
					$s_value = 'photo';
				}
				if ( is_post_type_archive('memory') ) {
					$s_value = 'memory-project';
				}
				else if( is_category() ) {
						$s_value = get_query_var( 'category_name' );		

				}
				if( is_page_template('page-search-results.php') ) {
					$s_value = 'search';
				}
				if( is_404() ) {
					$s_value = '404';
				}
				if( ! empty( $s_value ) ) {
					if ( ! in_array( $s_value, $a_values ) ) {
						$a_values[] = $s_value;
					}
				}
				break;
			
			case 'page':
				if( is_author() || is_category() || is_archive() || is_home() || is_tax( 'events' ) || is_page()  || is_search()  || is_404() ) {
					$s_value = 'index';
				}
				else if( is_single() ) {
					$s_value = 'story';
					if('video' == get_post_type($post->ID)){
						$s_value = 'video';
					}
				}
				if ( ! in_array( $s_value, $a_values ) ) {
					unset( $a_values );
					$a_values[] = $s_value;
				}
				
				
				break;
			
			
			case 'author':
				if( is_author () ) {
					$author = get_queried_object();
					$gravatar= drv_get_author_gravatar_data( $author->user_email, false, false );
					$a_values[] = sanitize_title( $gravatar['name'] );
				}
				if( is_single() ) {
					$obj = get_queried_object();
					$author = get_user_by( 'id', $obj->post_author );
					$gravatar= drv_get_author_gravatar_data( $author->user_email, false, false );
					$a_values[] = sanitize_title( $gravatar['name'] );
				}
				break;			
				
			case 'aid':
				if( is_single() ) {
					$a_values[] = $post->ID;
				}
			break;
			
			case 'cinf':
				if( is_single() ) {
					if ( $tags = get_the_tags() ) {
						foreach( $tags as $tag ) {
							$a_values[] = $tag->slug;
						}
					}
				}
				break;
				
			case 'ciab':
			      if( is_single() ) {
					  $iabs = inform_iabs( get_the_ID(), 0, true );
					  if ( ! empty( $iabs ) ) {
						  foreach ( $iabs as $iab ) {
							  $a_values[] = sanitize_title( $iab['label'] );
							}
						}
			      }
				break;
				
			case 'zone':				
				if( is_home() ) {
					$s_value = "war/ww1/index";
				}
				
				if( is_single() ) {
				
				}
				
				if( is_category() && is_single() ) {	
					if( ! empty( $segments[1] ) ) {
						$s_value = "war/ww1/" . $segments[1]."/story" ;
					}
				} else if ( is_category() && !is_single() ) {
					if( ! empty( $segments[1] ) ) {
						$s_value = "war/ww1/" . $segments[1]."/index" ;
					}
				}
			
			break;
			      
		}
	}
	
	return (array) $a_values;
}


/*
 * Get Ad slot url
 *
 */

function drv_get_ad_slot_url() {
	$ad = drv_define_adslot( $o_ad );
	$url =  $_SERVER["REQUEST_URI"];
	$segments = substr( $url, 1 );
	$segments = explode( '/', $segments );
	$total_segments = count( $segments );
	
	/*
if ( $segments[0] === 'olympics' ) {
		//remove first part of array
		array_shift($segments);
	}
*/
	
	$make_array = array();
	
	if( ! empty( $ad->slot ) ) {
		$make_array = explode( '/', substr( $ad->slot, 1 ) );
	}
	if( is_author() || is_category() || is_archive() || is_home() || is_tax( 'make' ) || is_tax( 'specialsection' ) || is_page() ) {
		$s_value = 'index';
	}
	else if( is_single() ) {
		$s_value = 'story';
	}
	
	$ad_slot_url = implode( '/', array_slice( array_unique( array_merge( $make_array, $segments ) ), 0, -1 ) );
	
	if( is_home() ) {
		$return = $s_value;
	}
	else {
		$return = str_replace( '//','/', $ad_slot_url ) . '/' . $s_value;
	}
	return $return;
}


/**
 * Display author posts link with first and last name ( always given priority to gravatar info, if not exists, then use the wordpress user info )
 *
 * @param int $author_id	author id
 * @param bool $href		Does the name need a link
 * @param bool $italics		Does the last name need italicized
 * @param string $class		Customize class name
 *
 * @uses	get_author_posts_url()  Retrieve the author's post URL
 * @uses	get_the_author_meta()  Retrieve the author's meta
 * @uses	wpcom_vip_get_user_profile()  Gets the gravatar information
 * @uses	drv_get_author_excerpt()	Gets author experpt
 *
 * @return	array of author information
 *
 * @since 1.0.0
 */
function drv_get_author_gravatar_data( $author_id_or_email = null, $href = true, $italics = true, $class = 'author-name' ) {
	
	$author = array();	
	
	if( is_int( $author_id_or_email ) ) {
		$author_id = $author_id_or_email;
		$author_email = get_the_author_meta( 'email', $author_id );
	}
	else {
		$author_email = $author_id_or_email;
		$author_obj = get_user_by( 'email', $author_email );
		$author_id = $author_obj->ID;
	} 
	
	$key = 'drv_get_author_posts_link_' . $author_id_or_email . '_' . $href . '_' . $italics;
	
	$transient = get_transient( $key );
	
	if( ! empty( $transient ) ) {
		return $transient;
	}
	else {
		//Get profile information from gravatar
		$profile = wpcom_vip_get_user_profile( $author_email );
		
		$author['description'] = get_the_author_meta( 'description', $author_id );
		
		if ( ! empty( $profile ) ) {
	
			if( ! empty( $profile['name'] ) ) {
				$author['first_name'] = ucwords( esc_attr( $profile['name']['givenName'] ) );
				$author['last_name'] = ucwords( esc_attr( $profile['name']['familyName'] ) );
				if( $italics )
				{
					$author['name'] = $author['first_name'] . ' <span>' . $author['last_name'] . '</span>';
				}
				else {
					$author['name'] = $author['first_name'] . ' ' . $author['last_name'];
				}
			}
			else {
				$author['name'] = $author['first_name'] = ucwords( esc_attr( $profile['displayName'] ) );
			}
			
			if( ! empty( $profile['aboutMe'] ) ) {
				$author_description = $profile['aboutMe'];
				
				$author['description'] = preg_replace( '/@(\S+?)\b/', ' <a target="_blank" href="http://twitter.com/$1">@$1</a>', $author_description );
			}
			
			if ( ! empty( $profile['accounts'] ) ) {
	
				foreach( $profile['accounts'] as $accounts ) {
	
					$social[$accounts['shortname'] . '-display'] = $accounts['display'];
					$social[$accounts['shortname']] = $accounts['url'];
				}
				
				$author['social'] = $social;
			}
		}
		else {
			$author['first_name'] = ucwords( esc_attr( get_the_author_meta( 'first_name', $author_id ) ) );
	
			$author['last_name'] = ucwords( esc_attr( get_the_author_meta( 'last_name', $author_id ) ) );
			if( $italics )
			{
				$author['name'] = $author['first_name'] . ' <span>' . $author['last_name'] . '</span>';
			}
			else {
				$author['name'] = $author['first_name'] . ' ' . $author['last_name'];
			}
		}
		
		if( $href ) {
			$author['name'] = '<a class="' . $class . '" href="' . get_author_posts_url( $author_id ) . '" rel="author" title="' . $author['first_name'] . ' ' . $author['last_name'] . '">' . $author['name'] . '</a>';
		}
		
		set_transient( $key, $author, 30 * 60 );
	
		return $author;
	}	
}


/*
Plugin Name: Postmedia Video Rotator Widget
Plugin URI: 
Description:  Display Video and Gallery rotators in your sidebar
Author: Sebastien
Version: 0.1
Author URI: 
*/


class PM_Video_Rotator_Widget extends WP_Widget
{
  function PM_Video_Rotator_Widget()
  {
    $widget_ops = array('classname' => 'PM_Video_Gallery_Widget', 'description' => 'Display Video rotator in your sidebar' );
    $this->WP_Widget('PM_Video_Rotator_Widget', 'Postmedia - Video Rotator Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;
      
    ?>
 
    <div class="flexNavVideo flexNav"></div>
		<div id="videoSlider" class="flexslider">
		<ul class="slides">
		
		<?php 
		/* show the latest Videos  */
		$query = pm_check_cached_posts('pm_video_posts_query', array( 'posts_per_page' => '5', 'post_type' => 'video' ));
		
		if ( $query->have_posts() ) {

			while ($query->have_posts()) : $query->the_post(); 
		?>
				
			<li>
				<?php get_template_part( 'content',  'widget'  ); ?>
			</li>
			
		<?php 		
			endwhile; ?>

	<?php } ?> <!-- #End of if $query->have_posts() -->
	
		</ul> 
	</div>  <!-- End flexslider -->
	
	<?php
 
    echo $after_widget;
    
    // Reset global $the_post as this query will have overwitten it
	wp_reset_postdata();
  }
 
}




add_action( 'widgets_init', create_function('', 'return register_widget("PM_Video_Rotator_Widget");') );




/*
Plugin Name: Postmedia Gallery Rotator Widget
Plugin URI: 
Description:  Display Video and Gallery rotators in your sidebar
Author: Sebastien
Version: 0.1
Author URI: 
*/


class PM_Gallery_Rotator_Widget extends WP_Widget
{
  function PM_Gallery_Rotator_Widget()
  {
    $widget_ops = array('classname' => 'PM_Video_Gallery_Widget', 'description' => 'Display Gallery rotator in your sidebar' );
    $this->WP_Widget('PM_Gallery_Rotator_Widget', 'Postmedia - Gallery Rotator Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title)){
	  //$after_title = " <span>»</span>" .  $after_title;
	  echo $before_title . $title . $after_title;  
    }
      
      
    ?>
 
    <div class="flexNavPhoto flexNav"></div>
		<div id="photoSlider" class="flexslider">
		<ul class="slides">
		<?php 
		/* show the latest Videos  */
		$query = pm_check_cached_posts('pm_gallery_posts_query', array( 'posts_per_page' => '5', 'post_type' => 'gallery' ));
		
		if ( $query->have_posts() ) {

			while ($query->have_posts()) : $query->the_post(); 
		?>
				
			<li>
				<?php get_template_part( 'content',  'widget'  ); ?>
			</li>
			
		<?php 		
			endwhile; ?>

	<?php } ?> <!-- #End of if $query->have_posts() -->
	
		</ul> 
	</div>  <!-- End flexslider -->

	
	<?php
 
    echo $after_widget;
    
    // Reset global $the_post as this query will have overwitten it
	wp_reset_postdata();
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("PM_Gallery_Rotator_Widget");') );







?>