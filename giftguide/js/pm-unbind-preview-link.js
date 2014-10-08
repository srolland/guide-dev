//Removes the javascript redirect on the post preview link in the admin section 
jQuery(document).ready(function(){
	jQuery( "#post-preview").unbind( "click" );
});