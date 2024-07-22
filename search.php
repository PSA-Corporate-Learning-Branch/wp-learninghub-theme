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
<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
        <div class="container-lg py-4 py-md-5">
            <h1 class="text-white title">Keyword Search</h1>
        </div>
    </div>
    <div class="bg-secondary-subtle">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">
            <h2>Find learning using keyword search</h2>
            <p>If you already know what you're looking for, search by a keyword to quickly narrow down your search. </p>
            <div class="row mt-4">
                <div class="col-md-8">
                    <?php if (have_posts()) : ?>
                    <div id="courselist"> 
                    <div class="mb-3 p-3 card rounded">
                        <?php
                        $resultcount = (int) $wp_query->found_posts;
                        $plural = 'course';
                        if ($resultcount > 1) $plural = 'courses';
                        ?>
                        <div class="fw-bold mb-2" id="coursecount">
                            <h3 class="h4 fw-semibold">Your search for 
                                <?php
                                printf(
                                    /* translators: %s: Search term. */
                                    esc_html__('"%s"', 'twentytwentyone'),
                                    '<span class="fw-semibold">' . esc_html(get_search_query()) . '</span>'
                                );
                                ?> 
                                matched <span class="badge fs-5 bg-gov-blue mx-1"><?= $resultcount ?></span> 
                                <?= $plural ?>
                                </h3>
                        </div>
                        <div class="mb-3 d-flex">
                            <input class="form-control search" aria-label="Search" placeholder="Filter these results by keyword" value="<?php echo $_GET['new'] ?>">
                        </div>
                        <div class="d-flex">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> Sort by </button>
                                <div class="dropdown-menu bg-dark-subtle text-dark-emphasis">
                                    <li><a class="sort dropdown-item" data-sort="published" href="#">Most Recent</a></li>
                                    <li><a class="sort dropdown-item" data-sort="coursename" href="#">Alphabetical</a></li>
                                    <li><a class="sort dropdown-item" data-sort="dm" href="#">Delivery Method</a></li>
                                    <li><a class="sort dropdown-item" data-sort="group" href="#">Group</a></li>
                                    <li><a class="sort dropdown-item" data-sort="audience" href="#">Audience</a></li>
                                    <li><a class="sort dropdown-item" data-sort="topic" href="#">Topic</a></li>
                                </div>
                            </div>
                            <div class="mx-2">
                                <button id="expall" class="btn btn-sm btn-primary px-2 d-inline-block">Expand All</button>
                                <button id="collapseall" class="btn btn-sm btn-primary px-2 d-inline-block">Collapse All</button>
                            </div>
                        </div>
                    </div>

                    <div class="list">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/course/single-course') ?>
                    <?php endwhile; ?>
                    <?php else : ?>
                        <p>Oh no! There are no courses that match your search. Please try another keyword.</p>
                    <?php endif; ?>
                    </div> <!-- /.list -->
                </div> <!-- /#courselist -->
                </div>
                <div class="col-md-4" id="filters">

                    <?php get_template_part('template-parts/sidebar/taxonomies') ?>

                </div>
            </div>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script type="module">
    var options = {
        valueNames: ['published', 'coursename', 'group', 'audience', 'topic', 'dm']
    };
    var courseList = new List('courselist', options);
    courseList.on('searchComplete', function() {
        let ccount = document.getElementById('coursecount');
        let update = '<span class=\"badge fs-5 bg-gov-blue me-1\">' + courseList.update().matchingItems.length + '<\/span>' + ' courses found';
        ccount.innerHTML = update;
    });
    document.addEventListener("DOMContentLoaded", function() {
        courseList.update;
    });
</script>
<script type="module">
    // 
    // Details/Summary niceties
    //
    // By default, all the courses are hidden behind a details/summary
    // and subsequently the description/launch links are as well.
    // This supports allowing the learner to choose to "expand all" and 
    // show everything on the page all at once, or "collapse all" and 
    // hide everything. 
    //
    // Show everything all in once fell swoop.
    let expall = document.getElementById('expall');
    let steplist = document.getElementById('courselist');
    let deets = steplist.querySelectorAll('details');
    expall.addEventListener('click', (e) => {
        Array.from(deets).forEach(function(element) {
            element.setAttribute('open', 'open');
        });
    });
    // Conversley, "collapse all" hides everyting open in one fell swoop.
    let collapseall = document.getElementById('collapseall');
    collapseall.addEventListener('click', (e) => {
        Array.from(deets).forEach(function(element) {
            element.removeAttribute('open');
        });
    });
</script> 
<?php get_footer(); ?>