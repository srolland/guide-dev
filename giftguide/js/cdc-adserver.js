/**
 *
 * Drives all Ads
 *
 * @author Postmedia Digital mghali@postmedia.com
 * @version 0.1
 *
 *@example
 * DART : http: //ad.ca.doubleclick.net/N3081/adj/calgaryherald.com/index;loc=theTop;loc=top;sz=468x60,728x90;dcopt=ist;kw=ron;nk=print;pr=ch;ck=index;imp=index;kw=ch;tile="+dartad_tile+";"+adcookieTag+surroundTag+"ord=34747567?"; // script ad code with adcookie, used for debug
 *
 *@example
 * DFP :
 * googletag.cmd.push(function() {
 * 		googletag.defineSlot("/3081/ch.m/index", [[300,50],[320,50]], "div-gpt-ad-1").addService(googletag.pubads()).
 * 		.setTargeting("loc", "top")
 * 		.setTargeting("tile", "1")
 * 		.setTargeting("nk","print")
 * 		.setTargeting("pr","ch");
 * 		googletag.enableServices();
 * 	});
 *
 *@example
 *<div id="div-dart-ad-1" class="ad" data-mobile="false"><script type="text/javascript">Postmedia.AdServer.Write({id:"div-dart-ad-1",size:"banner", keys:{ "loc": "top"}, mobile: false })</script></div>
 *
 */

Postmedia.AdServer = (function ($) {

	/**
	 * @type object ad object holds all global ad vriables loccally
	 */
	var ad = {
		provider: '',
		widthLimit: 728,
		ord: '',
		size: {
			banner: {
				desktop: "728x90,960x86",
				mobile: [[300, 50], [320, 50]]
			},
			bbox: {
				desktop: "300x250,300x251",
				mobile: [300, 250]
			},
			boxbanner: {
				desktop: "300x250,300x251",
				mobile: [[300, 50], [320, 50]]
			}
		},
		deviceWidth: $( window ).width()
	};

	ad.networkCode = (Postmedia.adConfig.networkCode) ? Postmedia.adConfig.networkCode : "3081";
	ad.adSite = (Postmedia.adConfig.site) ? Postmedia.adConfig.site : "ccn.com";
	ad.mSite = (Postmedia.adConfig.msite) ? Postmedia.adConfig.msite : "ccn.m";
	ad.zone = (Postmedia.adConfig.zone) ? Postmedia.adConfig.zone : "index";
	ad.keys = Postmedia.adConfig.keys;
	ad.provider = (ad.deviceWidth > ad.widthLimit) ? "DART" : "DFP";

	/**
	 * Load google tags and set DFP+ to Async if not loaded
	 */
	if( typeof(window.googletag) == "undefined" ){

		Log("Did not find googletags: Loading googletags in Async mode");

		window.googletag = {};
		window.googletag.cmd = [];

		var useSSL = "https:" == document.location.protocol;
		var src = (useSSL ? "https:" : "http:") + "//www.googletagservices.com/tag/js/gpt_mobile.js";
		$.getScript(src);

		googletag.cmd.push(function() {
			googletag.pubads().enableAsyncRendering();
		});

	}

	/**
	 * Set initial order number
	 */
	SetOrd();

    function Init() {
        /**
		 * This class is self initiating not sure if there is a need to use an initializer.
		 * moved init functionality above, shoul look into this later if needed.
		 */
    }

	/**
	 * Generate ordinal for adcode
	 *
	 * @returns {number} ord Number for DART
	 */
	function GenOrd() {
        return Math.floor((Math.random() * 100000000) + 1);
    }
	/**
	 * Sets ad.ord with nre ordinal
	 */
    function SetOrd() {
        ad.ord = GenOrd();
    }

    DFP = {

		index:0,
		slots:[],
		GetSize:function(s){

			/**
			 * if the size passed is an array then it is a custom size,
			 * return size
			 */
			if($.isArray(s)){

			  return s;

			/**
			 * Else if it is a string then it is one of the preset sizes in the library:
			 * banner , bbox , boxbanner
			 */
			}else if ((typeof s === 'string') && (ad.size[s])){

				s = s.toLowerCase();
				return ad.size[s].mobile;

			/**
			 * Let's just return any size for now.
			 */
			}else{

				/**
				 * alert developer that size is not correct format
				 */
				Log("DFP size : " + s + " is not the right format");
				return [[300, 50], [320, 50]];

			}

		}
    };

	DART = {
		index:0,
		slots:[],
		GetSize:function(s){

			/**
			 * if the size passed is an array then it is a custom size,
			 * so transform the size to be DART freindly. i.e: 250x250,300x250
			 */
			if($.isArray(s)){

				var sizeArr = [];
				$.each(s, function(index, value) {
					sizeArr.push(value[0]+"x"+value[1])
				});

			  return sizeArr.toString();

			/**
			 * Else if it is a string then it is one of the preset sizes in the library:
			 * banner , bbox , boxbanner
			 */
			}else if ((typeof s === 'string') && (ad.size[s])){

				s = s.toLowerCase();
				return ad.size[s].desktop;

			/**
			 * Let's just return any size for now.
			 */
			}else{

				/**
				 * alert developer that size is not correct format
				 */
				Log("size : " + s + " is not the right format");
				return "300x250";

			}

		}
	};

	function DfpWrite (obj){

			var slotIndex = DFP.index;
			googletag.cmd.push(function() {

				/**
				 * @todo: move DFP.slots[slotIndex] into a local gt function then push into array.
				 */
				DFP.slots[slotIndex] = googletag.defineSlot("/3081/"+ad.mSite+"/"+ad.zone, DFP.GetSize(obj.size), obj.id ).addService(googletag.pubads());
				DFP.slots[slotIndex].setTargeting("tile",slotIndex+1);
				/**
				 * Add page level targeting from the ad object if not available in page level
				 * @todo: test if we can move this to a service level rather than adding it to the adslot
				 */
				for (var prop in ad.keys) {

					/**
					 * if local keys are not available or that parameter is not overwritten locally
					 */
					if ( ad.keys.hasOwnProperty(prop) && (!obj.keys || !obj.keys.hasOwnProperty(prop)) ) {
						DFP.slots[slotIndex].setTargeting( prop , ad.keys[prop] );
					}

				}
				/**
				 * Add ad unit-level targeting
				 */
				if(obj.keys){

					for (var prop in obj.keys){
						if(obj.keys.hasOwnProperty(prop)){
								DFP.slots[slotIndex].setTargeting( prop , obj.keys[prop] );
						}

					}

					/**
					* Add Fall back for loc in the case it is not available in ad unit-level targeting
					* @todo: this fallback is useless with out tracking the ad size and tracking against it --- maybe we should just ignore and depend on unit level keys. just a thought!
					*/
				   if(!obj.keys.hasOwnProperty("loc")){

					   switch (slotIndex + 1) {
						   case 2:
							   DFP.slots[slotIndex].setTargeting("loc", "mid");
							   break;
						   case 3:
							   DFP.slots[slotIndex].setTargeting("loc", "bot");
							   break;
						   default:
							   DFP.slots[slotIndex].setTargeting("loc", "top");
							   break;
					   }

				   }

				}


				/**
				 * @todo: bench mark with sync loading enabled: googletag.pubads().enableSyncRendering()
				 */
				googletag.enableServices();
				googletag.display( obj.id );
			});
			/**
			 * increment ad slot
			 */
			DFP.index++;

	}

	function DartWrite (obj){

		    var adBlock = 'http://ad.ca.doubleclick.net/N3081/adj/' + ad.adSite + '/' + ad.zone ;
			adBlock += ';sz=' + DART.GetSize(obj.size);

			/**
			 * Add page level targeting from the ad object if not available in page level
			 */
			for (var prop in ad.keys) {

				if ( ad.keys.hasOwnProperty(prop) && (!obj.keys || !obj.keys.hasOwnProperty(prop)) &&  $.isArray(ad.keys[prop]) ) {

					Log("Write - Dart - key value is Array : "+prop+" = "+ad.keys[prop]);
					/**
					* if the key is an Array then we need to transform it to multiple keyvalues
					*/
					$.each(ad.keys[prop], function(index, value) {
						adBlock += ( ";" + prop + "=" +value);
					});

				}else if ( ad.keys.hasOwnProperty(prop) && (!obj.keys || !obj.keys.hasOwnProperty(prop)) ) {

					adBlock += ( ";" + prop + "=" +ad.keys[prop] );

				}

			}

			if(obj.keys){

				/**
				 * Add ad unit-level targeting
				 */
				for (var prop in obj.keys){

					if( obj.keys.hasOwnProperty(prop)  &&  $.isArray(obj.keys[prop]) ){

						Log("Write - Dart - key value is Array : "+prop+" = "+obj.keys[prop]);
						/**
						* if the key is an Array then we need to transform it to multiple keyvalues
						*/
						$.each(obj.keys[prop], function(index, value) {
							adBlock += ( ";" + prop + "=" +value);
						});

					}else if( obj.keys.hasOwnProperty(prop) ) {

						adBlock += ( ";" + prop + "=" +obj.keys[prop] );

					}

				}

				/**
				 * if this is the first 728x90 on the page and dcopt is not set on the page the add it in there
				 * @todo: this would set top level ads across the board maybe we should not have a fallback for this.
				 */
				if( DART.index == 0 && !obj.keys.hasOwnProperty("dcopt") && adBlock.indexOf("728x90") != -1){
					adBlock += ";dcopt=ist";
				}

				/**
				 * Add Fallback for loc in the case it is not available in ad unit-level targeting
				 * @todo: this fallback is useless with out tracking the ad size and tracking against it --- maybe we should just ignore and kill from code. just a thought!
				 */
				if(!obj.keys.hasOwnProperty("loc")){

					switch (DART.index + 1) {
						case 2:
							adBlock += ';loc=mid';
							break;
						case 3:
							adBlock += ';loc=bot';
							break;
						default:
							adBlock += ';loc=top';
							break;
					}

				}

			}

            adBlock += ';tile=' + (DART.index + 1) + ';ord=' + ad.ord;
			DART.index = DART.slots.push({ src : adBlock , id : obj.id });
			Postmedia.Data.WriteScript(adBlock, false);

			Log(adBlock);

	}

  function Write(obj) {
		var deviceWidth = $( window ).width();
		ad.provider = (deviceWidth > ad.widthLimit) ? "DART" : "DFP";

		if( ( typeof obj.mobile === "boolean" ) && obj.mobile ){

			/**
			* Write DFP+ adcode.
			* if there is an adunit level breakpoint and this is a mobile only adspot
			* else if the global provider is DFP
			*/
			if( obj.hasOwnProperty("breakpoint") && parseInt(obj.breakpoint) >= deviceWidth ){
				DfpWrite(obj);
			}else if( ad.provider === "DFP" ){
				DfpWrite(obj);
			}

		}else if ( ( typeof obj.mobile === "boolean" ) && !obj.mobile ) {

			/**
			* Write DART adcode
			* if there is an adunit level breakpoint and this is a desktop only adunit
			* else if the global provider is DART
			*/
			if( obj.hasOwnProperty("breakpoint") ) {
				if ( parseInt(obj.breakpoint) <= deviceWidth ) {
					DartWrite(obj);
				}
				/**
				 * If deviceWidth is less than the breakpoint, do not make the ad call
				 */
			}else if( ad.provider === "DART" ){
				DartWrite(obj);
			}

		}else{

			/**
			 * if adunit is mobile and desktop then check for local break and
			 * fallback on to the global adprovider and render appropriate adunit.
			 */
			if( obj.hasOwnProperty("breakpoint") ){

				if (parseInt(obj.breakpoint) <= deviceWidth){
					DartWrite(obj);
				}else {
					DfpWrite(obj);
				}

			}else if( ad.provider === "DART" ){
				DartWrite(obj);
			}else{
				DfpWrite(obj);
			}

		}

  }

	/**
	 * Get Video Ad URL
	 *
	 * @param   {null} function Description
	 *
	 * @returns {String} video ad url with page level targeting.
	 */
	function GetVideoAd() {

		var adUrl = 'http://ad.ca.doubleclick.net/N3081/pfadx/' + ad.adSite + '/' + ad.zone + ';sz=320x240,480x360' ;

		/**
		* Add page level targeting.
		*/
		for (var prop in ad.keys) {

			if ( ad.keys.hasOwnProperty(prop) &&  $.isArray(ad.keys[prop]) ) {
				/**
				* if the key is an Array then we need to transform it to multiple keyvalues
				*/
				$.each(ad.keys[prop], function(index, value) {
					adUrl += ( ";" + prop + "=" +value);
				});

			}else if ( ad.keys.hasOwnProperty(prop) ) {

				adUrl += ( ";" + prop + "=" +ad.keys[prop] );

			}

		}
        adUrl += ";tile=1;pos=pre1;ord=" + GenOrd();

		return adUrl;

    }


	/**
	 * Log
	 */
    function Log(a) {
		if ( document.location.search.indexOf("dart_debug=1") != -1 ||
			 document.location.search.indexOf("google_console=1") != -1 ) {
			console.log(a);
		}
    }

	/**
	 * DEBUG console for DART adcode for adops
	 */
	//var debug = (document.location.search.indexOf("dart_debug=1") != -1);
	if(document.location.search.indexOf("dart_debug=1") != -1){
		$(function() {

			$(document).keydown(function(e) {

				//Log('Handler for .keydown() called. keyCode: ' + e.keyCode);
				if( e.keyCode === 68 ){

					//Log(DART.slots);
					$.each( DART.slots, function(index, element) {
						var w = ad.deviceWidth;
						var h = $("#"+element.id).height();
						var offset = $("#"+element.id).offset();
						var html = '<div style="position:absolute; top:'+offset.top+'px; left:'+offset.left+'px; width:'+w+'px; height:'+h+'px;z-index:9999998; background-color:white; padding:20px;" >';
						html += (' ' + element.src + ' </div>');
						$("body").append(html)
					});

				}
			});

		});
	}


    return {
        Init: Init,
        GenOrd: GenOrd,
        GetVideoAd: GetVideoAd,
        Write: Write
    }

}(jQuery));
