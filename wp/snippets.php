<?php // Get phone number from ACF & clean for the link

$phone_number = get_field( 'tel', 33 );
$clean_number = str_replace( array(' ', '-', '(', ')'), '', $phone_number );
?>

<a href="tel:<?php echo $clean_number ?>" class="header-menu-tel-link"><?php echo $phone_number ?></a>

<?php // Clean tel func() 

function lnd_clean_tel( $tel )
{
	$tel = str_replace( array(' ', '-', '(', ')'), '', $tel );
	return $tel;
}

?>

<?php // Concat array to string

$array = array('lastname', 'email', 'phone');
$comma_separated = implode(",", $array);

echo $comma_separated; // lastname,email,phone

?>

<?php // Get thumbnail
$thumb = get_the_post_thumbnail( $post->id, 'medium', 'class=news_item--img' );

if ( $thumb ) { 

	// Return
	echo $thumb;

} else {

	// If haven'n, return spash pic
	echo '<img class="news_item--img" src="' . get_template_directory_uri() . '/img/none.jpg;" alt="Фото отсутствует">';	
} ?>

<?php // Get thumbnail url, if it is empty, than return spash pic url
		$thumb_url = ( get_the_post_thumbnail_url() ) ? get_the_post_thumbnail_url( $post, 'medium' ) : get_template_directory_uri() . '/img/photo-none.png';
?>

<?php // // Get post type title
$post_type = get_post_type_object( get_post_type($post) );
echo $post_type->label;
?>

<?php // Get post custom taxonomy 
$cat = get_the_terms( $post, 'taxonomy' );
echo $cat[0]->slug;
?>

<?php // Dimension units function
	function square_dim( $value )
	{
		$i = substr( $value, -1 );

		if ( $i == 1 ) {
			$dim = 'сотка';
		} elseif ( $i > 1 && $i < 5 ) {
			$dim = 'сотки';
		} else {
			$dim = 'соток';
		};

		return $value . ' ' . $dim;
	} 
?>

<?php // String with , to float
$value_int = floatval( str_replace(',', '.', $value) ); 
?>