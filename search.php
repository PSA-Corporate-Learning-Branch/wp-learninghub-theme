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
?>
<div class="bg-gov-green">
<div class="container">
<div class="row py-5 mb-3">
<div class="col-12">
	<h1 class="">Keyword Search</h1>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">

    <div class="col-md-8">
        <?php if (have_posts()) : ?>
            <div class="p-3 mb-3 bg-body-tertiary rounded-3">
                <?php
                $resultcount = (int) $wp_query->found_posts;
                $plural = 'course';
                if ($resultcount > 0) $plural = 'courses';
                ?>
                We found
                <span class="badge bg-body-secondary text-body-emphasis">
                    <?= $resultcount ?>
                </span>
                <?= $plural ?> which match your search for
                <?php
                printf(
                    /* translators: %s: Search term. */
                    esc_html__('"%s"', 'twentytwentyone'),
                    '<span class="page-description search-term">' . esc_html(get_search_query()) . '</span>'
                );
                ?>
            </div>
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/course/single-course') ?>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Oh no! There are no courses that match your filters.</p>
        <?php endif; ?>

    </div>
    <div class="col-md-4" id="filters">
    
    <?php get_template_part('template-parts/sidebar/taxonomies') ?>

    </div>
</div>


<?php get_footer(); ?>