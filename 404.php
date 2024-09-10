<?php

/**
 * The template for displaying 404 page not found
 *
 */

get_header();

?>
<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
        <div class="container-lg py-4 py-md-5">
            <h1 class="text-white title">Page not found</h1>
        </div>
    </div>
    <div class="bg-secondary-subtle">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">
            <p class="fs-4 mb-5">Sorry, we can't find that page.</p>
            <div style="max-width: 600px;">
                <?php get_template_part('template-parts/sidebar/taxonomies') ?>
            </div>
            <?php get_template_part('template-parts/needhelp') ?>
        </div>
    </div>
</div>
<?php

get_footer();
