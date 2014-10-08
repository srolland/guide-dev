<?php
/**
 * Recent_Posts widget class modified to Show Latest Posts in category.
 *
 * @since 0.1.2
 * @author jbracken - modified bey Sebastien
 */
class Postmedia_Widget_Recent_Category_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'widget_recent_category_entries', 'description' => 'The most recent posts in a category.' );
		parent::__construct( 'recent-category-posts', 'Postmedia -  Category Posts', $widget_ops );
		$this->alt_option_name = 'widget_recent_category_entries';

		add_action( 'save_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
	}

	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_recent_category_entries', 'widget' );

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
		$category = ( ! isset( $instance['category'] ) ) ? '1' : (int) $instance['category'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		if( ! empty( $number ) ) {
			$r = new WP_Query(
				apply_filters( 'widget_posts_args',
					array(
						'cat' => $category,
						'posts_per_page' => $number,
						'no_found_rows' => true,
						'post_status' => 'publish',
						'ignore_sticky_posts' => true
					)
				)
			);

			while ( $r->have_posts() ) : $r->the_post();
				
				get_template_part( 'content',  'widget'  ); 
				
			endwhile;

			echo $after_widget;

			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();
		}

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_recent_category_entries', $cache, 'widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = (int) $new_instance['category'];
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_recent_category_entries'] ) )
			delete_option( 'widget_recent_category_entries' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_recent_category_entries', 'widget' );
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$category = isset( $instance['category'] ) ? absint( $instance['category'] ) : 0;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
				
		<p><label for="<?php echo $this->get_field_id( 'category' ); ?>">Category:</label>
		<?php $dd_args = array(
						        'hierarchical' => 1,
						        'name' => $this->get_field_name( 'category' ),
						        'show_option_none' => 'Select a Category',
						        'selected' => $category,
						        'id' => $this->get_field_id( 'category' ),
						        'hide_empty' => 1,
						        'orderby' => 'NAME',	
						        'taxonomy' => array('category','events')
						    );
    						wp_dropdown_categories($dd_args);
    						?>
    	</p>


		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of posts to show:</label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		<?php
	}
}
register_widget( 'Postmedia_Widget_Recent_Category_Posts' );