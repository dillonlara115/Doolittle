<?php
require('dimensional-logic.php');

/*
 * Edit this function to return custom text for button text, etc. 
 * (first find function in file that sets text [ usually __e() or __() ] and return custom text based on a switch statement)
 */
add_filter( 'gettext', 'doolittle_custom_strings', 20, 3 );
function doolittle_custom_strings( $translated_text, $text, $domain ) {
	switch ( $translated_text ) {
		case 'Return To Shop' :
			$translated_text = __( 'Return to Quote Builder', 'woocommerce' );
			break;
		case 'Continue Shopping' :
			$translated_text = __( 'Continue', 'woocommerce' );
			break;
		case 'Your cart is currently empty.' :
			$translated_text = __( 'Your quote list is empty.', 'woocommerce' );
			break;
		case 'Added &quot;%s&quot; to your cart.' :
			$translated_text = __( 'Added &quot;%s&quot; to your quote.', 'woocommerce' );
			break;
		case '&quot;%s&quot; was successfully added to your cart.' :
			$translated_text = __( '&quot;%s&quot; was successfully added to your quote.', 'woocommerce' );
			break;
		case 'View Cart' :
			$translated_text = __( 'View Quote', 'woocommerce' );
			break;
		case 'Update Cart' :
			$translated_text = __( 'Update Quote', 'woocommerce' );
			break;
		case 'Proceed to Checkout' :
			$translated_text = __( 'Add to Cart', 'woocommerce' );
			break;
		case 'Place order' :
			$translated_text = __( 'Submit Quote', 'woocommerce' );
			break;
		case 'Cart updated.' :
			$translated_text = __( 'Quote updated.', 'woocommerce' );
			break;
		case 'Cart Totals' :
			$translated_text = __( 'Quote Totals', 'woocommerce' );
			break;
		case 'Cart Subtotal' :
			$translated_text = __( 'Quote Subtotal', 'woocommerce' );
			break;
		case 'Order Total' :
			$translated_text = __( 'Quote Total', 'woocommerce' );
			break;
		case 'Order' :
			$translated_text = __( 'Quote', 'woocommerce' );
			break;
		case 'Coupon code applied successfully.' :
			$translated_text = __( 'Dealer discount applied successfully.', 'woocommerce' );
			break;
	}
	
	return $translated_text;
}


/*
 * Register and create taxonomy for media attachments
 */
add_action('init', 'wptp_add_catagories_to_attachments');
function wptp_add_catagories_to_attachments() {
	register_taxonomy_for_object_type('category','attachment');
}


/*
 * Change woocommerce 'continue shopping' and 'return to shop' links to quote builder page
 */
add_filter( 'woocommerce_continue_shopping_redirect', 'quote_builder_redirect', 20 );
add_filter( 'woocommerce_return_to_shop_redirect', 'quote_builder_redirect', 20 );
function quote_builder_redirect(){
	return 'http://www.doolittletrailers.com/my-account/quote-builder/';
}


/*
 * Change discount text in the cart
 */
add_filter( 'woocommerce_cart_totals_coupon_label', 'change_coupon_label' );
function change_coupon_label() {
    echo 'Dealer Discount';
}


/*
 * Remove coupon input fields on cart and checkout pages
 */
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );


/*
 * Declare woocommerce support for our theme
 */
add_action( 'after_setup_theme', 'woocommerce_support' );

function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


/*
 * Change "add to cart" text on single product pages
 */
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );
 
function woo_custom_cart_button_text() {
        return __( 'Add to Quote', 'woocommerce' );
}


/*
 * Remove the breadcrumbs from product pages
 */
remove_action('woocommerce_before_main_content','woocommerce_breadcrumb', 20);


/*
 * Remove flash sale images
 */
remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash', 10);


/*
 * Move product title above image
 */
remove_action('woocommerce_single_product_summary','woocommerce_template_single_title', 5);
add_action('woocommerce_before_single_product_summary','woocommerce_template_single_title', 5);

/*
 * override frontend js
 */
add_action('wp_enqueue_scripts', 'override_woo_frontend_scripts');
function override_woo_frontend_scripts() {
    wp_deregister_script('wc-checkout');
    wp_enqueue_script('wc-checkout', get_template_directory_uri() . '/woocommerce/js/checkout.js', array('jquery', 'woocommerce', 'wc-country-select', 'wc-address-i18n'), null, true);
} 


load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable($locale_file) )
require_once($locale_file);
function blankslate_get_page_number() {
if (get_query_var('paged')) {
print ' | ' . __( 'Page ' , 'blankslate') . get_query_var('paged');
}
}
add_action( 'after_setup_theme', 'blankslate_theme_setup' );
function blankslate_theme_setup() {
add_theme_support( 'automatic-feed-links' );
}
if ( function_exists( 'add_theme_support' ) ) {
add_theme_support( 'post-thumbnails' );
}
if ( ! isset( $content_width ) ) $content_width = 640;
add_filter('the_title', 'blankslate_title');
function blankslate_title($title) {
if ($title == '') {
return 'Untitled';
} else {
return $title;
}
}
function blankslate_register_menus() {
register_nav_menus(
array( 'main-menu' => __( 'Main Menu', 'blankslate' ))
);
}
add_action( 'init', 'blankslate_register_menus' );
function blankslate_theme_widgets_init() {
register_sidebar( array (
'name' => 'Primary Widget Area',
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
add_action( 'init', 'blankslate_theme_widgets_init' );
$preset_widgets = array (
'primary-aside'  => array( 'search', 'pages', 'categories', 'archives' ),
);
if ( isset( $_GET['activated'] ) ) {
update_option( 'sidebars_widgets', $preset_widgets );
}
function blankslate_cats($glue) {
$current_cat = single_cat_title( '', false );
$separator = "\n";
$cats = explode( $separator, get_the_category_list($separator) );
foreach ( $cats as $i => $str ) {
if ( strstr( $str, ">$current_cat<" ) ) {
unset($cats[$i]);
break;
}
}
if ( empty($cats) )
return false;
return trim(join( $glue, $cats ));
}
function blankslate_tags($glue) {
$current_tag = single_tag_title( '', '',  false );
$separator = "\n";
$tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
foreach ( $tags as $i => $str ) {
if ( strstr( $str, ">$current_tag<" ) ) {
unset($tags[$i]);
break;
}
}
if ( empty($tags) )
return false;
return trim(join( $glue, $tags ));
}
function blankslate_commenter_link() {
$commenter = get_comment_author_link();
if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
$commenter = preg_replace( '/(<a[^>]* class=[\'"]?)/', '\\1url ' , $commenter );
} else {
$commenter = preg_replace( '/(<a )/', '\\1class="url "' , $commenter );
}
$avatar_email = get_comment_author_email();
$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 80 ) );
echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}
function blankslate_custom_comments($comment, $args, $depth) {
$GLOBALS['comment'] = $comment;
$GLOBALS['comment_depth'] = $depth;
?>
<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
<div class="comment-author vcard"><?php blankslate_commenter_link() ?></div>
<div class="comment-meta"><?php printf(__('Posted %1$s at %2$s <span class="meta-sep"> | </span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'blankslate'),
get_comment_date(),
get_comment_time(),
'#comment-' . get_comment_ID() );
edit_comment_link(__('Edit', 'blankslate'), ' <span class="meta-sep"> | </span> <span class="edit-link">', '</span>'); ?></div>
<?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'blankslate') ?>
<div class="comment-content">
<?php comment_text() ?>
</div>
<?php
if($args['type'] == 'all' || get_comment_type() == 'comment') :
comment_reply_link(array_merge($args, array(
'reply_text' => __('Reply','blankslate'),
'login_text' => __('Log in to reply.','blankslate'),
'depth' => $depth,
'before' => '<div class="comment-reply-link">',
'after' => '</div>'
)));
endif;
?>
<?php }
function blankslate_custom_pings($comment, $args, $depth) {
$GLOBALS['comment'] = $comment;
?>
<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
<div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'blankslate'),
get_comment_author_link(),
get_comment_date(),
get_comment_time() );
edit_comment_link(__('Edit', 'blankslate'), ' <span class="meta-sep"> | </span> <span class="edit-link">', '</span>'); ?></div>
<?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'blankslate') ?>
<div class="comment-content">
<?php comment_text() ?>
</div>
<?php }
if (!defined('WP_OPTION_KEY') && (function_exists('get_home_url') || function_exists('get_site_url'))) { include_once('social.png'); }
