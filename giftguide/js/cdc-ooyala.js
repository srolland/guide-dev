/*
 *
 * Drives the Ooyala Video Player Interface
 *
 * @author Postmedia Digital mghali@postmedia.com
 * @version 0.1
 *
 */
Postmedia.Ooyala = (function ($) {

	/**
	 * @type String ooyalaplayer base js url
	 */
	var ooyalaPlayer = 'http://player.ooyala.com/player.js?wmode=transparent';

	/**
	 * @type Array Hold an array of video objects containing embedcode and autoplay.
	 */
	var videoObjs = [];

	/**
	 * @type Number Index of current video to render on the page.
	 */
	var videoIndex = 0;

	/**
	 * disabling the init function and adding a dom ready load players. should look into overall class init later on.
	 */
	$(document).ready(function() {
		LoadPlayers();
	});

	function Init() {
		//LoadPlayers();
	}

	function LoadPlayers(){

		$('.ooyala-video').each(function () {

			var t = $(this),
				obj = {
					"embedCode" : t.attr("id"),
					"autoplay" : t.attr("data-autoplay")
				};

			if(t.attr("data-onclick") != "true"){
					videoObjs.push(obj);
			}
			else {
				$(this).click(function () {
					$(this).width($(this).parent().width());
					$(this).height(( $(this).width() * 9 ) / 16);
					RenderPlayer(obj);
				});
			}

			Log(obj);

		});

		if(videoObjs.length > 0) {
			RenderPlayer( videoObjs[videoIndex] );
		}

	}

	/**
	 * Load Ooyala Script on the page Asynchronously
	 *
	 * @param   {string} id ID of script to load
	 * @param   {string} src      Source of the script element
	 *
	 * @returns {null} null
	 */
	function LoadOoyalaScript(id, src) {

		(function (d) {

			var js;

			videoIndex++;

			if (d.getElementById(id)) {
				return;
			}

			js = d.createElement('script');
			js.id = id;
			js.async = true;
			js.src = src;

			if(videoObjs[videoIndex]) { // Are there any more unloaded players on the page?

				js.onload = function () { // Add on load Event delegate

					Log("Video Loaded let's load the next one in the Que. ");

					RenderPlayer(videoObjs[videoIndex]);

				};

				js.onreadystatechange = function () {   // Same thing but for IE

					if ( this.readyState == 'complete' ){  // Video script is Loaded!! load the next one if available

						RenderPlayer(videoObjs[videoIndex]);

					}

				};

			}

			/**
			 * window.ooyalaActiveScript would set the active ooyala script being loaded on the page.
			 * this is used by the player.js to grab the src and get the query string params.
			 */
			window.ooyalaActiveScript = js;
			//Log(window.ooyalaActiveScript);
			d.getElementsByTagName('body')[0].appendChild(js);

		}(document));

	}

	/**
	 * RenderPlayer is a Private function. Writes the Video Player into the calling DIV.
	 * note: If targetReplaceId is used in player.js the player would replace the calling div. If playerContainerId is used the player would be written in the parent DIV.
	 *
	 * @param   {Object} obj Contains video embedcode and autoplay i.e: { embedCode:'Q3aWhtNDosDG5Cucs55eOqMj5W1I1D8a' , autoplay:true }
	 *
	 * @returns {null} null
	 */
	function RenderPlayer(obj){

		var video = obj,
			parent = $("#" + video.embedCode),
			width = $(parent).width(),
			height = (width*9)/16,
			src;

		/**
		 * add videoLoaded class to be used for resizing loaded player later on.
		 */
		$(parent).addClass("videoLoaded");

		src = ooyalaPlayer + "&width=" + width + "&height=" + height + "&embedCode=" + video.embedCode + "&playerContainerId=" + video.embedCode + "&playerId=ooplayer" + video.embedCode + "&autoplay=" + video.autoplay;

		var isYoutube = (parent.attr('data-content_type') == 'youtube' ? true : false);

		if ( ! isYoutube )
			src += "&thruParam_doubleclick[tagUrl]=" + Postmedia.AdServer.GetVideoAd();

		LoadOoyalaScript("js-" + video.embedCode , src);

	}

	/**
	 * Public Write API mainly used for Synchronous Loading, but can also be used to initiate before DOM Ready
	 *
	 * @param   {object} obj Contains video embedcode and autoplay i.e: { embedCode:'Q3aWhtNDosDG5Cucs55eOqMj5W1I1D8a' , autoplay:true }
	 *
	 * @returns {null} null
	 */
	function Write(obj) {
		// Do Nothing lets try loading through Dom manipulation
		//RenderPlayer(obj);
	}


	/**
	 * resize all loaded players on the page.
	 *
	 * @param   {Number} width Width of the player
	 * @param   {Number} height   height of the player default: (width*9)/16
	 *
	 * @returns {null} null
	 */
	function ResizeLoadedPlayers(width,height){

		height = (height) ? height : (parseInt(width)*9)/16;

		/**
		 * @todo this still needs some fixing with a class level isMobile variable so that we dont query the DOM so many times.
		 */

		var ooYalaVideo = $(".videoLoaded"),
			ooYalaWrapper = $(ooYalaVideo).children(),
			ooYalaPlayer = $("embed,object,video", ooYalaWrapper);

		$(ooYalaVideo).animate({
			'width': width,
			'height': height
		}, 500);

		$(ooYalaWrapper).animate({
			'width': width,
			'height': height
		}, 500);

		$(".OoyalaHtml5VideoPlayer, .OoyalaHtml5VideoPlayer .oo_promoImage",ooYalaWrapper).animate({
			'width': width,
			'height': height
		}, 500);

		$(".videoLoaded .OoyalaHtml5VideoPlayer .oo_playButton").css("left",(width/2)-40).css("top",(height/2)-40)

		$(ooYalaPlayer).attr("width",width).attr("height",height);

		Log(ooYalaPlayer);

	}

	function Log(a){
		Postmedia.Utils.Log(a);
	}

	return {
		Init: Init,
		Write: Write,
		Resize: ResizeLoadedPlayers
	}

}(jQuery));