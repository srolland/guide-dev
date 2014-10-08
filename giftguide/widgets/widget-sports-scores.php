<?php
/**
 * Sports Scores - restyles timbit
 *
 */

class Postmedia_Widget_Sports_Scores extends WP_Widget {
	
	private $i_max_scores = 20;
	private $i_score_count = 100;
	private $s_css_sports_scores_url = 'http://www.windsorstar.com/css/responsive/sports_scores.css';
	private $s_js_carousel_url = 'http://www.windsorstar.com/js/responsive/jquery.npcarousel.js';
	private $s_js_sports_scores_url = 'http://www.windsorstar.com/js/responsive/jquery.pnsportsscores.js';
	private $s_timbit_url = 'http://tb-general.canada.com/scoreboard/ticker';
	
	function __construct() {
		parent::__construct('postmedia_sports_scores', 'Postmedia - Sports Scores', array(
			'classname' => 'postmedia_sports_scores',
			'description' => 'Scores by league'
		));
	}
	
	function form($a_saved) {
		
		$a_leagues = array(
			'cfl' => 'CFL',
			'mlb' => 'MLB',
			'nba' => 'NBA',
			'nfl' => 'NFL',
			'nhl' => 'NHL'
		);
		$a_widget = wp_parse_args((array) $a_saved, array(
			'league' => NULL,
			'maxscores' => $this->i_max_scores, // not editable for now
			'scorecount' => $this->i_score_count // not editable for now
		));
		
		// preferred league
		?><p><label for="<?php echo $this->get_field_id('league'); ?>">Preferred league: <select id="<?php echo $this->get_field_id('league'); ?>" name="<?php echo $this->get_field_name('league'); ?>">
			<option value="">(Default)</option><?php
		
		foreach ($a_leagues as $key => $value) {
			?><option value="<?php echo esc_attr($key); ?>"<?php selected($key, $a_widget['league']); ?>><?php echo esc_attr($value); ?></option><?php
		}
		
		?></select></label></p><?php
	}
	
	function update($a_input, $a_saved) {
		
		// start with saved
		$a_updated = $a_saved;
		
		// sanitize input
		$a_updated['league'] = sanitize_text_field($a_input['league']);
		$a_updated['maxscores'] = isset($a_input['maxscores']) ? (int) $a_input['maxscores'] : $this->i_max_scores;
		$a_updated['scorecount'] = isset($a_input['scorecount']) ? (int) $a_input['scorecount'] : $this->i_score_count;
		
		return $a_updated;
	}
	
	function widget($args, $a_widget) {
		
		// apply wrap if specified or if title present
		echo $args['before_widget'];
		
		?><link rel="stylesheet" type="text/css" href="<?php echo esc_attr($this->s_css_sports_scores_url); ?>" />
		<div id="pnSportsScoresSidebar" class="pnSportsScores" style="margin:20px 0"><?php
		
		// get timbit
		echo wpcom_vip_file_get_contents($this->s_timbit_url.'?maxscores='.(int) $a_widget['maxscores'].'&scorecount='.(int) $a_widget['scorecount']);
		
		?></div>
		<script type="text/javascript" src="<?php echo esc_js($this->s_js_carousel_url); ?>"></script>
		<script type="text/javascript" src="<?php echo esc_js($this->s_js_sports_scores_url); ?>"></script>
		<script type="text/javascript">
			jQuery(document).ready(function () {
				jQuery('#pnSportsScoresSidebar').pnSportsScores(<?php
		
		if (!empty($a_widget['league'])) {
					?>{league: '<?php echo esc_js($a_widget['league']); ?>'}<?php
		}
		
				?>);
			});
		</script>

		<?php
		
		// end wrap
		echo $args['after_widget'];
	}
}

register_widget('Postmedia_Widget_Sports_Scores');

?>
