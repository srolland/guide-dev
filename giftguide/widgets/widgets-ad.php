<?php
/**
 * Postmedia Ad widget
 *
 * @uses	cdc-adserver.js  Canada.com JavaScript Ad Server
 *
 * @since 0.1.2
 */
class Postmedia_Ad_Widget extends WP_Widget {
	const BASE_ID = 'postmedia-ad';

	public function __construct() {
		parent::__construct(
			self::BASE_ID,
			'Postmedia - Ad Unit',
			array(
				'classname' => 'postmedia-ad target-self',
				'description' => 'Display an ad unit'
			)
		);
	}

	public function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$this_size = $instance['size'];
		$this_counter = substr( $widget_id, strlen( self::BASE_ID ) + 1 );
		$this_id = array(
			'dart' => 'div-dart-ad-' . $this_counter,
			'gpt' => 'div-gpt-ad-' . $this_counter
		);

		// Since this ad widget is being rendered, $this_sidebar should contain at least one ad widget
		$this_sidebar = array();
		$ad_widgets = array();
		$all_sidebars = wp_get_sidebars_widgets();
		if ( array_key_exists( $id, $all_sidebars ) ) {
			// Get the sidebar containing this widget
			$this_sidebar = $all_sidebars[$id];
		}

		// Get the details for all the widgets of this type
		$ad_widgets_details = get_option( 'widget_' . self::BASE_ID );

		foreach ( $this_sidebar as $widget ) {
			// Widget is an ad
			if ( 0 === strpos( $widget, self::BASE_ID ) ) {
				// Get the counter assigned by WP
				$counter = substr( $widget, strlen( self::BASE_ID ) + 1 );

				// Get the size of the widget
				$widget_size = $ad_widgets_details[$counter]['size'];

				// Build the array of different sized widgets
				$ad_widgets[$widget_size][$widget] = $ad_widgets_details[$counter];
			}
		}

		// Get the array of widgets of this size
		$this_size_array = $ad_widgets[$this_size];

		// Get the index of this widget in the array of similarly sized widgets
		$this_size_index = array_search( $widget_id, array_keys( $this_size_array ) );

		if ( 0 === $this_size_index )
			$this_loc = 'top';
		elseif ( $this_size_index === ( count( $this_size_array ) - 1 ) )
			$this_loc = 'bot';
		elseif ( 1 === $this_size_index )
			$this_loc = 'mid';
		else
			$this_loc = 'mid' . $this_size_index;

		$this_sizes = array();
		$this_sizes['gpt'] = '[300, 50], [320, 50]';

		if ( $this_size == 'Big Box' )
			if ( $this_loc == 'top' )
				$this_sizes['dart'] = '[300, 250], [300, 251], [300, 600], [300, 1050]';
			else
				$this_sizes['dart'] = '[300, 250], [300, 252]';
		else
			$this_sizes['dart'] = '[300, 100]';

		// Output:
		echo $before_widget;
		?>
		<div id="<?php echo $this_id['dart']; ?>" class="ad" data-mobile="false">
			<script type="text/javascript">
			Postmedia.AdServer.Write({
				id:"<?php echo $this_id['dart']; ?>",
				size:[<?php echo $this_sizes['dart']; ?>],
				keys:{"loc":"<?php echo $this_loc; ?>"},
				mobile: false
			});
			</script>
		</div>
		<div id="<?php echo $this_id['gpt']; ?>" class="ad" data-mobile="true">
			<script type="text/javascript">
			Postmedia.AdServer.Write({
				id:"<?php echo $this_id['gpt']; ?>",
				size:[<?php echo $this_sizes['gpt']; ?>],
				keys:{"loc":"<?php echo $this_loc; ?>"},
				mobile: true
			});
			</script>
		</div>
		<?php
		echo $after_widget;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'size' => 'Big Box',
			'title' => 'Big Box'
		) );
		$size = strip_tags( $instance['size'] );
		$title = strip_tags( $instance['title'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>">Ad Size: </label>
			<select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
				<option value="Big Box" <?php echo ( $size == 'Big Box' ? 'selected="selected"' : '' ); ?>>Big Box</option>
				<option value="Impulse" <?php echo ( $size == 'Impulse' ? 'selected="selected"' : '' ); ?>>Impulse</option>
			</select>
		</p>
		<input type="hidden" id="<?php echo $this->get_field_id( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['size'] = strip_tags( $new_instance['size'] );
		$instance['title'] = strip_tags( $new_instance['size'] );

		return $instance;
	}
}
register_widget( 'Postmedia_Ad_Widget' );