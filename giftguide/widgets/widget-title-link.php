<?php
/**
 * Postmedia Widget Title Link Plugin
 *
 * @since 0.1.2
 */
class Postmedia_Widget_Title_Link {
	public static $wtl_options;

	public function __construct() {
		//delete_option('widget_title_link');
		if ( ( ! self::$wtl_options = get_option( 'widget_title_link' ) ) || ! is_array( self::$wtl_options ) )
			self::$wtl_options = array();

		add_action( 'sidebar_admin_setup', array( $this, 'sidebar_admin_setup' ) );
		add_filter( 'dynamic_sidebar_params', array( $this, 'dynamic_sidebar_params' ), 10);
	}

	/**
	 * Callback to modify the widget before_title and after_title values
	 *
	 * @param	array $params  Widget parameters
	 *
	 * @return	array  Modified widget parameters
	 */
	public function dynamic_sidebar_params( $params ) {
		global $wp_registered_widgets;
		$id = $params[0]['widget_id'];

		if ( false !== array_search( $id, array_keys( self::$wtl_options ) ) ) {
			if ( '' !== self::$wtl_options[$id] ) {
				$params[0]['before_title'] = $params[0]['before_title'] . '<a href="' . self::$wtl_options[$id] . '">';
				$params[0]['after_title'] = ' <span>»</span></a>' . $params[0]['after_title'];
			}
		}

		$wp_registered_widgets[$id]['callback_wtl_redirect'] = $wp_registered_widgets[$id]['callback'];
		$wp_registered_widgets[$id]['callback'] = array( $this, 'widget_title_link_redirected_callback' );
		return $params;
	}

	/**
	 * Callback to display the widget, including other plugin callbacks via apply_filters()
	 */
	public function widget_title_link_redirected_callback() {
		global $wp_registered_widgets, $wp_reset_query_is_done;

		// replace the original callback data
		$params = func_get_args();
		$id = $params[0]['widget_id'];
		$callback = $wp_registered_widgets[$id]['callback_wtl_redirect'];
		$wp_registered_widgets[$id]['callback'] = $callback;

		// run the callback but capture and filter the output using PHP output buffering
		if ( is_callable( $callback ) ) {
			ob_start();
			call_user_func_array( $callback, $params );
			$widget_content = ob_get_contents();
			ob_end_clean();
			echo apply_filters( 'widget_content', $widget_content, $id );
		}
	}

	/**
	 * Sets up the callback info on each widget and updates the widget_title_link options on save.
	 */
	public function sidebar_admin_setup() {
		global $wp_registered_widgets, $wp_registered_widget_controls;

		foreach ( $wp_registered_widgets as $id => $widget ) {

			// controlless widgets need an empty function so the callback function is called.
			if ( ! $wp_registered_widget_controls[$id] )
				wp_register_widget_control( $id, $widget['name'], array( $this, 'widget_title_link_empty_control' ) );

			$wp_registered_widget_controls[$id]['callback_wtl_redirect'] = $wp_registered_widget_controls[$id]['callback'];
			$wp_registered_widget_controls[$id]['callback'] = array( $this, 'widget_title_link_extra_control');
			array_push( $wp_registered_widget_controls[$id]['params'], $id );
		}

		// Update widget_title_link options
		if ( 'post' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
			//error_log(print_r($_POST, true));
			$widget_id = $_POST['widget-id'];

			if ( isset( $_POST['widget-title-link'] ) ) {
				if ( 0 < strlen( $_POST['widget-title-link'] ) ) {
					self::$wtl_options[$widget_id] = esc_url( $_POST['widget-title-link'] );
				}
				else {
					unset( self::$wtl_options[$widget_id] );
				}
			}
			else {
				unset( self::$wtl_options[$widget_id] );
			}

			// Delete option if widget is being deleted
			if ( isset( $_POST['delete_widget'] ) ) {
				if ( 1 === (int) $_POST['delete_widget'] ) {
					unset( self::$wtl_options[$widget_id] );
				}
			}

		}

		//error_log(print_r(self::$wtl_options, true));

		update_option( 'widget_title_link', self::$wtl_options );

	}

	/**
	 * For controlless widgets
	 */
	public function widget_title_link_empty_control() {}

	/**
	 * Injects the title link field into each widget
	 */
	public function widget_title_link_extra_control() {
		global $wp_registered_widget_controls;

		$params = func_get_args();
		$id = array_pop( $params );

		// go to the original control function
		$callback = $wp_registered_widget_controls[$id]['callback_wtl_redirect'];
		if ( is_callable( $callback ) )
			call_user_func_array( $callback, $params );

		$value = ( ! empty( self::$wtl_options[$id ] ) ) ? htmlspecialchars( stripslashes( self::$wtl_options[$id ] ), ENT_QUOTES ) : '';

		// dealing with multiple widgets - get the number. if -1 this is the 'template' for the admin interface
		$number = $params[0]['number'];
		if ( $number == -1 ) {
			$value = "";
		}

		$id_disp = 'widget-title-link';
		?>
		<p>
			<label>Title Links To:
			<input type="text" class="widefat" name="<?php echo $id_disp; ?>" value="<?php echo $value; ?>" /></label>
		</p>
		<?php
	}
}
$postmedia_widget_title_link = new Postmedia_Widget_Title_Link();