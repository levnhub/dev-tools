<?php
/**
 * Main Header Template
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	<meta name="author" content="Lev & Dev">
	<meta name="publisher" content="https://t.me/levndev">
	
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon.ico">
	<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon-16x16.png">
	<link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon-120x120.svg">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon-152x152.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon-152x152.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon-76x76.png">
	<link rel="apple-touch-startup-image" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon-152x152.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/favicon/favicon-270.png">

	<title><?php bloginfo( 'title' ); ?></title>
  
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<!-- Wrapper Start -->
	<div class="wrapper">
		<header class="header">
			HEADER
		</header>
