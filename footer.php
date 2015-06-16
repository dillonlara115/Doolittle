</div>
	<div class="footer">
		<div id="top">
			<div class="container">
				<div class="bucket">
					<h4><a href="http://www.doolittletrailers.com/locate-dealer/">Locate a Dealer</a></h4>
				</div>
				<div class="bucket right">
					<h4><a href="http://www.doolittletrailers.com/become-dealer/">Become a Dealer</a></h4>
				</div>
				<div style="clear: both"></div>
			</div>
		</div>
		<div id="bottom">
			<div class="trailers-footer">
				<h2>Our Trailers</h2>
				<div class="trailer-footer">
					<a href="http://www.doolittletrailers.com/trailers/cargo/"><img src="http://www.doolittletrailers.com/wp-content/uploads/2015/01/cargo-trailer-txt-concrete-doolittle.jpg" class="trailer-side"></a>
				</div>
				<div class="trailer-footer">
					<a href="http://www.doolittletrailers.com/trailers/dump/"><img src="http://www.doolittletrailers.com/wp-content/uploads/2015/01/dump-trailer-txt-concrete-doolittle.jpg" class="trailer-side"></a>
				</div>
				<div class="trailer-footer">
					<a href="http://www.doolittletrailers.com/trailers/utility/"><img src="http://www.doolittletrailers.com/wp-content/uploads/2015/01/utility-trailer-txt-concrete-doolittle.jpg" class="trailer-side"></a>
				</div>
				<div class="trailer-footer">
					<a href="http://www.doolittletrailers.com/trailers/deckover/"><img src="http://www.doolittletrailers.com/wp-content/uploads/2015/01/deckover-trailer-txt-concrete-doolittle.jpg" class="trailer-side"></a>
				</div>
				<div class="trailer-footer">
					<a href="http://www.doolittletrailers.com/trailers/equipment/"><img src="http://www.doolittletrailers.com/wp-content/uploads/2015/01/equipment-trailer-txt-concrete-doolittle.jpg" class="trailer-side"></a>
				</div>
				<div style="clear:both"></div>
			</div>
			<div class="container">
				<div class="buckets">
					<div class="bucket">
						<h4>Resources</h4>
						<ul class="list">
							<li><a href="http://www.doolittletrailers.com/about/">About DooLittle</a></li>
							<li><a href="http://www.doolittletrailers.com/locate-dealer/">Find a Dealer</a></li>
							<li><a href="http://www.doolittletrailers.com/become-dealer/">Become a Dealer</a></li>
							<li><a href="http://www.doolittletrailers.com/contact/">Contact Us</a></li>
						</ul>
					</div>
					<div class="bucket right">
						<h4>Connect with DooLittle</h4>
						<ul class="connect">
							<li class="img"><a href="https://www.facebook.com/DoolittleTrailerMfgInc" target="blank"><img src="http://www.doolittletrailers.com/wp-content/uploads/2014/10/facebook.png"></a></li>
							<li class="img"><a href="https://twitter.com/doolittletrailr" target="blank"><img src="http://www.doolittletrailers.com/wp-content/uploads/2014/10/twitter.png"></a></li>
						</ul>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
		<div id="copyright">
			<div class="container">
			</div>
		</div>
	</div>
</div>
<?php wp_footer(); ?>

<!-- Include the Sidr JS -->
<script src="http://www.doolittletrailers.com/wp-content/themes/doolittle/menu/jquery.sidr.min.js"></script>


<!-- Dont' load jQuery if on WooCommerce page (will screw up gravity forms)-->
<?php if (!is_woocommerce()):?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://www.doolittletrailers.com/wp-content/themes/doolittle/js/quote.js"></script>

<script type="text/javascript" src="http://www.doolittletrailers.com/jet-nav/js/jetmenu.js"></script>
<script src="http://www.doolittletrailers.com/responsive-tabs/js/jQueryTab.js" type="text/javascript"></script>
<script type="text/javascript" src="http://www.doolittletrailers.com/slick/slick.min.js"></script>
<!-- Include the Sidr JS -->
<script src="http://www.doolittletrailers.com/wp-content/themes/doolittle/menu/jquery.sidr.min.js"></script>



<script type="text/javascript">
$.jQueryTab({
	responsive:true,							// enable accordian on smaller screens
	collapsible:true,							// allow all accordions to collapse 
	useCookie: false,							// remember last active tab using cookie
	openOnhover: false,						// open tab on hover
	initialTab: 1,								// tab to open initially; start count at 1 not 0
	
	cookieName: 'active-tab',			// name of the cookie set to remember last active tab
	cookieExpires: 4,							// when it expires in days or standard UTC time
	cookiePath: '/',							// path on which cookie is accessible
	cookieDomain:'',							// domain of the cookie
	cookieSecure: false,					// enable secure cookie - requires https connection to transfer
	tabClass:'tabs',							// class of the tabs
	headerClass:'accordion_tabs',	// class of the header of accordion on smaller screens
	contentClass:'tab_content',		// class of container
	activeClass:'active',					// name of the class used for active tab
	
	tabTransition: 'fade',				// transitions to use - normal or fade
	tabIntime:500,								// time for animation IN (1000 = 1s)
	tabOuttime:0,									// time for animation OUT (1000 = 1s)
	
	accordionTransition: 'slide',	// transitions to use - normal or slide
	accordionIntime:500,					// time for animation IN (1000 = 1s)
	accordionOuttime:400,					// time for animation OUT (1000 = 1s)

	before: function(){},					// function to call before tab is opened
	after: function(){}						// function to call after tab is opened
});
</script>

<script type="text/javascript">
$(document).ready(function(){
	$('.responsive').slick({
		autoplay: true,		
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 1024,
			settings: {
			slidesToShow: 3,
			slidesToScroll: 3,
			infinite: true,
			}
		},
		{
			breakpoint: 600,
			settings: {
			slidesToShow: 2
			}
		},
		{
			breakpoint: 480,
			settings: {
			slidesToShow: 1
			}
		}
		]
	});
$('.responsive-2').slick({
		dots: false,
		autoplay: true,
		infinite: true,
		speed: 300,
		slidesToShow: 2,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 1024,
			settings: {
			slidesToShow: 2,
			slidesToScroll: 2,
			infinite: true,
			dots: true
			}
		},
		{
			breakpoint: 600,
			settings: {
			slidesToShow: 1
			}
		}
		]
	});
});
</script>

<script type="text/javascript">
      jQuery(document).ready(function() {
           $().jetmenu({
                speed: 200
           });
      });
</script>

<script>
$(document).ready(function() {
	$('#toggle h3').each(function() {
		var tis = $(this), state = false, answer = tis.next('div').hide().css('height','auto').slideUp();
		tis.click(function() {
			state = !state;
			answer.slideToggle(state);
			tis.toggleClass('active',state);
		});
	});
});
</script>

<!-- allow dealer documents open in new page -->
<script type="text/javascript">
  jQuery(document).ready( function(){
      jQuery('.document-icon > a').attr('target', '_blank');
  } );
</script>
<?php endif; ?>


</body>
</html>