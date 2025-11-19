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

$termid = get_queried_object()->term_id;
$termtitle = get_the_archive_title();
$description = get_the_archive_description();
$taxquery = array(
    array(
        'taxonomy' => 'learning_partner',
        'field' => 'slug',
        'terms' => sanitize_text_field(get_query_var('learning_partner')),
    )
);

$post_args = array(
    'post_type'                => 'course',
    'post_status'              => 'publish',
    'posts_per_page'           => -1,
    'ignore_sticky_posts'      => 0,
    'tax_query'                => $taxquery,
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

<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
        <div class="container-lg px-0 px-md-3 py-4 py-md-5">
            <h1 class="mb-0 text-white">Partner: <?= str_replace('Learning Partners:', '', $termtitle) ?></h1>
        </div>
    </div>
    <div class="bg-secondary-subtle">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">
            <h2>Offered by <?= str_replace('Learning Partners:', '', $termtitle) ?></h2>
            <?php
            $partners = get_categories(
                array(
                    'taxonomy' => 'learning_partner',
                    'orderby' => 'id',
                    'order' => 'ASC',
                    'hide_empty' => '1'
                )
            );
            ?>

            <div class="dropdown mb-3">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Select another partner
                </button>
                <ul class="dropdown-menu">
                    <?php foreach ($partners as $p) : ?>
                        <li>
                            <a class="dropdown-item" href="/learninghub/learning_partner/<?= $p->slug ?>">
                                <?= $p->name ?> (<?= $p->count ?>)
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-8">

                    <?php if ($post_my_query->have_posts()) : ?>
                        <div class="my-3 fw-semibold"><span class="badge fs-5 bg-gov-blue me-1"><?= $post_my_query->found_posts ?></span> found</div>
                        <?php while ($post_my_query->have_posts()) : $post_my_query->the_post(); ?>
                            <?php get_template_part('template-parts/course/single-course') ?>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>Oh no! There are no courses that match your filters.</p>
                        <?php //get_template_part( 'template-parts/content/content-none' ); 
                        ?>
                    <?php endif; ?>

                </div>
                <div class="col-md-4">

                    <?php get_template_part('template-parts/sidebar/taxonomies') ?>

                </div>
            </div>

        </div>

            <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
            <script>
                var courseoptions = {
                    valueNames: ['coursename', 'coursedesc', 'coursecats', 'coursekeys']
                };
                var courses = new List('courselist', courseoptions);
                document.getElementById('coursecount').innerHTML = courses.update().matchingItems.length;
                courses.on('searchComplete', function() {
                    //console.log(upcomingClasses.update().matchingItems.length);
                    //console.log(courses.update().matchingItems.length);
                    document.getElementById('coursecount').innerHTML = courses.update().matchingItems.length;
                });
            </script>

            <?php get_footer(); ?>
