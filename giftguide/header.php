<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?> <?php if( is_single() ) { ?>itemscope itemtype="http://schema.org/Article" <?php } ?> xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml" ><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<?php if( is_single() ) { ?>
		<meta itemprop="dateModified" content="<?php echo esc_attr( get_the_modified_time( 'Y-m-d' ) ); ?>">
		<meta itemprop="datePublished" content="<?php echo esc_attr( get_post_time( 'Y-m-d', true, get_the_ID() ) ); ?>">
		
		<meta itemprop="inLanguage" content="en-CA">
		<meta itemprop="genre" content="news">
		<meta itemprop="articleSection" content="Sports / Olympics">

		<span itemprop="copyrightHolder" itemscope itemtype="http://schema.org/Organization" itemid="http://www.canada.com/olympics/">
			<meta itemprop="name" content="Postmedia Network Inc."/>
			<meta itemprop="url" content="http://www.postmedia.com"/>
		</span>
		<meta itemprop="copyrightYear" content="<?php echo esc_attr( date( 'Y' ) ); ?>"/>
	<?php 

		
	}
	if( is_404() ) {?>	
		<meta name="ROBOTS" content="NOARCHIVE" />
		<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
	<?php } ?>
	
	<?php if( is_home() ) { ?>
		<meta name="msvalidate.01" content="915AE10930FFCE1EFBB9D7838CE66DE7" />
		<meta name="google-site-verification" content="1V5WwVqa3RG0TZclypEOxKNwjhPm7GP-mmoKcCf6KmY" />
		<!-- <link rel="publisher" href="https://plus.google.com/100187279218566668627" /> replace with Sochi Google+ account -->
		<?php } ?>
	
	<?php if( is_tax() ) { 
		$queried_object = get_queried_object();
		$term_name = $queried_object->name;
		$meta_description = $queried_object->description;
	?>
		<meta name="description" content="<?php echo $meta_description; ?>" /><meta name="keywords" content="<?php echo $term_name; ?>" />
	<?php } ?>
	<?php if( is_post_type_archive('video') ) { ?>
		<meta name="description" content="Canada's journey through WW1, with images and stories from the home front and the front lines of battle.
" /><meta name="keywords" content="Videos" />
	<?php } ?>
	<?php if( is_post_type_archive('gallery') ) { ?>
		<meta name="description" content="Canada's journey through WW1, with images and stories from the home front and the front lines of battle." /><meta name="keywords" content="Photos" />
	<?php } ?>
	
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri(); ?>?v=1.4" />
	
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_bloginfo( 'template_url' ) . '/flexslider.css';  ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_bloginfo( 'template_url' ) . '/colorbox.css';  ?>" />
	

	<!--[if lt IE 9]>
		<style type="text/css">
			#site-navigation .home a { background: url('<?php echo POSTMEDIA_THEME_URL; ?>/images/nav_logo.png') no-repeat 50% 50%; }
			.w1280{ max-width:970px!important; }
		</style>
	<![endif]-->	
	
	
	
	<link rel="icon" type="image/x-icon" href="<?php echo get_bloginfo( 'template_url' ) . '/favicon.ico';  ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <?php wp_head(); ?>

    <script type="text/javascript" charset="utf-8">
    // override loggers to avoid throwing errors
	if(window.console == null || window.console == undefined || !window.console) {
	           console = { log: function() {}, info: function() {}, warn: function() {}, error: function() {}, trace: function() {}, debug: function() {} };
	           //var fbscript = document.createElement("script");
	           //fbscript.src = "https://getfirebug.com/firebug-lite-beta.js";
	           //fbscript.setAttribute("type","text/javascript");
	           //document.getElementsByTagName("head")[0].appendChild(fbscript);
	} else if(!console.debug) {
	         console.debug = function(text) { if(console.log) console.log("D: "+text); };
	}

    //Ad code variables
    var adSlots = [];
    
    jQuery(window).load(function() {
    		
		<?php if( is_tax('events') && !is_paged() ) { ?>
			//Interactive lightbox
			jQuery(".iframe").colorbox({iframe:true, width:"910px", height:"950px"});
		<?php } ?>
			
	});
</script>


  

</head>

<body <?php body_class(); ?>>
	<script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '820710821303439',
          xfbml      : true,
          version    : 'v2.1'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_CA/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>

	
		<div id="leaderboard" class="grid wfull postmedia-ad">
		<div class="row">		
<?php
								
	if ( function_exists( 'jetpack_is_mobile' ) ) {
		if( jetpack_is_mobile() ){
			if ( function_exists( 'pn_dfp_ads' ) ) {
				pn_dfp_ads() -> call_ad('leaderboard-mobile');	
			}
		} else {
			if ( function_exists( 'pn_dfp_ads' ) ) {
				pn_dfp_ads() -> call_ad('leaderboard');	
			}
		}
	} else {
		if ( function_exists( 'pn_dfp_ads' ) ) {
			pn_dfp_ads() -> call_ad('leaderboard');	
		}
	}
?> 
			</div>
		</div>

	
          	

	<div id="page" class="grid w1280">

		<header id="header" class="row w1280" role="banner">
			<a href="http://postmedia.com" id="pm_logo_header" target="_blank"><img src="<?php echo get_bloginfo( 'template_url' ) . '/images/Postmedia-logo-white-94x15-HEADER-desktop.png';  ?>"/></a>


			<div id="main-header" class="c12">
				<div id="site-title" itemscope itemtype="http://schema.org/Organization">
				<a href="<?php echo get_home_url(); ?>" title="Postmedia's World War 1 Centenary site" rel="home" itemprop="url" id="main-logo">
				<img src="<?php echo POSTMEDIA_THEME_URL; ?>/images/sochi_desktop_logo@2x.png" width="645" style="margin-top:5px;"  alt="The Great War" itemprop="logo" /></a></div>

				<div id="desktop">

					<div class="header-meta">

					</div>

					<nav id="site-navigation" class="top-menu" role="navigation">
						<h3 class="assistive-text">Main menu</h3>
						
						<ul id="menu-sochi-phase-01" class="menu">
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '', 'items_wrap' => '%3$s', 'link_before' => '<i class="icon"></i>' ) ); ?>
						
						<!-- <li> -->
						
						<!-- </li> -->
						</ul>
						
						
						<div id="top-search-btn">
							<i id="top-search-icon" class="icon-search icon-large"></i> 
						</div>
						
						<div id="top-nav-search">
								<?php postmedia_search_form(); ?>
							</div>
						
					</nav><!-- #site-navigation -->
				
					<?php
					$category = get_the_category();

					$parent = ( $category ) ? get_cat_name( $category[0]->category_parent ) : '';
					$current_menu = ( $category ) ? $category[0]->name : 'news';
					$current_menu = ( $parent ) ? $parent : $current_menu;
					?>

				</div>

			<?php

				$options = get_option( 'postmedia_theme_options' );

				if ( $options['promo_ad_options_singular'] == 'On'  ){

					if ( is_singular() && ! is_page() ){

						echo postmedia_promo_ad_override();

					}

				} else {

					echo postmedia_promo_ad_override();

				}

			?>

			</div><!-- .c12 -->

			<div id="mobile" class="c12">
					
				<h2 id="mobile-site-title"><a href="<?php echo get_home_url(); ?>/" title="The Great War" rel="home">&nbsp;<!-- <img src="<?php echo POSTMEDIA_THEME_URL; ?>/images/nav_logo@2x.png" alt="2014 Winter Games"  /> --></a></h2>
				
				<div class="mobile-nav">
					<div class="header-meta">
						<div class="fr">
							<!-- <a class="button mobile-events" href="#">Events <i class="icon-chevron-down"></i></a> -->
							<a class="button mobile-menu" href="#"><i class="icon-reorder"></i></a>
							<a class="button mobile-search" href="#"><i class="icon-search"></i></a>
							
						</div>
					</div>
				</div>
			</div>

		</header><!-- #header .row -->
				
		<div id="bg-wrapper">
					
		<ul id="mobile-header-menu" class="mobile-main-menu">
			<li><?php postmedia_search_form(); ?></li>
			<?php 	//Call cached main menu 
					echo pm_get_menu( 'primary' );
			
			/* wp_nav_menu( array( 'theme_location' => 'mobile-footer', 'container' => '', 'items_wrap' => '%3$s', 'link_before' => '<i class="icon"></i>' ) ); */ ?>
		</ul>
			
			<!-- Alerts -->
		
		<?php 	$alert_status =  esc_attr( postmedia_theme_option( 'alert_options' ) ); 
				
				if ( $alert_status == "On"){	
				
					$pm_alert_posts = pm_check_cached_posts('pm_alert_posts_query', array( 'posts_per_page' => '1', 'caller_get_posts' => '1', 'post_type' => 'alert' ), $expires = 60 );
					
					if ( $pm_alert_posts->have_posts() ) { 
					
					 while ($pm_alert_posts->have_posts()) : $pm_alert_posts->the_post(); 
				
							get_template_part( 'content', 'alert' );	

					endwhile; 
			
					}
					wp_reset_query();
				}
		?>
		
		
		<?php if ( is_single() || is_archive() ) {
			$queried_object = get_queried_object();
			$cat_title = ( is_archive() ) ? single_cat_title( '', false ) : postmedia_single_cat_name();
			$cat_title = ( is_author() ) ? get_the_author() : $cat_title;
			$cat_title = ( is_post_type_archive() ) ? post_type_archive_title("",false) : $cat_title;
			if ( is_post_type_archive('memory') ) {
				$cat_title = "The Great War Memory Project";
			}
			$author_attr = ( is_author() ) ? ' rel="author" ' : '';
			$link = ( is_author() ) ? "http://www.canada.com/olympics/category/columns" : get_category_link( get_cat_ID( $cat_title ) );
			
			if ( is_tax()) {
				$current_term_title = single_cat_title( '', false );
				$taxonomy_term = get_term_by('name', $current_term_title, 'events' );
				$link = get_term_link($taxonomy_term);
			}
			
			if ( is_single() && has_term( "", "events", $queried_object->ID )) {
				$taxonomy_array = wp_get_post_terms($queried_object->ID, 'events', array("fields" => "all"));
				$cat_title = $taxonomy_array[0]->name;
				$link = get_term_link($taxonomy_array[0]);
			}

			?>
		<div id="large-title" class="row">
			<div class="c12">
				<h2><a href="<?php echo esc_url( $link ); ?>" <?php echo $author_attr; ?>><?php echo $cat_title; ?></a></h2>
			</div>
		</div>
		<?php } ?>
		<?php if ( is_404()  ) {
			$cat_title = "Error 404";
			?>
		<div id="large-title" class="row">
			<div class="c12">
				<h2><?php echo $cat_title; ?></h2>
			</div>
		</div>
		<?php } ?>

		<?php //echo postmedia_breadcrumbs(); ?>
		

		<div id="main" class="row">