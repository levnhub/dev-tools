<?php
/**
 * Name section template part
 *
 */

$selector = 'selectior';
$post_id = $args['post_id'] ?? get_the_ID();
$section = ( isset($args['is_sub_field']) && $args['is_sub_field'] ) 
	? get_sub_field( $selector, $post_id )
	: get_field( $selector, $post_id );

if ( $section ) { ?>

	<!-- Content -->

<?php }