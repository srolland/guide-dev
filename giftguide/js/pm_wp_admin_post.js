/**
 * JS related to WP Admin Post page 
 */

/**
 * This function checks the DOM for attachment description elements and
 * removes them.
 * 
 * This seems to be the only way to remove the field from the pop up
 */
function pm_wp_admin_configure_media_admin() {
	descriptionElement = jQuery('.attachment-details label[data-setting="description"]');
	
	if(descriptionElement.length > 0) {
		descriptionElement.hide();
	}	
	
	setTimeout(pm_wp_admin_configure_media_admin, 200);
}
pm_wp_admin_configure_media_admin();


 
/**
 * Remove description field from media editor (post)
 * 
 * This option is hardcoded in wp-admin/includes/media.php ( no hooks available to remove it )
 */
jQuery(function(){
	jQuery('label[for="content"]').hide();
	jQuery('#wp-attachment_content-wrap').hide();
});
