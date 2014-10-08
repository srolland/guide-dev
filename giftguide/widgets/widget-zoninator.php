<?php
/**
 * WS Zone Posts widget class formats zone posts so they appear with custom markup rather than the default Zoninator ul > li formatting.
 *
 * @uses Zoninator plugin settings
 *
 * @since 0.1.2
 * @author jbracken
 */
class Postmedia_Zoninator_ZonePosts_Widget extends WP_Widget {
	function Postmedia_Zoninator_ZonePosts_Widget() {
		$widget_ops = array( 'classname' => 'ws-widget-zone-posts', 'description' => 'Use this widget to display a list of posts from any zone.' );
		parent::__construct(  'ws-widget-zone-posts', 'Postmedia -  Zone Posts', $widget_ops );
		$this->alt_option_name = 'postmedia_widget_zone_posts';

		add_action( 'save_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
	}

	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'ws-widget-zone-posts', 'widget' );

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args );

		$zone_id = ( $instance['zone_id'] ) ? $instance['zone_id'] : 0;
		$show_description = ( $instance['show_description'] ) ? 1 : 0;

		if( ! $zone_id )
			return;

		$zone = z_get_zone( $zone_id );

		if( ! $zone )
			return;

		$posts = z_get_posts_in_zone( $zone_id );

		if( empty( $posts ) )
			return;

		echo $before_widget;
		echo $before_title . esc_html( $zone->name ) . $after_title;

		if( ! empty( $zone->description ) && $show_description ) {
			?><p class="description"><?php echo esc_html( $zone->description ); ?></p><?php
		}

		foreach( $posts as $post ) :
			$postid = $post->ID;
			$title = ( get_the_title( $postid ) ) ? get_the_title( $postid ) : $postid;
			$thumbnail = get_the_post_thumbnail( $postid, 'thumbnail', array( 'class'=>'alignleft' ) );
			$permalink = get_permalink( $postid );

			$word_limit = 55;
			$words = explode( ' ', $post->post_content, ( $word_limit + 1 ) );
			if ( count( $words ) > $word_limit )
				array_pop($words);

			$excerpt = implode( ' ', $words );
			$excerpt .= '[&hellip;]';
			?>
			<article>
				<header>
					<h4><a href="<?php echo $permalink; ?>" title="<?php echo esc_attr( $title ); ?>"><?php echo $title; ?></a></h4>
				</header>

				<a href="<?php $permalink ?>" title="<?php echo esc_attr( $title ); ?>"><?php echo $thumbnail;?></a>

				<p><?php echo $excerpt; ?></p>
			</article>
			<?php
		endforeach;

		echo $after_widget;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'ws-widget-zone-posts', $cache, 'widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'zone_id' => 0, 'show_description' => 0 ) );

		$instance['zone_id'] = absint( $new_instance['zone_id'] );
		$instance['show_description'] = ( $new_instance['show_description'] ) ? 1 : 0;

		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['ws-widget-zone-posts'] ) )
			delete_option( 'ws-widget-zone-posts' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'ws-widget-zone-posts', 'widget' );
	}

	function form( $instance ) {
		$zones = z_get_zones();

		if( empty( $zones ) ) {
			echo 'You need to create at least one zone before you use this widget!';
			return;
		}

		$zone_id = ( isset( $instance['zone_id'] ) ) ? absint( $instance['zone_id'] ) : 0;
		$show_description = ( isset( $instance['show_description'] ) ) ? (bool) $instance['show_description'] : true;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'zone_id' ); ?>">Zone:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'zone_id' ); ?>" name="<?php echo $this->get_field_name( 'zone_id' ); ?>">
				<option value="0" <?php selected( $zone_id, 0 ); ?>>-- Select a zone --</option>
				<?php foreach( $zones as $zone ) : ?>
					<option value="<?php echo $zone->term_id; ?>" <?php selected( $zone_id, $zone->term_id ); ?>>
					<?php echo esc_html( $zone->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_description' ); ?>">
				<input id="<?php echo $this->get_field_id( 'show_description' ); ?>" name="<?php echo $this->get_field_name( 'show_description' ); ?>" <?php checked( true, $show_description ); ?> type="checkbox" value="1" />
				Show zone description in widget
			</label>
		</p>
		<?php
	}
}
register_widget( 'Postmedia_Zoninator_ZonePosts_Widget' );