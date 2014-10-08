<?php
/**
 * Uses Easy Custom Field plugin to create new meta boxes
 * Examples: /vip/plugins/easy-custom-fields/easy-custom-fields.php
 *
 * @since 1.0.0
 * @author c.bavota
 *
 * @todo add id to input fields so that clicking the label selects the field
 *
 * Seb - Added Video post type to Ooyala video meta box
 */
$field_data = array (
	/*
'cdc_featured_video_id' => array (
		'fields' => array(
			'cdc_featured_video_title' => array(
				'label' => 'Title',
				'type' => 'text'
			),
			'cdc_featured_video_image' => array(
				'label' => 'Image URL',
				'type' => 'text'
			),
			'cdc_featured_video_description' => array(
				'label' => 'Description',
				'type' => 'text'
			),
			'cdc_featured_video_id' => array(
				'label' => 'ID',
				'type' => 'text'
			)
		),
		'title' => 'Featured Video',
		'context' => 'side',
		'priority' => 'high',
		'pages' => array( 'post','video' )
	),
*/
	'cdc_discussion_headline_id' => array (
		'fields' => array(
			'cdc_discussion_headline' => array(
				'label' => 'Set home page headline',
				'hint' => 'This headline will show up on the homepage keep it sweet and simple.',
				'type' => 'text'
			)
		),
		'title' => 'Home Page Headline',
		'context' => 'advanced',
		'priority' => 'high',
		'pages' => array( 'post','video','gallery' )
	),
	
	'pm_editorial_details' => array (
		'fields' => array(
			'pm_byline' => array(
				'label' => 'Byline',
				'type' => 'text'
			),
			'pm_distributor' => array(
				'label' => 'Distributor',
				'type' => 'text'
			)
		),
		'title' => 'Other Editorial Details',
		'context' => 'normal',
		'priority' => 'core',
		'pages' => array( 'post')
	),
);

class Easy_CF_Field_Text extends Easy_CF_Field {

	public function print_form() {

		$class = ( empty( $this->_field_data['class'] ) ) ? $this->_field_data['id'] . '_class' :  $this->_field_data['class'];
		$input_class = ( empty( $this->_field_data['input_class'] ) ) ? $this->_field_data['id'] . '_input_class' :  $this->_field_data['input_class'];

		$id = ( empty( $this->_field_data['id'] ) ) ? $this->_field_data['id'] :  $this->_field_data['id'];
		$label = ( empty( $this->_field_data['label'] ) ) ? $this->_field_data['id'] :  $this->_field_data['label'];
		$value = $this->get();
		$hint = ( empty( $this->_field_data['hint'] ) ) ? '' :  '<p><em>' . $this->_field_data['hint'] . '</em></p>';

		$label_format =
			'<div class="%s">'.
			'<p><label for="%s"><strong>%s</strong></label></p>'.
			'<p><input class="%s" style="width: 100%%;" type="text" name="%s" value="%s" /></p>'.
			'%s'.
			'</div>';

		printf( $label_format, $class, $id, $label, $input_class, $id, $value, $hint );

	}

	public function set( $value, $post_id='' ) {

		if ( empty( $post_id ) ) {

			global $post;
			$post_id = $post->ID;

		}

		if ( is_callable( array( &$this->validator, 'set' ) ) )
			$value = $this->validator->set( $value );

		if ( empty( $value ) )
			$result = delete_post_meta( $post_id, $this->_field_data['id'] );
		else
			$result = update_post_meta( $post_id, $this->_field_data['id'], $value );

		return $result;

	}

}

class Easy_CF_Field_Checkbox extends Easy_CF_Field {

	public function print_form() {

		$id = ( empty( $this->_field_data['id'] ) ) ? $this->_field_data['id'] :  $this->_field_data['id'];
		$label = ( empty( $this->_field_data['label'] ) ) ? $this->_field_data['id'] :  $this->_field_data['label'];
		$value = $this->get();
		$checked = checked( $value, 'on', false );
		$hint = ( empty( $this->_field_data['hint'] ) ) ? '' :  '<p><em>' . $this->_field_data['hint'] . '</em></p>';

		printf( '<div><p><label for="%1$s"><input type="checkbox" %2$s id="%1$s" name="%1$s" /> %3$s</label></p>%4$s</div>',
			$id,
			$checked,
			$label,
			$hint
		);

	}

}

class Easy_CF_Field_Photogallery extends Easy_CF_Field {

	public function print_form() {

		$id = ( empty( $this->_field_data['id'] ) ) ? $this->_field_data['id'] :  $this->_field_data['id'];
		$label = ( empty( $this->_field_data['label'] ) ) ? $this->_field_data['id'] :  $this->_field_data['label'];
		$hint = ( empty( $this->_field_data['hint'] ) ) ? '' :  '<p><em>' . $this->_field_data['hint'] . '</em></p>';
		$post_id = get_the_ID();

		printf( '<div><p><label for="%1$s"><input onclick="this.select()" type="text" id="%1$s" name="%1$s" value="[photo_gallery id=%2$s]" readonly="readonly" /> %3$s</label></p>%4$s</div>',
			$id,
			$post_id,
			$label,
			$hint
		);

	}

}

class Easy_CF_Field_Commentbox extends Easy_CF_Field {

	public function print_form() {

		$post_id = get_the_ID();
		$permalink = get_permalink( $post_id );
		$facebook_comments = cdc_get_fb_comments( $permalink, 0, 25, $post_id );

		if ( ! empty( $facebook_comments ) ) {

			$featured_comment = get_post_meta( $post_id, 'cdc_featured_comment', true );
			$class = empty( $featured_comment ) ? '' : 'class="set"';

			printf( '<h2 id="featured-comment-selected" %1$s>Featured comment selected:</h2>',
				$class
			);

			printf( '<div id="featured-comment" %1$s data-post-id="%2$s"><div class="content">',
				$class,
				(int) $post_id
			);

			if ( ! empty( $featured_comment ) )
				printf( '<img src="%1$s" alt="" class="fb-profile-image" /><div class="fb-comment-body"><span class="fb-comment-name">%2$s</span><span class="fb-comment-text">%3$s</span><span class="fb-comment-time">%4$s</span></div>',
					esc_url( $featured_comment['image'] ),
					esc_html( $featured_comment['name'] ),
					esc_html( $featured_comment['text'] ),
					esc_html( $featured_comment['time'] )
				);

			echo '</div><span class="delete-featured-comment">Delete featured comment</span></div>';

			echo '<h2>Choose from:</h2>';
			echo '<ul id="facebook-comments">';

			echo $facebook_comments;

			echo '</ul>';

			$fb_total_comments = json_decode( wpcom_vip_file_get_contents( 'http://graph.facebook.com/' . $permalink ) );
			$fb_total_comments = ! empty( $fb_total_comments->comments ) ? $fb_total_comments->comments : 0;

			if( $fb_total_comments > 25) {

				echo '<p id="fb-loader"><img src="http://static.ak.fbcdn.net/rsrc.php/v1/y9/r/jKEcVPZFk-2.gif" alt="" /></p>';

				printf( '<div id="load-more-comments" data-limit-start="26" data-post-id="%1$s">Load more comments</div>',
					$post_id
				);

			}

		} else {

			echo 'No comments yet.';

		}

	}

	public function delete( $post_id='' ) {

		return;

	}

}

$easy_cf = new Easy_CF( $field_data );
