<?php
/**
 * Theme options class
 *
 * @since 1.0.1
 * @author c.bavota
 *
 * @todo	Figure out what options are needed
 */
class postmedia_Theme_Options {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	public function admin_init() {
		// Theme options
		register_setting( 'postmedia_theme_options', 'postmedia_theme_options', array( $this, 'postmedia_theme_options_validate' ) );

		add_settings_section( 'facebook_section_id', 'Facebook', '__return_false', 'postmedia_theme_options' );
		add_settings_field( 'postmedia_theme_options_facebook_app_id', 'App ID', array( $this, 'input_regular' ), 'postmedia_theme_options', 'facebook_section_id', array( 'key' => 'facebook_app_id' ) );
		add_settings_field( 'postmedia_theme_options_facebook_page_id', 'Page ID', array( $this, 'input_regular' ), 'postmedia_theme_options', 'facebook_section_id', array( 'key' => 'facebook_page_id' ) );

		add_settings_section( 'social_section_id', 'Social Icons', '__return_false', 'postmedia_theme_options' );
		add_settings_field( 'postmedia_theme_options_rss_id', 'RSS Feed', array( $this, 'input_regular' ), 'postmedia_theme_options', 'social_section_id', array( 'key' => 'rss_feed_link' ) );
		add_settings_field( 'postmedia_theme_options_fb_page_id', 'Facebook Page', array( $this, 'input_regular' ), 'postmedia_theme_options', 'social_section_id', array( 'key' => 'facebook_link' ) );
		add_settings_field( 'postmedia_theme_options_twitter_id', 'Twitter', array( $this, 'input_regular' ), 'postmedia_theme_options', 'social_section_id', array( 'key' => 'twitter_link' ) );
		add_settings_field( 'postmedia_theme_options_pinterest_id', 'Pinterest', array( $this, 'input_regular' ), 'postmedia_theme_options', 'social_section_id', array( 'key' => 'pinterest_link' ) );
		add_settings_field( 'postmedia_theme_options_linkedin_id', 'LinkedIn', array( $this, 'input_regular' ), 'postmedia_theme_options', 'social_section_id', array( 'key' => 'linkedin_link' ) );
		add_settings_field( 'postmedia_theme_options_tumblr_id', 'Tumblr', array( $this, 'input_regular' ), 'postmedia_theme_options', 'social_section_id', array( 'key' => 'tumblr_link' ) );
		add_settings_field( 'postmedia_theme_options_google_plus_id', 'Google+', array( $this, 'input_regular' ), 'postmedia_theme_options', 'social_section_id', array( 'key' => 'google_link' ) );

		// add field to allow custom adcode on home page
		add_settings_section( 'promo_section_id', 'Promotional Ad Code Override', '__return_false', 'postmedia_theme_options' );
		add_settings_field( 'postmedia_theme_options_promo_ad_creative', 'Promo Ad Code', array( $this, 'input_regular' ), 'postmedia_theme_options', 'promo_section_id', array( 'key' => 'promo_ad_creative' ) );
		add_settings_field( 'postmedia_theme_options_promo_ad_link', 'Promo Ad Link', array( $this, 'input_regular' ), 'postmedia_theme_options', 'promo_section_id', array( 'key' => 'promo_ad_link' ) );
		add_settings_field( 'postmedia_theme_options_promo_ad_options', 'Override Promo Adcode?', array( $this, 'input_radio' ), 'postmedia_theme_options', 'promo_section_id', array( 'key' => 'promo_ad_options' ) );
		add_settings_field( 'postmedia_theme_options_promo_ad_options_singular', 'Display ad on story pages only.', array( $this, 'input_radio_singular' ), 'postmedia_theme_options', 'promo_section_id', array( 'key' => 'promo_ad_options_singular' ) );
		
		//Added Chartbeat options
		add_settings_section( 'chartbeat_section_id', 'Chartbeat', '__return_false', 'postmedia_theme_options' );
		add_settings_field( 'postmedia_theme_options_chartbeat_host', 'Chartbeat Host', array( $this, 'input_regular' ), 'postmedia_theme_options', 'chartbeat_section_id', array( 'key' => 'chartbeat_host' ) );
		add_settings_field( 'postmedia_theme_options_chartbeat_section', 'Chartbeat Section', array( $this, 'input_regular' ), 'postmedia_theme_options', 'chartbeat_section_id', array( 'key' => 'chartbeat_section' ) );
		
		add_settings_field( 'postmedia_theme_options_chartbeat_api_key', 'Chartbeat API Key', array( $this, 'input_regular' ), 'postmedia_theme_options', 'chartbeat_section_id', array( 'key' => 'chartbeat_api_key' ) );
		
		add_settings_field( 'postmedia_theme_options_chartbeat_limit', 'Chartbeat Limit', array( $this, 'input_regular' ), 'postmedia_theme_options', 'chartbeat_section_id', array( 'key' => 'chartbeat_limit' ) );
			
		//Added Alert settings
		add_settings_section( 'alert_section_id', 'Alerts', '__return_false', 'postmedia_theme_options' );
		add_settings_field( 'postmedia_theme_options_alert_options', 'Display alerts.', array( $this, 'input_radio_singular' ), 'postmedia_theme_options', 'alert_section_id', array( 'key' => 'alert_options' ) );
		
		
		
		// Home page options
		register_setting( 'postmedia_home_page_options', 'postmedia_home_page_options', array( $this, 'postmedia_home_page_options_validate' ) );
		add_settings_section('postmedia_home_page_options', 'Home Page Rotator Options', '__return_false', 'postmedia_home_page_options');

		add_settings_field( 'postmedia_home_page_one_id', 'Home Page Feature One', array( $this, 'feature_dropdown' ), 'postmedia_home_page_options', 'postmedia_home_page_options', array( 'key' => 'postmedia_home_page_one', 'name' => 'postmedia_home_page_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')  ) ) );
		add_settings_field( 'postmedia_home_page_two_id', 'Home Page Feature two', array( $this, 'feature_dropdown' ), 'postmedia_home_page_options', 'postmedia_home_page_options', array( 'key' => 'postmedia_home_page_two', 'name' => 'postmedia_home_page_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')   ) ) );
		add_settings_field( 'postmedia_home_page_three_id', 'Home Page Feature three', array( $this, 'feature_dropdown' ), 'postmedia_home_page_options', 'postmedia_home_page_options', array( 'key' => 'postmedia_home_page_three', 'name' => 'postmedia_home_page_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')   ) )  );
		add_settings_field( 'postmedia_home_page_four_id', 'Home Page Feature four', array( $this, 'feature_dropdown' ), 'postmedia_home_page_options', 'postmedia_home_page_options', array( 'key' => 'postmedia_home_page_four', 'name' => 'postmedia_home_page_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')   ) ) );

		
		//Added Disaster template settings
		add_settings_section( 'disaster_section_id', 'Disaster Template', '__return_false', 'postmedia_home_page_options' );
		add_settings_field( 'postmedia_theme_options_disaster_options', 'Display Disaster Template.', array( $this, 'input_radio_singular_homepage' ), 'postmedia_home_page_options', 'disaster_section_id', array( 'key' => 'disaster_options' ) );
		


// Curated Feed options
		register_setting( 'postmedia_curated_feed_options', 'postmedia_curated_feed_options', array( $this, 'postmedia_curated_feed_options_validate' ) );
		add_settings_section('postmedia_curated_feed_options', 'Curated Feed Options', '__return_false', 'postmedia_curated_feed_options');

		add_settings_field( 'postmedia_curated_feed_one_id', 'Position One', array( $this, 'feature_dropdown' ), 'postmedia_curated_feed_options', 'postmedia_curated_feed_options', array( 'key' => 'postmedia_curated_feed_one', 'name' => 'postmedia_curated_feed_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')  ) ) );
		add_settings_field( 'postmedia_curated_feed_two_id', 'Position Two', array( $this, 'feature_dropdown' ), 'postmedia_curated_feed_options', 'postmedia_curated_feed_options', array( 'key' => 'postmedia_curated_feed_two', 'name' => 'postmedia_curated_feed_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')   ) ) );
		add_settings_field( 'postmedia_curated_feed_three_id', 'Position Three', array( $this, 'feature_dropdown' ), 'postmedia_curated_feed_options', 'postmedia_curated_feed_options', array( 'key' => 'postmedia_curated_feed_three', 'name' => 'postmedia_curated_feed_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')   ) )  );
		add_settings_field( 'postmedia_curated_feed_four_id', 'Position Four', array( $this, 'feature_dropdown' ), 'postmedia_curated_feed_options', 'postmedia_curated_feed_options', array( 'key' => 'postmedia_curated_feed_four', 'name' => 'postmedia_curated_feed_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')   ) ) );
		
		
		add_settings_field( 'postmedia_curated_feed_five_id', 'Position Five', array( $this, 'feature_dropdown' ), 'postmedia_curated_feed_options', 'postmedia_curated_feed_options', array( 'key' => 'postmedia_curated_feed_five', 'name' => 'postmedia_curated_feed_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')  ) ) );
		add_settings_field( 'postmedia_curated_feed_six_id', 'Position Six', array( $this, 'feature_dropdown' ), 'postmedia_curated_feed_options', 'postmedia_curated_feed_options', array( 'key' => 'postmedia_curated_feed_six', 'name' => 'postmedia_curated_feed_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')   ) ) );
		add_settings_field( 'postmedia_curated_feed_seven_id', 'Position Seven', array( $this, 'feature_dropdown' ), 'postmedia_curated_feed_options', 'postmedia_curated_feed_options', array( 'key' => 'postmedia_curated_feed_seven', 'name' => 'postmedia_curated_feed_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')   ) )  );
		add_settings_field( 'postmedia_curated_feed_eight_id', 'Position Eight', array( $this, 'feature_dropdown' ), 'postmedia_curated_feed_options', 'postmedia_curated_feed_options', array( 'key' => 'postmedia_curated_feed_eight', 'name' => 'postmedia_curated_feed_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')   ) ) );
		
		
		add_settings_field( 'postmedia_curated_feed_nine_id', 'Position Nine', array( $this, 'feature_dropdown' ), 'postmedia_curated_feed_options', 'postmedia_curated_feed_options', array( 'key' => 'postmedia_curated_feed_nine', 'name' => 'postmedia_curated_feed_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')  ) ) );
		add_settings_field( 'postmedia_curated_feed_ten_id', 'Position Ten', array( $this, 'feature_dropdown' ), 'postmedia_curated_feed_options', 'postmedia_curated_feed_options', array( 'key' => 'postmedia_curated_feed_ten', 'name' => 'postmedia_curated_feed_options', 'query_args' => array( 'post_type' => array('post', 'video', 'gallery')   ) ) );





	}	
		
	public function input_regular( $atts ) {
		printf( '<input type="text" name="postmedia_theme_options[%1$s]" size="40" value="%2$s" />',
	  		$atts['key'],
	  		esc_attr( postmedia_theme_option( $atts['key'] ) )
		);
	}

	public function input_radio( $atts ) {

		$options = get_option( 'postmedia_theme_options' );
		$name = 'postmedia_theme_options[' . $atts['key'] .']';
		$option = esc_attr( $options[$atts['key']] );

		$items = array("Dart", "Override", "Off");
		foreach($items as $item) {
			$checked = ($option==$item) ? ' checked="checked" ' : '';
			echo "<label><input ".$checked." value='$item' name='" . $name . "' type='radio' /> $item</label><br />";
		}

	}

	public function input_radio_singular( $atts ) {

		$options = get_option( 'postmedia_theme_options' );
		$name = 'postmedia_theme_options[' . $atts['key'] .']';
		$option = esc_attr( $options[$atts['key']] );
		if ($option == "" ) { $option = 'Off'; }

		$items = array('On', 'Off');
		foreach($items as $item) {
			$checked = ($option==$item) ? ' checked="checked" there="'.$options[$atts['key']].'" ' : '';
			echo "<label><input ".$checked." value='$item' name='" . $name . "' type='radio' /> $item</label><br />";
		}

	}
	
	public function input_radio_singular_homepage( $atts ) {

		$options = get_option( 'postmedia_home_page_options' );
		$name = 'postmedia_home_page_options[' . $atts['key'] .']';
		$option = esc_attr( $options[$atts['key']] );
		if ($option == "" ) { $option = 'Off'; }

		$items = array('On', 'Off');
		foreach($items as $item) {
			$checked = ($option==$item) ? ' checked="checked" there="'.$options[$atts['key']].'" ' : '';
			echo "<label><input ".$checked." value='$item' name='" . $name . "' type='radio' /> $item</label><br />";
		}

	}

	
	public function options_type( $type = 'cdc_theme_options' ){
		switch ( $type ) {
			case 'postmedia_home_page_options' :
				return postmedia_get_home_page_options();
				break;
			case 'postmedia_curated_feed_options' :
				return postmedia_get_curated_feed_options();
				break;
			default :
				return postmedia_get_theme_options();
				break;
		}
	}
	/**
	 * Display Discussion Posts for display on the homepage
	 *
	 * @uses	cdc_get_home_page_options()
	 *
	 * @since 1.0.0
	 * @author jbracken/c.bavota
	 *
	 * @todo Determine a final reasonable number of discussions to show in the drop down
	 */
	public function feature_dropdown( $atts ) {
		$options = $this->options_type( $atts['name'] );
		$name = $atts['name'] . '[' . $atts['key'] .']';

		echo '<select name="' . esc_attr( $name ) . '">';

		// current choice
		if ( ! empty( $options[$atts['key']] ) && ( $the_post = get_post( $options[$atts['key']] ) ) )
			echo '<option value="' . $the_post->ID . '" selected="selected">' . esc_html( $the_post->post_title ) . '</option>';

		$query_args = wp_parse_args( $atts['query_args'], array(
			'numberposts'   => 50,
			'orderby'       => 'modified',
			'exclude'       => array( $options[$atts['key']] ),
		) );
		$the_posts = get_posts( $query_args );

		foreach ( $the_posts as $the_post ) {
			
			echo '<option value="' . $the_post->ID . '">' . ucfirst( get_post_type( $the_post->ID ) ) . ' - ' . esc_html( $the_post->post_title ) . '</option>';
		}

		echo '</select>';
	}

	/**
	 * Theme options validation function
	 *
	 * @uses	postmedia_theme_option()  Get the theme options
	 *
	 * @since 1.0.0
	 * @author c.bavota
	 */
	public function postmedia_theme_options_validate( $input ) {
		$options = '';

		$options['facebook_app_id'] = trim( sanitize_text_field( $input['facebook_app_id'] ) );
		$options['facebook_page_id'] = trim( sanitize_text_field( $input['facebook_page_id'] ) );

		$options['rss_feed_link'] = esc_url_raw( $input['rss_feed_link'] );
		$options['facebook_link'] = esc_url_raw( $input['facebook_link'] );
		$options['twitter_link'] = esc_url_raw( $input['twitter_link'] );
		$options['pinterest_link'] = esc_url_raw( $input['pinterest_link'] );
		$options['linkedin_link'] = esc_url_raw( $input['linkedin_link'] );
		$options['tumblr_link'] = esc_url_raw( $input['tumblr_link'] );
		$options['google_link'] = esc_url_raw( $input['google_link'] );

		$options['promo_ad_creative'] = esc_html( $input['promo_ad_creative'] );
		$options['promo_ad_link'] = esc_html( $input['promo_ad_link'] );
		$options['promo_ad_options'] = esc_html( $input['promo_ad_options'] );
		$options['promo_ad_options_singular'] = esc_html( $input['promo_ad_options_singular'] );
		
		//Seb: Added Chartbeat options
		$options['chartbeat_host'] = sanitize_text_field( $input['chartbeat_host'] );
		$options['chartbeat_section'] = sanitize_text_field( $input['chartbeat_section'] );
		$options['chartbeat_api_key'] = sanitize_text_field( $input['chartbeat_api_key'] );
		$options['chartbeat_limit'] = sanitize_text_field( $input['chartbeat_limit'] );
		
		$options['alert_options'] = esc_html( $input['alert_options'] );


		return $options;
	}
	
	/**
	 * Home page options validation function
	 *
	 * @uses	postmedia_get_home_page_options()  Get the theme options
	 *
	 * @since 1.0.0
	 * @author jbracken/c.bavota/
	 */
	public function postmedia_home_page_options_validate( $input ) {
		$options = get_option( 'postmedia_theme_options' );

		$options['postmedia_home_page_one'] = (int) $input['postmedia_home_page_one'];
		$options['postmedia_home_page_two'] = (int) $input['postmedia_home_page_two'];
		$options['postmedia_home_page_three'] = (int) $input['postmedia_home_page_three'];
		$options['postmedia_home_page_four'] = (int) $input['postmedia_home_page_four'];
		$options['disaster_options'] = esc_html( $input['disaster_options'] );

		return $options;
	}
	
	
	/**
	 * Custom feed options validation function
	 *
	 * @uses	postmedia_get_home_page_options()  Get the theme options
	 *
	 * @since 1.0.0
	 * @author jbracken/c.bavota/
	 */
	public function postmedia_curated_feed_options_validate( $input ) {
		$options = get_option( 'postmedia_theme_options' );

		$options['postmedia_curated_feed_one'] = (int) $input['postmedia_curated_feed_one'];
		$options['postmedia_curated_feed_two'] = (int) $input['postmedia_curated_feed_two'];
		$options['postmedia_curated_feed_three'] = (int) $input['postmedia_curated_feed_three'];
		$options['postmedia_curated_feed_four'] = (int) $input['postmedia_curated_feed_four'];
		$options['postmedia_curated_feed_five'] = (int) $input['postmedia_curated_feed_five'];
		$options['postmedia_curated_feed_six'] = (int) $input['postmedia_curated_feed_six'];
		$options['postmedia_curated_feed_seven'] = (int) $input['postmedia_curated_feed_seven'];
		$options['postmedia_curated_feed_eight'] = (int) $input['postmedia_curated_feed_eight'];
		$options['postmedia_curated_feed_nine'] = (int) $input['postmedia_curated_feed_nine'];
		$options['postmedia_curated_feed_ten'] = (int) $input['postmedia_curated_feed_ten'];
		
		return $options;
	}
	

	/**
	 * Add theme options page to wp-admin
	 *
	 * @uses	add_theme_page()  Add page to appearance panel
	 *
	 * @since 1.0.0
	 * @author c.bavota
	 */
	public function admin_menu() {
		//Home page
		add_theme_page( 'Home Page', 'Home Page', 'manage_options', 'postmedia_home_page_options', array( $this, 'home_page_options_render_page' ) );
		//Curated feed page
		add_theme_page( 'Curated Feed', 'Curated Feed', 'manage_options', 'postmedia_curated_feed_options', array( $this, 'curated_feed_options_render_page' ) );

		// Theme options page
		add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'postmedia_theme_options', array( $this, 'theme_options_render_page' ) );
	}

	/**
	 * What appears on the theme options page
	 *
	 * @uses	screen_icon()  Get the screen icon
	 * @uses	get_current_theme()  Get current theme name
	 * @uses	settings_errors()  Display any settings errors
	 * @uses	settings_fields()  Establish the settings field
	 * @uses	postmedia_theme_option()  Get theme options
	 * @uses	submit_button()  Display submit button
	 *
	 * @since 1.0.0
	 * @author c.bavota
	 *
	 * @todo	Complete page
	 */
	public function theme_options_render_page() {
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php echo get_admin_page_title(); ?></h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'postmedia_theme_options' );
					do_settings_sections( 'postmedia_theme_options' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}
	
	/**
	 * What appears on the Home Page Options page
	 *
	 * @since 1.0.0
	 * @author jbracken/c.bavota
	 *
	 */
	public function home_page_options_render_page() {
		$options = postmedia_get_home_page_options();
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php echo get_admin_page_title(); ?></h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'postmedia_home_page_options' );
					do_settings_sections( 'postmedia_home_page_options' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}
	
	/**
	 * What appears on the Curated Feed Options page
	 *
	 * @since 1.0.0
	 * @author jbracken/c.bavota
	 *
	 */
	public function curated_feed_options_render_page() {
		$options = postmedia_get_curated_feed_options();
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php echo get_admin_page_title(); ?></h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'postmedia_curated_feed_options' );
					do_settings_sections( 'postmedia_curated_feed_options' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}


}

	

/**
 * Function to return the home page theme options
 *
 * @uses	get_option()  Retrieve option
 *
 * @since 1.0.0
 * @author jbracken/c.bavota
 */
function postmedia_get_home_page_options() {
	$default_theme_options = array(
		'postmedia_home_page_one' => '',
		'postmedia_home_page_two' => '',
		'postmedia_home_page_three' => '',
		'postmedia_home_page_four' => '',
		'disaster_options' => '',
		
	);

	return wp_parse_args( get_option( 'postmedia_home_page_options' ), $default_theme_options );
}


/**
 * Function to return the curated feed theme options
 *
 * @uses	get_option()  Retrieve option
 *
 * @since 1.0.0
 * @author jbracken/c.bavota
 */
function postmedia_get_curated_feed_options() {
	$default_theme_options = array(
		'postmedia_curated_feed_one' => '',
		'postmedia_curated_feed_two' => '',
		'postmedia_curated_feed_three' => '',
		'postmedia_curated_feed_four' => '',
		'postmedia_curated_feed_five' => '',
		'postmedia_curated_feed_six' => '',
		'postmedia_curated_feed_seven' => '',
		'postmedia_curated_feed_eight' => '',
		'postmedia_curated_feed_nine' => '',
		'postmedia_curated_feed_ten' => '',
	);

	return wp_parse_args( get_option( 'postmedia_curated_feed_options' ), $default_theme_options );
}


$postmedia_theme_options = new postmedia_Theme_Options;

/**
 * Function to return the theme options
 *
 * @uses	get_option()  Retrieve option
 *
 * @since 1.0.0
 * @author c.bavota
 */
function postmedia_theme_option( $option = "" ) {
	$default_theme_options = array(
		'facebook_app_id' => '239752276115767', //this is Ghalis ID - the one from www.canada.com is - 380186209696
		'facebook_page_id' => '42682032028',
		'rss_feed_link' => 'http://www.canada.com/aboutus/sitemap.html',
		'facebook_link' => 'http://www.facebook.com/canada.com',
		'twitter_link' => 'https://twitter.com/#!/thecanadacom',
		'pinterest_link' => 'http://pinterest.com/canadalifestyle/',
		'tumblr_link' => 'http://windsorstar.tumblr.com/',
		'linkedin_link' => '',
		'google_link' => '',
		'promo_ad_creative' => 'Enter a URL for the ad creative',
		'promo_ad_link' => 'Enter the Destination URL',
		'promo_ad_options' => 'Off',
		'promo_ad_options_singular' => 'Off',
		'chartbeat_host' => 'postmedia',
		'chartbeat_section' => 'games.postmedia.com',
		'chartbeat_api_key' => 'e917aed8dde6cee4e8d1a04580d9616f',
		'chartbeat_limit' => '5',
		'alert_options' => 'Off'

	);

	$options = wp_parse_args( get_option( 'postmedia_theme_options' ), $default_theme_options );
	
	if ( $option == "" ) {
		return $options;
	} 
	
	return $options[$option];
}