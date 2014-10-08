<?php
/**
 * News Alerts - static links to site wide social links
 *
 * @since 0.1.2
 * @author jbracken / c.bavota
 *
 * @todo	Get Form working with Production signup functionality
 */
class Postmedia_Widget_News_Alerts extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'postmedia_news_alerts', 'description' => 'Signup for News Alerts' );
		parent::__construct( 'postmedia_news_alerts', 'Postmedia -  News Alerts', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$title = ( empty( $instance['title'] ) ) ? '' : apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
	    if ( ! empty( $title ) )
	    	echo $before_title . $title . $after_title;
		?>
		<form class="joinform" name="windsorstarnewsalertsubscribeform" method="POST" action="http://members.canada.com/scripts/subscribe.aspx">
			<p>Get the Windsor Star delivered to your inbox</p>
			<input type="hidden" name="returnurl" value="http://www.windsorstar.com/about-windsor-star/thankyou.html">
			<input type="hidden" name="errorurl" value="http://www.windsorstar.com/about-windsor-star/error.html">
			<input type="hidden" name="newsletter" value="breakingnewsalert-windsorstar">
			<input name="email" type="text" class="input_alert" placeholder="Your email address">
			<button class="btn green-btn">Submit</button>
		</form>
		<?php
		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => 'News Alerts',
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
register_widget( 'Postmedia_Widget_News_Alerts' );
