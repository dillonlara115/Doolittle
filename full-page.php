<?php
/*
Template Name: Full Page
*/
?>

<?php get_header(); ?>

	<div class="container">
		<div id="content-full">
			<?php the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php if ( has_post_thumbnail() ) {
					the_post_thumbnail('large', array('class' => 'content-header'));
					} else { ?>
					<?php } ?>
					<?php the_content(); ?>
					<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'blankslate' ) . '&after=</div>') ?>
					<?php edit_post_link( __( 'Edit', 'blankslate' ), '<span class="edit-link">', '</span>' ) ?>
				</div>
			</div>
			<?php comments_template( '', true ); ?>
			<?php
				// if viewing my account page and are logged in, get my account sidebar
				if(is_page("my-account")){
					if(is_user_logged_in()){
						get_sidebar();
					}
				}
			?>
			<div style="clear: both"></div>
		</div>
	</div>
<?php 
if (!is_woocommerce()){
	if (!is_page("my-account")){
		get_footer(); 
	}
}	
?>