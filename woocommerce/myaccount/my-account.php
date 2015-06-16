<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

wc_print_notices(); ?>

<p class="myaccount_user">
	<?php
	printf(
		__( 'Hello <strong>%1$s</strong>&nbsp&nbsp(not %1$s? <a href="%2$s">Sign out</a>).', 'woocommerce' ) . ' ',
		$current_user->display_name,
		wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) )
	);?>
</p>

<?php do_action( 'woocommerce_before_my_account' ); ?>

<?php //wc_get_template( 'myaccount/my-downloads.php' ); ?>


<div class="my-account-landing">
	<div class="my-account-item">
		<h2 class="quote"><a href="http://www.doolittletrailers.com/my-account/quote-builder/">Order Trailers</a></h2>
			<p>Doolittle Trailer Mfg., Inc. is a leading manufacturer of utility, equipment, enclosed and dump trailers located in Holts Summit, Missouri.</p>
			<!-- <p class="launch"><a href="http://www.doolittletrailers.com/my-account/quote-builder/">Launch</a></p> -->
	</div>
	<div class="my-account-item">
		<h2 class="in-stock"><a href="http://www.doolittletrailers.com/my-account/in-stock/">In-Stock List</a></h2>
			<p>View our entire in-stock list of Doolittle Trailers.</p>
			This In-Stock List was last modified <strong><?php tablepress_print_table_info( 'id=1&field=last_modified' ); ?></strong>.
			<!-- <p class="launch"><a href="http://www.doolittletrailers.com/my-account/in-stock/">Launch</a></p> -->
	</div>
	<div class="my-account-item">
		<h2 class="orders"><a href="http://www.doolittletrailers.com/my-account/recent-orders/">Recent Orders</a></h2>
		<p>Doolittle Trailer Mfg., Inc. is a leading manufacturer of utility, equipment, enclosed and dump trailers located in Holts Summit, Missouri.</p>
		<!-- <p class="launch"><a href="http://www.doolittletrailers.com/my-account/recent-orders/">Launch</a></p> -->
	</div>
	<div class="my-account-item">
		<h2 class="documents"><a href="http://www.doolittletrailers.com/my-account/documents/">Documents</a></h2>
			<p>Doolittle Trailer Mfg., Inc. is a leading manufacturer of utility, equipment, enclosed and dump trailers located in Holts Summit, Missouri.</p>
			<!-- <p class="launch"><a href="http://www.doolittletrailers.com/my-account/documents/">Launch</a></p> -->
	</div>
	<div class="my-account-item">
		<h2 class="edit"><a href="http://www.doolittletrailers.com/my-account/edit-account/">Edit Account Details</a></h2>
		<p>Doolittle Trailer Mfg., Inc. is a leading manufacturer of utility, equipment, enclosed and dump trailers located in Holts Summit, Missouri.</p>
		<!-- <p class="launch"><a href="http://www.doolittletrailers.com/my-account/edit-account/">Launch</a></p> -->
	</div>
	<div class="my-account-item">
		<h2 class="marketing"><a href="http://www.doolittletrailers.com/my-account/dealer-marketing/">Dealer Marketing</a></h2>
		<p>Doolittle Trailer Mfg., Inc. is a leading manufacturer of utility, equipment, enclosed and dump trailers located in Holts Summit, Missouri.</p>
		<!-- <p class="launch"><a href="http://www.doolittletrailers.com/my-account/dealer-marketing/">Launch</a></p> -->
	</div>
	<div class="my-account-item">
		<h2 class="locator"><a href="http://www.doolittletrailers.com/my-account/dealer-locator/">Dealer Locator</a></h2>
		<p>Use this tool to locate Doolittle Dealers by location</p>
		<!-- <p class="launch"><a href="http://www.doolittletrailers.com/my-account/dealer-marketing/">Launch</a></p> -->
	</div>

	<div style="clear:both"></div>
</div>

<div class="recent-orders">
<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => 10 ) ); ?>
<div class="view-all-orders"><a href="http://www.doolittletrailers.com/my-account/recent-orders/">View All Orders</a></div>
</div>

<?php //wc_get_template( 'myaccount/my-address.php' ); ?>

<?php do_action( 'woocommerce_after_my_account' ); ?>
