<?php
/**
 * The main functions file
 *
 */

// Global constant vars

	define('MC_SITE_URL', get_bloginfo('url'));
	define('MC_TEMPLATE_URL', get_template_directory_uri());
	define('MC_TEMPLATE_DIR', get_template_directory());
	define('MC_IMAGE_URL', MC_TEMPLATE_URL . '/img');
	define('MC_VECTOR_URL', MC_TEMPLATE_URL . '/svg');

// WP AJAX debug (works only if "wp-debug" enabled)

	if( WP_DEBUG && WP_DEBUG_DISPLAY && (defined('DOING_AJAX') && DOING_AJAX) ){
		@ ini_set( 'display_errors', 1 );
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

// Remove type attribute from scripts & styles links

	add_action('after_setup_theme', function() {
		add_theme_support( 'html5', [ 'script', 'style' ] );
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
			'name'                  => 'Новости',
			'singular_name'         => 'Новость',
			'add_new'               => 'Добавить новость',
			'add_new_item'          => 'Добавить новость',
			'edit_item'             => 'Редактировать новость',
			'new_item'              => 'Новая новость',
			'view_item'             => 'Просмотреть новость',
			'search_items'          => 'Поиск новости',
			'not_found'             => 'Новостей не найдено.',
			'not_found_in_trash'    => 'Новостей в корзине не найдено.',
			'parent_item_colon'     => '',
			'all_items'             => 'Все новости',
			'archives'              => 'Архивы новостей',
			'insert_into_item'      => 'Вставить в новость',
			'uploaded_to_this_item' => 'Загруженные для этой новости',
			'featured_image'        => 'Миниатюра новости',
			'filter_items_list'     => 'Фильтровать список новостей',
			'items_list_navigation' => 'Навигация по списку новостей',
			'items_list'            => 'Список новостей',
			'menu_name'             => 'Новости',
			'name_admin_bar'        => 'Новость', // пункте "добавить"
		);

		return (object) array_merge( (array) $labels, $new );
	}

// Rename "Posts" in "Service"

	add_filter('post_type_labels_post', 'rename_posts_labels');
	function rename_posts_labels( $labels ){

		$new = array(
			'name'                  => 'Услуги',
			'singular_name'         => 'Услуга',
			'add_new'               => 'Добавить услугу',
			'add_new_item'          => 'Добавить услугу',
			'edit_item'             => 'Редактировать услугу',
			'new_item'              => 'Новая услуга',
			'view_item'             => 'Просмотреть услугу',
			'search_items'          => 'Поиск услуги',
			'not_found'             => 'Услуг не найдено.',
			'not_found_in_trash'    => 'Услуг в корзине не найдено.',
			'parent_item_colon'     => '',
			'all_items'             => 'Все услуги',
			'archives'              => 'Архивы услуг',
			'insert_into_item'      => 'Вставить в услугу',
			'uploaded_to_this_item' => 'Загруженные для этой услуги',
			'featured_image'        => 'Миниатюра услуги',
			'filter_items_list'     => 'Фильтровать список услуг',
			'items_list_navigation' => 'Навигация по списку услуг',
			'items_list'            => 'Список услуг',
			'menu_name'             => 'Услуги',
			'name_admin_bar'        => 'Услуга', // пункте "добавить"
		);

		return (object) array_merge( (array) $labels, $new );
	}

// Register custom post type

	add_action('init', 'register_post_types');
	function register_post_types(){

		register_post_type('project', array(
			'label'  => 'Проекты',
			'labels' => array(
				'name'               => 'Проекты', // основное название для типа записи
				'singular_name'      => 'Проект', // название для одной записи этого типа
				'add_new'            => 'Добавить проект', // для добавления новой записи
				'add_new_item'       => 'Добавление проекта', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактировать проект', // для редактирования типа записи
				'new_item'           => 'Новый проект', // текст новой записи
				'view_item'          => 'Просмотреть проект', // для просмотра записи этого типа.
				'search_items'       => 'Искать проект', // для поиска по этим типам записи
				'all_items'          => 'Все проекты',
				'not_found'          => 'Проектов найдено', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Проектов в корзине не найдено', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Проекты', // название меню
			),
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => null, // зависит от public
			'exclude_from_search' => null, // зависит от public
			'show_ui'             => null, // зависит от public
			'show_in_menu'        => null, // показывать ли в меню адмнки
			'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
			'show_in_nav_menus'   => null, // зависит от public
			'show_in_rest'        => null, // добавить в REST API. C WP 4.7
			'rest_base'           => null, // $post_type. C WP 4.7
			'menu_position'       => 7,
			'menu_icon'           => 'dashicons-thumbs-up', 
			//'capability_type'   => 'post',
			//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
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
			'label'                 => '', // определяется параметром $labels->name
			'labels'                => array(
				'name'              => 'Категории',
				'singular_name'     => 'Категория',
				'search_items'      => 'Искать категории',
				'all_items'         => 'Все категории',
				'not_found'         => 'Проектов не найдено',
				'view_item'         => 'Просмотреть категорию',
				'parent_item'       => 'Родительская категория',
				'parent_item_colon' => 'Родительская категория:',
				'edit_item'         => 'Редактировать категорию',
				'update_item'       => 'Обновить категорию',
				'add_new_item'      => 'Добавить новую категорию',
				'new_item_name'     => 'Имя новой категории',
				'menu_name'         => 'Категории',
				'choose_from_most_used' => 'Выбрать из часто используемых категорий', // Не используется для древовидных типов.
				'back_to_items'			=> '← Назад ко всем',
			),
			'description'           => '', // описание таксономии
			'public'                => true,
			'publicly_queryable'    => null, // равен аргументу public
			'show_in_nav_menus'     => true, // равен аргументу public
			'show_ui'               => true, // равен аргументу public
			'show_in_menu'          => true, // равен аргументу show_ui
			'show_tagcloud'         => true, // равен аргументу show_ui
			'show_in_rest'          => null, // добавить в REST API
			'rest_base'             => null, // $taxonomy
			'hierarchical'          => true,
			'update_count_callback' => '',
			'rewrite'               => true,
			//'query_var'             => $taxonomy, // название параметра запроса
			'capabilities'          => array(),
			'meta_box_cb'           => null, // callback функция. Отвечает за html код метабокса (с версии 3.8): post_categories_meta_box или post_tags_meta_box. Если указать false, то метабокс будет отключен вообще
			'show_admin_column'     => true, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)
			'_builtin'              => false,
			'show_in_quick_edit'    => null, // по умолчанию значение show_ui
		) );
		// список параметров: http://wp-kama.ru/function/get_taxonomy_labels
	}

// Register actual jQuery

	add_action( 'wp_enqueue_scripts', 'jQuery_scripts', 1 );
	function jQuery_scripts() {
		// Отменяем зарегистрированный jQuery
		// Вместо "jquery-core", можно вписать "jquery", тогда будет отменен еще и jquery-migrate
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

// Post thumbnails

	add_theme_support( 'post-thumbnails', array( 'post' ) );

// Theme menu

	add_theme_support( 'menus' );

// Регистрируем боковые панели
	function sidebar_init() {
		register_sidebar( array(
			'name'          => 'Боковая панель 1',
			'id'            => 'sidebar-1',
			'description'   => 'На странице новости',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<div class="widget--title">',
			'after_title'   => '</div>',
		) );
	}
	add_action( 'widgets_init', 'sidebar_init' );

	function sidebar_init_2() {
		register_sidebar( array(
			'name'          => 'Боковая панель 2',
			'id'            => 'sidebar-2',
			'description'   => 'На странице записей и категорий',
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

// Отключаем обновление для некоторых плагинов.
	function filter_plugin_updates( $value ) {
	    unset( $value->response['advanced-custom-fields-pro-master/acf.php'] );
	    return $value;
	}
	add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );

// Удалим "Рубрика: ", "Метка: " и т.д. из заголовка архива
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
	            'text' => 'Каталог',
	        );
	        array_splice( $links, 1, -2, $breadcrumb );
	    }
	    return $links;
	};

// Fill alt attribute by image title
	add_filter( 'wp_prepare_attachment_for_js', 'change_empty_alt_to_title' );
	function change_empty_alt_to_title( $response ) {
		if ( ! $response['alt'] ) {
			$response['alt'] = sanitize_text_field( $response['title'] );
		}

		return $response;
	}

// Уберём метабокс Ninja Forms
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
				'page_title' => 'Контакты',
				'menu_title' => 'Контакты',
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
			$post_columns['main_size'] = 'Размер';
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
