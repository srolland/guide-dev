<?php
/**
 * Connect With Us Widget - static links to site wide social links
 *
 * @uses	postmedia_theme_option()
 *
 * @since 0.1.2
 * @author jbracken / c.bavota
 */
class Postmedia_Widget_Social_Site_Connect extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'class' => 'postmedia_social_site_connect', 'description' => 'Site Wide Social Share and Connections' );
		parent::__construct( 'postmedia_social_site_connect', 'Postmedia -  Site Wide Social Connect', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$title = ( empty( $instance['title'] ) ) ? '' : apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
	    if ( ! empty( $title ) )
	    	echo $before_title . $title . $after_title;
		?>
		<ul id="connect_right">
			<li><a class="facebook" target="_new" title="Windsor Star Facebook" href="<?php echo esc_url( postmedia_theme_option( 'facebook_link' ) );?>"><span class="assistive-text">Facebook</span></a></li>
			<li><a class="twitter" target="_new" title="Windsor Star Twitter" href="<?php echo esc_url( postmedia_theme_option( 'twitter_link' ) );?>"><span class="assistive-text">Twitter</span></a></li>
			<li><a class="google" target="_new"  title="Windsor Star Google Plus" href="<?php echo esc_url( postmedia_theme_option( 'google_link' ) );?>"><span class="assistive-text">Google Plus</span></a></li>
			<li><a class="pinterest" target="_new"  title="Windsor Star Pinterest" href="<?php echo esc_url( postmedia_theme_option( 'pinterest_link' ) );?>"><span class="assistive-text">Pinterest</span></a></li>
			<li><a class="tumblr" target="_new" title="Windsor Star Tumblr" href="<?php echo esc_url( postmedia_theme_option( 'tumblr_link' ) );?>"><span class="assistive-text">Tumblr</span></a></li>
			<li><a class="rss" target="_new" title="Windsor Star RSS Feed" href="<?php echo esc_url( postmedia_theme_option( 'rss_feed_link' ) );?>"><span class="assistive-text">RSS</span></a></li>
		</ul>
		<?php
		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => 'Follow Windsor Star',
		) );
		$title = strip_tags( $instance['title'] );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}
}
register_widget( 'Postmedia_Widget_Social_Site_Connect' );