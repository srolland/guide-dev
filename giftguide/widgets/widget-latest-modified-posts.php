<?php
/**
 * Recent_Posts widget class Modofied to Order By last Modified posts.
 *
 * @since 0.1.2
 * @author jbracken
 */
class Postmedia_Widget_Recent_Modified_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'widget_recent_modified_entries', 'description' => 'The most recent modified posts on your site.' );
		parent::__construct( 'recent-modofied-posts', 'Postmedia -  Latest Posts', $widget_ops );
		$this->alt_option_name = 'widget_recent_modified_entries';

		add_action( 'save_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
	}

	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_recent_modified_entries', 'widget' );

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ?'Latest Posts' : $instance['title'], $instance, $this->id_base );
		$number = ( ! isset( $instance['number'] ) || 0 > $instance['number'] || 100 < $instance['number'] ) ? '10' : (int) $instance['number'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		if( ! empty( $number ) ) {
			$r = new WP_Query(
				apply_filters( 'widget_posts_args',
					array(
						'orderby' => 'modified',
						'posts_per_page' => $number,
						'no_found_rows' => true,
						'post_status' => 'publish',
						'ignore_sticky_posts' => true
					)
				)
			);

			while ( $r->have_posts() ) : $r->the_post();
				$title = get_the_title();
				$url = get_permalink();
				$post_id = get_the_ID();
				?>
				<article>
					<header>
						<h4><a href="<?php echo $url; ?>" title="<?php echo esc_attr( $title ? $title : $post_id ); ?>"><?php if ( $title ) $title; else $post_id; ?></a></h4>
					</header>
					<div class="post-content">
						<?php echo postmedia_featured_thumbnail( $post_id, 'thumbnail', $url, $title ); ?>
						<?php the_excerpt(); ?>
					</div>
				</article>
				<?php
			endwhile;

			echo $after_widget;

			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();
		}

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_recent_modified_entries', $cache, 'widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_recent_modified_entries'] ) )
			delete_option( 'widget_recent_modified_entries' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_recent_modified_entries', 'widget' );
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of posts to show:</label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		<?php
	}
}
register_widget( 'Postmedia_Widget_Recent_Modified_Posts' );