<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package parallax-one
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
    <!-- Important Owl stylesheet -->
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/owl-carousel/owl.carousel.css">
     
    <!-- Default Theme -->
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/owl-carousel/owl.theme.css">
     
    <!--  jQuery 1.7+  -->
    <script src="<?php bloginfo('template_url'); ?>/owl-carousel/jquery-1.9.1.min.js"></script>
     <script src="<?php bloginfo('template_url'); ?>/js/smooth-scroll.js"></script>
    <!-- Include js plugin -->
    <script src="<?php bloginfo('template_url'); ?>/owl-carousel/owl.carousel.js"></script>
<script type="text/javascript">
      $(document).ready(function() {
     
      $("#owl-example").owlCarousel({
items : 3,
itemsDesktop : [1000,3],
itemsDesktopSmall : [900,2],
autoPlay : true

});
     
    });
</script>
<script>
    smoothScroll.init();
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-69659030-1', 'auto');
  ga('send', 'pageview');
</script>
<script type="text/javascript">
<!--
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'none')
          e.style.display = 'block';
       else
          e.style.display = 'none';
    }
//-->
</script>
 
</head>

<body itemscope itemtype="http://schema.org/WebPage" <?php body_class(); ?> dir="<?php if (is_rtl()) echo "rtl"; else echo "ltr"; ?>">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'parallax-one' ); ?></a>
	<!-- =========================
     PRE LOADER       
    ============================== -->
	<?php
		
	 global $wp_customize;

	 if(is_front_page() && !isset( $wp_customize ) && get_option( 'show_on_front' ) != 'page' ): 
	 
		$parallax_one_disable_preloader = get_theme_mod('paralax_one_disable_preloader');
		
		if( isset($parallax_one_disable_preloader) && ($parallax_one_disable_preloader != 1)):
			 
			echo '<div class="preloader">';
				echo '<div class="status">&nbsp;</div>';
			echo '</div>';
			
		endif;	

	endif; ?>


	<!-- =========================
     SECTION: HOME / HEADER  
    ============================== -->
	<!--header-->
	<header itemscope itemtype="http://schema.org/WPHeader" id="masthead" role="banner" data-stellar-background-ratio="0.5" class="header header-style-one site-header">

        <!-- COLOR OVER IMAGE -->
        <?php
			$paralax_one_sticky_header = get_theme_mod('paralax_one_sticky_header','parallax-one');
			if( isset($paralax_one_sticky_header) && ($paralax_one_sticky_header != 1)){
				$fixedheader = 'sticky-navigation-open';
			} else {
				if( !is_front_page() ){
					$fixedheader = 'sticky-navigation-open';
				}else{
					$fixedheader = '';
					if ( 'posts' != get_option( 'show_on_front' ) ) {
						if( isset($paralax_one_sticky_header) && ($paralax_one_sticky_header != 1)){
							$fixedheader = 'sticky-navigation-open';
						} else {
							$fixedheader = '';
						}
					}
				}
			}
        ?>
		<div class="overlay-layer-nav <?php if(!empty($fixedheader)) {echo esc_attr($fixedheader);} ?>">

            <!-- STICKY NAVIGATION -->
            <div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation appear-on-scroll">
				<!-- CONTAINER -->
                <div class="container">
				
                    <div class="navbar-header">
                     
                        <!-- LOGO -->
						
                        <button title='<?php _e( 'Toggle Menu', 'parallax-' ); ?>' aria-controls='menu-main-menu' aria-expanded='false' type="button" class="navbar-toggle menu-toggle" id="menu-toggle" data-toggle="collapse" data-target="#menu-primary">
                            <span class="screen-reader-text"><?php esc_html_e('Toggle navigation','parallax-one'); ?></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
						
						<?php
							
							$parallax_one = get_theme_mod('paralax_one_logo', parallax_get_file('/images/logo-nav.png') );

							
							
							if(!empty($parallax_one)):

								echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand" title="'.get_bloginfo('title').'">';

									echo '<img src="'.esc_url($parallax_one).'" alt="'.get_bloginfo('title').'">';

								echo '</a>';

								echo '<div class="header-logo-wrap text-header paralax_one_only_customizer">';

									echo '<h1 itemprop="headline" id="site-title" class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" rel="home">'.get_bloginfo( 'name' ).'</a></h1>';
								
									echo '<p itemprop="description" id="site-description" class="site-description">'.get_bloginfo( 'description' ).'</p>';

								echo '</div>';	
							
							else:
							
								if( isset( $wp_customize ) ):
								
									echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand paralax_one_only_customizer" title="'.get_bloginfo('title').'">';

										echo '<img src="" alt="'.get_bloginfo('title').'">';

									echo '</a>';
								
								endif;
							
								echo '<div class="header-logo-wrap text-header">';
									
									echo '<h1 itemprop="headline" id="site-title" class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" rel="home">'.get_bloginfo( 'name' ).'</a></h1>';

									echo '<p itemprop="description" id="site-description" class="site-description">'.get_bloginfo( 'description' ).'</p>';

								echo '</div>';							
							endif;	

						?>

                    </div>
                    
                    <!-- MENU -->
					<div itemscope itemtype="http://schema.org/SiteNavigationElement" aria-label="<?php esc_html_e('Primary Menu','parallax-one') ?>" id="menu-primary" class="navbar-collapse collapse">
						<!-- LOGO ON STICKY NAV BAR -->
						<div id="site-header-menu" class="site-header-menu">
							<nav id="site-navigation" class="main-navigation" role="navigation">
							<?php 
								wp_nav_menu( 
									array( 
										'theme_location'    => 'primary',
										'menu_class'        => 'primary-menu small-text',
										'depth'           	=> 4,
										'fallback_cb'       => 'parallax_one_wp_page_menu'
										 ) 
								);
							?>
							</nav>
						</div>
                    </div>
					
					
                </div>
                <!-- /END CONTAINER -->
            </div>
            <!-- /END STICKY NAVIGATION -->