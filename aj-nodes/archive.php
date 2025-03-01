<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AJNodes
 * @since 1.0.0
 */

// Include header.
get_header();

list( $ajn_var_post_id, $ajn_fields, $ajn_option_fields ) = AJNodes::defaults();

?>
<section id="hero-section" class="hero-section hero-home hero-resource">
	<div class="hero-home-inner">
		<div class="wrapper">
			<div class="home-hero-text">
				<h1 class="heading"><span><?php the_archive_title(); ?></span></h1>
				<div class="resource-search-form">
					<form role="search" method="get" id="" action="#">
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="" class="page-section">
	<div class="gl-s72"></div>
	<section>
		<div class="wrapper">
			<div class="post-archive three-columns ajax-search-container">
				<?php
				global $wp_query;
				if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					// Include specific template for the content.
					get_template_part( 'partials/content-archive', get_post_type() );
				}
				} else {
					// If no content, include the "No posts found" template.
					get_template_part( 'partials/content', 'none' );
				}
				?>
			</div>
			<div class="gl-s72"></div>
			<div class="ajax-search-pagination">
			<?php
			if ( have_posts() ) {
				if ( class_exists( 'AJNodes' ) && $wp_query->max_num_pages > 1 ) {
					?>
					<div class="center-align">
						<a href="<?php echo esc_html( $wp_query->max_num_pages ); ?>" class="wp-block-button__link wp-element-button" id="ajax-loadmore-click"><?php esc_html_e( 'Load More', 'AJNodes_td' ); ?></a>
					</div>
					<?php
				}
			}
			?>
			</div>
		</div>
	</section>
	<div class="gl-s160"></div>
</section>
<?php get_footer(); ?>
