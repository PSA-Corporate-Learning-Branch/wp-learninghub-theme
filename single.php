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

/* Start the Loop */
while (have_posts()) :
    the_post();

?>

    <div id="content">
        <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
            <div class="container-lg py-4 py-md-5">
                <h1 class="text-white title"><?php the_title() ?></h1>
                <h2 class="text-white title">Recent News</h2>
            </div>
        </div>

        <div class="bg-secondary-subtle">
            <div class="container-lg p-lg-5 p-4 bg-light-subtle">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <div class="entry-content">
                        <?php //the_post_thumbnail('large') ?>
                        <?php the_content() ?>
                    </div><!-- .entry-content -->

                </article><!-- #post-<?php the_ID(); ?> -->
            </div>
        </div>
    </div>
<?php
endwhile; // End of the loop.

get_footer();
