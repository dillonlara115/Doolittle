<?php
/*
Template Name: Recent Orders
*/
?>

<?php get_header(); 
	
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

wc_print_notices();
	
?>
	<div class="container">
		<div id="content-full">
			<?php the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="woocommerce">
							<div class="recent-orders">
								<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>
							</div>
						</div>
				</div>
			</div>
			<div style="clear: both"></div>
		</div>
	</div>
<?php get_footer(); ?>
