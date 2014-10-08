<?php

// Responsive Ad widget
class DFPAdResp extends WP_Widget {
	function DFPAdResp() {
		$widget_ops = array( 'classname' => 'postmedia_dfp_ad_resp', 'description' => 'Display DFP ads depending on the platform' );
		$this->WP_Widget( 'pm_DFP_responsive', 'Postmedia - Responsive DFP Ad', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$title = ( empty( $instance['title'] ) ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$number_of_tweets = (int) $instance['number_of_tweets'];
		$list = ( empty( $instance['list'] ) ) ? '' : strip_tags( $instance['list'] );

		echo $before_widget;
	    if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;   
	    }
		
		if ( function_exists( 'jetpack_is_mobile' ) ) {
			if( jetpack_is_mobile() ){
				if ( function_exists( 'pn_dfp_ads' ) ) {
					pn_dfp_ads() -> call_ad('big-box-top-memory');	
				}
			} else {
				if ( function_exists( 'pn_dfp_ads' ) ) {
					pn_dfp_ads() -> call_ad('big-box-top');	
				}
			}
		} else {
				if ( function_exists( 'pn_dfp_ads' ) ) {
					pn_dfp_ads() -> call_ad('big-box-top');	
				}
		}
		
		

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => ''
		) );
		$title = strip_tags( $instance['title'] );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		//$instance['number_of_tweets'] = (int) $new_instance['number_of_tweets'];
		//$instance['list'] = strip_tags( $new_instance['list'] );

		return $instance;
	}
}
register_widget( 'DFPAdResp' );