( function($) {
	// Responsive videos
	var all_videos = $( '.post-content' ).find( 'iframe[src^="http://player.vimeo.com"], iframe[src^="http://www.youtube.com"], iframe[src^="http://www.dailymotion.com"], object, embed' ),
		stickyHeaderTop,
     	top_offset = ( $( 'body' ).hasClass( 'admin-bar' ) ) ? 213 : 185,
    	input = document.createElement( 'input' ),
    	is_sticky = false,
    	in_use = false,
    	timer,
    	i,
    	boxWidth = 300,
		boxHeight = 250,
		adSlots = [];
		
		
    	/*Seb: CDC footer function vars */
    	breaking_point_tablet = 768;
    	
    $('#top-nav-search').toggle(200);	
    
   /*
 $('#container').isotope({
	    itemSelector: '.item',
	    masonry: {
	      columnWidth: 340
	    }
    });
*/

  
  
  
  
    $('a.memory_text').colorbox({html:function(){
  var txt = jQuery(this).children("span").html();//var txt = $(this).attr('rel');
  return '<p>'+txt+'</p>';}, width:"60%", onComplete:function(){ 
	            jQuery("#colorbox").append( "<ul id=\"cboxSocials\"><li><div class=\"fb-like\" data-href=\"" + jQuery(this).attr('data-href') + "\" data-layout=\"button\" data-action=\"like\" data-show-faces=\"false\" data-share=\"false\"></div></li>  <li><iframe allowtransparency=\"true\" frameborder=\"0\" scrolling=\"no\" src=\"http://platform.twitter.com/widgets/tweet_button.html?url="+jQuery(this).attr('data-href')+"&count=none&via=canadadotcom&text=Explore this and other submissions on Postmedia's Great War Memory Project\" style=\"width:55px; height:21px;\"></iframe></li>    <li><div class=\"g-plusone\" data-annotation=\"none\" data-size=\"medium\" data-href=\"" + jQuery(this).attr('data-href') + "\"></div></li>     <li class=\"last\"><a href=\"//www.pinterest.com/pin/create/button/?url=" + escape(jQuery(this).attr('data-href')) + "&media=http%3A%2F%2Fww1.canada.com%2Fwp-content%2Fuploads%2F2014%2F06%2FPlaceholder-memoryproject-textbaseditems-930x600.jpg&description=Explore%20this%20and%20other%20submissions%20on%20Postmedia%27s%20Great%20War%20Memory%20Project\" data-pin-do=\"buttonPin\" data-pin-config=\"beside\" target=\"\_BLANK\"><img src=\"//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png\" /></a></li>" );
	            
	             FB.XFBML.parse();
	             var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				 po.src = 'https://apis.google.com/js/platform.js';
	             var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	           
            },
            
            onClosed:function(){
	            
	            jQuery("#cboxSocials").remove();
	            
            }
            
  
  
  
  });
    //$('a.memory').hover(function(event) { alert( "Handler for .click() called." );event.preventDefault();  });
    
     $(document).bind('cbox_complete', function(){
		$('#cboxTitle').hide();
		$('#cboxLoadedContent').bind('mouseover', function(){
		$('#cboxTitle').slideDown();
	});
	$('#cboxOverlay').bind('mouseover', function(){
   		$('#cboxTitle').slideUp();
   	});
  });

  //Hide Share button in iOs 6
  	if(navigator.userAgent.toLowerCase().indexOf("os 6") >  - 1 ){
  		$("li.share").remove();
	}
    
    function GetUserAgent() {			
			var userAgents = ['mozilla','msie','webkit','iphone','ipad','ipod','android','blackberry'];
			var retAgent = '';
			for(var i = 0;i<userAgents.length;i++) {
				if(navigator.userAgent.toLowerCase().indexOf(userAgents[i]) >  - 1){
					retAgent = userAgents[i];
				}
			}			
			return retAgent;
		}
    
    jQuery('.events-footer')
    			.toggleClass( 'opened' )
				.find( 'ul.sub-menu' ).slideToggle();
		
		jQuery('.events-footer > a').click(function( event ) {
		  event.preventDefault();
		});
				
		var userAgent = GetUserAgent();
		
		if( userAgent == 'iphone' || userAgent == 'ipod' || userAgent == 'android' || userAgent == 'blackberry'){
			
			//jQuery('#mainSlider').removeClass('flexslider');
			
			jQuery('#mainSlider').flexslider({
				animation: "fade",
				pauseOnAction: true, 
				after: function(slider) { if (!slider.playing) { slider.play(); } }
			});
			
			jQuery('.flexCarrousel').flexslider({
				animation: "slide",
				animationLoop: true,
				itemWidth: 171,
				minItems: 2,
				maxItems: 2
			});
			
		} else {
		
			jQuery('#mainSlider').flexslider({
				animation: "fade",
				pauseOnAction: true, 
				after: function(slider) { if (!slider.playing) { slider.play(); } }
			});
			
			jQuery('.flexCarrousel').flexslider({
				animation: "slide",
				animationLoop: true,
				itemWidth: 171,
				minItems: 4,
				maxItems: 4,
				controlNav: false
			});
		}
		
		jQuery('#videoSlider').flexslider({
			animation: "fade",
			pauseOnAction: true, 
			after: function(slider) { if (!slider.playing) { slider.play(); } }
		});
		
		jQuery('#photoSlider').flexslider({
			animation: "fade",
			pauseOnAction: true, 
			after: function(slider) { if (!slider.playing) { slider.play(); } }
		});
		
		
		jQuery('.flexSidebarCarrousel').flexslider({
				animation: "slide",
				animationLoop: true,
				itemWidth: 171,
				minItems: 2,
				maxItems: 2
			});
			
			

    function stickyHeader() {
		return ( $( 'body' ).hasClass( 'admin-bar' ) ) ? $( '#page' ).offset().top + 150 : $( '#page' ).offset().top +220;
    } 
    
    /* Seb - hover subnav reveal */ 
    $('li.events > a').click(function (event){ event.preventDefault();});
    
	$('li.events').hover(function(){ $("li.events > .sub-menu").slideDown('fast'); $('li.events > a').addClass('menu_hover'); },
	function(){ $("li.events > .sub-menu").stop().slideUp('fast'); $('li.events > a').removeClass('menu_hover'); });
	
	
	$('#top-search-btn ').click( 
		function() { 
			if( $(this).hasClass('active') ) {  
		
				$('#top-nav-search').stop().slideUp('fast');
			 	$('#top-search-btn').removeClass('active');
			 	 
			 	$('#top-search-icon').removeClass('icon-angle-up'); 
			 	$('#top-search-icon').addClass('icon-search'); 
			 		 
			
			 } else {
		
				$(this).addClass('active'); 
				$('#top-nav-search').stop().slideDown('fast'); 		
				
				$('#top-search-icon').removeClass('icon-search'); 
			 	$('#top-search-icon').addClass('icon-angle-up');
		 
			}
		}        
	);
		

	all_videos.each(function() {
		var el = $(this);
		el
			.attr( 'data-aspectRatio', el.height() / el.width() )
			.attr( 'data-oldWidth', el.attr( 'width' ) );
	} );

	$(window)
		.resize( function() {
			all_videos.each( function() {
				var el = $(this),
					newWidth = el.parents( '.post-content' ).width(),
					oldWidth = el.attr( 'data-oldWidth' );

				if ( oldWidth > newWidth ) {
					el
						.removeAttr( 'height' )
						.removeAttr( 'width' )
					    .width( newWidth )
				    	.height( newWidth * el.attr( 'data-aspectRatio' ) );
				}
			} );

			if ( $(window).width() <= 768 ) {
				$( '#footer-menus' )
					.find( 'nav ul' ).hide()
					.end()
					.find( 'h3' ).addClass( 'mobile' );
				stickyHeaderTop = stickyHeader();
				top_offset = ( $( 'body' ).hasClass( 'admin-bar' ) ) ? 100 : 72;
			} else {
				$( '#footer-menus' )
					.find( 'nav ul' ).show()
					.end()
					.find( 'h3' ).removeClass( 'mobile' );
				$( '#mobile-header-menu' ).hide();
				$( 'body' ).removeClass( 'opened' );
				stickyHeaderTop = stickyHeader();
			}
			if ( $(window).width() <= 600 ) {
				stickyHeaderTop = stickyHeader();
			}
			
			/*Seb: added CDC footer menu nav funtion */
			if ( breaking_point_tablet > $(window).width() ) {
				$( '.footer-widget-title' ).addClass( 'mobile' );
			} else {
				$( '.footer-widget-title' ).removeClass( 'mobile' );
				$( '.footer-widget ul' ).show();
			}

		} )
		.scroll(function(){
			if ( $(window).scrollTop() > stickyHeaderTop ){
				$( 'body' ).addClass( 'sticky-header' );
				is_sticky = true;
			}else{
				$( 'body' ).removeClass( 'sticky-header' );
				is_sticky = false;
			}
		} )
		.resize()

	// Placeholder fix for older browsers
    if ( ( 'placeholder' in input ) == false ) {
		$( '[placeholder]' ).focus( function() {
			i = $( this );
			if ( i.val() == i.attr( 'placeholder' ) ) {
				i.val( '' ).removeClass( 'placeholder' );
				if ( i.hasClass( 'password' ) ) {
					i.removeClass( 'password' );
					this.type = 'password';
				}
			}
		} ).blur( function() {
			i = $( this );
			if ( i.val() == '' || i.val() == i.attr( 'placeholder' ) ) {
				if ( this.type == 'password' ) {
					i.addClass( 'password' );
					this.type = 'text';
				}
				i.addClass( 'placeholder' ).val( i.attr( 'placeholder' ) );
			}
		} ).blur().parents( 'form' ).submit( function() {
			$( this ).find( '[placeholder]' ).each( function() {
				i = $( this );
				if ( i.val() == i.attr( 'placeholder' ) )
					i.val( '' );
			} )
		} );
	}

	// Comments button
	$( '#primary' ).find( '.comments-button' ).click( function(e) {
		e.preventDefault();
		$( 'html, body' ).animate( { scrollTop: $( '#facebook-comments' ).offset().top - top_offset } );
	} );

	// Mobile menu
	$( '#mobile' ).find( '.mobile-nav .button.mobile-events, .mobile-nav .button.mobile-menu, .mobile-nav .button.mobile-search' ).click( function(e) {
		e.preventDefault();
		var h = $( '#mobile-footer-menu' ).height() + 100
			hMenu = 672
			hMobile = $( '#mobile' ).height();
				
		//Seb: refined mobile nav scroll offsets for specific nav buttons
		//$( 'html, body' ).animate( { scrollTop: $( '#footer-menus' ).offset().top - h } );
		
		if ( $( this ).is( ".button.mobile-search" ) ) {
			
			if ( GetUserAgent() == "ipad"){
				$( 'html, body' ).animate( { scrollTop: $( '#footer-menus' ).offset().top - 735 }, function () {$( "#mobile-footer-menu input[name='s']" ).focus();} );
				return
			} else if ( GetUserAgent() == "iphone" && is_sticky == true ){
				$( 'html, body' ).animate( { scrollTop: $( '#footer-menus' ).offset().top - 640 }, function () {$( "#mobile-footer-menu input[name='s']" ).focus();} );
				return
			}else {
				$( 'html, body' ).animate( { scrollTop: $( '#footer-menus' ).offset().top - h }, function () {$( "#mobile-footer-menu input[name='s']" ).focus();} );
				return
			}
		}
		
		if ( $( this ).is( ".button.mobile-events" ) ) {
			$( 'html, body' ).animate( { scrollTop: $( '#mobile-footer-menu li.events-footer' ).offset().top - hMobile } );
			return
		}
		
		if ( $( this ).is( ".button.mobile-menu" ) ) {		
			//$( 'html, body' ).animate( { scrollTop: $( '#mobile-footer-menu li.news-footer' ).offset().top  } );
			$( 'html, body' ).animate( { scrollTop: $( '#mobile-footer-menu li.footer-nav-first' ).offset().top - hMobile } );
			return
		}
		
		$( 'html, body' ).animate( { scrollTop: $( '#footer-menus' ).offset().top - h } );
		
		
	} );
		
	// Mobile footer
	$( '#footer-menus' ).on( 'click', 'h3.mobile', function() {
		$(this).parent().find( 'ul' ).slideToggle();
	} );

	$( '.mobile-main-menu' )
		.find( '.sub-menu' ).each( function() {
			$(this).before( '<i class="icon-chevron-down"></i>' );
		} )
		.end()
		.on( 'click', 'i', function() {
			$(this)
				.toggleClass( 'icon-chevron-down' )
				.toggleClass( 'icon-remove' )
				.parent().toggleClass( 'opened' )
				.find( 'ul.sub-menu' ).slideToggle();
		} );
		

	// Share button
	$( '#social-bar' ).find( '.share-button' ).click( function(e) {
		e.preventDefault();
		$(this).toggleClass( 'selected' );
		$( '#social-share' ).toggle();
	} );

	// Mobile footer
	$( '#footer-menus' ).on( 'click', 'h3.mobile', function() {
		$(this).parent().find( 'ul' ).stop().slideToggle();
		$(this).toggleClass('open');
	} );

	// External link script
	$( 'a[href^="http://"], a[href^="https://"]' ).not( 'a[href^="http://www.windsorstar.com"]' )
		.filter( function() {
			if ( 0 == $(this).parents( '.target-self' ).length )
				return $(this);
		} )
		.each( function() {
			var a = new RegExp( '/' + window.location.host + '/' );
			if ( ! a.test( this.href ) )
				$(this).attr( 'target', '_blank' );
		} );
	
} )(jQuery);