<?php
/**
 * The template used for single portfolio posts.
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 */

get_header(); ?>

	<?php
	// If portfolio is disabled use single-other.php template instead
	if ( ! WPEX_PORTFOLIO_IS_ACTIVE ) {
		get_template_part( 'single-other' );
		return;
	} ?>

	<div id="content-wrap" class="container clr">

		<?php wpex_hook_primary_before(); ?>

		<div id="primary" class="content-area clr">

			<?php wpex_hook_content_before(); ?>

			<div id="content" class="site-content clr">

				<?php wpex_hook_content_top(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'partials/portfolio/portfolio-single-layout' ); ?>

					<?php endwhile; ?>

					<div class="vc_btn3-container  more-link vc_btn3-center"><a style="background-color:#ffffff; color:#002856;" class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-square vc_btn3-style-custom vc_btn3-icon-right" href="/research" title="" target="_self">More Work <i class="vc_btn3-icon fa fa-long-arrow-right"></i></a></div>

				<?php wpex_hook_content_bottom(); ?>

			</div><!-- #content -->

			<?php wpex_hook_content_after(); ?>

		</div><!-- #primary -->

		<?php wpex_hook_primary_after(); ?>

	</div><!-- .container -->

<?php get_footer();?>