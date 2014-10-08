<?php
class Postmedia_Functions_Init {
	
	
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
	}

	public function wp_enqueue_scripts() {
		// Need to hook to our own script handle, not 'jquery'
		wp_localize_script( 'json2', 'Postmedia', $this->postmedia_js_object() );
	}
	
	
	/**
	 * Generates the Postmedia JavaScript object used for exposing back-end data
	 *
	 * @return array    Array containing the object properties that will be assigned to the Postmedia JS object
	 *
	 * @todo Improve the ad code object
	 * @todo Change Jetpack_User_Agent_Info::is_ipad() to jetpack_is_ipad()
	 */

	/**
	 * Admapper++
	 */
	const AD_PREFIX = 'ccn';

	function postmedia_js_object() {
		$postmedia_js = array();
		$options = postmedia_theme_option();

		$postmedia_js['Urls'] = array(
			'home_url' => home_url(),
			'stylesheet_directory_uri' => get_stylesheet_directory_uri(),
			'ajaxurl' => home_url( '/wp-admin/admin-ajax.php' )
		);

		$postmedia_js['Properties'] = array(
			'domain' => '',
			'userAgents' => array(
				'mozilla', 'msie', 'webkit', 'ipad'
			),
			'mobileAgents' => array(
				'iphone', 'ipod', 'android'
			),
			'isMobile' => (bool) (string) jetpack_is_mobile(),
			'isIpad' => (bool) (string) Jetpack_User_Agent_Info::is_ipad(),
			'isModal' => false
		);
		
		
		/**
		 * Ad Code
		 */
		global $post;

		/**
		 * AdMapper++
		 */
		global $postmedia_ad_mapper;

		$ad_slug = '';
		$ad_keys = array(
			'nk' => 'ccn',
			'pr' => 'ccn',
			'ck' => 'war',
			'sck' => array( 'ww1' )
		);

		/**
		 * Determine whether or not it's an index page
		 */
		if ( is_single() || is_author() )
			$is_index = false;
		else
			$is_index = true;

		if ( is_home() )
			$is_home = true;
		else
			$is_home = false;
			
		

		if ( ! is_404() ) {
			if ( is_singular() || is_author() ) {
				if ( is_author() ) {
					$ad_keys['page'] = 'index';
					$ad_keys['author'] = get_the_author_meta( 'user_nicename' );
					//$ad_keys['ck'] = 'author';
					$ad_keys['sck'][] = $ad_keys['author'];
					
					//$ad_keys['imp'] = $ad_keys['sck'][count( $ad_keys['sck'] ) - 1];
				}
				elseif ( is_page() ) {
					$ad_keys['page'] = 'index';
					$ad_keys['author'] = get_the_author_meta( 'user_nicename' );
					//$ad_keys['ck'] = $postmedia_ad_mapper->page_key;
					$ad_keys['sck'] = array(
						'ww1',$ad_keys['author']
					);
					//$ad_keys['imp'] = $ad_keys['sck'][count( $ad_keys['sck'] ) - 1];
				} else { // Post
					$ad_keys['page'] = 'story';
					$ad_keys['aid'] = get_the_ID();
					$ad_keys['author'] = get_the_author_meta( 'user_nicename', $post->post_author );
					
					$url =  $_SERVER["REQUEST_URI"];
						$segments = substr( $url, 1 );
						$segments = explode( '/', $segments );
					if ( ! empty( $segments[0]) && ! empty( $segments[1]) ){
						$ad_keys['sck'] = array(
						'ww1',$segments[0], $segments[1] );
					}else {
						$ad_keys['sck'] = array(
						'ww1');
					}
					
					
					if ( is_category() ) {
					
						$url =  $_SERVER["REQUEST_URI"];
						$segments = substr( $url, 1 );
						$segments = explode( '/', $segments );
	
		
						$ad_keys['sck'] = array(
						'ww1', $segments[1] );
					}

					/*
if ('video' == get_post_type($post->ID)) {
						$ad_keys['page'] = 'video';
						$ad_keys['ck'] = 'video';
					}
					if ('gallery' == get_post_type($post->ID)) {
						$ad_keys['ck'] = 'photo';
					}
*/
					
					// can't use list pluck because we don't want an associative array
					$ad_keys['cinf'] = array();
					if ( $tags = get_the_tags() ) {
						foreach( $tags as $tag ) {
							$ad_keys['cinf'][] = $tag->slug;
						}
					}
					
					
					// Get IAB tags
					$iabs = inform_iabs( get_the_ID(), 0, true );
					if ( ! empty( $iabs ) ) {
						$ad_keys['ciab'] = array();
						foreach ( $iabs as $iab ) {
							$ad_keys['ciab'][] = sanitize_title( $iab['label'] );
						}
						$postmedia_js['Tracking'] = array(
							'iabs' => $iabs,
							'tags' => inform_tags( get_the_ID(), 0, true )
						);
					}
				}
			}
			else { // Index page of some sort
				$ad_keys['page'] = 'index';

				if ( is_front_page() ) {
					$ad_keys['ck'] = 'war';
				}
				else {
					if ( is_category() ) {
					
						$url =  $_SERVER["REQUEST_URI"];
						$segments = substr( $url, 1 );
						$segments = explode( '/', $segments );
	
		
						$ad_keys['sck'] = array(
						'ww1', $segments[1] );
						/*
$category_mapping = $postmedia_ad_mapper->get_category_map();
						$ad_keys['ck'] = array_shift( $category_mapping );
						if ( ! empty( $category_mapping ) ) {
							$ad_keys['sck'] = $category_mapping;
						}
						
*/
					}
					
					elseif ( is_tag() ) {
						$ad_keys['ck'] = 'war';
						$ad_keys['tag'] = get_query_var( 'tag' );
					}
				}

				if ( empty( $ad_keys['sck'] ) ) {
					$ad_keys['imp'] = is_tag() ? $ad_keys['tag'] : $ad_keys['ck'];
				}
				else {
					$sck_len = count( $ad_keys['sck'] );
					$ad_keys['imp'] = $ad_keys['sck'][$sck_len - 1];
				}
			}
		}
		else {
			/**
			 * 404
			 */
			$ad_keys['ck'] = 'war';
			$ad_keys['sck'] = array( 'ww1', '404' );
			$ad_keys['page'] = 'index';
			
		}

		$sck = empty( $ad_keys['sck'] ) ? null : $ad_keys['sck'];

		$ad_config_site = ( true === $is_home ) ? 'ccn_ind.com' : $postmedia_ad_mapper->get_ad_site( $ad_keys['ck'], $sck );

		$postmedia_js['adConfig'] = array(
			'site' => 'ccn_news.com',
			'msite' => 'ccn.m',
			'networkId' => 3081,
			'keys' => $ad_keys
		);

		if ( is_tag() ) {
			$postmedia_js['adConfig']['zone'] = 'tag';
		}
		else {
	
			$postmedia_js['adConfig']['zone'] = $ad_keys['ck'];
			if ( isset( $ad_keys['sck'] ) ) {
				foreach ( $ad_keys['sck'] as $sck ) {
					$postmedia_js['adConfig']['zone'] .= '/' . $sck;
				}
			}
			if ( is_home() ){
				$postmedia_js['adConfig']['zone'] .= '/index';
			}
		}
		$postmedia_js['adConfig']['keys'] = $this->sort_ad_keys( $postmedia_js['adConfig']['keys'] );

		if ( ! is_front_page() )
			$postmedia_js['adConfig']['zone'] .= '/' . $ad_keys['page'];


	    $postmedia_js['Facebook'] = array(
			'pageId' => $options['facebook_page_id'],
			'appId'  => $options['facebook_app_id']
		);

		if ( is_singular() && current_user_can( 'edit_posts' ) ) {
			$postmedia_js['debug'] = array(
				'iabs' => inform_iabs( get_the_ID(), 0, true ),
				'post_meta' => get_post_meta( get_the_ID() )
			);
		}

		return $postmedia_js;

	}

	/**
	 * Sorts ad keys based on Ad Ops request
	 *
	 * @param array $array Array of ad keys/values
	 *
	 * @return array    Sorted array
	 *
	 * @since 1.0.0
	 * @author Garth Gutenberg
	 */
	private function sort_ad_keys( $array ) {
		$order_array = array( 'loc', 'sz', 'nk', 'pr', 'ck', 'sck', 'page', 'tile', 'ciab', 'cinf', 'aid', 'ord' );
		$ordered = array();
		foreach( $order_array as $key ) {
			if ( array_key_exists( $key, $array ) ) {
				$ordered[$key] = $array[$key];
				unset( $array[$key] );
			}
		}
		return $ordered + $array;
	}

	/**
	 * Retrieves the category hierarchy (as slugs) given a category ID
	 *
	 * @param int $id Category ID
	 *
	 * @return array    Numbered array of category slugs in hierarchical order
	 */
	private function get_category_hierarchy( $id ) {
		$id_hierarchy = array_reverse( get_ancestors( $id, 'category' ) );

		$hierarchy = array();

		// Get ancestor categories
		if ( ! empty( $id_hierarchy ) ) {
			foreach ( $id_hierarchy as $cat_id ) {
				$category = get_term_by( 'id', $cat_id, 'category' );
				$hierarchy[] = $category->slug;
			}
		}

		// Set assigned category
		$category = get_term_by( 'id', $id, 'category' );
		$hierarchy[] = $category->slug;

		return $hierarchy;
	}
}
$postmedia_functions_init = new Postmedia_Functions_Init;