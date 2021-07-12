<?php // Post Loop

			// numberposts (число)
			// offset (число)
			// category (строка/число)
			// category_name (строка)
			// tag (строка)
			// include (строка/число/массив)
			// exclude (строка/число)
			// meta_key и meta_value (строка)
			// meta_query (массив)
			// date_query (массив)
			// post_type (строка/массив)
			// post_mime_type (строка/массив)
			// post_status (строка)
			// post_parent (число)
			// nopaging (логический)
			// orderby (строка)
			// order (строка)
			// suppress_filters (логический)

$posts = get_posts( array(
	'numberposts' => -1, 
	'post_type' => 'post'
) );

if ( $posts ) : ?>

<div class="list">

<?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>

	<div class="item"><?php the_title(); ?></div>

<?php endforeach; wp_reset_postdata(); ?>

</div>

<?php endif; // Post Loop End ?>


<?php // Posts Loop (with pagination)

$post_type = get_post_type(); // Получим тип архива

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; // Получим текущий номер страницы пагинации

// Зададим параметры вывода
$args = array(
	'post_type' => $post_type,
	'posts_per_page' => 10,
	'paged' => $paged
);

query_posts( $args ); ?>

<?php if ( have_posts() ) : 

	$i = 0; ?>

	<div class="catalog">

	<?php while ( have_posts() ) : // Loop Start

		$i++;
		
		the_post();

		$post_type = get_post_type();

		$id = get_the_ID(); ?>

		<div class="item"><?php the_title(); ?></div>

	<?php endwhile; // Loop End ?>

	</div>

	<? // Pagination
	$args = array(
		'show_all'     => false, // показаны все страницы участвующие в пагинации
		'end_size'     => 1,     // количество страниц на концах
		'mid_size'     => 1,     // количество страниц вокруг текущей
		'prev_next'    => false,  // выводить ли боковые ссылки "предыдущая/следующая страница".
		// 'prev_text'    => __('« Previous'),
		// 'next_text'    => __('Next »'),
		'add_args'     => false, // Массив аргументов (переменных запроса), которые нужно добавить к ссылкам.
		'add_fragment' => '',     // Текст который добавиться ко всем ссылкам.
		'screen_reader_text' => __( 'Posts navigation' ),
	);

	$pages = get_the_posts_pagination( $args );

	if ( $pages) :

		echo $pages;
		
	endif; // Pagination End ?>

<?php else : ?>

	<div class="not_found">Не найдено</div>

<?php endif; wp_reset_query(); // Posts Loop End ?>


<?php // Category Loop

			// 'type'         => 'post',
			// 'child_of'     => 0,
			// 'parent'       => '',
			// 'orderby'      => 'name',
			// 'order'        => 'ASC',
			// 'hide_empty'   => 1,
			// 'hierarchical' => 1,
			// 'exclude'      => '',
			// 'include'      => '',
			// 'number'       => 0,
			// 'taxonomy'     => 'category',
			// 'pad_counts'   => false,
			// полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms

$categories = get_categories( array(
	'type'         => 'post',
	'taxonomy'     => 'category',
	'hide_empty'   => 1
	// полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
) );

if ( $categories ) : ?>

	<ul class="list">

		<?php foreach ( $categories as $cat ) : ?>

			<li class="item">
				<a href="<?= get_category_link( $cat ); ?>" class="link"><?= $cat->name; ?></a>
			</li>

			<?php // Данные в объекте $cat
			// $cat->term_id
			// $cat->name (Рубрика 1)
			// $cat->slug (rubrika-1)
			// $cat->term_group (0)
			// $cat->term_taxonomy_id (4)
			// $cat->taxonomy (category)
			// $cat->description (Текст описания)
			// $cat->parent (0)
			// $cat->count (14)
			// $cat->object_id (2743)
			// $cat->cat_ID (4)
			// $cat->category_count (14)
			// $cat->category_description (Текст описания)
			// $cat->cat_name (Рубрика 1)
			// $cat->category_nicename (rubrika-1)
			// $cat->category_parent (0) ?>

		<?php endforeach; ?>

	</ul>

<?php endif; // Category Loop End?>


<?php // Menu Item Loop;

if ( $menu_items = wp_get_nav_menu_items('Main menu') ) : ?>

<nav class="main_menu">
	<ul class="main_menu--list">

	<?php foreach ( $menu_items as $menu_item ) :

	$title = $menu_item->title; // Заголовок элемента меню (анкор ссылки)
	$url = $menu_item->url; // URL ссылки
	$target = ( $menu_item->target ) ? 'target="' . $menu_item->target . '"' : '' ; // Цель ссылки c аттрибутом
	$active = ( $menu_item->object_id == get_queried_object_id() ) ? 'active' : '';

	?>

		<li class="main_menu--item">
			<a class="main_menu--link <?= $active ?>" href="<?= $url ?>" <?= $target ?>><?= $title ?></a>
		</li>

	<?php endforeach; ?>

	</ul>
</nav>

<?php endif; // Menu Item Loop End ?>


<?php // 3 Level Menu Loop

global $post;
$post_ID = $post->ID;

function wp_get_menu_array( $current_menu ) {

	$array_menus = wp_get_nav_menu_items($current_menu);
	$menu = array();

	foreach ($array_menus as $array_menu) {
		if (empty($array_menu->menu_item_parent)){
			$current_id = $array_menu->ID;
			$menu[$current_id] = array(
				'id'         =>   $current_id,
				'title'      =>   $array_menu->title,
				'class'      =>   $array_menu->classes[0],
				'href'       =>   $array_menu->url,
				'children'   =>   array(),
				'object_id'  => 	$array_menu->object_id 
			);
		}

		if (isset($current_id) && $current_id == $array_menu->menu_item_parent) {
			$submenu_id = $array_menu->ID;
			$menu[$current_id]['children'][$array_menu->ID] = array(
				'id'         =>   $submenu_id,
				'title'      =>   $array_menu->title,
				'class'      =>   $array_menu->classes[0],
				'href'       =>   $array_menu->url,
				'children'   =>   array(),
				'object_id'  => 	$array_menu->object_id
			);
		}

		if (isset($submenu_id) && $submenu_id == $array_menu->menu_item_parent) {
			$menu[$current_id]['children'][$submenu_id]['children'][$array_menu->ID] = array(
				'id'         =>   $array_menu->ID,
				'title'      =>   $array_menu->title,
				'class'      =>   $array_menu->classes[0],
				'href'       =>   $array_menu->url,
				'object_id'  => 	$array_menu->object_id
			);
		}
	}

	return $menu;   
}
	
$menus = wp_get_menu_array( 'Главное меню' );

if ( $menus ) : ?>
<nav class="nav">
	<ul class="nav--list">
		<?php foreach ( $menus as $menu ) : ?>
		<li class="nav--item">
			<a href="<?= $menu['href']; ?>" class="nav--link <?php if ( $post_ID == $menu['object_id'] ) echo 'active' ?>">
				<?= $menu['title']; ?>
			</a>
			<?php if ( $menu['children'] ) : ?>
			<ul class="nav--sublist">
				<?php foreach ( $menu['children'] as $children ) : ?>
				<li class="nav--subitem">
					<a href="<?= $children['href']; ?>" class="nav--sublink <?php if ( $post_ID == $children['object_id'] ) echo 'active' ?>">
						<?= $children['title']; ?>
					</a>
					<?php if ( $children['children'] ) : ?>
					<ul class="nav--thirdlist">
						<li class="nav--thirditem">
							<?php foreach ( $children['children'] as $sub_children ) : ?>
							<a href="<?= $sub_children['href']; ?>" class="nav--thirdlink <?php if ( $post_ID == $sub_children['object_id'] ) echo 'active' ?>">
								<?= $sub_children['title']; ?>
							</a>
							<?php endforeach; ?>
						</li>
					</ul>
					<?php endif; ?>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
	</ul>
</nav>
<?php endif; // 3 Level Menu Loop End ?>


<?php // Get terms loop

$terms = get_the_terms( $post->id, 'category' );

if ( $terms ) : 

	foreach ($terms as $term): ?>		

<h2><?= $term->name; ?></h2>
<p><?php the_field( 'field', $term ); // if acf ?> ?></p>

	<?php endforeach;

endif;  // Get terms loop end ?>


<?php // Post in Category loop

$categories = get_categories( array(
  'type'         => 'post',
  'taxonomy'     => 'category',
  'hide_empty'   => 1
) );

if ( $categories ) : 

    $current_cat = get_the_category();
    $current_post_id = ( !is_home() ) ? get_the_ID() : 0;

    foreach ( $categories as $cat ) : ?>

      <div>
        <a class="<?php if ( $cat->slug === $current_cat[0]->slug && !is_home() ) echo 'current'; ?>" href="<?= get_category_link( $cat ); ?>"><?= $cat->name; ?></a>

        <?php // Post Loop

        $posts = get_posts( array(
          'numberposts' => -1, 
          'post_type' => 'post',
          'category' => $cat->term_id
        ) );

        if ( $posts ) : ?>

        <ul>

        <?php foreach ( $posts as $post ) :

          setup_postdata( $post ); ?>

          <li>
            <a class="<?php if ( $post->ID === $current_post_id ) echo 'current'; ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          </li>

        <?php endforeach; wp_reset_postdata(); ?>

        </ul>

        <?php endif; // Post Loop End ?>

      </div>

    <?php endforeach;
endif; // Category Loop End ?>
