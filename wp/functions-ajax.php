<?php
/**
 * The AJAX functions file
 *
 */

// Get posts loop template

add_action( 'wp_ajax_get_posts_template', 'lnd_get_posts_template' );
add_action( 'wp_ajax_nopriv_get_posts_template', 'lnd_get_posts_template' );
function lnd_get_posts_template()
{
	check_ajax_referer( 'ajax_nonce' );

	$args = array(
		'category_name' => $_POST['args']['category_name'] ?? '',
	);

	get_template_part( 'template-parts/loop', 'posts', $args );

	wp_die();
}