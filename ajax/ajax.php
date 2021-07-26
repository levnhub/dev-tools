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

// Send message

	add_action('wp_ajax_send_message', 'lnd_send_message');
	add_action('wp_ajax_nopriv_send_message', 'lnd_send_message');
	function lnd_send_message()
	{
	    check_ajax_referer('ajax_nonce');

	    if (isset($_POST['data']) and !empty($_POST['data'])) {

	        parse_str($_POST['data'], $data);

	        // var_dump($data); // debug

	        // Validate fields
	        if (empty($data['name'])) wp_send_json_error('no_name');
	        if (empty($data['tel'])) wp_send_json_error('no_tel');
	        if (empty($data['email'])) wp_send_json_error('no_email');
	        if (empty($data['privacy'])) wp_send_json_error('no_privacy');

	        $data['subject'] = 'Заявка с сайта';

	        // Mail
	        $headers[] = 'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>';
	        $message_admin = lnd_get_mail_template('mail-admin', $data);
	        $message_client = lnd_get_mail_template('mail-client', $data);
	        add_filter('wp_mail_content_type', 'set_html_content_type');
	        // To admin
	        $mail_admin = wp_mail('ma4ine@ya.ru', $data['subject'], $message_admin, $headers);
	        // To client
	        $mail_client = wp_mail($data['email'], $data['subject'], $message_client, $headers);
	        remove_filter('wp_mail_content_type', 'set_html_content_type');

	        // Telegram
	        $telegram = lnd_send_message_telegram($data);

	        if ( ! $mail_admin ) {
	            echo 'Admin e-mail error';
	        } elseif ( ! $mail_client ) {
	            echo 'Client e-mail error';
	        } elseif ( ! json_decode( $telegram, true )['ok'] ) {
	            echo 'Telegram message error';
	        } else {
	            echo 'success';
	        }
	    }

	    wp_die();
	}

	function lnd_get_mail_template($slug, array $data = array(), $output = false)
	{
	    if(!$output) ob_start();
	    $template_file = locate_template("{$slug}.php", false, false);
	    extract($data, EXTR_SKIP);
	    require($template_file);
	    if(!$output) return ob_get_clean();
	}

	function lnd_send_message_telegram($data)
	{
	    if ( !is_array($data) or empty($data) ) return false;

	    unset($data['privacy']);

	    $text = '
	        *subject*

	        Клиент: name
	        Телефон: tel
	        E-mail: email
	    ';

	    if ( !empty($data['comment']) ) {
	        $text .= '
	            Пожелания: comment
	        ';
	    }

	    if ( !empty($data['clients']) ) {
	        $text .= '
	            + eщё участники в письме на почте
	        ';
	        unset($data['clients']);
	    }

	    // Add values

	    foreach ($data as $key => $value) {
	        if (!$value) continue;
	        $text = str_replace($key, $value, $text);
	    }

	    // Prepare query

			$chars = array( '_', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!');
			foreach ($chars as $char) {
				$text = str_replace($char, '\\' . $char, $text);
			}

	    $text = str_replace('++++', '', urlencode($text));

	    $query_string = 'https://api.telegram.org/bot1933950867:AAHDslWY-FIzJd1UhowPkyiaXdenqcBOM2c/sendMessage?chat_id=1027889489&parse_mode=MarkdownV2&text=' . $text;

	    // my test id 1027889489
	    // use '?getUpdates' to get client chat_id 

	    $options = array(
	        'http' => array(
	            'header' => "Content-type: application/x-www-form-urlencoded\r\n" . "X-Country: ru",
	            'method' => 'POST',
	            'content' => '',
	        ),
	        'ssl' => array(
	            'verify_peer' => false,
	            'verify_peer_name' => false
	        )
	    );
	    $context = stream_context_create($options);
	    $result = file_get_contents($query_string, false, $context);

	    return $result;
	}

