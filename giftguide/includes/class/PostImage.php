<?php

namespace Driving;

/**
 * PostImage
 * 
 * Combine all information related to images for a post into one object.
 * Business rules for image properties are managed here. 
 *
 * 
	$pi = new Driving\PostImage( null, null, 23 );

	echo $pi->credit();
	echo $pi->description();
	echo $pi->title();
	echo $pi->distributor();
	echo $pi->caption();
	echo $pi->alt();
	echo $pi->url();
	echo $pi->width();
	echo $pi->height();
 * 
 * 
 * @param string/array $size [optional] Size of image
 * @param string $post_id [optional] Id of post to load thumb for. Otherwise the current post.
 * @param string $image_id [optional] Id of image to load. Otherwise load the default thumb for post.
 * 
 * @author Chris Murphy
 */
class PostImage {
	
	// global WP post variable reference
	private $_post;
	
	// optional size
	private $_size = null;
	
	
	/**
	 * Image Id
	 */
	private $id = null;
	public function id() {
		if ( ! $this->id ) {
			$gallery = get_post_meta( $this->_post->ID, 'drv_featured_photogallery', true );
			
			if( ! empty( $gallery ) ) {		
				$regex_pattern = get_shortcode_regex();
				
				preg_match ( '/'.$regex_pattern.'/s', $gallery, $matches );
				
				if( ! empty( $matches[3] ) ) {
					$ids = str_replace ( '"', '', $matches[3] );
					
					if( ! empty( $ids ) ) {
						$ids = explode(',', str_replace( 'ids=', '', $ids ) );
						
						$this->id = $ids[0];
					}
				}
			}
			//else if( $video = get_post_meta( $this->_post->ID, 'cdc_featured_video_image', true ) ) {
			//	$return = $video;
			//}
			else if ( has_post_thumbnail( $this->_post->ID ) ) {	
				
				$this->id = get_post_thumbnail_id( $this->_post->ID );
			}
		}
		
		return $this->id;
	}
	
	/**
	 * WP Image SRC based on provided size 
	 * or the default image
	 * 
	 * @return array
	 */
	public function src() {
		$key = 'Driving-PostImage-src-' . $this->id() . $this->_size;	
		
		$src = get_transient( $key );

		if( ! $src ) {
			$src = wp_get_attachment_image_src( $this->id() , $this->_size );
			
			set_transient( $key, (array) $src, 5 * 60 );
		}
		
		return $src;
	}
	
	/**
	 * Post permalink
	 * Previously seen in (site.php > drv_wp_get_attachment_data)
	 * Added here for compatibility
	 */
	public function href() {
		return get_permalink( $this->_post->ID );
	}
	
	/**
	 * Credit - Custom field
	 */
	private $credit;
	public function credit() {
		if( ! $this->credit ) {
			$post_meta = $this->getPostMeta();
			
			if ( isset( $post_meta['drv_attachment_credit'][0] ) ) 
				$this->credit = $post_meta['drv_attachment_credit'][0];
		}
		
		return $this->credit;
	}
	
	/**
	 * Distributor - Custom field
	 */
	private $distributor;
	public function distributor() {
		if( ! $this->distributor ) {
			$post_meta = $this->getPostMeta();
			
			if ( isset( $post_meta['drv_attachment_distributor'][0] ) ) 
				$this->distributor = $post_meta['drv_attachment_distributor'][0];
		}
		
		return $this->distributor;
	}

	/**
	 * Image Title (title="")
	 */
	public function title() {
		return $this->getPostData()->post_title;
	}
	
	/**
	 * Image Description
	 */
	public function description() {
		return $this->getPostData()->post_content;
	}
	
	/**
	 * Image Caption
	 */
	public function caption() {
		if ( ! empty( $this->getPostData()->post_excerpt ) ) 
			return $this->getPostData()->post_excerpt;
		else
		
		if( isset( $this->description ) && ! empty( $this->description ) )
			return $this->description; // fall back to description as this was normally populated
	}
	
	/**
	 * URL for image
	 */
	public function url() {
		$url = '';
		
		$thumb_src = $this->src();	
		
		if ( isset( $thumb_src[0] ) ) 
			$url = $thumb_src[0];
		else
			$url = $this->getPostData()->guid;
		
		return $url;
	}
	
	/**
	 * Image width
	 */
	public function width() {
		$width = '';
		
		$thumb_src = $this->src();	
		
		if ( isset( $thumb_src[1] ) ) {
			$width = $thumb_src[1];
		}
		else if ( $this->getPostAttachmentMeta() ) {
			$pam = $this->getPostAttachmentMeta();
			$width = $pam['width'];
		}
		
		return $width;
	}
	
	/**
	 * Image height
	 */
	public function height() {
		$height = '';
		
		$thumb_src = $this->src( $this->_size );	
		
		if ( isset( $thumb_src[2] ) ) {
			$height = $thumb_src[2];
		}
		else if ( $this->getPostAttachmentMeta() ) {
			$pam = $this->getPostAttachmentMeta();
			$height = $pam['height'];
		}
		
		return $height;
	}
	
	/**
	 * Image alt (alt="")
	 */
	public function alt() {
		$alt = $this->_post->post_title;
		
		$post_meta = $this->getPostMeta();
		
		if ( isset( $post_meta['_wp_attachment_image_alt'][0] ) && strlen( trim( $post_meta['_wp_attachment_image_alt'][0] ) ) > 0 )
			$alt = $post_meta['_wp_attachment_image_alt'][0]; // alt of image
		else if ( $this->caption() )
			$alt = $this->caption(); // caption/description of image
		else if ( $this->title() )
			$alt = $this->title(); // title of image
		
		return $alt;
	}
	
	
	
	
	
	
	
	public function __construct ( $size = null, $post_id = null, $image_id = null ) {
		if ( $post_id ) {
			$this->_post = get_post( $post_id );
		}
		else {
			// reference global WP post variable
			global $post;
			
			$this->_post =& $post;
		}
		
		// get/set thumbnail id ( if image id is provided load that image instead of the default thumb )
	  	if ( $image_id )
			$this->id = $image_id;
		
		// if size is not set we don't get (url,width,height)
		if ( $size )
			$this->_size = $size;
	}
	
	/**
	 * Check if image id exists
	 * If Image Id is explicitly set this will be true.
	 * Otherwise we get the id through either an available gallery image or the posts thumbnail. See id().
	 */
	public function exists() {
		return ( $this->id() ) ? true : false;
	}

	/**
	 * Get Post Data
	 */
	private $_postData = null;
	public function getPostData() {
		if( ! $this->_postData ) {
			$key = 'Driving-PostImage-getPostData-' . $this->id();	
		
			$data = get_transient( $key );
			
			if( $data ) {
				$this->_postData = $data;
			}
			else {
				$this->_postData = get_post( $this->id() );
			
				set_transient( $key, $this->_postData, 5 * 60 );
			}
		}
		
		return $this->_postData;
	}
	
	/**
	 * Get Post Meta Data
	 */
	private $_postMeta = array();
	public function getPostMeta() {
		if( ! $this->_postMeta ) {
			$key = 'Driving-PostImage-getPostMeta-' . $this->id();	
		
			$data = get_transient( $key );
			
			if( $data ) {
				$this->_postMeta = $data;
			}
			else {
				$this->_postMeta = get_post_meta( $this->id() );
			
				set_transient( $key, $this->_postMeta, 5 * 60 );
			}
		}
		
		return $this->_postMeta;
	}
	
	/**
	 * Get Post Attachment Meta Data
	 */
	private $_postAttachmentMeta = null;
	public function getPostAttachmentMeta() {
		if( ! $this->_postAttachmentMeta ) {
			$post_meta = $this->getPostMeta();
			
			if ( isset( $post_meta['_wp_attachment_metadata'][0] ) ) 
				$this->_postAttachmentMeta = unserialize( $post_meta['_wp_attachment_metadata'][0] );
		}
		
		return $this->_postAttachmentMeta;
	}
	
} 