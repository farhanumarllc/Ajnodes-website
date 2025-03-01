<?php
/**
 * Custom related functions
 *
 * @link
 *
 * @package AJNodes
 * @since 1.0.0
 */

namespace AJNodes\Blog;

/**
 * Template Class For Custom
 *
 * Template Class
 *
 * @category Setting_Class
 * @package  AJNodes
 */
class WP_Theme_Blog_Url {

	/**
	 * Define class Constructor
	 **/
	public function __construct() {
		$post_custom_permalink = get_option( 'post_custom_permalink' );
		if ( '' !== $post_custom_permalink ) {

			add_action( 'generate_rewrite_rules', array( $this, 'glide_posts_add_rewrite_rules' ) );
			add_filter( 'post_link', array( $this, 'posts_change_blog_links' ), 1, 3 );
			add_action( 'template_redirect', array( $this, 'custom_redirect_dynamic_slug' ) );
		}

		add_action( 'admin_init', array( $this, 'admin_init_fields' ) );
	}

	/**
	 * Rewrite Rules.
	 *
	 * @param array $wp_rewrite  wp rewrite rules.
	 *
	 * @return array $wp_rewrite
	 */
	public function glide_posts_add_rewrite_rules( $wp_rewrite ) {
		$post_custom_permalink = get_option( 'post_custom_permalink' );
		$new_rules             = array(
			$post_custom_permalink . '/page/([0-9]{1,})/?$' => 'index.php?post_type=post&paged=' . $wp_rewrite->preg_index( 1 ),
			$post_custom_permalink . '/(.+?)/?$' => 'index.php?post_type=post&name=' . $wp_rewrite->preg_index( 1 ),
		);
		$wp_rewrite->rules     = $new_rules + $wp_rewrite->rules;
		return $wp_rewrite->rules;
	}
	/**
	 * Change Post link
	 *
	 * @param string $post_link Post link.
	 * @param int    $id post id.
	 *
	 * @return string $post_link.
	 */
	public function posts_change_blog_links( $post_link, $id = 0 ) {
		$post                  = get_post( $id );
		$post_custom_permalink = get_option( 'post_custom_permalink' );
		if ( is_object( $post ) && 'post' === $post->post_type ) {
			return home_url( '/' . $post_custom_permalink . '/' . $post->post_name . '/' );
		}
		return $post_link;
	}
	/**
	 * Redirect
	 */
	public function custom_redirect_dynamic_slug() {
		$posts_page_id         = get_option( 'page_for_posts' );
		$queried_object_id     = get_queried_object_id();
		$post_custom_permalink = get_option( 'post_custom_permalink' );
		if ( 'post' === get_post_type() && (int) $posts_page_id !== $queried_object_id ) {

			$request_uri = ( isset( $_SERVER['REQUEST_URI'] ) ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : null;
			// Use a regular expression to capture the dynamic slug.
			if ( $request_uri ) {
				if ( preg_match( '/^\/([^\/]+)\/$/', $request_uri, $matches ) ) {

					$dynamic_slug = ( isset( $matches[1] ) ) ? $matches[1] : null;
					if ( $dynamic_slug ) {

						// Redirect to the new URL with the dynamic slug.
						$new_url = home_url( "/$post_custom_permalink/$dynamic_slug/" );
						wp_redirect( $new_url, 301 );
						exit();
					}
				}
			}
		}
	}

	/**
	 * Fix labels.
	 */
	public function admin_init_fields() {

		// register our setting.
		// register our setting.
		$args = array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => null,
		);
		register_setting(
			'permalink', // option group "reading", default WP group.
			'post_custom_permalink', // option name.
			$args
		);

		// add our new setting.
		add_settings_field(
			'post_custom_permalink', // ID.
			'Post Permalink Structure', // Title.
			array( $this, 'setting_callback_function' ), // Callback.
			'permalink', // page.
			'optional', // section.
			array( 'label_for' => 'post_custom_permalink' )
		);
		$post_custom_permalink = get_option( 'post_custom_permalink' );
		if ( isset( $_POST['permalink_structure'] ) && isset( $_POST['post_custom_permalink'] ) ) {

			$post_custom_permalink = wp_unslash( $_POST['post_custom_permalink'] );
			update_option( 'post_custom_permalink', $post_custom_permalink );

		}
	}
	/**
	 * Fix labels.
	 */
	public function setting_callback_function() {
		// get saved project page ID.

		$post_custom_permalink = get_option( 'post_custom_permalink' );
		echo html_entity_decode( '<input name="post_custom_permalink" type="text" id="post_custom_permalink" value="' . $post_custom_permalink . '" class="regular-text code"> ' );
	}


}
new WP_Theme_Blog_Url();
