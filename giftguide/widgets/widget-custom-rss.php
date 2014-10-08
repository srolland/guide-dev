<?php
/**
 * WS RSS widget class
 *
 * @since 0.1.2
 * @author jbracken /auttomattic
 */
class Postmedia_Widget_RSS extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'class' => 'postmedia_rss', 'description' => 'Entries from any RSS or Atom feed' );
		parent::__construct( 'postmedia_rss', 'Postmedia -  RSS', $widget_ops );
	}

	function widget( $args, $instance ) {
		if ( isset( $instance['error'] ) && $instance['error'] )
			return;

		extract( $args, EXTR_SKIP );

		$url = ! empty( $instance['url'] ) ? $instance['url'] : '';
		while ( $url != stristr( $url, 'http' ) )
			$url = substr( $url, 1 );

		if ( empty( $url ) )
			return;

		// self-url destruction sequence
		if ( in_array( untrailingslashit( $url ), array( site_url(), home_url() ) ) )
			return;

		$rss = fetch_feed( $url );
		$title = $instance['title'];
		$desc = '';
		$link = '';

		if ( ! is_wp_error( $rss ) ) {
			$desc = esc_attr( strip_tags( @html_entity_decode( $rss->get_description(), ENT_QUOTES, get_option( 'blog_charset' ) ) ) );

			if ( empty( $title ) )
				$title = esc_html( strip_tags( $rss->get_title() ) );

			$link = esc_url( strip_tags( $rss->get_permalink() ) );

			while ( $link != stristr( $link, 'http' ) ) {
				$link = substr( $link, 1 );
			}
		}

		if ( empty( $title ) )
			$title = empty( $desc ) ? 'Unknown Feed' : $desc;

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$url = esc_url( strip_tags( $url ) );
		$icon = includes_url( 'images/rss.png' );

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		postmedia_widget_rss_output( $rss, $instance );

		echo $after_widget;

		if ( ! is_wp_error( $rss ) )
			$rss->__destruct();

		unset( $rss );
	}

	function update( $new_instance, $old_instance ) {
		$testurl = ( isset( $new_instance['url'] ) && ( !isset( $old_instance['url'] ) || ( $new_instance['url'] != $old_instance['url'] ) ) );
		return postmedia_widget_rss_process( $new_instance, $testurl );
	}

	function form( $instance ) {
		if ( empty( $instance ) )
			$instance = array(
				'title' => '',
				'url' => '',
				'items' => 10,
				'error' => false,
				'show_summary' => 0,
				'show_author' => 0,
				'show_date' => 0
			);

		$instance['number'] = $this->number;

		postmedia_widget_rss_form( $instance );
	}
}

/**
 * Display the RSS entries in a list.
 *
 * @param	string|array|object $rss  RSS url
 * @param	array $args  Widget arguments
 *
 * @since 0.1.2
 * @author jbracken /auttomattic
 */
function postmedia_widget_rss_output( $rss, $args = array() ) {
	if ( is_string( $rss ) ) {
		$rss = fetch_feed( $rss );
	} elseif ( is_array( $rss ) && isset( $rss['url'] ) ) {
		$args = $rss;
		$rss = fetch_feed( $rss['url'] );
	} elseif ( ! is_object( $rss ) ) {
		return;
	}

	if ( is_wp_error( $rss ) ) {
		if ( is_admin() || current_user_can( 'manage_options' ) )
			echo '<p>' . sprintf( __( '<strong>RSS Error</strong>: %s' ), $rss->get_error_message() ) . '</p>';
		return;
	}

	$default_args = array(
		'show_author' => 0,
		'show_date' => 0,
		'show_summary' => 0
	);

	$args = wp_parse_args( $args, $default_args );

	extract( $args, EXTR_SKIP );

	$items = (int) $items;
	$items = ( 1 > $items || 20 < $items ) ? 10 : $items;

	$show_summary = (int) $show_summary;
	$show_author = (int) $show_author;
	$show_date = (int) $show_date;

	if ( ! $rss->get_item_quantity() ) {
		echo '<article><p>An error has occurred; the feed is probably down. Try again later.</p></article>';
		$rss->__destruct();
		unset( $rss );
		return;
	}

	foreach ( $rss->get_items(0, $items) as $item ) {
		$link = $item->get_link();

		while ( $link != stristr( $link, 'http' ) ) {
			$link = substr($link, 1);
		}

		$link = esc_url( strip_tags( $link ) );
		$title = esc_attr( strip_tags( $item->get_title() ) );
		$title = ( empty( $title ) ) ? 'Untitled' : $title;

		// We want to grab the Google-namespaced <gd:when> tag.
		$when = $item->get_item_tags( 'http://www.w3.org/2005/Atom', 'link' );

		// Once we grab the tag, let's grab the startTime attribute
		//$date = $when[0]['attribs']['']['startTime'];
		$abstract = $when[0]['attribs']['']['Abstract'];

		$desc = $item->get_description();

		if ( empty( $desc ) ){

			//if the description is empty use the abstract from the link tag
			$desc = str_replace( array( "\n", "\r" ), ' ', esc_attr( strip_tags( @html_entity_decode( $abstract, ENT_QUOTES, get_option( 'blog_charset' ) ) ) ) );

		}

		if ( $title == $desc ){

			$desc = '';

		}


		// Append ellipsis. Change existing [...] to [&hellip;].
		if ( '[...]' == substr( $desc, -5 ) )
			$desc = substr( $desc, 0, -5 ) . '[&hellip;]';
		//elseif ( '[&hellip;]' != substr( $desc, -10 ) )
			//$desc .= ' [&hellip;]';

		$desc = strip_tags( $desc );

		$entry_title = apply_filters( 'the_title', $item->get_title() );
		$link = esc_url( $item->get_permalink() );
		$enclosure = $item->get_enclosure();
		$image_url = is_object( $enclosure ) ? $enclosure->link : '';
		$image = ( empty ( $image_url ) ) ? '' : '<a href="' . $link . '" title="' . $entry_title . '"><img src="' . esc_url( $image_url ) . '" alt="' . $entry_title . '" class="alignleft" /></a>';
		?>
		<article>
			<header>
				<h3 class="title"><a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h3>
			</header>
			<div class="post-content">
				<a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $image; ?></a>
				<p><?php echo $desc;?></p>
			</div>
		</article>
		<?php
	}

	$rss->__destruct();
	unset( $rss );
}

/**
 * Display RSS widget options form.
 *
 * The options for what fields are displayed for the RSS form are all booleans
 * and are as follows: 'url', 'title', 'items', 'show_summary', 'show_author',
 * 'show_date'.
 *
 * @param	array|string $args  Values for input fields
 * @param	array $inputs  Override default display options
 *
 * @since 0.1.2
 * @author jbracken /auttomattic
 */
function postmedia_widget_rss_form( $args, $inputs = null ) {
	$default_inputs = array(
		'url' => true,
		'title' => true,
		'items' => true,
		'show_summary' => true,
		'show_author' => true,
		'show_date' => true
	);

	$inputs = wp_parse_args( $inputs, $default_inputs );

	extract( $args );

	extract( $inputs, EXTR_SKIP );

	$number = esc_attr( $number );
	$title = esc_attr( $title );
	$url = esc_url( $url );
	$items = (int) $items;
	$items = ( 1 > $items || 20 < $items ) ? 10 : $items;

	$show_summary = (int) $show_summary;
	$show_author = (int) $show_author;
	$show_date = (int) $show_date;

	if ( ! empty( $error ) )
		echo '<p class="widget-error"><strong>' . sprintf( __( 'RSS Error: %s' ), $error ) . '</strong></p>';

	if ( $inputs['url'] ) :
		?>
		<p><label for="rss-url-<?php echo $number; ?>">Enter the RSS feed URL here:</label>
		<input class="widefat" id="rss-url-<?php echo $number; ?>" name="widget-postmedia_rss[<?php echo $number; ?>][url]" type="text" value="<?php echo $url; ?>" /></p>
		<?php
	endif;
	if ( $inputs['title'] ) : ?>
		<p><label for="rss-title-<?php echo $number; ?>">Give the feed a title (optional):</label>
		<input class="widefat" id="rss-title-<?php echo $number; ?>" name="widget-postmedia_rss[<?php echo $number; ?>][title]" type="text" value="<?php echo $title; ?>" /></p>
		<?php
	endif;
	if ( $inputs['items'] ) : ?>
		<p><label for="rss-items-<?php echo $number; ?>">How many items would you like to display?</label>
		<select id="rss-items-<?php echo $number; ?>" name="widget-postmedia_rss[<?php echo $number; ?>][items]">
		<?php
		for ( $i = 1; $i <= 20; ++$i ) {
			echo "<option value='$i' " . ( $items == $i ? "selected='selected'" : '' ) . ">$i</option>";
		}
		?>
		</select>
		</p>
		<?php
	endif;

	foreach ( array_keys( $default_inputs ) as $input ) {
		if ( 'hidden' === $inputs[$input] ) {
			$id = str_replace( '_', '-', $input );
			?>
			<input type="hidden" id="rss-<?php echo $id; ?>-<?php echo $number; ?>" name="widget-postmedia_rss[<?php echo $number; ?>][<?php echo $input; ?>]" value="<?php echo $input; ?>" />
			<?php
		}
	}
}

/**
 * Process RSS feed widget data and optionally retrieve feed items.
 *
 * The feed widget can not have more than 20 items or it will reset back to the
 * default, which is 10.
 *
 * The resulting array has the feed title, feed url, feed link (from channel),
 * feed items, error (if any), and whether to show summary, author, and date.
 * All respectively in the order of the array elements.
 *
 *
 * @param	array $widget_rss  RSS widget feed data. Expects unescaped data.
 * @param	bool $check_feed  Optional, default is true. Whether to check feed for errors.
 *
 * @return	array
 *
 * @since 0.1.2
 * @author jbracken /auttomattic
 */
function postmedia_widget_rss_process( $widget_rss, $check_feed = true ) {
	$items = (int) $widget_rss['items'];
	$items = ( 1 > $items || 20 < $items ) ? 10 : $items;

	$url = esc_url_raw( strip_tags( $widget_rss['url'] ) );
	$title = trim( strip_tags( $widget_rss['title'] ) );
	$show_summary = isset( $widget_rss['show_summary'] ) ? (int) $widget_rss['show_summary'] : 0;
	$show_author = isset( $widget_rss['show_author'] ) ? (int) $widget_rss['show_author'] :0;
	$show_date = isset( $widget_rss['show_date'] ) ? (int) $widget_rss['show_date'] : 0;

	if ( $check_feed ) {
		$rss = fetch_feed( $url );
		$error = false;
		$link = '';
		if ( is_wp_error( $rss ) ) {
			$error = $rss->get_error_message();
		} else {
			$link = esc_url( strip_tags( $rss->get_permalink() ) );

 			while ( $link != stristr( $link, 'http' ) ) {
				$link = substr($link, 1);
			}

			$rss->__destruct();
			unset( $rss );
		}
	}

	return compact( 'title', 'url', 'link', 'items', 'error', 'show_summary', 'show_author', 'show_date' );
}
register_widget( 'Postmedia_Widget_RSS' );