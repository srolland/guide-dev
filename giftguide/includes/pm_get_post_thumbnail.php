<?php
/**
 * Return a stdClass object of info associated with a posts thumbnail.
 * @param string/array $size [optional] Size of image
 * @param string $post_id [optional] Id of post to load thumb for. Otherwise the current post.
 * @return object
 */
function pm_get_post_thumbnail( $size=null, $post_id=null ) {
  	if( $post_id ) {
  		$post = get_post( $post_id );
  	}	
	else {
  		global $post;
	}
  
  	if ( has_post_thumbnail( $post->ID ) ) {
	  	$thumb = new stdClass();
	  
	  	// get/set thumbnail id
	  	$thumb->id = get_post_thumbnail_id( $post->ID );
		
		// get thumb src based on provided size
		$thumb_src = ( $size ) ? wp_get_attachment_image_src( $thumb->id , $size ) : null;	
		
		// get thumbnail post data
		$post_data = get_post( $thumb->id );
		$post_meta = get_post_meta( $thumb->id );

		// load more meta
		$post_attachment_meta = ( isset( $post_meta['_wp_attachment_metadata'][0] ) ) ? unserialize( $post_meta['_wp_attachment_metadata'][0] ) : null;
		
		// load credit from custom field
		$thumb->credit = ( isset( $post_meta['_pm_attachment_credit'][0] ) ) ? $post_meta['_pm_attachment_credit'][0] : null;

		// set thumb properties
		$thumb->title = $post_data->post_title;
		$thumb->description = $post_data->post_content;
		//$thumb->caption = $post_data->post_excerpt;
		$thumb->caption = ( !empty( $post_data->post_excerpt ) ) ? $post_data->post_excerpt : $thumb->description; // fall back to description as this was normally populated
		$thumb->url = ( $thumb_src ) ? $thumb_src[0] : $post_data->guid;
		$thumb->width = ( $thumb_src ) ? $thumb_src[1] : ( ( $post_attachment_meta ) ? $post_attachment_meta['width'] : '' );
		$thumb->height = ( $thumb_src ) ? $thumb_src[2] : ( ( $post_attachment_meta ) ? $post_attachment_meta['height'] : '' );
	  	$thumb->alt = $post->post_title; // title of post
	  	
		// ALT: check if alt then excerpt available to replace title
		if ( isset( $post_meta['_wp_attachment_image_alt'][0] ) && strlen( trim( $post_meta['_wp_attachment_image_alt'][0] ) ) > 0 )
			$thumb->alt = $post_meta['_wp_attachment_image_alt'][0]; // alt of image
		else if ( !empty( $post_data->post_excerpt ) )
			$thumb->alt = $post_data->post_excerpt; // caption of image
		else if ( !empty( $post_data->post_title ) )
			$thumb->alt = $post_data->post_title; // title of image
		
		// description not wanted as an alt fallback
		//else if ( !empty( $post_data->post_content ) )
		//	$thumb->alt = strip_tags( $post_data->post_content );
		
		return $thumb;
	}
	
	return null;  
}