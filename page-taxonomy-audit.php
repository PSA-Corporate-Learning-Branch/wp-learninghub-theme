<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$post_args = array(
    'post_type'                => 'course',
    'post_status'              => 'publish',
    'posts_per_page'           => -1,
    'ignore_sticky_posts'      => 0,
    'tax_query' 			   => array(
									'taxonomy' => 'topics',
									'terms' => '',
									'operator' => 'NOT EXISTS'
								),
    'orderby'                  => array(
									'date' =>'DESC',
									'menu_order'=>'ASC'
								), 
    'order'                    => 'ASC',
    'hide_empty'               => 1,
    'hierarchical'             => 1,
    'exclude'                  => '',
    'include'                  => '',
    'number'                   => '',
    'pad_counts'               => false, 
	//'s'						   => 'ethics'
);
$post_my_query = null;
$post_my_query = new WP_Query($post_args);

?>
<div class="bg-gov-green">
<div class="container">
<div class="row py-5 mb-3">
<div class="col-md-12">
	<h1>Taxonomy Audit</h1>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row justify-content-md-center">
<div class="col-md-8">
<?php $count = 0 ?>
<?php if( $post_my_query->have_posts() ) : ?>
<?php while ($post_my_query->have_posts()) : $post_my_query->the_post(); ?>

<div>
	<?php $count ++; echo $count; ?>
	<a href="<?= the_permalink() ?>"><?= the_title() ?></a>
</div>

<?php endwhile; ?>
<?php else : ?>

<p>Sorry, but there are no courses that match your filters.</p>

<?php endif; ?>


</div>
</div>
</div>
<?php 	

get_footer();
