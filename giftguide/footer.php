<?php
if ( is_single() && 'gallery' == get_post_format() ) {
	// do nothing
} else if( is_home() ) {
	// do nothing
}else if (is_post_type_archive( 'athlete' ) || is_post_type_archive( 'memory' )) {
	// do nothing
}/*
else if( is_category() ) {
	$current_cat = get_queried_object()->slug . '-widget-area';
	echo $current_cat;
	get_sidebar($current_cat);
}
else {
	get_sidebar();
}*/
?>


	</div> <!-- #main.row -->
	
	</div> <!-- #bg-wrapper -->
	
	

<footer id="footer" class=" row" role="contentinfo">

	<ul id="mobile-footer-menu" class="mobile-main-menu">
			<li class="footer_search"><?php postmedia_search_form_02(); ?></li>
			<?php  	//Call footer menu (cached)
					echo pm_get_menu( 'mobile-footer' );
			/* wp_nav_menu( array( 'theme_location' => 'mobile-footer', 'container' => '', 'items_wrap' => '%3$s', 'link_before' => '<i class="icon"></i>' ) ); */ ?>
		</ul>

			<div id="footer-menus" class="footer-max-size-wrapper">
				<div class="footer-wrapper">
				
				<div class="footer-menu">
					<aside id="nav_menu-4" class="footer-widget widget_nav_menu"><h3 class="footer-widget-title">About Us</h3><div class="menu-footer_about_us-container"><ul id="menu-footer_about_us" class="menu"><li id="menu-item-64896" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64896"><a href="http://o.canada.com/2012/08/10/who-we-are/" target="_blank">Who We Are</a></li>

<li id="menu-item-64907" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64907"><?php echo '<a href="mailto:'.antispambot('webfeedback@postmedia.com').'">Contact Us</a>'; ?></li>
<li id="menu-item-89548" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-89548"><a href="/facebook-commenting-faqs" target="_blank">Facebook Commenting FAQs</a></li>

<li id="menu-item-64906" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64906"><a href="http://www.postmedia.com/advertising/" target="_blank">Advertise with Us</a></li>
<li id="menu-item-65886" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-65886"><a href="http://www.canada.com/newsletter/signup/index.html" target="_blank">Subscribe To Our Newsletters</a></li>
<li id="menu-item-64897" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64897"><a href="http://o.canada.com/2012/08/10/privacy-statement/" target="_blank">Privacy Statement</a></li>
<li id="menu-item-62967" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-62967"><a href="http://www.canada.com/aboutus/termsofservice.html" target="_blank">Terms</a></li>
<li id="menu-item-64904" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64904"><a href="http://www.canada.com/aboutus/copyright.html" target="_blank">Copyright &amp; Permissions</a></li>
</ul></div></aside><aside id="nav_menu-5" class="footer-widget widget_nav_menu"><h3 class="footer-widget-title">Partner Sites</h3><div class="menu-footer_partner_sites-container"><ul id="menu-footer_partner_sites" class="menu">
<li id="menu-item-62997" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-62997"><a href="http://www.canada.com" target="_blank">Canada.com</a></li>
<li id="menu-item-62996" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-62996"><a href="http://www.driving.ca" target="_blank">Driving.ca</a></li>
<li id="menu-item-64933" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64933"><a href="http://www.faceoff.com/index.html" target="_blank">Faceoff.com</a></li>
<li id="menu-item-64934" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64934"><a href="http://www.canada.com/onlinetv" target="_blank">Postmedia Online TV</a></li>
<li id="menu-item-213589" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-213589"><a href="https://www.youtube.com/user/canadacomvideo" target="_blank">Canada.com YouTube channel</a></li>
<li id="menu-item-214782" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-214782"><a href="http://www.canada.com/business/index.html" target="_blank">FP Business</a></li>
</ul></div></aside><aside id="nav_menu-6" class="footer-widget widget_nav_menu"><h3 class="footer-widget-title">Featured Sites</h3><div class="menu-footer_featured_sites-container"><ul id="menu-footer_featured_sites" class="menu"><li id="menu-item-98738" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-98738"><a href="http://portsandbows.com" target="_blank">Ports and Bows</a></li>

<li id="menu-item-62973" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-62973"><a href="http://www.Canada.com/oscars" target="_blank">Award Shows</a></li>
<li id="menu-item-62974" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-62974"><a href="http://o.canada.com/discussions/fifa-world-cup" target="_blank">FIFA World Cup</a></li>
</ul>

</div></aside><aside id="nav_menu-7" class="footer-widget widget_nav_menu"><h3 class="footer-widget-title">Newspapers</h3><div class="menu-footer_newspapers-container"><ul id="menu-footer_newspapers" class="menu"><li id="menu-item-64922" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64922"><a href="http://www.nationalpost.com/index.html" target="_blank">The National Post</a></li>
<li id="menu-item-64923" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64923"><a href="http://www.theprovince.com/index.html" target="_blank">The Province</a></li>
<li id="menu-item-64924" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64924"><a href="http://www.vancouversun.com/index.html" target="_blank">Vancouver Sun</a></li>
<li id="menu-item-64925" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64925"><a href="http://www.edmontonjournal.com/index.html" target="_blank">Edmonton Journal</a></li>
<li id="menu-item-64926" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64926"><a href="http://www.calgaryherald.com/index.html" target="_blank">Calgary Herald</a></li>
<li id="menu-item-64927" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64927"><a href="http://www.leaderpost.com/index.html" target="_blank">Regina Leader-Post</a></li>
<li id="menu-item-64928" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64928"><a href="http://www.thestarphoenix.com/index.html" target="_blank">Saskatoon StarPhoenix</a></li>
<li id="menu-item-65363" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-65363"><a href="http://www.windsorstar.com/index.html" target="_blank">Windsor Star</a></li>
<li id="menu-item-62994" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-62994"><a href="http://www.ottawacitizen.com/index.html" target="_blank">Ottawa Citizen</a></li>
<li id="menu-item-64931" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64931"><a href="http://www.montrealgazette.com/index.html" target="_blank">The Gazette (Montreal)</a></li>
</ul></div></aside><aside id="nav_menu-8" class="footer-widget widget_nav_menu"><h3 class="footer-widget-title">Marketplace</h3><div class="menu-footer_marketplace-container"><ul id="menu-footer_marketplace" class="menu"><li id="menu-item-62978" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-62978"><a href="http://www.canada.com/shop/index.html" target="_blank">Shopping</a></li>
<li id="menu-item-64915" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64915"><a href="http://www.workopolis.com/jobsearch/whitelabel/nationalpost/home" target="_blank">Jobs</a></li>
<li id="menu-item-64916" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64916"><a href="http://www.driving.ca/index.html" target="_blank">Cars</a></li>
<li id="menu-item-64917" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64917"><a href="http://www.househunting.ca/index.html?branding=default" target="_blank">Homes</a></li>
<li id="menu-item-64918" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64918"><a href="http://www.legacy.com/obituaries/remembering/" target="_blank">Remembering</a></li>
<li id="menu-item-64920" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64920"><a href="http://www.flyercity.ca/?p=canada&#038;locale=en&#038;utm_source=fm&#038;utm_medium=fm_48&#038;utm_term=more&#038;utm_campaign=wishabi_1_0" target="_blank">Flyer City</a></li>
<li id="menu-item-80975" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-80975"><a href="http://www.infomart.com" target="_blank">Infomart</a></li>
</ul></div></aside>				</div>
				
				<div class="footer-links">
					<div class="footer-links-left">
						<!-- <a href="http://www.canada.com/aboutus/sitemap.html" class="site-map">Site Map</a> -->
						<aside id="cdc_social_icons-2" class="widget cdc_social_icons"><h3 class="widget-title">Follow Us</h3>							<a href="/feed" target="_blank" class="sprite rss" title="rss"></a>
							<!-- <a href="http://www.facebook.com/canada.com" target="_blank" class="sprite facebook" title="facebook"></a> -->
							<a href="https://twitter.com/#!/canadadotcom" target="_blank" class="sprite twitter" title="twitter"></a>
							<!-- <a href="https://plus.google.com/103522559669112616048" target="_blank" class="sprite google" title="google plus" rel="publisher"></a> -->
							<!-- <a href="http://pinterest.com/canadalifestyle/" target="_blank" class="sprite pinterest" title="pinterest"></a> -->
							<!-- <a href="http://www.youtube.com/user/canadacomvideo" target="_blank" class="sprite youtube" title="youtube"></a> -->
					</aside>
					</div>
					
					<div id="pm_logo_footer">
						<a href="http://postmedia.com" target="_blank"></a>
					</div>
					
					<div class="footer-links-right">
						<!-- <a href="http://www.canada.com/aboutus/sitemap.html?layer=true&returnurl=http%3A%2F%2Fwww.canada.com%2Fmembers%2Fedit-profile.html" class="manage-subscriptions">Manage Subscriptions</a> -->
						<a href="#top" class="back-to-top">Back to Top <i class="icon-arrow-up"></i></a>
					</div>
				</div>
				
				<div class="footer-copyright">
					<span class="legal">&copy; <?php echo date("Y"); ?> <a href="http://www.postmedia.com">Postmedia Network Inc.</a> All rights reserved. Unauthorized distribution, transmission or republication strictly prohibited.</span>
					
				</div>
				</div>
			</div>
	
		</footer><!-- #footer -->
		
		

</div> <!-- #page.grid -->

<?php wp_footer(); ?>

	<?php // setup omniture variables

	$prop_6 = is_single() ? 'Metered Content' : 'Free Content';

	//get the adsite for omniture
	$get_ad_adsite = new Postmedia_Functions_Init;
	$site = $get_ad_adsite->postmedia_js_object();
	$prop_37 = isset( $site['adConfig']['site'] ) ? $site['adConfig']['site'] : '';

	global $post;

	if ( is_single() ){

		$prop_8 = isset( $post->ID ) ? $post->ID : '';
		$prop_25 = 'blog';
		$events = 'event2,event45';


	} else {

		$prop_8 = '';
		$prop_25 = 'index';
		$events = '';

	}

	unset($category);
	if (is_category()) {

		$category = get_query_var('cat');

	} else if ( is_single() ) {

		$post_categories = wp_get_post_categories( $post->ID );
		$category = $post_categories[0];

	}

	if ( $category ) {

		$category = get_category( $category );
		$prop_22 = $category->cat_name;
		$channel = $category->cat_slug;
		$parents = array_reverse( array_filter( explode( ',', get_category_parents( $category->cat_ID, false, ',' ) ) ) );
		if( ! empty( $parents) ) {
			$prop_20 = $parents[0];
		}

	}
	else {
		$channel = '';
	}

	?>

	
<script>	
(function($, window, document, undefined) {
    var pluginName = 'socialSharers';
    var defaults = {
        twitter: {
            handle: null
        },
        facebook: {
            appID: null
        },
        googleplus: {}
    };
    var width, height, pos, url, link, title;

    function SocialSharers(element, options) {
        this.element = $(element);
        this.options = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    function newPosition(width, height) {
        var position = {};
        width = parseInt(width, 10) || 500;
        height = parseInt(height, 10) || 500;
        position.left = (screen.width / 2) - (width / 2);
        position.top = (screen.height / 2) - (height / 2);
        return position;
    }
    
    
    SocialSharers.prototype = {
        init: function() {
            this.loadScripts();
            this.events();
        },
        loadScripts: function() {
            var js, fjs = document.getElementsByTagName('script')[0],
                add = function(url, id) {
                    if (document.getElementById(id)) {
                        return;
                    }
                    js = document.createElement('script');
                    js.src = url;
                    id && (js.id = id);
                    fjs.parentNode.insertBefore(js, fjs);
                };
            if (this.options.facebook.appID && this.element.find('[data-share="facebook"]').length) add('//connect.facebook.net/en_US/all.js#xfbml=1&appId=' + this.options.facebook.appID, 'facebook-jssdk');
        },
        facebook: function($el) {
            link = $el.data('link') || window.location.href;
            var pubDate = new Date($el.data("pub-date"));
            var d = new Date();
            if ((d - pubDate) < 500) return;
            if (this.options.facebook.appID) {
                var obj = {
                    method: 'share',
                    href: link,
                    picture: $el.data('image') || '',
                    name: $el.data('title') || document.title,
                    description: $el.data('description') || ''
                };
                FB.ui(obj);
            } else {
                width = 640;
                height = 320;
                pos = newPosition(width, height);
                url = 'https://www.facebook.com/sharer/sharer.php?u=';
                url += encodeURIComponent(link);
                window.open(url, 'fbshare', 'width=' + width + ', height=' + height + ', top=' + pos.top + ', left=' + pos.left + ', menubar=no, status=no, toolbar=no, ');
            }
            return false;
        },
        twitter: function($el) {
            var via, hashtags;
            link = ($el.data('link')) ? $el.data('link') : window.location.href;
            title = ($el.data('title')) ? $el.data('title') : document.title;
            via = (this.options.twitter.handle) ? '&via=' + this.options.twitter.handle : '';
            hashtags = ($el.data('hashtags')) ? '&hashtags=' + $el.data('hashtags') : '';
            width = 550;
            height = 450;
            pos = newPosition(width, height);
            url = 'https://twitter.com/share?url=' + encodeURIComponent(link) +
                '&text=' + encodeURIComponent(title) + via + hashtags;
            window.open(url, 'twshare', 'width=' + width + ', height=' + height + ', top=' + pos.top + ', left=' + pos.left + ', menubar=no, status=no, toolbar=no, ');
            return false;
        },
        googleplus: function($el) {
            link = ($el.data('link')) ? $el.data('link') : window.location.href;
            title = ($el.data('title')) ? $el.data('title') : document.title;
            width = 600;
            height = 540;
            pos = newPosition(width, height);
            url = 'https://plus.google.com/share?url=' + encodeURIComponent(link);
            window.open(url, 'gpshare', 'width=' + width + ', height=' + height + ', top=' + pos.top + ', left=' + pos.left + ', menubar=no, status=no, toolbar=no, ');
        },
        events: function() {
            var self = this;
            this.element.on('click', 'a', function(e) {
                var $el = $(this);
                switch ($el.data('share')) {
                    case 'facebook':
                        self.facebook($el);
                        break;
                    case 'twitter':
                        self.twitter($el);
                        break;
                    case 'googleplus':
                        self.googleplus($el);
                        break;
                }
                $el.blur();
            });
            if (this.options.facebook.appID) {
                window.fbAsyncInit = function() {
                    FB.init({
                        appId: self.options.facebook.appID,
                        status: false
                    });
                };
            }
        }
    };
    $.fn[pluginName] = function(options) {
        return this.each(function() {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new SocialSharers(this, options));
            }
        });
    };
    
    $( "#page" ).socialSharers();
    
})(jQuery, window, document);



</script>
	
<!-- Google Analytics Code -->	
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function()
{ (i[r].q=i[r].q||[]).push(arguments)}
,i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-35592751-3', 'canada.com');
ga('send', 'pageview');
</script>

<!-- SiteCatalyst code version: H.25.4.
Copyright 1996-2013 Adobe, Inc. All Rights Reserved 
More info available at http://www.omniture.com -->

<script language='JavaScript' type='text/javascript' src='http://www.canada.com/js/account_worldwar1centenary_s_code.js'></script>
<script language='JavaScript' type='text/javascript' src='http://www.canada.com/js/global_s_code.js'></script>
<script language='JavaScript' type='text/javascript' src='http://www.canada.com/js/local_worldwar1centenary_s_code.js'></script>


<script language='JavaScript' type='text/javascript'>
<!--
/* You may give each page an identifying name, server, and channel on the next lines. */
<?php 
	
	if( is_404() ) {
		echo "s.pageType=\"errorPage\"; //If 404 page, \"errorPage\". Else, \"\".";
 	} else {
	 	echo "s.pageType=\"\"; //If 404 page, \"errorPage\". Else, \"\".";
 	}
 	
 ?>
 
s.prop4="Non-Registered"; //If you can detect Canada.com login status on your site, "Registered" or "Non-Registered". If you can not detect, always "Non-Registered".
<?php 
	
	if( is_single() ) {
		echo "s.prop23=\"" . get_the_title() . "\"; //If this page is a story page, set to story headline. Else, \"\"";
 	} else {
	 	echo "s.prop23=\"\"; //If this page is a story page, set to story headline. Else, \"\"";
 	}
 ?>
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script>
<script language="JavaScript" type="text/javascript"><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'!-'+'-')
//--></script><noscript><img src="http://canwest.112.2o7.net/b/ss/canwestglobal,canwest/1/H.25.4--NS/0" height="1" width="1" border="0" alt="" /></noscript><!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.25.4. -->


</body>
</html>