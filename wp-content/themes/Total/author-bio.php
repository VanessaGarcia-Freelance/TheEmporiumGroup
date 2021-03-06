<?php
/**
 * The template for displaying Author bios.
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get global post
global $post;

// Define author bio data
$data = array(
	'post_author' => $post->post_author,
	'avatar_size' => apply_filters( 'wpex_author_bio_avatar_size', 74 ),
	'author_name' => get_the_author(),
	'posts_url'   => get_author_posts_url( get_the_author_meta( 'ID' ) ),
	'description' => get_the_author_meta( 'description' ),

);

// Get author avatar
$data['avatar'] = get_avatar( get_the_author_meta( 'user_email' ), $data['avatar_size'] );

// Apply filters so we can tweak the author bio output
$data = apply_filters( 'wpex_post_author_bio_data', $data );

// Extract
extract( $data ); ?>

<section class="author-bio clr">

	<?php if ( $avatar ) : ?>

		<div class="author-bio-avatar">

			<a href="<?php echo $posts_url; ?>" title="<?php _e( 'Visit Author Page', 'wpex' ); ?>">
				<?php
				// Display author avatar
				echo $avatar; ?>
			</a>

		</div><!-- .author-bio-avatar -->
		
	<?php endif; ?>

	<div class="author-bio-content clr">

		<h4 class="author-bio-title"><a href="<?php echo $posts_url; ?>" title="<?php _e( 'Visit Author Page', 'wpex' ); ?>"><?php echo $author_name; ?></a></h4><!-- .author-bio-title -->

		<?php
		// Outputs the author description if one exists
		if ( $description ) : ?>

			<div class="author-bio-description clr">
				<?php echo do_shortcode( $description ); ?>
			</div><!-- author-bio-description -->

		<?php endif; ?>

		<?php
		// Display author social links if there are social links defined
		if ( wpex_author_has_social() ) : ?>

			<div class="author-bio-social clr">
				<?php
				// Display twitter url
				if ( $twitter = get_the_author_meta( 'wpex_twitter', $post_author ) ) : ?>
					<a href="<?php echo $twitter; ?>" title="Twitter" class="twitter tooltip-up">
						<span class="fa fa-twitter"></span>
					</a>
				<?php endif; ?>

				<?php
				// Display facebook url
				if ( $facebook = get_the_author_meta( 'wpex_facebook', $post_author ) ) : ?>
					<a href="<?php echo $facebook; ?>" title="Facebook" class="facebook tooltip-up">
						<span class="fa fa-facebook"></span>
					</a>
				<?php endif; ?>

				<?php
				// Display google plus url
				if ( $gplus = get_the_author_meta( 'wpex_googleplus', $post_author ) ) : ?>
					<a href="<?php echo $gplus; ?>" title="Google Plus" class="google-plus tooltip-up">
						<span class="fa fa-google-plus"></span>
					</a>
				<?php endif; ?>

				<?php
				// Display Linkedin url
				if ( $linkedin = get_the_author_meta( 'wpex_linkedin', $post_author ) ) : ?>
					<a href="<?php echo $linkedin; ?>" title="LinkedIn" class="linkedin tooltip-up">
						<span class="fa fa-linkedin"></span>
					</a>
				<?php endif; ?>

				<?php
				// Display pinterest plus url
				if ( $pinterest = get_the_author_meta( 'wpex_pinterest', $post_author ) ) : ?>
					<a href="<?php echo $pinterest; ?>" title="Pinterest" class="pinterest tooltip-up">
						<span class="fa fa-pinterest"></span>
					</a>
				<?php endif; ?>

				<?php
				// Display instagram plus url
				if ( $instagram = get_the_author_meta( 'wpex_instagram', $post_author ) ) : ?>
					<a href="<?php echo  $instagram; ?>" title="Instagram" class="instagram tooltip-up">
						<span class="fa fa-instagram"></span>
					</a>
				<?php endif; ?>
			</div><!-- .author-bio-social -->

		<?php endif; ?>

	</div><!-- .author-bio-content -->

</section><!-- .author-bio -->