<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AJNodes
 * @since 1.0.0
 */

?>

<section class="no-results not-found">
	<div class="page-header">
		<h2 class="page-title"><?php echo esc_html__( 'Nothing Found', 'AJNodes_td' ); ?></h2>
	</div><!-- .page-header -->
	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) {
				printf(
					'<p>' . wp_kses(
						/* translators: 1: link to WP admin new post page. */
						__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'AJNodes_td' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					) . '</p>',
					esc_url( admin_url( 'post-new.php' ) )
				);
			?>
		<?php } elseif ( is_search() ) { ?>
			<p><?php echo esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'AJNodes_td' ); ?></p>
			<?php get_search_form(); ?>
		<?php } else { ?>
			<p><?php echo esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'AJNodes_td' ); ?></p>
			<?php get_search_form(); ?>
		<?php } ?>
	</div><!-- .page-section -->
</section><!-- .no-results -->
