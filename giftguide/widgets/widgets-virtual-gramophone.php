<?php
/**
 * The Postmedia Virtual Gramophone widget
 *
 * @since 0.1.2
 */
class postmedia_Virtual_Gramophone_Widget extends WP_Widget {
	function postmedia_Virtual_Gramophone_Widget() {
		$widget_ops = array( 'classname' => 'postmedia_twitter', 'description' => 'Display a virtual gramophone playlist' );
		$this->WP_Widget( 'postmedia_virtual_gramophone', 'Postmedia - Virtual Gramophone', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$title = ( empty( $instance['title'] ) ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$playlist_shortcode =  ( empty( $instance['playlist_shortcode'] ) ) ? '' : strip_tags( $instance['playlist_shortcode'] );
		$playlist_post_url = ( empty( $instance['playlist_post_url'] ) ) ? '' : strip_tags( $instance['playlist_post_url'] );

		echo $before_widget;
	    if ( ! empty( $title ) )
	    	echo $before_title . $title . $after_title;

		echo do_shortcode($playlist_shortcode);
		
		echo "<a href=\"" . $playlist_post_url . "\" class=\"playlist-link\">View all</a>";

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'playlist_shortcode' => '',
			'playlist_post_url' => '',
		) );
		$title = strip_tags( $instance['title'] );
		$playlist_shortcode = strip_tags( $instance['playlist_shortcode'] );
		$playlist_post_url = strip_tags( $instance['playlist_post_url'] );
		
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'playlist_shortcode' ); ?>">Playlist shortcode: <input class="widefat" id="<?php echo $this->get_field_id( 'playlist_shortcode' ); ?>" name="<?php echo $this->get_field_name( 'playlist_shortcode' ); ?>" type="text" value="<?php echo esc_attr( $playlist_shortcode ); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'playlist_post_url' ); ?>">Playlist post URL: <input class="widefat" id="<?php echo $this->get_field_id( 'playlist_post_url' ); ?>" name="<?php echo $this->get_field_name( 'playlist_post_url' ); ?>" type="text" value="<?php echo $playlist_post_url; ?>" /></label></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['playlist_shortcode'] = strip_tags( $new_instance['playlist_shortcode'] );
		$instance['playlist_post_url'] = strip_tags( $new_instance['playlist_post_url'] );

		return $instance;
	}
}
register_widget( 'postmedia_Virtual_Gramophone_Widget' );