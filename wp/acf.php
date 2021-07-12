<!-- ACF -->

<?php // Image

$image = get_field('image');

if ( $image ) : ?>

	<a href="<?= $image['url']; ?>" title="<?= $image['title']; ?>">

		<img src="<?= $image['sizes']['thumbnail']; ?>" alt="<?= $image['alt']; ?>"?>">

		<?php if ( $image['caption'] ) : ?>

				<p><?= $image['caption'] ?></p>

		<?php endif; ?>

	</a>

<?php else : ?>

<img src="<?= get_template_directory_uri() . '/img/none.jpg' ?>" alt="Фото отсутствует">

<?php endif; // Image End ?>


<?php // Gallery First Image & None

$images = get_field( 'gallery' );

if ( $images ) : ?>
	
<img src="<?= $images[0]['sizes']['thumbnail']; ?>" alt="<?= $images[0]['alt'] ?>">

<?php else : ?>

<img src="<?= get_template_directory_uri() . '/img/none.jpg' ?>" alt="Фото отсутствует">

<?php endif; // Gallery First Image End ?>


<?php // Gallery

$images = get_field( 'gallery' );

if ( $images ) : ?>
	
<ul class="gallery">

	<?php foreach ( $images as $image ) : 

  $width = $image['width'];
  $height = $image['height'];
  $orientation = ( $width < $height ) ? 'portrait' : 'landscape'; ?>

	<li class="gallery--item gallery--item-<?= $orientation; ?>">
		<a href="<?= $image['url']; ?>">
			 <img src="<?= $image['sizes']['thumbnail']; ?>" alt="<?= $image['alt']; ?>">
		</a>
		<p><?= $image['caption']; ?></p>
	</li>

	<?php endforeach; ?>

</ul>

<?php endif; // Gallery End ?>


<?php // Repeater Loop

if ( have_rows( 'repeater_field_name' ) ) : ?>

<ul class="slides">

<?php while ( have_rows( 'repeater_field_name' ) ) : the_row(); 

	// vars
	$index = get_row_index();
	$image = get_sub_field('image');
	$content = get_sub_field('content');
	$link = get_sub_field('link');

	?>

	<li class="slide">

		<?php if ( $link ) : ?>
			<a href="<?= $link; ?>">
		<?php endif; ?>

			<img src="<?= $image['sizes']['large']; ?>" alt="<?= $image['alt'] ?>" title="<?= $image['title'] ?>">

		<?php if ( $link ) : ?>
			</a>
		<?php endif; ?>

			<?= $content; ?>

	</li>

<?php endwhile; ?>

</ul>

<?php endif; // Repeater Loop End ?>


<?php // Repeater Loop to Array

if ( have_rows('repeater_field_name') ) :

	$array = array();

	while( have_rows('repeater_field_name') ): the_row(); 

		// vars
		$value = get_sub_field( 'field' );
		// add
		array_push( $array, $value);

	endwhile;

endif; // Repeater Loop to Array End ?>


<?php  // Group (with Sub Object content)

if ( have_rows( 'group' ) ) : the_row();

$rows = get_row( true ); // format the value loaded from the db ?>

<ul>

<?php foreach ( $rows as $key => $row ) :

$sub_object = get_sub_field_object( $key ); 

$label = $sub_object['label'];
$value = $sub_object['value'];
echo $key; // sub field title

?>

	<li>
		<b><?= $label ?></b>
		<em><?= $value ?></em>
	</li>

<?php endforeach; ?>

</ul>
	
<?php endif; // Group End ?>


<?php // Group (with Repeaters)

// group
if ( have_rows('price-class') ) : the_row();

$rows = get_row( true ); 

$i = 0; ?>

<div>

	<?php $i = 0; // group loop

	foreach ( $rows as $key => $row ) :

	$i++;

	if ( have_rows( $key) ) : // repeater loop ?>

	<ul>

	<?php while ( have_rows( $key) ) : the_row();

	$title = get_sub_field('title'); ?>

		<li><?= $title; ?></li>

	<?php endwhile; ?>

	</ul>

<?php endif; // repeater loop end

endforeach; // group loop end ?>

</div>

<?php endif; // group end

// Group (with Repeaters) End ?>


<?php // Flexible content

if ( have_rows( 'page-content' ) ) : ?>

<section>

<?php // loop through the rows of data
while ( have_rows( 'page-content' ) ) : the_row();

if ( get_row_layout() == 'full-title' ) : ?>

	<h2><?php the_sub_field('title'); ?></h2>

<?php elseif ( get_row_layout() == 'full-content' ) : ?>

	<div><?php the_sub_field('content'); ?></div>

<?php elseif ( get_row_layout() == 'half-content' ) : ?>

	<div><?php the_sub_field('content'); ?></div>

<?php else : ?>

	<div>Страница в процессе наполнения</div>

<?php endif;

endwhile; ?>

</section>

<?php endif; // Flexible content end ?>


<?php // Single term

$term = get_field('term');

if ( $term ) :  

$image = get_field( 'image', $term ); ?>

	<img src="<?= $image['sizes']['thumbnail']; ?>" alt="<?= $image['alt']; ?>">

	<p><?= $term->name; ?></p>

<?php endif; // Single term end ?>


<?php // Table

$table = get_field( 'table_name' );

if ( $table ) : ?>

<div class="table">

	<?php foreach ( $table['body'] as $tr ) : ?>

	<div class="row">

		<?php foreach ( $tr as $td ) : ?>

			<div class="col"><?= $td['c']; ?></div>
			
		<?php endforeach; ?>

	</div>
		
	<?php endforeach; ?>

</div>
	
<?php endif; // Table End ?>


<?php // convert PHP 2 JSON

// get all the local field groups 
$field_groups = acf_get_local_field_groups();

// loop over each of the gield gruops 
foreach( $field_groups as $field_group ) {

	// get the field group key 
	$key = $field_group['key'];

	// if this field group has fields 
	if( acf_have_local_fields( $key ) ) {
	
      	// append the fields 
		$field_group['fields'] = acf_get_local_fields( $key );

	}

	// save the acf-json file to the acf-json dir by default 
	acf_write_json_field_group( $field_group );

}

// convert PHP 2 JSON end ?>	