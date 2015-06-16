<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title('&raquo;','true','right'); ?><?php bloginfo('name'); ?></title>

<!-- Include Sidr bundled CSS theme -->
<link rel="stylesheet" href="http://www.doolittletrailers.com/wp-content/themes/doolittle/menu/jquery.sidr.dark.css">

<!-- Ensure that sidr menu doesn't show up until responsive -->
<style>
	#sidr {
		display: none;
	}	
</style>

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="http://www.doolittletrailers.com/jet-nav/css/jetmenu.css">
<link type="text/css" rel="stylesheet" href="http://www.doolittletrailers.com/responsive-tabs/jQueryTab.css" />
<link rel="stylesheet" type="text/css" href="http://www.doolittletrailers.com/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />

<?php wp_head(); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55114971-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body <?php body_class(); ?>>

<!-- check to see if logged in for woocommerce pages -->
<?php
// if user is not logged in
if(!is_user_logged_in()){
	
	if(is_woocommerce()){
		header('location: http://www.doolittletrailers.com/my-account/');
	} else{
	
		global $post;
		
		// get parents of current page
		$parents = get_post_ancestors($post);
		
		// check to see if any ancestors are My Account
		foreach($parents as $page_id){
			// if so, redirect to login page
			if($page_id == 334){
				header('location: http://www.doolittletrailers.com/my-account/');
			}
		}
	}
} else{
	$is_child = false;
	
	if (is_woocommerce()){
		$is_child = true;
	} elseif (is_page('334')){
		$is_child = true;
	} else{
	
	global $post;
		
		// get parents of current page
		$parents = get_post_ancestors($post);
		
		// check to see if any ancestors are My Account
		foreach($parents as $page_id){
			// if so, redirect to login page
			if($page_id == 334){
				$is_child = true;
			}
		}
	}
}
?>

<div class="page">
	<div class="header">
		<div class="top-nav">
			<div class="container">
				<ul class="top-cta">
					<?php 
						// dealer navigation upon logged in user
						if (is_user_logged_in()) : 
					?>
							<li class="my_account_header"><a href="http://www.doolittletrailers.com/my-account/">My Account</a></li>
							<li class="logout_header"><a href="<?php echo wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) );?>">Logout</a></li>
						<?php 
						elseif (!is_user_logged_in()) :
						?>
							<li><a href="http://www.doolittletrailers.com/locate-dealer/">Locate a Dealer</a></li>
							<li class="dealer"><a href="http://www.doolittletrailers.com/become-dealer/">Become a Dealer</a></li>
							<li class="login"><a href="http://www.doolittletrailers.com/my-account/">Dealer Login</a></li>
							<li class="phone"><a href="http://www.doolittletrailers.com/">1 (800) 654-4948</a></li>
						<?php 
						endif;
						?>
						
					<li class="img"><a href="https://www.facebook.com/DoolittleTrailerMfgInc" target="blank"><img src="http://www.doolittletrailers.com/wp-content/uploads/2014/10/facebook.png"></a></li>
					<li class="img"><a href="https://twitter.com/doolittletrailr" target="blank"><img src="http://www.doolittletrailers.com/wp-content/uploads/2014/10/twitter.png"></a></li>
				</ul>
				<div style="clear: both"></div>
			</div>
		</div>
		<div class="bottom-nav">
			<div class="container">
				<a href="http://www.doolittletrailers.com/"><img src="http://www.doolittletrailers.com/wp-content/uploads/2014/12/logo-doolittle.png" class="logo main-nav-image"></a>
				<div class="push-right">
					<a id="simple-menu" href="#sidr">&#8801;</a>
					<div id="sidr">
						<!-- Your content -->
						<ul>
							<li><a href="#">Home</a></li>
							<li><a href="/about/">About Us</a></li>
							<li><a href="/trailers/">Our Trailers</a></li>
							<li><a href="/resources/financing/">Resources</a></li>
							<li><a href="/contact/>Contact</a></li>
						</ul>
						
						<script>
							$(document).ready(function() {
							  $('#simple-menu').sidr();
							});
						</script>
						
						<?php 
						// dealer navigation upon logged in user
						if (is_user_logged_in()) : 
						?>
							<li class="my_account_header"><a href="http://www.doolittletrailers.com/my-account/">My Account</a></li>
							<li class="logout_header"><a href="<?php echo wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) );?>">Logout</a></li>
						<?php 
						elseif (!is_user_logged_in()) :
						?>
							<li id="sidr-yellow"><a href="http://www.doolittletrailers.com/locate-dealer/">Locate a Dealer</a></li>
							<li id="sidr-yellow" class="dealer"><a href="http://www.doolittletrailers.com/become-dealer/">Become a Dealer</a></li>
							<li id="sidr-yellow" class="login"><a href="http://www.doolittletrailers.com/my-account/">Dealer Login</a></li>
						<?php 
						endif;
						?>
					</div>
					
					<!-- Responsive Menu -->
					<script type="text/javascript">
					$( document ).ready(function() {
							(function ($, window, document, undefined) {
								$(document).ready(function () {
									$('#simple-menu').sidr();
							});
						});
					});
					</script>

					<div id='cssmenu'>
					<ul>
				<?php
					global $user_login, $current_user;

					if (is_user_logged_in()) {
					    get_currentuserinfo();
					    $user_info = get_userdata($current_user->ID);

					    if (in_array('subscriber', $user_info->roles)) { 
					         if ($is_child): ?>
				    		<li><a href="http://www.doolittletrailers.com/my-account/"><span>My Account</a></li>
				    		<li><a href="http://www.doolittletrailers.com/my-account/in-stock/">In-Stock List</a></li>
							
					<?php endif; 
					    } else {
					    	if ($is_child): ?>
				    		<li><a href="http://www.doolittletrailers.com/my-account/"><span>My Account</a></li>
				    		<li><a href="http://www.doolittletrailers.com/my-account/checkout/"><span>My Cart</a></li>
							<li><a href="http://www.doolittletrailers.com/my-account/quote-builder/"><span>Quote Builder</a></li>
							<li><a href="http://www.doolittletrailers.com/my-account/documents/"><span>Documents</a></li>
							<li class="last"><a href="http://www.doolittletrailers.com/my-account/quote-list/"><span>Quote List</a></li>
					<?php endif; 
					    }
					}
				?>


				
						
						
						<?php if (!$is_child): ?>
						<li><a href="http://www.doolittletrailers.com/"><span>Home</span></a></li>	
						<li class='active has-sub'><a href="http://www.doolittletrailers.com/about/"><span>About Us</span></a>
							<ul>
								<li><a href="http://www.doolittletrailers.com/about/">About DooLittle</a></li>
								<li><a href="http://www.doolittletrailers.com/about/people/">Our People</a></li>
								<li><a href="http://www.doolittletrailers.com/about/advantages/">DooLittle Advantages</a></li>
							</ul>
						</li>	
						<li class='active has-sub'><a href="http://www.doolittletrailers.com/trailers/"><span>Our Trailers</span></a>
							<ul>
								<li><a href="http://www.doolittletrailers.com/trailers/cargo/">Cargo Trailers</a></li>
								<li><a href="http://www.doolittletrailers.com/trailers/dump/">Dump Trailers</a></li>
								<li><a href="http://www.doolittletrailers.com/trailers/utility/">Utility Trailers</a></li>
								<li><a href="http://www.doolittletrailers.com/trailers/deckover/">Deckover Trailers</a></li>
								<li><a href="http://www.doolittletrailers.com/trailers/equipment/">Equipment Trailers</a></li>
							</ul>
						</li>
						<li class='active has-sub'><a href="http://www.doolittletrailers.com/resources/financing/"><span>Resources</span></a>
							<ul>
								<li><a href="http://www.doolittletrailers.com/resources/financing/">Financing</a></li>
								<li><a href="http://www.doolittletrailers.com/locate-dealer/">Locate a Dealer</a></li>
								<li><a href="http://www.doolittletrailers.com/become-dealer/">Become a Dealer</a></li>
							</ul>
						</li>
						<li class="last"><a href="http://www.doolittletrailers.com/contact/"><span>Contact</span></a></li>
						<?php endif; ?>
					</ul>
					<div style="clear: both"></div>
				</div>
				<div style="clear: both"></div>
			</div>
		</div>	
	</div>