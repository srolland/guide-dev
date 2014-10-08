<?php
// Init WP.com VIP environment // Hook me up
//require_once( WP_CONTENT_DIR . '/themes/vip/plugins/vip-init.php' );
require_once( __DIR__ . '/includes/class.custom-atom-feed.php' );
// Load our load sitemap helpers
require_once( __DIR__ . '/includes/wpcom-sitemap.php' );

if ( ! isset( $content_width ) )
	$content_width = 950;

define( 'POSTMEDIA_THEME_URL', get_template_directory_uri() );
define( 'POSTMEDIA_THEME_TEMPLATE', get_template_directory() );



add_action( 'after_setup_theme', 'postmedia_setup' );
/**
 * Initial setup
 *
 * This function is attached to the 'after_setup_theme' action hook.
 *
 * @uses	add_theme_support()
 *
 * @since Windsor 1.0.0
 */
function postmedia_setup() {
	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menu( 'primary', __( 'Primary Menu' ) );
	register_nav_menu( 'secondary', __( 'Secondary Menu' ) );
	register_nav_menu( 'mobile-footer', __( 'Mobile Footer Menu' ) );

	// This theme uses Featured Images (also known as post thumbnails) for archive pages
	add_theme_support( 'post-thumbnails' );


	/* Seb: added thumbnail sizes */
	add_image_size( 'item', 300, 300, true );
	add_image_size( 'item@2x', 450, 450, true );
	add_image_size( 'main', 550, 450, true );
	add_image_size( 'main@2x', 750, 615, true ); 

}

/**
 * Load VIP plugins
 */
if (function_exists('wpcom_vip_load_plugin')) {
	
	wpcom_vip_load_plugin( 'co-authors-plus' );
	wpcom_vip_load_plugin( 'edit-flow' );
	wpcom_vip_load_plugin( 'seo-friendly-images-mod' );
	wpcom_vip_load_plugin( 'easy-custom-fields' );
	wpcom_vip_load_plugin( 'inform', 'postmedia-plugins' );
	wpcom_vip_load_plugin( 'wp-timbits', 'postmedia-plugins' );
	wpcom_vip_load_plugin( 'wp-to-saxotech', 'postmedia-plugins' );
	wpcom_vip_load_plugin( 'main-category', 'postmedia-plugins' );
	wpcom_vip_load_plugin( 'chartbeat' );
	wpcom_vip_load_plugin( 'zoninator' );
	wpcom_vip_load_plugin( 'post-revision-workflow' );
	wpcom_vip_load_plugin( 'add-meta-tags-mod' );
	wpcom_vip_load_plugin( 'related-links', 'postmedia-plugins' ); //postmedia related links plugin
	wpcom_vip_load_plugin( 'suppress-thumbnail', 'postmedia-plugins' );//postmedia suppress-thumbnail plugin
	wpcom_vip_load_plugin( 'ad-mapper', 'postmedia-plugins' );//postmedia ad mapper plugin	
	wpcom_vip_load_plugin( 'dfp-ads', 'postmedia-plugins' );
	wpcom_vip_load_plugin( 'subheading' );
	wpcom_vip_load_plugin( 'pn-video-override', 'postmedia-plugins' );
}



/**
 * Includes
 */
require_once( POSTMEDIA_THEME_TEMPLATE . '/includes/functions-init.php' ); // Init functions
require_once( POSTMEDIA_THEME_TEMPLATE . '/includes/functions-site.php' ); // Site functions

/**
 * Load Widgets
 */
require_once( POSTMEDIA_THEME_TEMPLATE . '/widgets/widgets-ww1-twitter.php' ); // Twitter Widget
require_once( POSTMEDIA_THEME_TEMPLATE . '/widgets/widgets-ad.php' ); // Ad Widget
require_once( POSTMEDIA_THEME_TEMPLATE . '/widgets/widget-latest-modified-posts.php' ); // latest posts sorted by modified
require_once( POSTMEDIA_THEME_TEMPLATE . '/widgets/widget-latest-category-posts.php' ); // latest posts sorted by modified
require_once( POSTMEDIA_THEME_TEMPLATE . '/widgets/widget-custom-rss.php' ); // Pull atom feeds into sidebars
require_once( POSTMEDIA_THEME_TEMPLATE . '/widgets/widget-zoninator.php' ); // Display Zones with custom markup
require_once( POSTMEDIA_THEME_TEMPLATE . '/widgets/widget-title-link.php' ); // Link Widget titles
require_once( POSTMEDIA_THEME_TEMPLATE . '/widgets/widgets-virtual-gramophone.php' ); // Virtual gramophone widget
require_once( POSTMEDIA_THEME_TEMPLATE . '/widgets/widget-DFP-responsive-big-box.php' ); // Responsive top Bigbox ad

require_once( POSTMEDIA_THEME_TEMPLATE . '/includes/class.metaboxes.php' ); // Class for custom metaboxes
require_once( POSTMEDIA_THEME_TEMPLATE . '/includes/class.theme-options.php' ); // Class for theme options
require_once( POSTMEDIA_THEME_TEMPLATE . '/includes/pm_get_post_thumbnail.php' ); // post thumbnail helper
require_once( POSTMEDIA_THEME_TEMPLATE . '/includes/pm_custom_media_uploader.php' ); // admin custom uploader - media
require_once( POSTMEDIA_THEME_TEMPLATE . '/includes/class/PostImage.php' ); // Class to combine and filter image data



add_action( 'wp_enqueue_scripts', 'postmedia_add_js' );
/**
 * Load all JavaScript to header
 *
 * This function is attached to the 'wp_enqueue_scripts' action hook.
 *
 * @uses	is_admin()
 * @uses	is_singular()
 * @uses	get_option()
 * @uses	wp_enqueue_script()
 * @uses	POSTMEDIA_THEME_URL
 *
 * @since Windsor 1.0.0
 */
function postmedia_add_js() {
	if ( ! is_admin() ) {
		global $postmedia_functions_init;

		// Canned
		wp_enqueue_script( 'postmedia-modernizr', POSTMEDIA_THEME_URL .'/js/modernizr.min.js', array( 'jquery' ), '2.5.3', true);
                wp_enqueue_script( 'cdc_sha1_js', POSTMEDIA_THEME_URL .'/js/sha1.js', '', '1.7.4' , true);
		//wp_enqueue_script( 'cdc_codebird_js', POSTMEDIA_THEME_URL .'/js/codebird.js', '', '1.7.4', true );
		wp_enqueue_script( 'postmedia-twitter', POSTMEDIA_THEME_URL .'/js/lib-livetwitter.min.js', array( 'jquery' ), '1.7.4', true);
		wp_enqueue_script( 'pinterest' , 'http://assets.pinterest.com/js/pinit.js', '', '', true );
		
		//Seb: added flexslider
		wp_enqueue_script( 'flexslider', POSTMEDIA_THEME_URL .'/js/jquery.flexslider.js', array( 'jquery' ), true);
		wp_enqueue_script( 'colorbox', POSTMEDIA_THEME_URL .'/js/jquery.colorbox-min.js', array( 'jquery' ), true);
		

		// Custom
		wp_enqueue_script( 'postmedia-utils', POSTMEDIA_THEME_URL . '/js/cdc-utils.js', array( 'jquery', 'postmedia-modernizr' ) , '1.0.0' );
		wp_enqueue_script( 'postmedia-data', POSTMEDIA_THEME_URL . '/js/cdc-data.js', array( 'jquery', 'postmedia-utils' ) , '1.0.0' );
		wp_enqueue_script( 'postmedia-adserver', POSTMEDIA_THEME_URL .'/js/cdc-adserver.js', array( 'jquery', 'postmedia-utils', 'postmedia-data' ), '1.0.0' );
		//wp_enqueue_script( 'postmedia-omniture', POSTMEDIA_THEME_URL . '/js/ws-omniture.js', array( 'jquery', 'postmedia-utils', 'postmedia-data' ) , '1.0.0' );
		
		wp_enqueue_script( 'postmedia-isotope', POSTMEDIA_THEME_URL .'/js/isotope.pkgd.min.js', array( 'jquery', 'postmedia-utils', 'postmedia-data' ), '2.0.1', true );
		
		wp_enqueue_script( 'postmedia-sochi', POSTMEDIA_THEME_URL .'/js/sochi.js', array( 'jquery', 'postmedia-utils', 'postmedia-data' ), '1.0.0', true );
		
		
		
		//wp_enqueue_script( 'cdc_ooyala_js', POSTMEDIA_THEME_URL .'/js/cdc-ooyala.js', array( 'jquery' ), '2.0.0' );

		//wp_enqueue_script( 'postmedia-omniture-account', 'http://www.canada.com/js/account_sochi_s_code.js', array( 'jquery' ), '1.9.0', true );
		//wp_enqueue_script( 'postmedia-omniture-global', 'http://www.canada.com/js/global_s_code.js', array( 'jquery' ), '1.9.0', true );
		//wp_enqueue_script( 'postmedia-omniture-local', 'http://www.canada.com/js/local_sochi_s_code.js', array( 'jquery' ), '1.9.0', true );
		
		// Icon font
		wp_enqueue_style( 'font_awesome', 'http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css', false, null, 'all' );

		// Utilities variable
		wp_localize_script( 'postmedia-modernizr', 'Postmedia', $postmedia_functions_init->postmedia_js_object() );
				
	}
}

add_action( 'admin_print_scripts', 'postmedia_admin_print_scripts' );
/**
 * Load all JavaScript to admin header
 *
 * This function is attached to the 'admin_print_scripts' action hook.
 *
 * @uses	is_admin()
 * @uses	is_singular()
 * @uses	get_option()
 * @uses	wp_enqueue_script()
 * @uses	POSTMEDIA_THEME_URL
 *
 * @since Windsor 1.0.0
 */
function postmedia_admin_print_scripts() {
	wp_enqueue_script( 'custom_quicktags', POSTMEDIA_THEME_URL . '/js/custom_quicktags.js', array( 'quicktags' ) );
}

add_action( 'widgets_init', 'postmedia_widgets_init' );
/**
 * Creating the main sidebar and dynamically creating sidebars for each category
 *
 * This function is attached to the 'widgets_init' action hook.
 *
 * @uses	register_sidebar()
 * @uses	get_categories()
 * @uses	get_cat_name()
 *
 * @since Windsor 1.0.0
 *
 * @todo	Figure out a better way to organize the categories. Currently ordering by hierarchy is not available
 * 			in the default get_categories() function in WordPress.
 */
function postmedia_widgets_init() {

	// check for easy sidebars
	if (function_exists('easy_sidebars')) {
		return;
	}

	register_sidebar( array(
		'name' => __( 'Main Sidebar' ),
		'id' => 'sidebar',
		'description' => __( 'This is the regular sidebar widgetized area.' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Main Sidebar Top' ),
		'id' => 'sidebar-top',
		'description' => __( 'This is the top half of the main sidebar widgetized area.' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Main Sidebar Bottom' ),
		'id' => 'sidebar-bottom',
		'description' => __( 'This is the second half of the main sidebar widgetized area.' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	/*
register_sidebar( array(
		'name' => __( 'Single Sidebar' ),
		'id' => 'sidebar-single',
		'description' => __( 'This is the main sidebar widgetized area for single posts.' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
*/
	
	
	
$categories = get_categories( array( 'hide_empty' => 0 ) );

	foreach ( $categories as $category ) {
		$cat_parent_name = ( 0 != $category->parent ) ? get_cat_name( $category->parent ) . ' - ' : '';
		$cat_parent_slug = ( $cat_parent_name ) ? sanitize_title( $cat_parent_name ) . '-' : '';
		register_sidebar( array(
			'name' => $cat_parent_name . $category->cat_name,
			'id' => $cat_parent_slug . $category->category_nicename . '-widget-area',
			'description' => 'This is the ' . $category->cat_name . ' widgetized area',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}

}


/**
 * TinyMCE editor plugin hook
 */ 
function drv_add_tinymce_plugins( $plugin_array ) {
   $plugin_array['wpeditimage'] = POSTMEDIA_THEME_URL . '/includes/plugins/pm-wpeditimage/editor_plugin.js';
   
   return $plugin_array;
}



/**
 * Add pagination
 *
 * @uses	paginate_links()
 * @uses	add_query_arg()
 *
 * @since Windsor 1.0.0
 */
function postmedia_pagination() {
	global $wp_query;

	$current = max( 1, get_query_var('paged') );
	$big = 999999999; // need an unlikely integer

	$pagination_return = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => $current,
		'total' => $wp_query->max_num_pages,
		'next_text' => '&raquo;',
		'prev_text' => '&laquo;'
	) );

	if ( ! empty( $pagination_return ) ) {
		echo '<div id="pagination">';
		echo '<div class="total-pages">';
		printf( __( 'Page %1$s of %2$s' ), $current, $wp_query->max_num_pages );
		echo '</div>';
		echo $pagination_return;
		echo '</div>';
	}
}

/**
 * Allows the use of shortcodes in widgets
 **/

add_filter('widget_text', 'do_shortcode');



add_filter( 'wp_title', 'postmedia_filter_wp_title' );
/**
 * Filters the page title appropriately depending on the current page
 *
 * This function is attached to the 'wp_title' filter hook.
 *
 * @uses	get_bloginfo()
 * @uses	is_home()
 * @uses	is_front_page()
 *
 * @since Windsor 1.0.0
 */
function postmedia_filter_wp_title( $title ) {
	global $page, $paged;

	$site_description = get_bloginfo( 'description' );

	$filtered_title = $title . get_bloginfo( 'name' );
	$filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' | ' . $site_description: '';
	$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) ) : '';

	return $filtered_title;
}

/**
 * Update default WordPress search form to HTML5 search form
 *
 * @param	$text  Custom text to appear as placeholder
 *
 * @return	Modified search form
 *
 * @since Windsor 1.0.0
 */
function postmedia_search_form() {
	?>
    <form role="search" method="get" class="searchform" action="<?php echo get_home_url(); ?>/" onsubmit="javascript:return !!this['s'].value.length">
    <label class="assistive-text">Search for:</label>
    <input type="search" placeholder="Search The Great War" value="<?php echo get_search_query(); ?>" name="s" class="site-search" />
    <button class="btn blue-btn"><span>Search</span></button>
    </form>
    <?php
}





/**
 * Resize images that are less than 300px wide and/or less than 200px tall
 *
 * This function is attached to the 'add_attachment' filter hook.
 *
 *
 * @since WW1 Centenary 1.0.0
 */


function resize_image( $imgname, $min_width = 300, $min_height = 200 )
{
    
    $img_type = exif_imagetype($imgname);
    
    
     
    /* Attempt to open */
    switch($img_type)
    {
    	case 1:
    		$src_img = imagecreatefromgif($imgname);
    		break;
    		
    	case 2:	
    		$src_img = imagecreatefromjpeg($imgname);
    		break;
    		
    	case 3:	
    		$src_img = imagecreatefrompng($imgname);
    		break;
    		    		
    	default:
            return $imgname;
    		break;
    }
   
    /* See if it failed */
    if(!$src_img)
    {
        /* Create a black image */
        $new_img  = imagecreatetruecolor(300, 75);
        $bgc = imagecolorallocate($new_img, 255, 255, 255);
        $tc  = imagecolorallocate($new_img, 0, 0, 0);

        imagefilledrectangle($new_img, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring($im, 1, 5, 5, 'Error loading ' . $src_img, $tc);
    }
    
    
    //-------------------
    
    	$width_src = imagesx($src_img);
		$height_src = imagesy($src_img);
		
		$pos_X = 0;
		$pos_Y = 0;
		$width_added = 0;
		$height_added = 0;
		
		if ( $width_src < $min_width ) {
			$width_added = $min_width - $width_src;
			$pos_X = ($width_added/2);		
		} 
				
		if ( $height_src < $min_height ) {
			$height_added = $min_height - $height_src;
			$pos_Y = ($height_added/2);		
		}
		
		$width_new = + $width_src;// + $width_added;
		$height_new = + $height_src;// + $height_added;
		$quality = 100;
		
		$new_img = imagecreatetruecolor($width_src + $width_added, $height_src + $height_added);
		
		$bgc = imagecolorallocate($new_img, 255, 255, 255);
		
		imagefill($new_img, 0, 0, $bgc);

		imagecopyresampled($new_img, $src_img, $pos_X, $pos_Y, 0, 0, $width_new, $height_new, $width_src, $height_src);
    
    
    //-------------------

    return $new_img;
}


function resize_small_images($post_ID) {
    
   	$parent_id = get_post_ancestors( $post_ID );
   	$parent_post_type = get_post_type( $parent_id[0] );
   		
    if ( 'memory' === $parent_post_type ) {
    	
		$src = wp_get_attachment_image_src( $post_ID );
		$src = $src[0];
		$src_img_type = exif_imagetype($src);
	    $img = resize_image($src, 450, 255);
		$upload_dir = wp_upload_dir();
		$overwrite = $upload_dir['path'] . "/" . basename($src) ;
		
	    switch($src_img_type){
		    case 1:
		    	imagegif($img, $overwrite);
		    	break;
			case 2:
				imagejpeg($img, $overwrite);
		   		break;
		   
		   	case 3:
		   		imagepng($img, $overwrite);
		   		break; 	
		   	default:
		   		return true;
		   		break;
	    }
	    imagedestroy($img);
    }   
	
    return $post_ID;
}

add_filter('add_attachment', 'resize_small_images', 10, 2);



/**
 * Update default WordPress search form to HTML5 search form
 *
 * @param	$text  Custom text to appear as placeholder
 *
 * @return	Modified search form
 *
 * @since Windsor 1.0.0
 */
function postmedia_search_form_02() {
	?>
    <form role="search" method="get" class="searchform" action="<?php echo get_home_url(); ?>/" onsubmit="javascript:return !!this['s'].value.length">
    <label class="assistive-text">Search for:</label>
    <input type="search" placeholder="Search The Great War" value="<?php echo get_search_query(); ?>" name="s" class="site-search" />
    <button class="btn blue-btn footer"><span>Search</span></button>
    </form>
    <?php
}

add_filter( 'excerpt_length', 'postmedia_excerpt_length', 999 );
/**
 * Custom excerpt length
 *
 * This function is attached to the 'excerpt_length' filter hook.
 *
 * @param	int $length
 *
 * @return	Custom excerpt length
 *
 * @since Windsor 1.0.0
 */
function postmedia_excerpt_length( $length ) {
	return 40;
}

/**
 * Custom excerpt "Read more link"
 *
 * This function is attached to the 'excerpt_more' filter hook.
 *
 * Wraps the "[...]" after excerpt with a link to the post.
 *
 * @since Sochi 1.0.0
 */
function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">continue reading</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );



/**
 * Create breadcrumbs for single post pages
 *
 * @uses	get_the_category()  Gather categories for current post
 * @uses	get_cat_name()  Get category name
 * @uses	get_category_link()  Get category link
 * @uses	sanitize_title()  Sanitize string for use as class
 * @uses 	main-category plugin from postmedia shared plugin repo
 *
 * @return	string  Breadscrumb links
 *
 * @since Windsor 1.0.0
 * @jbracken
 */
function postmedia_breadcrumbs() {
	$output = '';

	if ( is_single() ) {
		$output .= '<div id="breadcrumbs" class="row"><nav class="c12">';
		$categories = get_the_category();
		$preferred_category =  $categories[0]->term_id;

		if ( $categories[0]->parent != 0 ){

			$category_crumbs = get_ancestors( $preferred_category, 'category' );
			array_push( $category_crumbs, $preferred_category );

		} else {

			$category_crumbs = array();
			array_push( $category_crumbs, $preferred_category );

		}

		$seperator = ' / ';
		$links = '';

		foreach ( $category_crumbs as $category_crumb ) {

			$current_cat_name = get_cat_name( $category_crumb );
			$current_cat_link = get_category_link( $category_crumb );
			$category_ancestors = get_ancestors( $category_crumb, 'category' );
			$category_parent = ( empty( $category_ancestors ) ) ? true : false;
			$category_class   = ( $category_parent == true ) ? 'parent-cat ' : '';

			$links .= '<a href="' . $current_cat_link .
					  '" class="' . $category_class . sanitize_title( get_cat_name( $category_crumb ) ).
					  '" title="' . esc_attr( sprintf( __( "View all posts in %s" ),  $current_cat_name ) ) .
					  '">' . $current_cat_name .
					  '</a>' . $seperator;

		}

		$output .= trim( $links, $seperator );

		$output .= '</nav></div>';
	}

	return $output;
}

/**
 * Get parent category name and sanitize
 *
 * @uses	get_the_category()  Gather categories for current post
 * @uses	get_cat_name()  Get category name
 * @uses	get_category_link()  Get category link
 * @uses	sanitize_title()  Sanitize string for use as class
 *
 * @return	string  Breadscrumb links
 *
 * @since Windsor 1.0.0
 */
function postmedia_single_cat_name() {
	$categories = get_the_category();

	if ( $categories ) {
		$cat = str_replace( '/', ' &amp; ', $categories[0]->name );
		return '<a href="' . get_category_link( $categories[0]->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $categories[0]->name ) ) . '">' . $cat . '</a>';
	}
}

add_shortcode('storybar', 'postmedia_storybar');
/**
 * Adds pn_storybar shortcode
 *
 * @return	string  Breadscrumb links
 *
 * @since Windsor 1.0.0
 * @author Brandon Hill / c.bavota
 */
function postmedia_storybar( $atts, $content ) {
	if ( is_feed() )
		return;

	extract( shortcode_atts( array(
		'title' => '',
		'link' => ''
	), $atts ) );

	// sanitize
	$link_beg = ( empty( $link ) ) ? '' : '<a href="' . esc_url( $link ) . '">';
	$link_end = ( empty( $link ) ) ? '' : '</a>';
	$title = ( empty( $title ) ) ? '' : '<h3>' . $link_beg . sanitize_text_field( $title ) . $link_end . '</h3>';

	return '<section id="right-sidebar" class="fr">' . $title . wp_kses_post( wpautop( $content ) ) . '</section>';
}

/**
 * Gather tweets from Twitter
 *
 * @param	string $username  Hashtag or Username to fetcg
 * @param	int $number_of_tweets (default: 5)  Number of tweets to display
 *
 * @return	string  Contains tweets
 *
 * @since 1.0.0
 */
function postmedia_get_tweets( $username, $number_of_tweets = 5, $list = null ) {
	$number_of_tweets = (int) $number_of_tweets;
	$term = '"' . esc_js( $username ) . '"';
	$term = ( $list ) ? '{user: "' . esc_js( $username ) . '", list: "' . esc_js( $list ) . '"}' : $term;
	$mode = ( strpos( $username, "#" ) === false ) ? 'user_timeline' : 'search';
	$mode = ( $list ) ? 'list' : $mode;

	return '
<script type="text/javascript">
(function($) {
	$( "#twitter-feed" ).liveTwitter( ' .  $term . ', { limit: ' . $number_of_tweets . ', mode: "' . $mode . '", showAuthor: true, retweets: true, imageSize: 45, rate: 30000 } );
})(jQuery);
</script>';
}

add_filter( 'nav_menu_css_class', 'add_custom_class', 10, 2 );

function add_custom_class( $classes = array(), $menu_item = false ) {
    if ( is_single() ) {
    	$category = get_the_category( get_the_ID() );
    	if ( $category[0]->parent == $menu_item->object_id || $category[0]->cat_ID == $menu_item->object_id )
	        $classes[] = 'single-post-parent-category';
    }
    return $classes;
}

/**
 * Gather users from Voices usergroup
 *
 * @user	EF_User_Groups  User group class
 *
 * @since 1.0.0
 * @author Jake (10up) / c.bavota
 *
 * @todo persistent caching via object cache
 */
function postmedia_get_voices_usergroup( $name = 'Voices' ) {

	static $user_ids;

	if ( ! isset( $user_ids ) && class_exists( 'edit_flow' ) && did_action( 'ef_modules_loaded' ) ) {
		global $edit_flow;

		if ( isset( $edit_flow->user_groups ) ) {
			$edit_flow->user_groups->register_usergroup_objects(); // by default, the taxonomy is only in admin (admin_init)
			$voices = $edit_flow->user_groups->get_usergroup_by( 'name', $name );

			if ( ! empty( $voices->user_ids ) )
				$user_ids =  $voices->user_ids;
		}

	}

	if ( ! isset( $user_ids ) )
		$user_ids = array();

	return $user_ids;

}


/**
 * Custom Fucntion to display just the tags with label="tag" and categories with no label
 * to make disctinction between categories and tag in feed syndication formats
 *
 * @return string  // a valid atom string for syndication
 *
 *@author jbracken
 */
function postmedia_get_the_category_and_tag_rss( $type = null ) {

	if ( empty($type) )
		$type = get_default_feed();

		$categories = get_the_category();
		$tags = get_the_tags();
		$the_list = '';
		$cat_names = array();
		$tag_names = array();

		$filter = 'rss';

		if ( 'atom' == $type )
			$filter = 'raw';


	if ( !empty($tags) ) foreach ( (array) $tags as $tag ) {

		$tag_names[] = sanitize_term_field('name', $tag->name, $tag->term_id, 'post_tag', $filter);

	}

	$tag_names = array_unique($tag_names);

	foreach ( $tag_names as $tag_name ) {
		if ( 'rdf' == $type )
			$the_list .= "\t\t<dc:subject><![CDATA[$tag_name]]></dc:subject>";

		elseif ( 'atom' == $type )
			$the_list .= sprintf( "\n\t\t\t\t" . '<category scheme="%1$s" term="%2$s" label="tag"/>', esc_attr( apply_filters( 'get_bloginfo_rss', get_bloginfo( 'url' ) ) ), esc_attr( $tag_name ) );

		else
			$the_list .= "\t\t<category><![CDATA[" . @html_entity_decode( $tag_name, ENT_COMPAT, get_option('blog_charset') ) . "]]></category>\n";
	}

	if ( !empty($categories) ) foreach ( (array) $categories as $category ) {

		$cat_names[] = sanitize_term_field('name', $category->name, $category->term_id, 'category', $filter);

	}


	$cat_names = array_unique( $cat_names );


	foreach ( $cat_names as $cat_name ) {

		$category_id = get_cat_ID( $cat_name );

		$category_parents = array();

		$category_parents = get_ancestors( $category_id, 'category' );

		if ( empty( $category_parents ) ){

			$category_label = 'Section';

		} else {

			$category_label = 'SubSection';
			$parent_category = get_category_parents( $category_id, FALSE, '' );

		}

		if ( 'rdf' == $type ){

			$the_list .= "\t\t<dc:subject><![CDATA[$cat_name]]></dc:subject>\n";

		} elseif ( 'atom' == $type ) {

			if ( $category_label == 'SubSection' ){

				$the_list .= sprintf( "\n\t\t\t\t" . '<category scheme="%1$s" term="%2$s" label="Section" />', esc_attr( apply_filters( 'get_bloginfo_rss', get_bloginfo( 'url' ) ) ), esc_attr( str_replace( $cat_name, '', $parent_category ) ) );

			}

			$the_list .= sprintf( "\n\t\t\t\t" . '<category scheme="%1$s" term="%2$s" label="' . $category_label .'" />', esc_attr( apply_filters( 'get_bloginfo_rss', get_bloginfo( 'url' ) ) ), esc_attr( $cat_name ) );

		} else {

			$the_list .= "\t\t<category><![CDATA[" . @html_entity_decode( $cat_name, ENT_COMPAT, get_option('blog_charset') ) . "]]></category>\n";

		}

	}

	return apply_filters('the_category_rss', $the_list, $type);
}

/**
 * Get Gravatar profile based on author ID
 *
 * Must be included within the WP loop like so:
 * <?php echo postmedia_get_gravatar_profile( get_the_author_meta('ID') ); ?>
 *
 * @param	int $author_id  Author ID
 *
 * @uses	wpcom_vip_get_user_profile()  Return Grofile
 *
 * @return	string  Gravatar profile associated with Author ID
 *
 * @since 1.0.0
 * @author c.bavota
 */
function postmedia_get_gravatar_profile( $author_id ) {
	$profile = wpcom_vip_get_user_profile( $author_id );
	$author_profile = ( is_array( $profile ) && isset( $profile['id'] ) ) ? $profile['aboutMe'] : '';

	return $author_profile;
}

/**
 * Uses Easy Custom Field plugin to create new meta boxes
 * Examples: /vip/plugins/easy-custom-fields/easy-custom-fields.php
 *
 * @since 1.0.0
 * @author c.bavota
 *
 * @todo add id to input fields so that clicking the label selects the field
 */
$field_data = array (
	'postmedia_syndication_slugs' => array (
		'fields' => array(
			'postmedia_syndication_slug' => array(
				'label' => 'Quick Wire Slug',
				'type' => 'text'
			)
		),
		'title' => 'Set Quickwire Slug',
		'context' => 'advanced',
		'priority' => 'high',
		'pages' => array( 'post', 'discussion', 'photo_gallery' )
	)
	,
	'postmedia_syndication_topics' => array (
		'fields' => array(
			'postmedia_syndication_topic' => array(
				'label' => 'Southparc Topic',
				'type' => 'text'
			)
		),
		'title' => 'Enter Southparc Topic',
		'context' => 'advanced',
		'priority' => 'side',
		'pages' => array( 'post' )
	),
	'postmedia_retailer_information' => array (
		'fields' => array(
			'postmedia_retailer_name_1' => array(
				'label' => 'Retailer Name 1',
				'type' => 'text'
			),
			'postmedia_retailer_url_1' => array(
				'label' => 'Retailer URL 1',
				'type' => 'text'
			)/* Retail price may come back...
,
			'postmedia_retailer_price_1' => array(
				'label' => 'Price 1',
				'type' => 'text'
			)*/,
			'postmedia_retailer_name_2' => array(
				'label' => 'Retailer Name 2',
				'type' => 'text'
			),
			'postmedia_retailer_url_2' => array(
				'label' => 'Retailer URL 2',
				'type' => 'text'
			),
			'postmedia_retailer_name_3' => array(
				'label' => 'Retailer Name 3',
				'type' => 'text'
			),
			'postmedia_retailer_url_3' => array(
				'label' => 'Retailer URL 3',
				'type' => 'text'
			),
			'postmedia_retailer_name_4' => array(
				'label' => 'Retailer Name 4',
				'type' => 'text'
			),
			'postmedia_retailer_url_4' => array(
				'label' => 'Retailer URL 4',
				'type' => 'text'
			),
			'postmedia_retailer_name_5' => array(
				'label' => 'Retailer Name 5',
				'type' => 'text'
			),
			'postmedia_retailer_url_5' => array(
				'label' => 'Retailer URL 5',
				'type' => 'text'
			)
			
		
		),
		'title' => 'Retailer Information',
		'context' => 'advanced',
		'priority' => 'high',
		'pages' => array( 'post' )
		
	)

);


$easy_cf = new Easy_CF( $field_data );

/*
Plugin Name: Tableau
Plugin URI: http://github.com/postmedia/wp-tableau
Description: Shortcode for displaying data from Tableau Public
Usage: https://github.com/maid0marion/Tableau-Wordpress-Plugin/wiki/How-to-Use-the-Tableau-Wordpress-Plugin
Version: 0.1
Author: Postmedia Network Inc.
License: MIT
*/

// register Tableau shortcode
function pd_tableau_shortcode($attr){

  extract( shortcode_atts( array(
      'width' => '800',
      'height' => '1000',
      'id' => 'shared/9G78NK9K4',
      'tabs' => 'no'
    ), $attr ) );

  // when saved as shared, use the parameter 'path' otherwise use 'name'
  $identifier = strpos($id, 'shared/') === false ? 'name' : 'path';

  return '
  <script type="text/javascript" src="http://public.tableausoftware.com/javascripts/api/viz_v1.js"></script>
  <div class="tableauPlaceholder" style="width:' . esc_attr( $width ) . 'px; height:' . esc_attr( $height ) . 'px;">
    <object class="tableauViz" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" style="display:none;">
      <param name="host_url" value="http://public.tableausoftware.com/" />
      <param name="' . esc_attr( $identifier ) . '" value="' . esc_attr( $id ) . '" />
      <param name="tabs" value="' . esc_attr( $tabs ) . '" />
      <param name="toolbar" value="yes" />
      <param name="animate_transition" value="yes" />
      <param name="display_spinner" value="yes" />
      <param name="display_overlay" value="yes" />
      <param name="display_count" value="yes" />
    </object>
  </div>
  <div style="width:' . esc_attr( $width ) . 'px;height:22px;padding:0px 10px 0px 0px;color:black;font:normal 8pt verdana,helvetica,arial,sans-serif;">
    <div style="float:right; padding-right:8px;">
      <a href="http://www.tableausoftware.com/public?ref=' . urlencode( 'http://public.tableausoftware.com/views/' . $id ) . '" target="_blank">Powered by Tableau</a>
    </div>
  </div>';

}

add_shortcode( 'tableau', 'pd_tableau_shortcode' );

/**
 * Postmedia Scribble Live shortcode
 *
 * Generate a ScribbleLive Iframe from the scribblelive short URL found by clicking 'My Events' then clicking the name of your event, then clicking 'templates'.
 * Copy the short url and then add to your post as needed.
 * If you have created a custom template, you can also specifiy the 'Themeid' parameter which is found by looking at the 'embed section' from the page described above.
 * in this format [post-scribble url="http://scrbliv.me/123345" themeid="1234" height="300" width="460"].
 *
 *
 */

function postmedia_shortcode_scribblelive( $atts, $content = null ){

		$scribble_default = array(
		'url' => '',             // the short url from the scribble live admin area
		'themeid' => '',     	  // specify your custom themeid
		'height' => '300',		  // set the default iframe height
		'width' => '450'		  // set the default iframe width
		);

		//ensure that if the user has not specified a value for height or width or themeid, that we set the default values.
	    extract( shortcode_atts( $scribble_default, $atts ) );

		// if height and width or themeid were set in the shortcode, we need to make sure that they are numbers only, if someone enter a letter by mistake, we reset the defaults.
		$height = (int) $height;
		$themeid = (int) $themeid;
		$width = (int) $width;

		// If the url specified is not the 'short url' from scribble live, we wont return anything.
		if ( 0 === strpos( $url, 'http://scrbliv.me' ) ) {

				// Get the iID of the event from scribble live shorturl.
				$pm_scribblelive_id = preg_replace( '/http\:\/\/scrbliv\.me\//' ,'' , $url );

				//Generate the iframe source code
				$pm_scribllelive_iframe = '<iframe src="' . esc_url( 'http://embed.scribblelive.com/Embed/v5.aspx?Id=' . $pm_scribblelive_id  . '&ThemeId=' . $themeid ) . '" width="' . $width . '" height="' . $height . '" frameborder="0" style="border:0px;"></iframe>';

				return $pm_scribllelive_iframe;

		}

}
add_shortcode( 'post-scribble', 'postmedia_shortcode_scribblelive' );

function postmedia_get_image_size_dimensions( $size ) {
	global $_wp_additional_image_sizes;
	$image_sizes = get_intermediate_image_sizes();

	$key = array_search( $size, $image_sizes );

	if ( false !== $key ) {
		$s = $image_sizes[$key];
		if (isset($_wp_additional_image_sizes[$s])) {
			$width = intval($_wp_additional_image_sizes[$s]['width']);
			$height = intval($_wp_additional_image_sizes[$s]['height']);
		} else {
			$width = get_option($s.'_size_w');
			$height = get_option($s.'_size_h');
		}

		return array(
			'width' => $width,
			'height' => $height
		);
	}

	return false;
}

add_filter( 'post_thumbnail_html', 'postmedia_remove_thumbnail_dimensions', 10, 3 );
/**
 * Remove height and width from post thumbnail images
 *
 * This function is attached to the 'post_thumbnail_html' filter hook.
 *
 * @param	$html  The HTML string
 * @param	$post_id  The post ID
 * @param	$post_image_id  The thumbnail ID
 *
 * @since 1.0.0
 * @author c.bavota
 */
function postmedia_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', '', $html );
    return $html;
}

/**
 * Post Media Featured Video Markup.
 * Echoes the Featured video image for archive listing pages as well as single post page
 *
 * @param $post_id, $size
 *
 * @author jbracken
 */
function postmedia_featured_thumbnail( $post_id, $size, $url, $title, $use_size = false ){
	//setup
	$title = get_the_title( $post_id );
	$thumbnail_id = get_post_thumbnail_id( $post_id );
	$featured_video_id = get_post_meta( $post_id, 'cdc_featured_video_id', true ) ? get_post_meta( $post_id, 'cdc_featured_video_id', true ) : false;

	$output = '';
	if ( $featured_video_id != false ){
		if ( has_post_thumbnail( $post_id ) ){
			//if no ooyala video image, use featured image
			$output .= 	'<div class="video-wrap"><a href="' . $url . '" title="' . esc_attr( $title ) . '" rel="bookmark">';
			$output .= '<img src="' . get_template_directory_uri() . '/images/playbutton.png" class="video-overlay" />';
			$output .=	get_the_post_thumbnail( $post_id, $size, array( 'class' => 'alignleft' ) );
			$output .=	'</a></div>';
		} elseif ( $featured_video_image = get_post_meta( $post_id, 'cdc_featured_video_image', true ) ){
			//prefer the ooyala video image
			$featured_video_title = get_post_meta( $post_id, 'cdc_featured_video_title', true );

			$output .= '<div class="video-wrap"><a href="' . $url . '" title="' . esc_attr( $title ) . '" rel="bookmark">';
			$output .= '<img src="' . get_template_directory_uri() . '/images/playbutton.png" class="video-overlay" />';
			$output .= '<img src="' . $featured_video_image . '" class="alignleft wp-post-image" itemprop="image"  alt="' . esc_attr( $featured_video_title ) . '" /></a></div>';
		} else{
			//Seb: Added placeholder
			//if no video image or featured image
			
			//$output .= '<!-- no featured image or ooyala image set -->';
			
			$output .= '<a href="' . $url . '" title="' . esc_attr( $title ) . '" rel="bookmark">';
			$output .= "<img class='alignleft wp-post-image' src='http://placehold.it/600x600&text=Placeholder' itemprop=\"image\"  alt='" . esc_attr( $title ) . "' title='" . esc_attr( $title ) . "'/>";
			$output .= '</a>';
			
		}
	} elseif ( $post_id ){
	//Seb: If necessary find a way to wrap this so as to use $size instead of null. Also added placeholder
		if ( has_post_thumbnail( $post_id ) == false ){
			$output .= '<a href="' . $url . '" title="' . esc_attr( $title ) . '" rel="bookmark">';
			$output .= "<img class='alignleft wp-post-image' src='http://placehold.it/600x600&text=Placeholder' itemprop=\"image\" alt='" . esc_attr( $title ) . "' title='" . esc_attr( $title ) . "'/>";
			$output .= '</a>';
		}
	
		if( $use_size ) {
			if ( $thumb = pm_get_post_thumbnail( $size , $post_id ) ) {
				//it's not a video, so just use featured image based on the Custom Image Size
				$output .= '<a href="' . $url . '" title="' . esc_attr( $title ) . '" rel="bookmark">';
				$output .= "<img class='alignleft wp-post-image' src='" . esc_url( $thumb->url ) . "' itemprop=\"image\" alt='" . esc_attr( $thumb->alt ) . " Uses size' title='" . esc_attr( $thumb->title ) . "'/>";
				$output .= '</a>';
			}
			
		} else {
			if ( $thumb = pm_get_post_thumbnail( null, $post_id ) ) {
				//it's not a video, so just use featured image
				$output .= '<a href="' . $url . '" title="' . esc_attr( $title ) . '" rel="bookmark">';
				$output .= "<img class='alignleft wp-post-image' src='" . esc_url( $thumb->url ) . "' itemprop=\"image\" alt='" . esc_attr( $thumb->alt ) . "' title='" . esc_attr( $thumb->title ) . "'/>";
				$output .= '</a>';
			}
			
			
			
		}
	
	}
	return $output;
}



/**
 * Post Media Featured Image Video Markup for the Memory Project.
 * Echoes the Featured video image for archive listing pages as well as single post page
 *
 * @param $post_id, $size
 *
 * @author jbracken, srolland
 */
 function postmedia_featured_memory_thumbnail( $post_id, $size, $url, $permalink, $title, $content, $use_size = false ){
	//setup
//	$thumbnail_id = get_post_thumbnail_id( $post_id );
	//$featured_video_id = get_post_meta( $post_id, 'cdc_featured_video_id', true ) ? get_post_meta( $post_id, 'cdc_featured_video_id', true ) : false;

	$output = '';
	if ( $post_id ){
	//Seb: If necessary find a way to wrap this so as to use $size instead of null. Also added placeholder
		if ( has_post_thumbnail( $post_id ) == false ){
			$output .= '<a href="#" title="' . esc_attr( $title ) . '" data-href="' . $permalink . '" class="memory_text" rel="bookmark">';
			$output .= "<img class='alignleft wp-post-image memory_text' src='/wp-content/uploads/2014/06/Placeholder-memoryproject-textbaseditems-930x600-300x193.jpg' alt='" . esc_attr( $title ) . "' title='" . esc_attr( $title ) . "' />";
			$output .= "<span class=\"text_body\"><pre>" . $content . "</pre></span>";
			$output .= '</a>';
		}
	
		else {
			if ( $thumb = pm_get_post_thumbnail( $size , $post_id ) ) {
			
				//it's not a video, so just use featured image based on the Custom Image Size
				$output .= '<a href="' . $thumb -> url . '" title="' . esc_attr( $title ) . '" data-href="' . $permalink . '" class="memory_pic" rel="bookmark" alt="' . esc_attr( $title ) . '">';
				$output .= get_the_post_thumbnail($post_id, 'memory-project-lg');
				$output .= "<span class=\"text_body\"><pre>" . $content . "</pre></span>";
				$output .= '</a>';
			}
			
		} /*
else {
			if ( $thumb = pm_get_post_thumbnail( null, $post_id ) ) {
				//it's not a video, so just use featured image
				$output .= '<a href="' . $url . '" title="' . esc_attr( $title ) . '" class="memory_pic" rel="bookmark"  alt="' . esc_attr( $title ) . '">';
				$output .= "<img class='alignleft wp-post-image' src='" . esc_url( $thumb->url ) . "' alt='" . esc_attr( $thumb->alt ) . "' title='" . esc_attr( $thumb->title ) . "'/>";
				$output .= "<span class=\"text_body\"><pre>" . $content . "</pre></span>";
				$output .= '</a>';
			}
			
		}
*/
	
	}
	return $output;
}


//add_filter( 'parse_query', 'postmedia_parse_query' );
/**
 * Modify the query on author page
 *
 * This function is attached to the 'parse_query' filter hook.
 *
 * @param	array $query  The current page query
 *
 * @uses	is_author()
 * @uses	is_main_query()
 *
 * @since Windsor 1.0.5
 */
function postmedia_parse_query( $query ) {
	if ( ! $query->is_author() || ! $query->is_main_query() )
		return $query;

	$query->set( 'posts_per_page', 10 );
	$query->set( 'orderby', 'modified' );
	$query->set( 'tax_query', array(
		'taxonomy' => 'author',
		'term' => $query->query['author_name'],
		'field' => 'slug',
	) );

	return $query;
}

/**
 * Creates meta description from excerpt
 *
 * @since 1.0.6
 * @author c.bavota
 */
function postmedia_meta_description() {
	global $post;
	$description = strip_tags( strip_shortcodes( $post->post_content ) );
	$descrip_more = '';

	if ( strlen( $description ) > 155 ) {
		$description = substr( $description, 0, 155 );
		$descrip_more = '...';
	}

	$descripwords = preg_split( '/[\n\r\t ]+/', $description, -1, PREG_SPLIT_NO_EMPTY );
	array_pop( $descripwords );

	return esc_attr( implode( ' ', $descripwords ) . $descrip_more );
}

add_action( 'wp_head', 'postmedia_facebook_opengraph' );
/**
 * Displays Facebook Opengraph meta tags in header
 *
 * This function is attached to the 'wp_head' action hook.
 *
 * @uses	get_the_ID()  Get post ID
 * @uses	setup_postdata()  setup postdata to get the excerpt
 * @uses	wp_get_attachment_image_src()  Get thumbnail src
 * @uses	get_post_thumbnail_id  Get thumbnail ID
 * @uses	the_title()  Display the post title
 *
 * @since 1.0.6
 * @author c.bavota
 */
function postmedia_facebook_opengraph() {
	$postmedia_fb_user_id = '295961116800';
	?>
<!-- Facebook Opengraph meta tags -->
<meta property="fb:app_id" content="<?php echo esc_attr( postmedia_theme_option( 'facebook_app_id' ) ); ?>" />

<meta property="fb:admins" content="100002625504753"/>
<meta property="article:publisher" content="380186209696" />
<meta property="og:site_name" content="Postmedia's World War 1 Centenary site"/>
	<?php
	if ( is_single() ) {
		$post_id = get_the_ID();
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
	/*
	if ('video' == get_post_type($post_id)){
			if (get_post_meta( $post_id, 'cdc_featured_video_image', true )) {
				$thumbnail = array(get_post_meta( $post_id, 'cdc_featured_video_image', true ));	
			} 
		}
*/
		$thumbnail = empty( $thumbnail ) ? '' : '<meta property="og:image" content="' . esc_url( $thumbnail[0] ) . '">';
		$permalink = get_permalink( $post_id );
		?>
<meta property="og:title" content="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" />
<meta property="og:description" content="<?php echo postmedia_meta_description(); ?>"/>
<meta property="og:type" content="article" />
<meta property="og:url" content="<?php echo($permalink); ?>" />
<?php echo $thumbnail . "\n"; ?>
	<?php
	}  elseif ( is_post_type_archive('memory') ) {
		
		if( isset($_GET["mem"])){
				
				$post_id = $_GET["mem"];
				$img_id = get_post_thumbnail_id($post_id);
				$img_url = wp_get_attachment_image_src( $img_id, "memory-project-full" );
		
			?>
			
			<meta property="og:title" content="The Great War" />
			<meta property="og:description" content="Explore this and other submissions on Postmedia's Great War Memory Project. <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" />
			<meta property="og:image" content="<?php echo $img_url[0]; ?>" />
			<meta property="og:type" content="website" />
			<meta property="og:url" content="http://ww1.canada.com/" />
			<!-- Facebook Opengraph meta tags -->
			
			<meta itemprop="image" content="<?php echo $img_url[0]; ?>">
	<?php
		} else {
			?>
			
			<meta property="og:title" content="The Great War" />
			<meta property="og:description" content="Explore this and other submissions on Postmedia's Great War Memory Project. <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" />
			<meta property="og:image" content="http://ww1.staging.wpengine.com/wp-content/uploads/2014/06/Placeholder-memoryproject-textbaseditems-930x600.jpg" />
			<meta property="og:type" content="website" />
			<meta property="og:url" content="http://ww1.canada.com/" />
			<!-- Facebook Opengraph meta tags -->
			
			<meta itemprop="image" content="http://ww1.staging.wpengine.com/wp-content/uploads/2014/06/Placeholder-memoryproject-textbaseditems-930x600.jpg">
	<?php
	
		}
		
	
	
	
	} elseif ( is_home() ) {
	?>
<meta property="og:title" content="The Great War" />
<meta property="og:description" content="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" />
<meta property="og:image" content="<?php echo POSTMEDIA_THEME_URL; ?>/images/screenshot.png" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://ww1.canada.com/" />
<!-- Facebook Opengraph meta tags -->
	<?php
	}
}

add_action( 'wp_footer', 'postmedia_chartbeat' );
/**
 * Include the Chartbeat javascript
 *
 * This function is attached to the 'wp_footer' action hook.
 *
 * @uses	is_single()
 * @uses	get_the_author()
 *
 * @since Windsor 1.0.5
 */
function postmedia_chartbeat() {
	?>
<script type="text/javascript">
/* <![CDATA[ */
<!-- /// LOAD CHARTBEAT /// -->
var _sf_async_config={};

/** CONFIGURATION START **/
_sf_async_config.uid = 34988;
_sf_async_config.domain = 'postmedia.com';
_sf_async_config.sections = 'http://ww1.canada.com/';
<?php
// if single page, get_the_author to populate the chartbeat variable
if  ( is_single() )
	printf( "_sf_async_config.authors = '%s';\n", esc_js( get_the_author() ) );
?>

/** CONFIGURATION END **/
( function(){
	function loadChartbeat() {
		window._sf_endpt=(new Date()).getTime();
		var e = document.createElement('script');
		e.setAttribute('language', 'javascript');
		e.setAttribute('type', 'text/javascript');
		e.setAttribute('src',
		   (('https:' == document.location.protocol) ? 'https://a248.e.akamai.net/chartbeat.download.akamai.com/102508/' : 'http://static.chartbeat.com/') +
		   'js/chartbeat.js');
		document.body.appendChild(e);
	}
	var oldonload = window.onload;
	window.onload = (typeof window.onload != 'function') ? loadChartbeat : function() { oldonload(); loadChartbeat(); };
})();
<!-- /// END CHARTBEAT /// -->
/* ]]> */
</script>
	<?php
}

add_action( 'wp_footer', 'postmedia_google_analytics' );
/**
 *
 * Add Google Analytics to the footer
 *
 */
function postmedia_google_analytics() {
	?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26313358-10']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

	<?php
}




/*
 * Exlude zone post ids from the main query
 *
 * @uses postmedia_zone_post_ids()
 *
 * @author Vasu
 */
function postmedia_exclude_zone_posts( $query = false ) {
	if ( ! is_category() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() )
       return;

	$query->set( 'post__not_in', postmedia_zone_post_ids() );
}
add_action( 'pre_get_posts', 'postmedia_exclude_zone_posts' );

/*
 * Returns zone post ids
 *
 * @uses postmedia_check_zone_changes()
 * @uses get_transient & delete_transient
 * @uses postmedia_get_zone_posts
 *
 * @author Vasu
 */
function postmedia_zone_post_ids() {
	$cat_obj = get_queried_object();
	$slug = $cat_obj->slug;
	$name = $cat_obj->name;

	postmedia_check_zone_changes( $name );

	if ( false === ( $zone_post_ids = get_transient( $name . '_zone_post_ids'  ) ) ) {

		//Check if zoninator plugin exists or enabled in functions.php
		if( class_exists( 'Zoninator' ) ) {

			//Get all zones
			$all_zones = ( function_exists( 'z_get_zones' ) ) ? z_get_zones() : array();

			//Check if there any any zones created
			if( ! empty( $all_zones ) ) {

				foreach( $all_zones as $zone ) {

					$zone_name = strtolower( $zone->name );
					$zone_slug = $zone->slug;
					$zone_id = (int)$zone->term_id;

					//Check if the category name and zone name matches || Check if category slug and zone slug matches
					if( ( strcmp( strtolower( $name ), $zone_name ) == 0 ) || ( strcmp( $slug, $zone_slug ) == 0 ) ) {

						//Get zone post ids
						$zone_post_ids = postmedia_get_zone_posts( $zone_id, 'zone_ids' );

						//Check if zone has any posts
						if( ! empty( $zone_post_ids ) ) {

							//Save zone id in the transient for checking the count
							set_transient( $name . '_zone_id', $zone_id );

							//Save zone post ids for the cateory in a transient
							set_transient( $name . '_zone_post_ids', $zone_post_ids );
						}
					}
				}
			}
		}
	}

	return $zone_post_ids;
}


/*
 * Returns zone posts or ids based on the return variable
 *
 * @uses z_get_posts_in_zone()
 *
 * @author Vasu
 */
function postmedia_get_zone_posts( $zone_id, $return ) {

	$zone_posts = ( function_exists( 'z_get_posts_in_zone' ) ) ? z_get_posts_in_zone( $zone_id ) : array();

	//Check if zone has any posts
	if( ! empty( $zone_posts ) ) {

		foreach ( $zone_posts as $zone_post ) {

			$zone_ids[] = (int)$zone_post->ID;
		}
	}

	switch( $return ) {
		case 'zone_posts':
			$zone_data = ( empty( $zone_posts ) ) ? array() : $zone_posts;
		break;

		case 'zone_ids':
			$zone_data = ( empty( $zone_ids ) ) ? array() : $zone_ids;
		break;

		default:
			$zone_data = ( empty( $zone_ids ) ) ? array() : $zone_ids;
	}

	return $zone_data;
}

/*
 * Checks to see if there is any change in the zone, comparing the zone count with the transient count
 *
 * @uses postmedia_get_zone_posts()
 * @uses get_transient & delete_transient
 *
 * @author Vasu
 */
function postmedia_check_zone_changes( $name ) {

	if( false !== ( $zone_id = get_transient ( $name . '_zone_id' ) ) ) {

		$zone_ids = postmedia_get_zone_posts( (int)$zone_id, 'zone_ids' );

		if( count( $zone_ids ) != count ( get_transient( $name . '_zone_post_ids' ) ) )
		{
			delete_transient( $name . '_zone_post_ids' );
		}
		else {
			set_transient( $name . '_zone_post_ids', $zone_ids );
		}
	}
}

/*
 * Display zone posts
 *
 * @uses get_transient
 *
 * @author Vasu
 */
function postmedia_display_zone_posts() {
	$cat_obj = get_queried_object();

	if ( false !== ( $zone_post_ids = get_transient( $cat_obj->name . '_zone_post_ids'  ) ) ) {

		if( ! empty( $zone_post_ids ) ) {

			//WP_query - Array of parameters
			$args = array(
				'post__in' => $zone_post_ids,
				'orderby' => 'post__in'
			);

			//Creating new query to put zone posts first in the list
			$zone_query = new WP_Query( $args );

			if ( $zone_query->have_posts() ) {

				while( $zone_query->have_posts() ) : $zone_query->the_post();

					get_template_part( 'content' , get_post_format() );

				endwhile;
			}
		}
	}
}

/*
 * Display zone posts
 *
 * @uses get_transient
 *
 * @author Vasu
 */
function postmedia_zone_posts_rss2( ) {

	if( is_feed('rss2') ) {

	$cat_obj = get_queried_object();

	if ( false !== ( $zone_post_ids = get_transient( $cat_obj->name . '_zone_post_ids'  ) ) ) {

		if( ! empty( $zone_post_ids ) ) {

			//WP_query - Array of parameters
			$args = array(
				'post__in' => $zone_post_ids,
				'orderby' => 'post__in'
			);

			//Creating new query to put zone posts first in the list
			$zone_query = new WP_Query( $args );

			if ( $zone_query->have_posts() ) {

				while( $zone_query->have_posts() ) : $zone_query->the_post();

				$z_post_id = get_the_ID();

				$content = get_the_content_feed('rss2');
				$rss_title = get_the_title_rss();

				?>

					<item>

						<title><![CDATA[ <?php echo html_entity_decode($rss_title, ENT_COMPAT, 'utf-8'); ?>]]></title>
						<link><?php the_permalink();?></link>
						<comments></comments>
						<pubDate><?php echo get_post_time('Y-m-d\TH:i:s\Z', true); ?></pubDate>
						<dc:creator><?php get_the_author(); ?></dc:creator>
				<?php the_category_rss(); ?>
						<guid isPermalink="false"><?php the_guid(); ?></guid>
						<description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
						<content:encoded><![CDATA[<?php echo $content; ?>]]></content:encoded>
				<?php

						if ( has_post_thumbnail( $z_post_id  ) ) {

							$thumbnail_id = get_post_thumbnail_id( $z_post_id );
							$images[] = postmedia_the_media_element_rss2( $thumbnail_id );

						}

				?>
					</item>

					<?php

				endwhile;
			}
		}
	}

	}

}
add_action( 'rss2_head',  'postmedia_zone_posts_rss2' );


/**
 * Sets up cache for the menu 
 * Sebastien
 */


function pm_get_menu( $which_menu )
{
    $menu = get_transient( 'pm_menus_'. $which_menu );
 
    if (false === $menu) {
    	// parameter 'echo' => 0  will return the menu instead of echoing it
		$menu = wp_nav_menu( array( 'theme_location' => $which_menu, 'container' => '', 'items_wrap' => '%3$s',  'echo' => 0 ) )	;
		
        set_transient('pm_menus_'. $which_menu, $menu, 60*30);
    } 
	
    return $menu;
}

function pm_update_menu()
{
    delete_transient('pm_menus_primary');
    delete_transient('pm_menus_mobile-footer');
}
 
add_action( 'wp_update_nav_menu', 'pm_update_menu' );



/**
 * Sets up cascade for post category/taxonomy labels: Event > Category 
 * Sebastien
 */

function postmedia_get_label( $post_id, $custom_taxonomy , $return_value = false  ) {
		
	
	$label_key = "label_" . $post_id;
	
	$get_transient = get_transient( $label_key );
	
	if( ! empty( $get_transient ) ) {
	       $label = $get_transient;
	}
	else {	
		  
		$events = get_the_terms( $post_id, $custom_taxonomy );
						
		if ( $events && ! is_wp_error( $events ) ) { 
				
			$event_labels = array();
						
			$event_slugs = array();
	
			foreach ( $events as $event ) {
				$event_labels[] = $event->name;
				$event_slugs[] = $event->slug;
			}
				
			$label = array(
				"value" => $event_labels[0],
    			"link" => "<a href=\"" . get_site_url() . "/events/" . $event_slugs[0] .  "\" >" . $event_labels[0] ."</a>",
			);
		}	
		else { 
			$category = get_the_category(); 
			// Get the URL of this category
			$category_link = get_category_link( $category[0]->cat_ID );
			
			$label = array(
				"value" => $category[0]->cat_name,
    			"link" => "<a href=\"" . $category_link . "\" >" . $category[0]->cat_name ."</a>",
			);
			
		}  
		    
		set_transient( $label_key, $label, 30 * 60 );
	}
	if ( $return_value ) {
		return $label["value"];
	} else {
		echo $label["link"];	
	}

}				
		


/*
 * Adds credit and distributor fields for images
 *
 * @uses drv_add_image_fields() Adds credit and distributor fields to images
 * @uses drv_save_image_fields() Saves credit and distributor fields for images
 * @uses get_post_meta()
 *
 * @since 1.0.0
 */
	
function drv_add_image_fields( $form_fields, $post ) {
    //$field_credit_value = get_post_meta( $post->ID, 'drv_attachment_credit', true );
	$field_distributor_value = get_post_meta( $post->ID, 'drv_attachment_distributor', true );
   /*
 $form_fields['drv_attachment_credit'] = array(
        'value' => $field_credit_value ? $field_credit_value : '',
        'label' => __( 'Credit' ),
		'input' => 'text'
    );
*/
	$form_fields['drv_attachment_distributor'] = array(
        'value' => $field_distributor_value ? $field_distributor_value : '',
        'label' => __( 'Distributor' ),
		'input' => 'text'
    );
    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'drv_add_image_fields', 10, 2 );

function drv_save_image_fields( $post, $attachment ) {
	/*
if ( ! empty( $attachment['drv_attachment_credit'] ) )
        update_post_meta( $post['ID'], 'drv_attachment_credit', sanitize_text_field( $attachment['drv_attachment_credit'] ) );
    else
		delete_post_meta( $post['ID'], 'drv_attachment_credit' );
*/
	
    if ( ! empty( $attachment['drv_attachment_distributor'] ) )
        update_post_meta( $post['ID'], 'drv_attachment_distributor', sanitize_text_field( $attachment['drv_attachment_distributor'] ) );
	else
		delete_post_meta( $post['ID'], 'drv_attachment_distributor' );
	
	return $post;
}
add_action( 'attachment_fields_to_save', 'drv_save_image_fields', 10, 2 );




/*
 * Override caption shortcode to return credit and distributor
 *
 * @since 1.0.0
 *
 */

add_filter('img_caption_shortcode', 'drv_img_caption',10,3);

function drv_img_caption($val, $attr, $content = null)
{
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> '',
		'width'	=> '',
		'caption' => ''
	), $attr));
	
	if ( 1 > (int) $width || empty($caption) )
		return $val;

	$capid = '';
	if ( $id ) {
		$id = str_replace( "attachment_", "", $id );
		$capid = 'id="attachment'. esc_attr( $id ) . '" ';
		$idtext = 'id="' . esc_attr( $id ) . '" ';
		$credit = get_post_meta( $id, '_pm_attachment_credit', true );
		$distributor = get_post_meta( $id, 'drv_attachment_distributor', true );
	}

	$img_caption = '<div ' . $idtext . 'class="wp-caption ' . esc_attr($align) . '">' . do_shortcode( wp_kses_post( $content ) ) . '<p ' . $capid 
	. 'class="wp-caption-text">' . wp_kses_post( $caption ) . '<br />' . esc_html( $credit . ', ' . $distributor ) . '</p></div>';
	
	return $img_caption;
}


				

//Seb: increase number of posts per archive page

function limit_posts_per_archive_page() {
	
	if ( ! is_admin() ) {
	
		/*
if ( is_category() || is_archive() )
			set_query_var('posts_per_archive_page', 7);
*/ // or use variable key: posts_per_page
			
		if ( is_archive() && is_post_type_archive('memory') )
			set_query_var('posts_per_archive_page', 20); // or use variable key: posts_per_page	
	}
}
add_filter('pre_get_posts', 'limit_posts_per_archive_page');


// Hide Email from Spam Bots using a short code place this in your functions file

function HideMail($atts , $content = null ){
	if ( ! is_email ($content) )
		return;

	return '<a href="mailto:'.antispambot($content).'">'.antispambot($content).'</a>';
}
add_shortcode( 'email','HideMail');



/**
 * Displays the Promo Ad Code, Override setting from them options page or turn this ad slot off.
 */

function postmedia_promo_ad_override(){

	$options = get_option( 'postmedia_theme_options' );

	$promo_ad_output =  '<div class="nav-promo target-self">
				<div id="div-dart-ad-promo" class="ad" data-mobile="false">';

	$adcode_setting = $options['promo_ad_options'];

	if ( $options['promo_ad_options'] == 'Override' ){

		$promo_image = $options['promo_ad_creative'];
		$promo_link = $options['promo_ad_link'];

		$promo_ad_output .= '<a href="'. $promo_link .'"><img src="'. $promo_image .'" /></a>';

	} elseif ( $options['promo_ad_options'] == 'Dart' ) {

		$promo_ad_output .= '<script type="text/javascript">
		Postmedia.AdServer.Write({
			id:"div-dart-ad-promo",
			size:[[960,42]],
			keys:{ "dcopt" : "ist", "loc": "top" },
			mobile: false
		});
		</script>';

	} else{

		return;

	}

	$promo_ad_output .= '</div></div>';

	return $promo_ad_output;

}

/**
 * get weather timbit, change image src
 */

function postmedia_weather_timbit( $s_region = 'ON', $s_city = 'Windsor', $s_icon_size = 'small' ) {

	$a_icon_sizes = array(
		'small' => '26x22',
		'medium' => '51x44'
	);

	// sanitize
	$a_params = array(
		'region' => sanitize_title( $s_region ),
		'city' => sanitize_title( $s_city )
	);
	$s_icon_size = array_key_exists( $s_icon_size, $a_icon_sizes ) ? $s_icon_size : 'small';

	$s_img_path = POSTMEDIA_THEME_URL . '/images/weather/' . $s_icon_size . '/';
	$s_url = 'http://tb-general.canada.com/weather/?'. http_build_query( $a_params );

	if ( $s_html = wpcom_vip_file_get_contents( $s_url ) ) {

		// update image src
		$s_html = preg_replace( '/(?<=src=)("|\')[^\1]+?\/([^\/\1]+)\-\d+x\d+(\.[a-z]+)\1/', '$1' . $s_img_path . '$2-' . $a_icon_sizes[ $s_icon_size ]  . '$3$1', $s_html );

		return $s_html;

	}
}


/*****
* Memory Custom Post Type 
*/ 


function memory_post_type() {

	$labels = array(
		'name'                => _x( 'Memories', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Memory', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Memories', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Alert:', 'text_domain' ),
		'all_items'           => __( 'All Memories', 'text_domain' ),
		'view_item'           => __( 'View Memory', 'text_domain' ),
		'add_new_item'        => __( 'Add New Memory', 'text_domain' ),
		'add_new'             => __( 'New Memory', 'text_domain' ),
		'edit_item'           => __( 'Edit Memory', 'text_domain' ),
		'update_item'         => __( 'Update Memory', 'text_domain' ),
		'search_items'        => __( 'Search memories', 'text_domain' ),
		'not_found'           => __( 'No memories found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No memories found in Trash', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                => 'memory-project',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true
	);
	$args = array(
		'label'               => __( 'memory', 'text_domain' ),
		'description'         => __( 'Memories are the items that make up the Memory Project', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array('title','author','editor', 'custom-fields', 'thumbnail', 'comments' ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'post',
	);
	register_post_type( 'memory', $args );

}

// Hook into the 'init' action
add_action( 'init', 'memory_post_type', 0 );






function pm_custom_post_icon_styles() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-video .wp-menu-image {
            background: url(<?php echo admin_url() ?>/images/post-formats.png) no-repeat 6px -122px !important;
        }
        #menu-posts-video:hover .wp-menu-image, #menu-posts-video.wp-has-current-submenu .wp-menu-image {
            background-position: 0 -255px;
        }
        
        #icon-edit.icon32-posts-video { background: url(<?php echo admin_url() ?>/images/post-formats32.png) no-repeat 0 -126px !important; }
        
        #menu-posts-gallery .wp-menu-image {
            background: url(<?php echo admin_url() ?>/images/post-formats.png) no-repeat 6px -58px !important;
        }
        #menu-posts-gallery:hover .wp-menu-image, #menu-posts-gallery.wp-has-current-submenu .wp-menu-image {
            background-position: 0 -64px;
        }
        
        #icon-edit.icon32-posts-gallery { background: url(<?php echo admin_url() ?>/images/post-formats32.png) no-repeat 0 -126px !important; }
        
               
    </style>
<?php }

// Styling for the custom post type icon
add_action( 'admin_head', 'pm_custom_post_icon_styles' );


// Modified Gallery Shortcode

add_filter("post_gallery", "sochi_post_gallery",10000,2);
function sochi_post_gallery($output, $attr) {
    global $post, $wp_locale;

    static $instance = 0;
    $instance++;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 1,
		'size'       => 'index-large',
		'include'    => '',
		'exclude'    => '',
		'link'		 => 'file'
	), $attr, 'gallery'));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$icontag = tag_escape($icontag);
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) )
		$itemtag = 'dl';
	if ( ! isset( $valid_tags[ $captiontag ] ) )
		$captiontag = 'dd';
	if ( ! isset( $valid_tags[ $icontag ] ) )
		$icontag = 'dt';

	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', true ) )
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>";
	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] )
			$image_output = wp_get_attachment_link( $id, $size, false, false );
		elseif ( ! empty( $attr['link'] ) && 'none' === $attr['link'] )
			$image_output = wp_get_attachment_image( $id, $size, false );
		else
			$image_output = wp_get_attachment_link( $id, $size, true, false );

		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) )
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />';
	}

	$output .= "
			<br style='clear: both;' />
		</div>\n";

	return $output;
}

/*
 * Closes comments on individual photos in carrousel
 *
 */
function filter_media_comment_status( $open, $post_id ) {
	$post = get_post( $post_id );
	if( $post->post_type == 'attachment' ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10000 , 2 );


/*
 * Default category for custom post types
 *
 * @author Sebastien
 */

function set_default_category($post_ID) {
	global $wpdb;
	$args = array(
		'orderby' => 'name'
  	);
  	$all_catgories = array();
	$categories = get_categories( $args );
	foreach ( $categories as $category ) {
		 array_push( $all_catgories, $category->name );
	} 	
	if(!wp_is_post_revision($post_ID)) {
		if ( in_category($all_catgories) == false ) {
			$default_cat = array (1);
			wp_set_object_terms( $post_ID, $default_cat, 'category');
		}
	}
}
add_action('publish_gallery', 'set_default_category');

add_action('publish_video', 'set_default_category');

/*
 * Changes the ajaxurl for the liveblog plugin to Site URL in General settings
 *
 * @author Sebastien
 */
 
function pm_update_liveblog_ajaxurl(){
	global $post;
	$post_id = get_the_ID();
	//First find out if the post is a liveblog post or not
	if ( class_exists( 'WPCOM_Liveblog' ) ){
		if ( WPCOM_Liveblog::is_liveblog_post( $post_id ) ){
			//Set the ajaxurl of the liveblog plugin uploader to use get_site_url escped for JSON
			$new_url = addcslashes ( get_home_url() , "/" );
			echo "<script>_wpPluploadSettings.defaults.url = \"" . $new_url . "\/wp-admin\/admin-ajax.php\";</script>";
		}
	}	
}

add_action('get_template_part_content', 'pm_update_liveblog_ajaxurl');


/*
 * Create meta tag information for twitter card generation
 *
 * @author vasu
 *
 **/
function get_twitter_card () {
	global $post;

	if ( is_single() ) {

		$twitter_card = array();

		$twitter_card['post_url'] = get_permalink( $post->ID );
		$twitter_card['post_title'] = $post->post_title;
		$twitter_card['post_excerpt'] = trim( $post->post_excerpt );
		if( empty( $twitter_card['post_excerpt'] ) ) {
			$new_excerpt = substr( $post->post_content, 0, 150). "[...]";
			$twitter_card['post_excerpt'] = trim( $new_excerpt );	
		}

		$twitter_card['author_id'] = $post->post_author;
		$twitter_card['author_email'] = get_the_author_meta( 'user_email', $twitter_card['author_id'] );

		$twitter_card['post_image'] = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

		$twitter_card['creator'] = '@canadadotcom';

		//Get social information
		$twitter_card_social = drv_get_author_gravatar_data( $twitter_card['author_email'] );

		//Get user gravatar profile
		$profile = wpcom_vip_get_user_profile( $twitter_card['author_email'] );

		if ( ! empty( $profile ) ) {
			if( empty( $twitter_card['post_image'] ) ) {
				if( ! empty ( $profile['thumbnailUrl'] ) ) {
					$twitter_card[ 'post_image' ] = $profile['thumbnailUrl'];
				}
			}
		}

		if( ! empty( $twitter_card_social ) ) {
			if ( ! empty( $twitter_card_social['social']['twitter'] ) ) {
				$twitter_card['creator'] = $twitter_card_social['social']['twitter-display'];
			}
		}

		if( ! empty( $twitter_card ) ) { ?>
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@canadadotcom">

		<?php if( ! empty( $twitter_card['creator'] ) ) { ?>
		<meta name="twitter:creator" content="<?php echo esc_attr( $twitter_card['creator'] ); ?>">
		<?php } ?>

		<?php if( ! empty( $twitter_card['post_url'] ) ) { ?>
		<meta name="twitter:url" content="<?php echo esc_url( $twitter_card['post_url'] ); ?>">
		<?php } ?>

		<?php if( ! empty( $twitter_card['post_title'] ) ) { ?>
		<meta name="twitter:title" content="<?php echo esc_attr( $twitter_card['post_title'] ); ?>">
		<?php } ?>

		<?php if( ! empty( $twitter_card['post_excerpt'] ) ) { ?>
		<meta name="twitter:description" content="<?php echo esc_attr( $twitter_card['post_excerpt'] ); ?>">
		<?php } ?>
		
		<?php if( ! empty( $twitter_card['post_image'] ) ) { ?>
		<meta name="twitter:image" content="<?php echo esc_url( $twitter_card['post_image'] ); ?>">
		<?php }
		}
	}
}

add_action( 'wp_head', 'get_twitter_card' );


/**
 * Creating a custom Wordpress-style RSS2 feed using chartbeat metrics.  
 */

function pm_chartbeat_wordpress_feed () {
load_template( TEMPLATEPATH . '/feeds/chartbeat-wordpress-feed.php');
}
add_feed( 'feed/pm-chartbeat-feed',  'pm_chartbeat_wordpress_feed' );

/**
 * Creating a custom Wordpress-style RSS2 feed for curated stories.  
 */
function pm_curated_wordpress_feed () {
load_template( TEMPLATEPATH . '/feeds/curated-wordpress-feed.php');
}

add_feed( 'feed/pm-curated-feed',  'pm_curated_wordpress_feed' );



/**
 * Switches the Regular post title with the "homepage headline" (cdc_discussion_headline)
 *
 *	@author srolland
 **/
add_filter( 'the_title_rss', 'pm_rss_headlines' );

function pm_rss_headlines ( $title ) {
	global $post;
	$post_id = $post->ID;
	
	if ( is_feed('feed/pm-curated-feed') || is_feed('feed/pm-chartbeat-feed') ) {
		$short_title = get_post_meta( $post_id, 'cdc_discussion_headline', true );
		if ( !empty($short_title) ){  
			$title = $short_title;  
		} 
	}
	return $title;	
}



/*
 * Add media support to RSS (Thumnails, enclosures)
 *
 * @uses rss2_ns
 *
 * @author Sebastien
 */
add_filter( 'rss2_ns', 'mrss_namespace' );
 
function mrss_namespace() {
    echo 'xmlns:media="http://search.yahoo.com/mrss/"';
}

add_action('rss2_item', 'mrss_post_thumbnail');

function mrss_post_thumbnail() {
	global $post;
	if(has_post_thumbnail($post->ID)) {
		//$thumb = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
		$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'index-small'); 
		if ($thumb){
			//echo "	<media:content medium=\"image\"  url=\"" . $thumb[0] . "\"/>\n	";	
			echo "<enclosure url=\"" . $thumb[0] . "\" type=\"image/jpeg\" />";
		}
		
	}
}



/*
 * Remove enclosures from Video custom post type
 *
 * @uses rss_enclosure
 *
 * @author Sebastien
 */
 
 function remove_video_enclosures(){
 	if ( 'video' == get_post_type() ) {
    	return '';
    }
}

add_filter( 'rss_enclosure', 'remove_video_enclosures' );




/*
 * Facebook like button - shortcode, admin edit button
 */

add_shortcode('pn_facebook_like', 'postmedia_facebook_like_button');
function postmedia_facebook_like_button($a_attr) {

	$a_attr = shortcode_atts(array(
		'class' => 'pnFacebookLikeBtn',
		'label' => 'Find Postmedia\'s World War 1 Centenary site on Facebook',
		'user' => 'canada.com'
	), $a_attr);

	ob_start()
	?><a href="<?php echo esc_url('http://www.facebook.com/'.$a_attr['user']); ?>" rel="external" target="_blank"<?php echo !empty($a_attr['class']) ? ' class="'.sanitize_html_class($a_attr['class']).'"' : NULL; ?>><?php echo esc_html(sanitize_text_field($a_attr['label'])); ?></a><?php
	return ob_get_clean();
}

add_action('admin_print_scripts', 'postmedia_facebook_like_admin_js', 99);
function postmedia_facebook_like_admin_js() {
	global $pagenow;
	if (preg_match('/^post(\-new)?\.php$/', $pagenow)) {
		?><script type="text/javascript">
			edButtons[edButtons.length] = new edButton('pnFacebookLikeButton', 'Facebook Like button', '\n[pn_facebook_like /]\n');
		</script><?php
	}
}



/**
 * BREAKING NEWS Feature
 *
 * Add label="Keyword" so that southparc can pickup breaking news and traffic watch.
 *
 * Each post that need to be considered a part of the home page breaking news or traffic watch needs two tags.
 * 'reserved' is mandiatory as we will be using the http://blogs.windsorstar.com/tag/reserved/feed/atom
 * then add either BreakingNews or TrafficWatch additionally and it will appear in order of descending modified post date
 *
 * @author jayabrack
 *
 */
add_action( 'atom_entry', 'pm_southparc_keyword_label', 1 );

function pm_southparc_keyword_label( $type = 'atom' ) {

	$tags = get_the_tags();
	$the_list = '';
	$tag_names = array();
	$filter = 'rss';

	if ( !empty($tags) ) foreach ( (array) $tags as $tag ) {

		$tag_names[] = sanitize_term_field('name', $tag->name, $tag->term_id, 'post_tag', $filter);

	}

	$tag_names = array_unique($tag_names);

	foreach ( $tag_names as $tag_name ) {

		$the_list .= sprintf( "\n\t\t\t\t" . '<category  term="%2$s" label="Keyword"/>', esc_attr( apply_filters( 'get_bloginfo_rss', get_bloginfo( 'url' ) ) ), esc_attr( $tag_name ) );

	}
  
	echo  "\n\n". $the_list . "\n\n";

}

//removing query string from <image:loc> element
add_filter( 'wpcom_sitemap_news_sitemap_item', 'pm_image_filter_news_sitemap_query_string', 10, 2 );
function pm_image_filter_news_sitemap_query_string( $item, $post ) {

	// there is always a better way to remove query args from a string !
	$item['image:image']['image:loc'] = remove_query_arg( 'w', $item['image:image']['image:loc'] );
    return $item;

}


add_action( 'wp_footer', 'pm_add_comscore_tags' );

function pm_add_comscore_tags() {
/**
 * Add comscore tags to the footer
 */
?>

<!-- Begin comScore Tag -->

	<script>
		var _comscore = _comscore || [];
		_comscore.push({ c1: "2", c2: "10276888" });
		(function() {
			var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;
			s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
			el.parentNode.insertBefore(s, el);
		})();
	</script>
	<noscript>
  		<img src="http://b.scorecardresearch.com/p?c1=2&c2=10276888&cv=2.0&cj=1" />
  	</noscript>

<!-- End comScore Tag -->


<?php

}


/**
 * Removes Jet Pack's Facebook Opengraph meta tags in header
 *
 * This function is attached to the 'jetpack_enable_open_graph' action hook.
 **/
 
add_filter( 'jetpack_enable_open_graph', '__return_false', 99 );
remove_action( 'wp_head', 'jetpack_og_tags' );



/**
 * Load WP Admin JS functions
 */
function pm_load_admin_js( $hook ) {
	if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
		//wp_enqueue_script( 'pm_wp_admin_post', get_template_directory_uri() . '/js/pm_wp_admin_post.js' );
	}
}
add_action( 'admin_enqueue_scripts', 'pm_load_admin_js' );


/**
 * Register Tinymce plugins
 */
function pm_register_timymce_plugins() {
   	if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) ) {
		add_filter( "mce_external_plugins", "pm_add_tinymce_plugins" );
   	}
}
 
function pm_add_tinymce_plugins( $plugin_array ) {
   $plugin_array['wpeditimage'] = POSTMEDIA_THEME_URL . '/js/plugins/pm-wpeditimage/editor_plugin.js';
   
   return $plugin_array;
}
add_action('admin_init', 'pm_register_timymce_plugins');



// Disable WP 3.6 Post format UI
add_filter( 'enable_post_format_ui', '__return_false');





/*
 * Custom image urls based on the host
 */
$cdn_host = 'www.canada.com/olympics';
//cdn_load_media( $cdn_host );
/**
 * Load image files from our CDN
 */
function cdn_load_media( $cdn_host_media ) {
	
	$current_host_media = 'pdsochi.staging.wpengine.com';

	add_filter( 'wp_get_attachment_url', function( $url, $attachment_id ) use ( $cdn_host_media ) {
		if ( !is_feed() ) { return custom_cdn_replace( $url, $cdn_host_media ); } else { return $url; }
	}, 999, 2 );

	add_filter( 'the_content', function( $content ) use ( $current_host_media, $cdn_host_media ) {
		
			$content = preg_replace_callback( '#(https?://' . preg_quote( $current_host_media ) . '[^\s\'">]+)#', function( $matches ) use ( $cdn_host_media ) {
				return custom_cdn_replace( $matches[1], $cdn_host_media );
			}, $content );
		
		return $content;
	}, 999 );
}


/**
 * Replace the hostname in a URL
 * 
 * @param string $url Original URL
 * @param string $cdn_host Replacement hostname
 * @return string Updated URL
 */
function custom_cdn_replace( $url, $cdn_host ) {
	return preg_replace( '|://[^/]+?/|', "://$cdn_host/", $url );
}

// Change post preview button url 

function update_preview_link() {
    $slug = basename(get_permalink());
    $new_domain = 'http://wpmedia-games.canada.com/';
    $preview_url = "$new_domain$slug&preview=true";
    return "$preview_url";
}
//add_filter( 'preview_post_link', 'update_preview_link' );


function pm_unbind_post_preview_link($hook){
	if( $hook == 'post-new.php' ){
		wp_enqueue_script( 'pm-unbind-link', POSTMEDIA_THEME_URL .'/js/pm-unbind-preview-link.js', array( 'jquery' ), '1', true);
	}
}

//add_action('admin_enqueue_scripts','pm_unbind_post_preview_link' ); 


/**
 * Fetch a remote URL and cache the result for a certain period of time.
 *
 * This function originally used file_get_contents(), hence the function name.
 * While it no longer does, it still operates the same as the basic PHP function.
 *
 * We strongly recommend not using a $timeout value of more than 3 seconds as this
 * function makes blocking requests (stops page generation and waits for the response).
 * 
 * The $extra_args are:
 *  * obey_cache_control_header: uses the "cache-control" "max-age" value if greater than $cache_time.
 *  * http_api_args: see http://codex.wordpress.org/Function_API/wp_remote_get
 *
 * @link http://lobby.vip.wordpress.com/best-practices/fetching-remote-data/ Fetching Remote Data
 * @param string $url URL to fetch
 * @param int $timeout Optional. The timeout limit in seconds; valid values are 1-10. Defaults to 3.
 * @param int $cache_time Optional. The minimum cache time in seconds. Valid values are >= 60. Defaults to 900.
 * @param array $extra_args Optional. Advanced arguments: "obey_cache_control_header" and "http_api_args".
 * @return string The remote file's contents (cached)
 */
function wpcom_vip_file_get_contents( $url, $timeout = 3, $cache_time = 900, $extra_args = array() ) {
	global $blog_id;

	$extra_args_defaults = array(
		'obey_cache_control_header' => true, // Uses the "cache-control" "max-age" value if greater than $cache_time
		'http_api_args' => array(), // See http://codex.wordpress.org/Function_API/wp_remote_get
	);

	$extra_args = wp_parse_args( $extra_args, $extra_args_defaults );

	$cache_key       = md5( serialize( array_merge( $extra_args, array( 'url' => $url ) ) ) );
	$backup_key      = $cache_key . '_backup';
	$disable_get_key = $cache_key . '_disable';
	$cache_group     = 'wpcom_vip_file_get_contents';

	// Temporary legacy keys to prevent mass cache misses during our key switch
	$old_cache_key       = md5( $url );
	$old_backup_key      = 'backup:' . $old_cache_key;
	$old_disable_get_key = 'disable:' . $old_cache_key;

	// Let's see if we have an existing cache already
	// Empty strings are okay, false means no cache
	if ( false !== $cache = wp_cache_get( $cache_key, $cache_group) )
		return $cache;

	// Legacy
	if ( false !== $cache = wp_cache_get( $old_cache_key, $cache_group) )
		return $cache;

	// The timeout can be 1 to 10 seconds, we strongly recommend no more than 3 seconds
	$timeout = min( 10, max( 1, (int) $timeout ) );

	if ( $timeout > 3 )
		_doing_it_wrong( __FUNCTION__, 'Using a timeout value of over 3 seconds is strongly discouraged because users have to wait for the remote request to finish before the rest of their page loads.', null );

	$server_up = true;
	$response = false;
	$content = false;

	// Check to see if previous attempts have failed
	if ( false !== wp_cache_get( $disable_get_key, $cache_group ) ) {
		$server_up = false;
	}
	// Legacy
	elseif ( false !== wp_cache_get( $old_disable_get_key, $cache_group ) ) {
		$server_up = false;
	}
	// Otherwise make the remote request
	else {
		$http_api_args = (array) $extra_args['http_api_args'];
		$http_api_args['timeout'] = $timeout;
		$response = wp_remote_get( $url, $http_api_args );
	}

	// Was the request successful?
	if ( $server_up && ! is_wp_error( $response ) && 200 == wp_remote_retrieve_response_code( $response ) ) {
		$content = wp_remote_retrieve_body( $response );

		$cache_header = wp_remote_retrieve_header( $response, 'cache-control' );
		if ( is_array( $cache_header ) )
			$cache_header = array_shift( $cache_header );

		// Obey the cache time header unless an arg is passed saying not to
		if ( $extra_args['obey_cache_control_header'] && $cache_header ) {
			$cache_header = trim( $cache_header );
			// When multiple cache-control directives are returned, they are comma separated
			foreach ( explode( ',', $cache_header ) as $cache_control ) {
				// In this scenario, only look for the max-age directive
				if( 'max-age' == substr( trim( $cache_control ), 0, 7 ) )
					// Note the array_pad() call prevents 'undefined offset' notices when explode() returns less than 2 results
					list( $cache_header_type, $cache_header_time ) = array_pad( explode( '=', trim( $cache_control ), 2 ), 2, null );
			}
			// If the max-age directive was found and had a value set that is greater than our cache time
			if ( isset( $cache_header_type ) && isset( $cache_header_time ) && $cache_header_time > $cache_time )
				$cache_time = (int) $cache_header_time; // Casting to an int will strip "must-revalidate", etc.
		}

		// The cache time shouldn't be less than a minute
		// Please try and keep this as high as possible though
		// It'll make your site faster if you do
		$cache_time = (int) $cache_time;
		if ( $cache_time < 60 )
			$cache_time = 60;

		// Cache the result
		wp_cache_set( $cache_key, $content, $cache_group, $cache_time );

		// Additionally cache the result with no expiry as a backup content source
		wp_cache_set( $backup_key, $content, $cache_group );

		// So we can hook in other places and do stuff
		do_action( 'wpcom_vip_remote_request_success', $url, $response );
	}
	// Okay, it wasn't successful. Perhaps we have a backup result from earlier.
	elseif ( $content = wp_cache_get( $backup_key, $cache_group ) ) {
		// If a remote request failed, log why it did
		if ( $response && ! is_wp_error( $response ) ) {
			error_log( "wpcom_vip_file_get_contents: Blog ID {$blog_id}: Failure for $url and the result was: " . maybe_serialize( $response['headers'] ) . ' ' . maybe_serialize( $response['response'] ) );
		} elseif ( $response ) { // is WP_Error object
			error_log( "wpcom_vip_file_get_contents: Blog ID {$blog_id}: Failure for $url and the result was: " . maybe_serialize( $response ) );
		}
	}
	// Legacy
	elseif ( $content = wp_cache_get( $old_backup_key, $cache_group ) ) {
		// If a remote request failed, log why it did
		if ( $response && ! is_wp_error( $response ) ) {
			error_log( "wpcom_vip_file_get_contents: Blog ID {$blog_id}: Failure for $url and the result was: " . maybe_serialize( $response['headers'] ) . ' ' . maybe_serialize( $response['response'] ) );
		} elseif ( $response ) { // is WP_Error object
			error_log( "wpcom_vip_file_get_contents: Blog ID {$blog_id}: Failure for $url and the result was: " . maybe_serialize( $response ) );
		}
	}
	// We were unable to fetch any content, so don't try again for another 60 seconds
	elseif ( $response ) {
		wp_cache_set( $disable_get_key, 1, $cache_group, 60 );

		// If a remote request failed, log why it did
		if ( $response && ! is_wp_error( $response ) ) {
			error_log( "wpcom_vip_file_get_contents: Blog ID {$blog_id}: Failure for $url and the result was: " . maybe_serialize( $response['headers'] ) . ' ' . maybe_serialize( $response['response'] ) );
		} elseif ( $response ) { // is WP_Error object
			error_log( "wpcom_vip_file_get_contents: Blog ID {$blog_id}: Failure for $url and the result was: " . maybe_serialize( $response ) );
		}
		// So we can hook in other places and do stuff
		do_action( 'wpcom_vip_remote_request_error', $url, $response );
	}

	return $content;
}


/**
 * Returns profile information for a WordPress.com/Gravatar user
 *
 * @param string|int $email_or_id Email, ID, or username for user to lookup
 * @return false|array Profile info formatted as noted here: http://en.gravatar.com/site/implement/profiles/php/. If user not found, returns false.
 */
function wpcom_vip_get_user_profile( $email_or_id ) {

	if ( is_numeric( $email_or_id ) ) {
		$user = get_user_by( 'id', $email_or_id );
		if ( ! $user )
			return false;

		$email = $user->user_email;
	} elseif ( is_email( $email_or_id ) ) {
		$email = $email_or_id;
	} else {
		$user_login = sanitize_user( $email_or_id, true );
		$user = get_user_by( 'login', $user_login );
		if ( ! $user )
			return;

		$email = $user->user_email;
	}

	$hashed_email = md5( strtolower( trim( $email ) ) );
	$profile_url = esc_url_raw( sprintf( '%s.gravatar.com/%s.php', ( is_ssl() ? 'https://secure' : 'http://www' ), $hashed_email ), array( 'http', 'https' ) );

	//$profile = file_get_contents( $profile_url, 1, 900 );
	$profile = wpcom_vip_file_get_contents( $profile_url, 1, 900 );
	
	//$profile_01 = file_get_contents( $profile_url );
	$profile_02 = wpcom_vip_file_get_contents( $profile_url, 1, 900 );

	
	if ( $profile ) {
		$profile = unserialize( $profile );

		if ( is_array( $profile ) && ! empty( $profile['entry'] ) && is_array( $profile['entry'] ) ) {
			$profile = $profile['entry'][0];
		} else {
			$profile = false;
		}
	}
	return $profile;
}