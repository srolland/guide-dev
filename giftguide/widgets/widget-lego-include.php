<?php
/**
 * Lego include - calls /scripts/include.aspx for remote includes
 *
 */

class Postmedia_Widget_Lego_Include extends WP_Widget {
	
	function __construct() {
		parent::__construct('postmedia_lego_include', 'Postmedia - Lego Include', array(
			'classname' => 'postmedia_lego_include',
			'description' => 'Remote include from Lego'
		));
	}
	
	function form($a_saved) {
		
		$a_widget = wp_parse_args((array) $a_saved, array(
			'file' => NULL,
			'host' => 'www.windsorstar.com',
			'title' => NULL,
			'wrap' => 1,
		));
		
		// title
		?><p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($a_widget['title']); ?>" class="widefat" /></label></p><?php
		
		// file
		?><p><label for="<?php echo $this->get_field_id('file'); ?>">File: <input type="text" id="<?php echo $this->get_field_id('file'); ?>" name="<?php echo $this->get_field_name('file'); ?>" value="<?php echo esc_attr($a_widget['file']); ?>" class="widefat" /></label></p><?php
		
		// host
		?><p><label for="<?php echo $this->get_field_id('host'); ?>">Host: <input type="text" id="<?php echo $this->get_field_id('host'); ?>" name="<?php echo $this->get_field_name('host'); ?>" value="<?php echo esc_attr($a_widget['host']); ?>" class="widefat" /></label></p><?php
		
		// wrap
		?><p><label for="<?php echo $this->get_field_id('wrap'); ?>"><input type="checkbox" id="<?php echo $this->get_field_id('wrap'); ?>" name="<?php echo $this->get_field_name('wrap'); ?>" value="1"<?php checked(!!$a_widget['wrap'] || !empty($a_widget['title'])); disabled(!empty($a_widget['title'])); ?> /> Apply wrappers</label></p><?php
		
		// force wrap when title
		?><script type="text/javascript">
			jQuery('#<?php echo $this->get_field_id('title'); ?>').bind('keyup', function () {
				var b = !!jQuery(this).val().length,
					oInWrap = jQuery('#<?php echo $this->get_field_id('wrap'); ?>');
				oInWrap.attr('disabled', b);
				if (b) {
					oInWrap.attr('checked', b);
				}
			});
		</script><?
	}
	
	function update($a_input, $a_saved) {
		
		// start with saved
		$a_updated = $a_saved;
		
		// sanitize input
		$a_updated['file'] = sanitize_text_field($a_input['file']);
		if (preg_match('/^([a-z\d_\-]+\.)+[a-z]{2,}$/i', $a_input['host'])) {
			$a_updated['host'] = strtolower($a_input['host']);
		}
		$a_updated['title'] = sanitize_text_field($a_input['title']);
		$a_updated['wrap'] = !empty($a_updated['title']) || isset($a_input['wrap']) ? 1 : 0;
		
		return $a_updated;
	}
	
	function widget($args, $a_widget) {
		
		// get wrappers
		extract($args, EXTR_SKIP);
		
		// filter title
		$s_title = !empty($a_widget['title']) ? apply_filters('widget_title', $a_widget['title']) : NULL;
		
		// apply wrap if specified or if title present
		echo !empty($s_title) || $a_widget['wrap'] ? $before_widget : NULL;
		if (!empty($s_title)) {
			echo $before_title.$s_title.$after_title;
		}
		
		// call Lego include
		?><script type="text/javascript" src="<?php echo esc_url('http://'.$a_widget['host'].'/scripts/include.aspx?file='.$a_widget['file'].'&amp;applyincludes=true'); ?>"></script><?php
		
		// end wrap
		echo !empty($s_title) || $a_widget['wrap'] ? $after_widget : NULL;
	}
}

register_widget('Postmedia_Widget_Lego_Include');

?>
