<?php
/**
 * From v2.o.wp.canada.com
 * 
 * @author	Chris Murphy
 * @version	1.0.0
 */
class pm_custom_media_uploader {
	public function __construct() {
		add_filter( 'attachment_fields_to_edit', array( $this, 'attachment_fields_to_edit' ), null, 2 );
		add_filter( 'attachment_fields_to_save', array( $this, 'attachment_fields_to_save' ), null, 2 );
	}

	/**
	 * Adds form fields to the media uploader
	 *
	 * @param	array $form_fields  Current form fields
	 * @param	array $post  Current post array
	 *
	 * @uses	get_post_meta()  Get the custom field value
	 *
	 * @return	array  Modifieid form fields
	 *
	 * @since 1.0.0
	 * @author c.bavota
	 */
	public function attachment_fields_to_edit( $form_fields, $post ) {
		$form_fields['pm_attachment_credit'] = array(
		    'label' => 'Credit',
			'input' => 'text',
		    'value' => get_post_meta( $post->ID, '_pm_attachment_credit', true )
		);

		return $form_fields;
	}

	/**
	 * Save function for custom form fields to the media uploader
	 *
	 * @param	array $attachment  Current attachment array
	 * @param	array $post  Current post array
	 *
	 * @uses	update_post_meta()  Update the custom field value
	 *
	 * @return	array  Modified form fields
	 *
	 * @since 1.0.0
	 * @author c.bavota
	 */
	public function attachment_fields_to_save( $post, $attachment ) {
		if ( ! empty( $attachment['pm_attachment_credit'] ) )
			update_post_meta( $post['ID'], '_pm_attachment_credit', $attachment['pm_attachment_credit'] );
		else
			delete_post_meta( $post['ID'], '_pm_attachment_credit' );

		$caption = $attachment['post_excerpt'];
		$count = strlen( $caption );

		if ( empty( $caption ) )
			$post['errors']['post_excerpt']['errors'][] = __('<span style="color: #ff0000;">Please add a caption.</span>');

		if ( 100 < $count )
			$post['errors']['post_excerpt']['errors'][] = __('<span style="color: #ff0000;">The caption limit is 100 characters.</span>');

		return $post;
	}
}
$pm_custom_media_uploader = new pm_custom_media_uploader();