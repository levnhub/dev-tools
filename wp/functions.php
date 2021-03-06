<?php
/**
 * The main functions file
 *
 */

// Global constant vars

	define('MC_SITE_URL', get_bloginfo('url'));
	define('MC_ADMIN_EMAIL', get_bloginfo('admin_email'));
	define('MC_TEMPLATE_URL', get_template_directory_uri());
	define('MC_TEMPLATE_DIR', get_template_directory());
	define('MC_IMAGE_URL', MC_TEMPLATE_URL . '/img');
	define('MC_VECTOR_URL', MC_TEMPLATE_URL . '/svg');

// WP AJAX debug (works only if "wp-debug" enabled)

	if( WP_DEBUG && WP_DEBUG_DISPLAY && (defined('DOING_AJAX') && DOING_AJAX) ){
		@ ini_set( 'display_errors', 1 );
	}

// CORS localhost allow

	if ( stripos($_SERVER['SERVER_NAME'], 'localhost') ) {
		add_action('init','add_cors_http_header');
		function add_cors_http_header(){
			header("Access-Control-Allow-Origin: *");
		}
	}

// Remove unuseful

	add_action('wp_loaded', function () {
	  remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
	  remove_action('wp_head', 'wp_generator'); // remove wordpress version
	  remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
	  remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links
	  remove_action('wp_head', 'index_rel_link'); // remove link to index page
	  remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)
	  remove_action('wp_head', 'start_post_rel_link', 10); // remove random post link
	  remove_action('wp_head', 'parent_post_rel_link', 10); // remove parent post link
	  remove_action('wp_head', 'adjacent_posts_rel_link', 10); // remove the next and previous post links
	  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
	  remove_action('wp_head', 'wp_shortlink_wp_head', 10);
	  remove_action('wp_head', 'rest_output_link_wp_head');
	  remove_action('wp_head', 'wp_oembed_add_discovery_links');
	  remove_action('template_redirect', 'rest_output_link_header', 11);
	  remove_action('wp_head', 'rel_canonical'); // remove canonical from head
	  remove_action('wp_enqueue_scripts', 'evc_share_styles'); //remove plugin styles
	  remove_action('wp_head', 'print_emoji_detection_script', 7);
	  remove_action('admin_print_scripts', 'print_emoji_detection_script');
	  remove_action('wp_print_styles', 'print_emoji_styles');
	  remove_action('admin_print_styles', 'print_emoji_styles');
	});
	add_filter('wpseo_canonical', '__return_false');
	add_filter('wpseo_author_link', '__return_false');
	add_filter('wpseo_prev_rel_link', '__return_false');
	add_filter('wpseo_next_rel_link', '__return_false');

// Setup theme

	add_action('after_setup_theme', function() {
		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails', array( 'post' ) );
		add_theme_support( 'html5', [ 'script', 'style' ] );
		add_image_size( 'small', 225, 225 );
	});

// Disable annoying Yoast SEO admin notifications

	add_action( 'admin_init', function() {
	  if ( class_exists( 'Yoast_Notification_Center' ) ) {
	      $yoast_nc = Yoast_Notification_Center::get();
	      remove_action( 'admin_notices', array( $yoast_nc, 'display_notifications' ) );
	      remove_action( 'all_admin_notices', array( $yoast_nc, 'display_notifications' ) );
	  }
	});
	add_filter('wpseo_enable_notification_post_trash', '__return_false');
	add_filter('wpseo_enable_notification_post_slug_change', '__return_false');
	add_filter('wpseo_enable_notification_term_delete','__return_false');
	add_filter('wpseo_enable_notification_term_slug_change','__return_false');

// Rename "Posts" in "News"

	add_filter('post_type_labels_post', 'rename_posts_labels');
	function rename_posts_labels( $labels ){

		$new = array(
			'name'                  => '??????????????',
			'singular_name'         => '??????????????',
			'add_new'               => '???????????????? ??????????????',
			'add_new_item'          => '???????????????? ??????????????',
			'edit_item'             => '?????????????????????????? ??????????????',
			'new_item'              => '?????????? ??????????????',
			'view_item'             => '?????????????????????? ??????????????',
			'search_items'          => '?????????? ??????????????',
			'not_found'             => '???????????????? ???? ??????????????.',
			'not_found_in_trash'    => '???????????????? ?? ?????????????? ???? ??????????????.',
			'parent_item_colon'     => '',
			'all_items'             => '?????? ??????????????',
			'archives'              => '???????????? ????????????????',
			'insert_into_item'      => '???????????????? ?? ??????????????',
			'uploaded_to_this_item' => '?????????????????????? ?????? ???????? ??????????????',
			'featured_image'        => '?????????????????? ??????????????',
			'filter_items_list'     => '?????????????????????? ???????????? ????????????????',
			'items_list_navigation' => '?????????????????? ???? ???????????? ????????????????',
			'items_list'            => '???????????? ????????????????',
			'menu_name'             => '??????????????',
			'name_admin_bar'        => '??????????????', // ???????????? "????????????????"
		);

		return (object) array_merge( (array) $labels, $new );
	}

// Rename "Posts" in "Service"

	add_filter('post_type_labels_post', 'rename_posts_labels');
	function rename_posts_labels( $labels ){

		$new = array(
			'name'                  => '????????????',
			'singular_name'         => '????????????',
			'add_new'               => '???????????????? ????????????',
			'add_new_item'          => '???????????????? ????????????',
			'edit_item'             => '?????????????????????????? ????????????',
			'new_item'              => '?????????? ????????????',
			'view_item'             => '?????????????????????? ????????????',
			'search_items'          => '?????????? ????????????',
			'not_found'             => '?????????? ???? ??????????????.',
			'not_found_in_trash'    => '?????????? ?? ?????????????? ???? ??????????????.',
			'parent_item_colon'     => '',
			'all_items'             => '?????? ????????????',
			'archives'              => '???????????? ??????????',
			'insert_into_item'      => '???????????????? ?? ????????????',
			'uploaded_to_this_item' => '?????????????????????? ?????? ???????? ????????????',
			'featured_image'        => '?????????????????? ????????????',
			'filter_items_list'     => '?????????????????????? ???????????? ??????????',
			'items_list_navigation' => '?????????????????? ???? ???????????? ??????????',
			'items_list'            => '???????????? ??????????',
			'menu_name'             => '????????????',
			'name_admin_bar'        => '????????????', // ???????????? "????????????????"
		);

		return (object) array_merge( (array) $labels, $new );
	}

// Register custom post type

	add_action('init', 'register_post_types');
	function register_post_types(){

		register_post_type('project', array(
			'label'  => '??????????????',
			'labels' => array(
				'name'               => '??????????????', // ???????????????? ???????????????? ?????? ???????? ????????????
				'singular_name'      => '????????????', // ???????????????? ?????? ?????????? ???????????? ?????????? ????????
				'add_new'            => '???????????????? ????????????', // ?????? ???????????????????? ?????????? ????????????
				'add_new_item'       => '???????????????????? ??????????????', // ?????????????????? ?? ?????????? ?????????????????????? ???????????? ?? ??????????-????????????.
				'edit_item'          => '?????????????????????????? ????????????', // ?????? ???????????????????????????? ???????? ????????????
				'new_item'           => '?????????? ????????????', // ?????????? ?????????? ????????????
				'view_item'          => '?????????????????????? ????????????', // ?????? ?????????????????? ???????????? ?????????? ????????.
				'search_items'       => '???????????? ????????????', // ?????? ???????????? ???? ???????? ?????????? ????????????
				'all_items'          => '?????? ??????????????',
				'not_found'          => '???????????????? ??????????????', // ???????? ?? ???????????????????? ???????????? ???????????? ???? ???????? ??????????????
				'not_found_in_trash' => '???????????????? ?? ?????????????? ???? ??????????????', // ???????? ???? ???????? ?????????????? ?? ??????????????
				'parent_item_colon'  => '', // ?????? ?????????????????? (?? ?????????????????????? ??????????)
				'menu_name'          => '??????????????', // ???????????????? ????????
			),
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => null, // ?????????????? ???? public
			'exclude_from_search' => null, // ?????????????? ???? public
			'show_ui'             => null, // ?????????????? ???? public
			'show_in_menu'        => null, // ???????????????????? ???? ?? ???????? ????????????
			'show_in_admin_bar'   => null, // ???? ?????????????????? ???????????????? show_in_menu
			'show_in_nav_menus'   => null, // ?????????????? ???? public
			'show_in_rest'        => null, // ???????????????? ?? REST API. C WP 4.7
			'rest_base'           => null, // $post_type. C WP 4.7
			'menu_position'       => 7,
			'menu_icon'           => 'dashicons-thumbs-up', 
			//'capability_type'   => 'post',
			//'capabilities'      => 'post', // ???????????? ???????????????????????????? ???????? ?????? ?????????? ???????? ????????????
			//'map_meta_cap'      => null, // ???????????? true ?????????? ???????????????? ?????????????????? ???????????????????? ?????????????????????? ????????
			'hierarchical'        => true,
			'supports'            => array('title','editor','author','excerpt','thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => array('cat'),
			'has_archive'         => true,
			'rewrite'             => true,
			'query_var'           => true,
		) );
	}

// Register custom taxonomies

	add_action('init', 'register_taxonomies');
	function register_taxonomies(){

		register_taxonomy('cat', array('project'), array(
			'label'                 => '', // ???????????????????????? ???????????????????? $labels->name
			'labels'                => array(
				'name'              => '??????????????????',
				'singular_name'     => '??????????????????',
				'search_items'      => '???????????? ??????????????????',
				'all_items'         => '?????? ??????????????????',
				'not_found'         => '???????????????? ???? ??????????????',
				'view_item'         => '?????????????????????? ??????????????????',
				'parent_item'       => '???????????????????????? ??????????????????',
				'parent_item_colon' => '???????????????????????? ??????????????????:',
				'edit_item'         => '?????????????????????????? ??????????????????',
				'update_item'       => '???????????????? ??????????????????',
				'add_new_item'      => '???????????????? ?????????? ??????????????????',
				'new_item_name'     => '?????? ?????????? ??????????????????',
				'menu_name'         => '??????????????????',
				'choose_from_most_used' => '?????????????? ???? ?????????? ???????????????????????? ??????????????????', // ???? ???????????????????????? ?????? ?????????????????????? ??????????.
				'back_to_items'			=> '??? ?????????? ???? ????????',
			),
			'description'           => '', // ???????????????? ????????????????????
			'public'                => true,
			'publicly_queryable'    => null, // ?????????? ?????????????????? public
			'show_in_nav_menus'     => true, // ?????????? ?????????????????? public
			'show_ui'               => true, // ?????????? ?????????????????? public
			'show_in_menu'          => true, // ?????????? ?????????????????? show_ui
			'show_tagcloud'         => true, // ?????????? ?????????????????? show_ui
			'show_in_rest'          => null, // ???????????????? ?? REST API
			'rest_base'             => null, // $taxonomy
			'hierarchical'          => true,
			'update_count_callback' => '',
			'rewrite'               => true,
			//'query_var'             => $taxonomy, // ???????????????? ?????????????????? ??????????????
			'capabilities'          => array(),
			'meta_box_cb'           => null, // callback ??????????????. ???????????????? ???? html ?????? ?????????????????? (?? ???????????? 3.8): post_categories_meta_box ?????? post_tags_meta_box. ???????? ?????????????? false, ???? ???????????????? ?????????? ???????????????? ????????????
			'show_admin_column'     => true, // ?????????????????? ?????? ?????? ????????-???????????????? ?????????????? ???????????????????? ?? ?????????????? ???????????????????????????????? ???????? ????????????. (?? ???????????? 3.5)
			'_builtin'              => false,
			'show_in_quick_edit'    => null, // ???? ?????????????????? ???????????????? show_ui
		) );
		// ???????????? ????????????????????: http://wp-kama.ru/function/get_taxonomy_labels
	}

// Reorder Posts menu

	add_action('admin_menu', 're_order_menu');
	function re_order_menu () {
		global $menu;
		$posts = $menu[5];
		unset($menu[5]);
		$menu[7] = $posts;
	}

// Register actual jQuery

	add_action( 'wp_enqueue_scripts', 'jQuery_scripts', 1 );
	function jQuery_scripts() {
		// ???????????????? ???????????????????????????????????? jQuery
		// ???????????? "jquery-core", ?????????? ?????????????? "jquery", ?????????? ?????????? ?????????????? ?????? ?? jquery-migrate
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '3.2.1', true );
		wp_register_script( 'jquery-migrate', '//code.jquery.com/jquery-migrate-1.4.1.js', array(), '1.4.1', true );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-migrate' );
	}

// Enqueue styles & scripst to front-end

	add_action( 'wp_enqueue_scripts', 'theme_scripts' );
	function theme_scripts() {

		$url = get_template_directory_uri();
		$dir = get_template_directory();

		// Styles
		wp_enqueue_style( 'style', get_stylesheet_uri() );
		wp_enqueue_style( 'title-font', $url . '/font/kelson-sans/stylesheet.css', array(), filemtime($dir . '/font/kelson-sans/stylesheet.css') );
		wp_enqueue_style( 'text-font', $url . '/font/helvetica-neue-cyr/stylesheet.css', array(), filemtime($dir . '/font/helvetica-neue-cyr/stylesheet.css') );
		wp_enqueue_style( 'icon-font', $url . '/font/iconfont/stylesheet.css', array(), filemtime($dir . '/font/iconfont/stylesheet.css') );
		wp_enqueue_style( 'vendor-style', $url . '/css/vendor.min.css', array(), filemtime($dir . '/css/vendor.min.css') );
		wp_enqueue_style( 'main-style', $url . '/css/main.min.css', array(), filemtime($dir . '/css/main.min.css') );
		
		// Scripts
		wp_enqueue_script( 'yandex_map-api', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU', array(), '2.1.0', true );
		wp_enqueue_script( 'vendor-script', $url . '/js/vendor.min.js', array('jquery'), filemtime($dir . '/js/vendor.min.js'), true );
		wp_enqueue_script( 'main-script', $url . '/js/main.min.js', array('jquery'), filemtime($dir . '/js/main.min.js'), true );

		// Add AJAX variables
	    wp_localize_script('main-script', 'ajax_front', array(
	        'url' => admin_url('admin-ajax.php', 'relative'),
	        'nonce' => wp_create_nonce('nonce-ajax')
	    ));
	}

// Enqueue styles & scripst to back-end

	add_action( 'admin_enqueue_scripts', 'admin_scripts' );
	function admin_scripts() {

		$url = get_template_directory_uri();
		$dir = get_template_directory();

		// Styles
		wp_enqueue_style( 'admin-style', $url . '/css/admin.min.css', false, filemtime($dir . '/css/admin.min.css') );

		// Scripts
		wp_enqueue_script( 'admin-script', $url . '/js/admin.min.js', array(), filemtime($dir . '/js/admin.min.js'), true );

	}

// ???????????????????????? ?????????????? ????????????
	function sidebar_init() {
		register_sidebar( array(
			'name'          => '?????????????? ???????????? 1',
			'id'            => 'sidebar-1',
			'description'   => '???? ???????????????? ??????????????',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<div class="widget--title">',
			'after_title'   => '</div>',
		) );
	}
	add_action( 'widgets_init', 'sidebar_init' );

	function sidebar_init_2() {
		register_sidebar( array(
			'name'          => '?????????????? ???????????? 2',
			'id'            => 'sidebar-2',
			'description'   => '???? ???????????????? ?????????????? ?? ??????????????????',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<div class="widget--title">',
			'after_title'   => '</div>',
		) );
	}
	add_action( 'widgets_init', 'sidebar_init_2' );

// Excerpt filter
	add_filter( 'excerpt_length', function(){
		return 30;
	} );

	add_filter('excerpt_more', function($more) {
		return '...';
	});

	// Custom excerpt
	function custom_excerpt( $limit ) {
    return wp_trim_words(get_the_excerpt(), $limit, '...');
	};

// ?????????????????? ???????????????????? ?????? ?????????????????? ????????????????.
	function filter_plugin_updates( $value ) {
	    unset( $value->response['advanced-custom-fields-pro-master/acf.php'] );
	    return $value;
	}
	add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );

// ???????????? "??????????????: ", "??????????: " ?? ??.??. ???? ?????????????????? ????????????
	add_filter( 'get_the_archive_title', function( $title ){
		return preg_replace('~^[^:]+: ~', '', $title );
	});

// Excerpt support
	add_post_type_support( 'page', 'excerpt' );

// Drastically speed up the load times of the post edit page!
	add_filter('acf/settings/remove_wp_meta_box', '__return_true');	

// Add a link to the Yoast SEO breadcrumbs
	add_filter( 'wpseo_breadcrumb_links', 'yoast_seo_breadcrumb_append_link' );
	function yoast_seo_breadcrumb_append_link( $links ) {
	    global $post;
	    $post_type = get_post_type();
	    if ( $post_type === 'custom' ) {
	        $breadcrumb[] = array(
	            'url' => site_url( '/catalog/' ),
	            'text' => '??????????????',
	        );
	        array_splice( $links, 1, -2, $breadcrumb );
	    }
	    return $links;
	};

// ???????????? ???????????????? Ninja Forms
	add_action('add_meta_boxes', function() {
	    remove_meta_box('nf_admin_metaboxes_appendaform', ['page', 'post'], 'side');
	}, 99);

// Remove native taxonoomy
	add_action('init', 'ev_unregister_taxonomy');
	function ev_unregister_taxonomy(){
	    register_taxonomy('post_tag', array());
	}

	// Remove menu item
	add_action( 'admin_menu', 'remove_menus' );
	function remove_menus(){
	    remove_menu_page('edit-tags.php?taxonomy=post_tag'); // Post tags
	}

// Remove old fields script

	add_action( 'init', 'br_old_social_fields_remove_script', 10, 1 );
	function br_old_social_fields_remove_script()
	{
		if ( !is_user_logged_in() ) return false;

		if ( isset($_GET['script']) and $_GET['script'] === 'remove_old_user_meta' ) {

			$args = array(
				'fields' => 'ID',
			);

			$users = get_users($args);

			foreach ($users as $user_id) {

				delete_user_meta($user_id, 'city');
			}

			echo 'delete';
		}
	}

// Option page add

	add_action('init', 'custom_acf_options_page');
	function custom_acf_options_page()
	{
		if (function_exists('acf_add_options_page')) {

			acf_add_options_page(array(
				'page_title' => '????????????????',
				'menu_title' => '????????????????',
				'menu_slug' => 'site-general-contact',
				'icon_url' => 'dashicons-phone',
				'capability' => 'edit_posts',
				'redirect' => FALSE,
			));
		}
	}

// Adds ACF fields to Post List

	add_filter( 'manage_posts_columns', 'custom_posts_table_head', 10, 2 );
	function custom_posts_table_head( $post_columns, $post_type ) {
		if ( 'project' === $post_type ) {
			$post_columns['main_size'] = '????????????';
		}

		return $post_columns;
	}

	add_action( 'manage_project_posts_custom_column', 'bs_projects_table_content', 10, 2);
	function bs_projects_table_content( $column_name, $post_id ) {

	    if( $column_name == 'main_size' ) {
	        $size = get_field('main_size', $post_id)['label'];
					echo $size;
	    }
	}

// Add menu_order to the list of permitted orderby values (REST API)

	// add_filter( 'rest_post_collection_params', 'filter_add_rest_orderby_params', 10, 1 );
	add_filter( 'rest_project_collection_params', 'filter_add_rest_orderby_params', 10, 1 );
	function filter_add_rest_orderby_params( $params ) {
		$params['orderby']['enum'][] = 'menu_order';
		return $params;
	}

// Match & replace content pdf links

	add_filter('the_content', 'lnd_content_filter');
	function lnd_content_filter( $content ){
		$is_match = preg_match_all('/\<a.*pdf.*a\>/', $content, $matches, PREG_SET_ORDER);

		if ( $is_match > 0 ) {
			foreach ( $matches as $match ) {
				$replaced = str_replace( '<a', '<a class="doc_content"', $match );
				$content = str_replace( $match, $replaced, $content );
			}
		}
		return $content;
	}

// Redirect

	add_action( 'template_redirect', 'lnd_seo_template_redirect');
	function lnd_seo_template_redirect() {

		$uri = $_SERVER['REQUEST_URI'];

		if ($uri == "/ob-organizaczii/"){

			wp_redirect( '/ob-organizaczii/osnovnye-svedeniya/', 301 );
			exit;

		}
	}