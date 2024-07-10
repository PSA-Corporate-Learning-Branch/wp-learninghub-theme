<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$termtitle = get_the_archive_title();
$description = get_the_archive_description();
$taxquery = array(
	array (
		'taxonomy' => 'external_system',
		'field' => 'slug',
		'terms' => sanitize_text_field(get_query_var('external_system')),
	)
);

$post_args = array(
    'post_type'                => 'course',
    'post_status'              => 'publish',
    'posts_per_page'           => -1,
    'ignore_sticky_posts'      => 0,
    'tax_query' 			   => $taxquery,
    'orderby'                  => 'name', 
    'order'                    => 'ASC',
    'hide_empty'               => 0,
    'hierarchical'             => 1,
    'exclude'                  => '',
    'include'                  => '',
    'number'                   => '',
    'pad_counts'               => true, 
);
$post_my_query = null;
$post_my_query = new WP_Query($post_args);

?>

<div class="bg-gov-green">
<div class="container">
<div class="row py-5 mb-3">
<div class="col-12">

    <h1 class=""><?= str_replace('System:','Platform:',$termtitle) ?></h1>
	<?php 
	$platforms = get_categories(
							array(
								'taxonomy' => 'external_system',
								'orderby' => 'id',
								'order' => 'DESC',
								'hide_empty' => '1'
							));
	?>
	
	<div class="dropdown">
	<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
		Platforms
	</button>
	<ul class="dropdown-menu">
		<?php foreach($platforms as $p): ?>
		<li>
			<a class="dropdown-item" href="/learninghub/external_system/<?= $p->slug ?>">
				<?= $p->name ?> (<?= $p->count ?>)
			</a>
		</li>
		<?php endforeach ?>
	</ul>
	</div>

</div>
</div>
</div>
</div>

<div class="container">
	<div class="row">
	<div class="col-md-8">
	
	
	<?php if( $post_my_query->have_posts() ) : ?>
		<div class="mb-2"><strong><?= $post_my_query->found_posts ?> courses on this platform.</strong></div>
	<?php while ($post_my_query->have_posts()) : $post_my_query->the_post(); ?>
		<?php get_template_part( 'template-parts/course/single-course' ) ?>
	<?php endwhile; ?>
	<?php else : ?>
		<p>Oh no! There are no courses that match your filters.</p>
	<?php //get_template_part( 'template-parts/content/content-none' ); ?>
	<?php endif; ?>

	</div>
<div class="col-md-4">
	
<?php get_template_part('template-parts/sidebar/taxonomies') ?>

	</div>
	</div>



<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script>

var courseoptions = {
    valueNames: [ 'coursename', 'coursedesc', 'coursecats', 'coursekeys' ]
};
var courses = new List('courselist', courseoptions);
document.getElementById('coursecount').innerHTML = courses.update().matchingItems.length;
courses.on('searchComplete', function(){
    //console.log(upcomingClasses.update().matchingItems.length);
    //console.log(courses.update().matchingItems.length);
    document.getElementById('coursecount').innerHTML = courses.update().matchingItems.length;
});

</script>

<?php get_footer(); ?>
