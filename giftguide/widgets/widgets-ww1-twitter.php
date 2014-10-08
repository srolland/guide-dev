<?php
/**
 * The Windsor Star Twitter widget
 *
 * @since 0.1.2
 */
class postmedia_WW1_Twitter_Widget extends WP_Widget {
	function postmedia_WW1_Twitter_Widget() {
		$widget_ops = array( 'classname' => 'postmedia_twitter', 'description' => 'Display the We Are The Dead List Tweets' );
		$this->WP_Widget( 'postmedia_twitter', 'Postmedia -  Twitter', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$title = ( empty( $instance['title'] ) ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$number_of_tweets = (int) $instance['number_of_tweets'];
		$list = ( empty( $instance['list'] ) ) ? '' : strip_tags( $instance['list'] );

		echo $before_widget;
	    if ( ! empty( $title ) )
	    	echo $before_title . $title . $after_title;

		echo '<a class="twitter-timeline" href="https://twitter.com/search?q=1914%2C+OR+1915%2C+OR+1916%2C+OR+1917%2C+OR+1918+from%3Awearethedead" data-widget-id="451165668642013184" data-chrome="noheader nofooter" width="310" height="600" lang="EN">Tweets about "1914, OR 1915, OR 1916, OR 1917, OR 1918 from:wearethedead"</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => 'We Are The Dead',
			'list' => '',
			'number_of_tweets' => '5',
		) );
		$title = strip_tags( $instance['title'] );
		$number_of_tweets = (int) $instance['number_of_tweets'];
		$list = strip_tags( $instance['list'] );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p><!--

		<p><label for="<?php echo $this->get_field_id( 'list' ); ?>">List: <input class="widefat" id="<?php echo $this->get_field_id( 'list' ); ?>" name="<?php echo $this->get_field_name( 'list' ); ?>" type="text" value="<?php echo esc_attr( $list ); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'number_of_tweets' ); ?>">Number of Tweets: <input class="widefat" id="<?php echo $this->get_field_id( 'number_of_tweets' ); ?>" name="<?php echo $this->get_field_name( 'number_of_tweets' ); ?>" type="text" value="<?php echo $number_of_tweets; ?>" /></label></p>
-->
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number_of_tweets'] = (int) $new_instance['number_of_tweets'];
		$instance['list'] = strip_tags( $new_instance['list'] );

		return $instance;
	}
}
register_widget( 'postmedia_WW1_Twitter_Widget' );