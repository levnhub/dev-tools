<?php
/**
 * Event list template
 *
 */

global $post;

get_header();

$post = get_post( get_option('page_for_posts') );
setup_postdata( $post );

?>

<?php the_title() ?>

<?php 

wp_reset_postdata();

get_footer();