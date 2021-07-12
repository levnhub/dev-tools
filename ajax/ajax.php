<?php

	// Get template part

	add_action( 'wp_ajax_mc_get_posts_template', 'mc_ajax_get_posts_template' );
	add_action( 'wp_ajax_nopriv_mc_get_posts_template', 'mc_get_posts_template' );
	function mc_get_posts_template()
	{
		check_ajax_referer( 'ajax_nonce' );

		$args = array(
			'category_name' => $_POST['args']['category_name'] ?? '',
		);

		get_template_part( 'template-parts/loop', 'posts', $args );

		wp_die();
	}

	// JSON file write

	$json = $_POST['json'];

	/* sanity check */
	if (json_decode($json) != null) {

		$file = fopen('map-data.json','w+');
		fwrite($file, $json);
		fclose($file);

	} else {
	 // user has posted invalid JSON, handle the error 
	}


	// Same, but like method

	function write_json($json, $filename) {

		$filename2 = __DIR__ . '/json/' . $filename . '.json';
		$fh = fopen($filename2, 'w+'); // open file and create if does not exist
		fwrite($fh, $json); // write data
		fclose($fh); // close file

		return $filename;
	}



