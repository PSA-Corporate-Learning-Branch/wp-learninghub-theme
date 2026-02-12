<?php
//
// This is the main filter interface for the LearningHUB.
//
// WP_Query takes a "taxquery" an array argument that allows you to query by 
// taxonomy. Let's start building that array.
$taxquery = [];
// We go through each of the 3 taxonomies that we want to filter on:
// topic, audience, and delivery method
// If the array exists...

if (!empty($_GET['topic'])) {
    $topicterm = $_GET['topic'];
    $t = array(
        'taxonomy' => 'topics',
        'field' => 'slug',
        'terms' => $topicterm,
    );
    array_push($taxquery, $t);
    // Now we need to look up the names of the terms from the slugs
    // so that we can show them back to the user in the "remove filter"
    // area.
    $tterms = [];
    // Loop through each of the slugs
    foreach ($_GET['topic'] as $t) {
        // Look up the term object for the slug
        $tterm = get_term_by('slug', $t, 'topics');
        // add the result to the array that we can now loop through below.
        array_push($tterms, $tterm);
    }
}


if (!empty($_GET['audience'])) {
    $audienceterm = $_GET['audience'];
    $a = array(
        'taxonomy' => 'audience',
        'field' => 'slug',
        'terms' => $audienceterm,
    );
    array_push($taxquery, $a);
    // Now we need to look up the names of the terms from the slugs
    // so that we can show them back to the user in the "remove filter"
    // area.
    $aterms = [];
    // Loop through each of the slugs
    foreach ($_GET['audience'] as $a) {
        // Look up the term object for the slug
        $aterm = get_term_by('slug', $a, 'audience');
        // add the result to the array that we can now loop through below.
        array_push($aterms, $aterm);
    }
}

if (!empty($_GET['delivery_method'])) {
    $dmterm = $_GET['delivery_method'];

    $dm = array(
        'taxonomy' => 'delivery_method',
        'field' => 'slug',
        'terms' => $dmterm,
    );
    array_push($taxquery, $dm);
    // Now we need to look up the names of the terms from the slugs
    // so that we can show them back to the user in the "remove filter"
    // area.
    $dterms = [];
    // Loop through each of the slugs
    foreach ($_GET['delivery_method'] as $d) {
        // Look up the term object for the slug
        $dterm = get_term_by('slug', $d, 'delivery_method');
        // add the result to the array that we can now loop through below.
        array_push($dterms, $dterm);
    }
}

$kw = '';
if (!empty($_GET['keyword'])) {
    $kw = sanitize_text_field($_GET['keyword']);
}

/**
 * This is the main Wordpress query that we pass our $taxquery to.
 * 
 * Note that we're not passing the keyword term to the 's' search variable
 * for WP_Query because this makes the query bypass the modifications
 * we've made altering the search query so that it includes taxonomies in the
 * search results. For example, a default search for "ethics" will only return
 * 3 courses that mention "ethics" in the title or the description, but with 
 * the modification, it returns 5 *more* courses that don't mention "ethics"
 * anywhere but in the topic. 
 * 
 * Because I consider this feature basically indispensible we're going to 
 * ignore keyword search in the database query entirely; instead, we load all 
 * of the courses onto the page regardless of the search term and use list.js 
 * to filter the list on the page after the page loads. 
 * 
 * List.js results match or exceed the results from doing a query
 * at the database level. Until I can figure out how to make WP_Query search 
 * into taxonomies, it's going to have to stay like this. I've written a bunch
 * of javascript to make the UI nicer but that also further increases the 
 * dependence of the UI on Javascript. I've included some prototype <noscript>
 * support to add a fallback link to the default Wordpress search $_GET['s'].
 */

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
    'update_post_meta_cache'   => false,
    'update_post_term_cache'   => false,
    // 's'						   => $_GET['search'] // wish that we could!
);
$post_my_query = null;
$post_my_query = new WP_Query($post_args);

get_header();
?>

<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
        <div class="container-lg px-0 px-md-3 py-4 py-md-5">
            <h1 class="mb-0 text-white">Course Catalogue</h1>
        </div>
    </div>
    <div class="bg-secondary-subtle">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">
            <h2>Find exactly what you're looking for</h2>
            <p>The LearningHUB offers two main ways to find corporate learning. You can use filters or search (or both!) to get as specific as you like.</p>
            <p class="mb-lg-4"><strong>Not sure where to start?</strong> Check out <a href="/learninghub/foundational-corporate-learning/">Mandatory and Foundational learning</a> for all employees and people leaders.</p>


            <div id="courselist">
                <div class="row">
                    <div class="col-lg-5 mb-4 mb-lg-0 h-100" id="filters">
                        <div class="mb-3 p-3 card topic-card rounded">
                            <h3 class="h4">Search using a keyword</h3>
                            <p class="fs-6">Find courses that use a specific keyword or phrase in their title or description.</p>
                            <?php if (!empty($kw)): ?>
                                <noscript>
                                    <div class="alert alert-primary">
                                        <div><a href="/learninghub/?s=<?= $kw ?>">Try again please.</a></div>
                                    </div>
                                </noscript>
                            <?php endif ?>
                            <input id="searchfilter" class="form-control search" aria-label="Search" placeholder="Search catalogue by keyword" value="<?php echo $_GET['keyword'] ?>">
                        </div>
                        <h3 class="h4 mt-4">Find learning using filters</h3>
                        <p class="fs-6 mb-0">Three <a href="/learninghub/categories/">types of categorization</a> help you find exactly what you're looking for: audience, topic and delivery.</p>
                        <div class="mb-3">
                            <div class="row">
                                <?php
                                // Grab the current URL
                                $url = $_SERVER['REQUEST_URI'];
                                $currenturl = urldecode($url);
                                ?>
                                <?php if (!empty($kw)) : ?>
                                    <div id="nokey" class="col-md-auto mb-2">
                                        <div>Keyword</div>
                                        <?php
                                        $kwurl = $currenturl;
                                        $replace = 'keyword=' . $kw . '';
                                        $keyurl = str_replace($replace, '', $kwurl);
                                        $keyurl = str_replace('&&', '&', $keyurl);
                                        ?>
                                        <div aria-label="remove filter: <?= $kw ?>" class="badge bg-dark-subtle border-0 fw-normal">
                                            <a id="keywordfilter" href="<?= $keyurl ?>" class="text-secondary-emphasis text-decoration-none"> <span><?= $kw ?></span> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1" viewBox="0 0 16 16">
                                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                </svg></a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div id="nokey" class="col-md-auto mb-2 d-none">
                                        <div>Keyword</div>
                                        <div aria-label="remove filter: " class="badge bg-dark-subtle border-0 fw-normal">
                                            <a id="keywordfilter" href="<?= $currenturl ?>" class="text-secondary-emphasis text-decoration-none"> <span></span> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1" viewBox="0 0 16 16">
                                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                </svg></a>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <?php if (!empty($_GET['topic']) || !empty($_GET['audience']) || !empty($_GET['delivery_method'])) : ?>
                                    <?php if (!empty($tterms)) : ?>
                                        <div class="col-md-auto mb-2">
                                            <div>Topic</div>
                                            <?php foreach ($tterms as $t) : ?>
                                                <?php
                                                $topurl = $currenturl;
                                                $replace = 'topic[]=' . $t->slug . '';
                                                $turl = str_replace($replace, '', $topurl);
                                                $turl = str_replace('&&', '&', $turl);
                                                ?>
                                                <div aria-label="remove filter: <?= $t->name ?>" class="badge bg-dark-subtle fw-normal d-inline-flex mb-1">
                                                    <a href="<?= $turl ?>" class="text-secondary-emphasis text-decoration-none"> <?= $t->name ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1 align-text-bottom" viewBox="0 0 16 16">
                                                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                        </svg></a>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endif ?>
                                    <?php if (!empty($aterms)) : ?>
                                        <div class="col-md-auto mb-2">
                                            <div>Audience</div>
                                            <?php foreach ($aterms as $a) : ?>
                                                <?php
                                                $audurl = $currenturl;
                                                $replace = 'audience[]=' . $a->slug . '';
                                                $aurl = str_replace($replace, '', $audurl);
                                                $aurl = str_replace('&&', '&', $aurl);
                                                ?>
                                                <div aria-label="remove filter: <?= $a->name ?>" class="badge bg-dark-subtle fw-normal d-inline-flex mb-1">
                                                    <a href="<?= $aurl ?>" class="text-secondary-emphasis text-decoration-none"> <?= $a->name ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1 align-text-bottom" viewBox="0 0 16 16">
                                                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                        </svg></a>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endif ?>
                                    <?php if (!empty($dterms)) : ?>
                                        <div class="col-md-auto">
                                            <div>Delivery Method</div>
                                            <?php foreach ($dterms as $d) : ?>
                                                <?php
                                                $dmurl = $currenturl;
                                                $replace = 'delivery_method[]=' . $d->slug . '';
                                                $durl = str_replace($replace, '', $dmurl);
                                                $durl = str_replace('&&', '&', $durl);
                                                ?>
                                                <div aria-label="remove filter: <?= $d->name ?>" class="badge bg-dark-subtle fw-normal d-inline-flex mb-1">
                                                    <a href="<?= $durl ?>" class="text-secondary-emphasis text-decoration-none"> <?= $d->name ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1 align-text-bottom" viewBox="0 0 16 16">
                                                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                        </svg></a>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endif ?>

                                    <div class="mt-1">
                                        <a class="btn btn-sm btn-secondary" href="/learninghub/filter/">Clear All</a>
                                    </div>


                                <?php endif ?>

                            </div>
                        </div>
                        <style>
                            /* We hide the form submit button for taxonomy filters by default, 
                        but the noscript below will show it if there's no JS. 
                        #gracefuldegradation */
                            .applybutton {
                                display: none;
                            }
                        </style>
                        <noscript>
                            <style>
                                .applybutton {
                                    display: block;
                                }
                            </style>
                        </noscript>

                        <div class="accordion" id="filterCategories">
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="topicsHeading">
                                    <button class="accordion-button text-bg-primary  py-2 px-3 py-lg-3 collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseTopics" aria-expanded="false" aria-controls="collapseTopics">
                                        <div class="d-flex flex-column align-items-start">
                                            <span class="fw-semibold">Topic</span>
                                            <span class="fs-6"><small>What is the learning about?</small></span>
                                        </div>
                                    </button>
                                </h4>
                                <div id="collapseTopics" class="accordion-collapse collapse" aria-labelledby="topicsHeading">
                                    <div class="accordion-body bg-light-subtle p-3">
                                        <form action="/learninghub/filter" method="GET">
                                            <input class="hiddenkeywords" type="hidden" name="keyword" value="<?= $kw ?>">
                                            <?php if (!empty($_GET['audience'])) : ?>
                                                <?php foreach ($_GET['audience'] as $aid) : ?>
                                                    <input type="hidden" name="audience[]" value="<?= $aid ?>">
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <?php if (!empty($_GET['delivery_method'])) : ?>
                                                <?php foreach ($_GET['delivery_method'] as $did) : ?>
                                                    <input type="hidden" name="delivery_method[]" value="<?= $did ?>">
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <?php
                                            $topics = get_categories(
                                                array(
                                                    'taxonomy' => 'topics',
                                                    'orderby' => 'name',
                                                    'order' => 'ASC',
                                                    'hide_empty' => '0'
                                                )
                                            );
                                            ?>
                                            <?php foreach ($topics as $t) : ?>
                                                <?php $active = '' ?>
                                                <?php if (!empty($_GET['topic']) && in_array($t->slug, $_GET['topic'])) $active = 'checked' ?>
                                                <?php $desc = 'No description set';
                                                if (!empty($t->description)) $desc = $t->description; ?>
                                                <div class="form-check fs-6">
                                                    <input class="form-check-input" onchange="this.form.submit()" type="checkbox" value="<?= $t->slug ?>" name="topic[]" id="topic<?= $t->term_id ?>" <?= $active ?>>
                                                    <label for="topic<?= $t->term_id ?>" class="<?php if ($active == 'checked') echo 'fw-semibold' ?>"> <?= $t->name ?> <!--(<?= $t->count ?>)--> </label>
                                                    <a
                                                        aria-label="<?= $t->name ?>"
                                                        tabindex="0"
                                                        class=""
                                                        role="button"
                                                        data-bs-toggle="popover"
                                                        data-bs-trigger="focus"
                                                        data-bs-title="Topic Description"
                                                        data-bs-content="<?= $desc ?>">

                                                        <span class="icon-svg baseline-svg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                <path fill="#999" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                            </svg>
                                                        </span>

                                                    </a>

                                                </div>
                                            <?php endforeach ?>
                                            <button class="btn btn-sm bg-gov-green mt-2 applybutton">Apply</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="audienceHeading">
                                    <button class="accordion-button text-bg-primary  py-2 px-3 py-lg-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAudience" aria-expanded="false" aria-controls="collapseAudience">
                                        <div class="d-flex flex-column align-items-start">
                                            <span class="fw-semibold">Audience</span>
                                            <span class="fs-6"><small>Who is the learning for?</small></span>
                                        </div>
                                    </button>
                                </h4>
                                <div id="collapseAudience" class="accordion-collapse collapse" aria-labelledby="audienceHeading">
                                    <div class="accordion-body bg-light-subtle p-3">
                                        <form action="/learninghub/filter" method="GET">
                                            <input class="hiddenkeywords" type="hidden" name="keyword" value="<?= $kw ?>">
                                            <?php if (!empty($_GET['topic'])) : ?>
                                                <?php foreach ($_GET['topic'] as $tid) : ?>
                                                    <input type="hidden" name="topic[]" value="<?= $tid ?>">
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <?php if (!empty($_GET['delivery_method'])) : ?>
                                                <?php foreach ($_GET['delivery_method'] as $did) : ?>
                                                    <input type="hidden" name="delivery_method[]" value="<?= $did ?>">
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <?php
                                            $audiences = get_categories(
                                                array(
                                                    'taxonomy' => 'audience',
                                                    'orderby' => 'id',
                                                    'order' => 'ASC',
                                                    'hide_empty' => '0'
                                                )
                                            );
                                            ?>
                                            <?php foreach ($audiences as $a) : ?>
                                                <?php $active = '' ?>
                                                <?php $desc = 'No description set';
                                                if (!empty($a->description)) $desc = $a->description; ?>
                                                <?php if (!empty($_GET['audience']) && in_array($a->slug, $_GET['audience'])) $active = 'checked' ?>
                                                <div class="form-check fs-6">
                                                    <input class="form-check-input" onchange="this.form.submit()" type="checkbox" value="<?= $a->slug ?>" name="audience[]" id="audience<?= $a->term_id ?>" <?= $active ?>>
                                                    <label for="audience<?= $a->term_id ?>" class="<?php if ($active == 'checked') echo 'fw-semibold' ?>"> <?= $a->name ?> <!--(<?= $a->count ?>)--> </label>
                                                    <a
                                                        aria-label="<?= $a->name ?>"
                                                        tabindex="0"
                                                        class=""
                                                        role="button"
                                                        data-bs-toggle="popover"
                                                        data-bs-trigger="focus"
                                                        data-bs-title="Topic Description"
                                                        data-bs-content="<?= $desc ?>">

                                                        <span class="icon-svg baseline-svg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                <path fill="#999" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                            </svg>
                                                        </span>

                                                    </a>
                                                </div>
                                            <?php endforeach ?>
                                            <button class="btn btn-sm bg-gov-green mt-2 applybutton">Apply</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="deliveryHeading">
                                    <button class="accordion-button text-bg-primary  py-2 px-3 py-lg-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDelivery" aria-expanded="false" aria-controls="collapseDelivery">
                                        <div class="d-flex flex-column align-items-start">
                                            <span class="fw-semibold">Delivery Method </span>
                                            <span class="fs-6"><small>How is the learning offered?</small></span>
                                        </div>
                                    </button>
                                </h4>
                                <div id="collapseDelivery" class="accordion-collapse collapse" aria-labelledby="deliveryHeading">
                                    <div class="accordion-body bg-light-subtle p-3">
                                        <form action="/learninghub/filter" method="GET">
                                            <input class="hiddenkeywords" type="hidden" name="keyword" value="<?= $kw ?>">
                                            <?php if (!empty($_GET['topic'])) : ?>
                                                <?php foreach ($_GET['topic'] as $tid) : ?>
                                                    <input type="hidden" name="topic[]" value="<?= $tid ?>">
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <?php if (!empty($_GET['audience'])) : ?>
                                                <?php foreach ($_GET['audience'] as $auid) : ?>
                                                    <input type="hidden" name="audience[]" value="<?= $auid ?>">
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <?php
                                            $dms = get_categories(
                                                array(
                                                    'taxonomy' => 'delivery_method',
                                                    'orderby' => 'id',
                                                    'order' => 'ASC',
                                                    'hide_empty' => '0'
                                                )
                                            ); //,'include' => array(3,37,82,236,410)
                                            ?>
                                            <?php foreach ($dms as $d) : ?>
                                                <?php $active = '' ?>
                                                <?php $desc = 'No description set';
                                                if (!empty($d->description)) $desc = $d->description; ?>
                                                <?php if (!empty($_GET['delivery_method']) && in_array($d->slug, $_GET['delivery_method'])) $active = 'checked' ?>
                                                <div class="form-check fs-6">
                                                    <input class="form-check-input" onchange="this.form.submit()" type="checkbox" value="<?= $d->slug ?>" name="delivery_method[]" id="delivery_method<?= $d->term_id ?>" <?= $active ?>>
                                                    <label for="delivery_method<?= $d->term_id ?>" class="<?php if ($active == 'checked') echo 'fw-semibold' ?>"> <?= $d->name ?> <!--(<?= $d->count ?>)--> </label>
                                                    <a
                                                        aria-label="<?= $d->name ?>"
                                                        tabindex="0"
                                                        class=""
                                                        role="button"
                                                        data-bs-toggle="popover"
                                                        data-bs-trigger="focus"
                                                        data-bs-title="Topic Description"
                                                        data-bs-content="<?= $desc ?>">

                                                        <span class="icon-svg baseline-svg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                <path fill="#999" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                            </svg>
                                                        </span>

                                                    </a>
                                                </div>
                                            <?php endforeach ?>
                                            <button class="btn btn-sm bg-gov-green mt-2 applybutton">Apply</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="results" class="col-lg-7">
                        <h3 class="h4">Search results</h3>
                        <div class="fw-bold mb-2" id="coursecount">
                            <h3 class="h4 fw-semibold"><span class="badge fs-5 bg-gov-blue me-1"><?= $post_my_query->found_posts ?></span> items found</h3>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> Sort results by </button>
                                <ul class="dropdown-menu bg-dark-subtle text-dark-emphasis">
                                    <li><a class="sort dropdown-item" data-sort="published" href="#">Most Recent</a></li>
                                    <li><a class="sort dropdown-item" data-sort="coursename" href="#">Alphabetical</a></li>
                                    <li><a class="sort dropdown-item" data-sort="dm" href="#">Delivery Method</a></li>
                                    <li><a class="sort dropdown-item" data-sort="audience" href="#">Audience</a></li>
                                    <li><a class="sort dropdown-item" data-sort="topic" href="#">Topic</a></li>
                                </ul>
                            </div>
                            <div class="mx-2">
                                <button id="expall" class="btn btn-sm btn-secondary px-2 d-inline-block">Expand All</button>
                                <button id="collapseall" class="btn btn-sm btn-secondary px-2 d-inline-block">Collapse All</button>
                            </div>
                        </div>
                        <div class="list">
                            <?php if ($post_my_query->have_posts()) : ?>
                                <?php while ($post_my_query->have_posts()) : $post_my_query->the_post(); ?>
                                    <?php get_template_part('template-parts/course/single-course') ?>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <p>Sorry, but there are no courses that match your filters.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo get_template_directory_uri() ?>/js/list.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script> -->

<script type="module">
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))


    var options = {
        valueNames: ['published', 'coursename', 'coursedesc', 'audience', 'topic', 'dm', 'coursekeywords'],
        fuzzySearch: true
    };
    var courseList = new List('courselist', options);

    // As soon as the search updates we also update the UI in several places
    courseList.on('searchComplete', function() {

        let ccount = document.getElementById('coursecount');
        let hidekeyfil = document.getElementById('nokey');
        let removefilter = document.getElementById('keywordfilter');
        let searchValue = document.querySelector('.search').value;
        let sl = document.querySelector('.search').value;
        if (sl.length > 1) {
            hidekeyfil.classList.remove('d-none');
        }
        if (sl.length < 1) {
            updateURLParameter('keyword', '');
            hidekeyfil.classList.add('d-none');
        } else {
            updateURLParameter('keyword', searchValue);
        }
        if (removefilter) {
            let removekw = removefilter.firstElementChild;
            removekw.textContent = searchValue;
        }
        updateHiddenKeywords(searchValue);
        let update = '<span class=\"badge fs-5 bg-gov-blue me-1\">' + courseList.update().matchingItems.length + '<\/span>' + ' items found';
        ccount.innerHTML = update;

    });
    document.addEventListener("DOMContentLoaded", function() {
        let searchkey = document.getElementById('searchfilter').getAttribute('value');
        courseList.search(searchkey);
    });

    function updateURLParameter(param, value) {
        // Get the current URL
        let url = new URL(window.location.href);

        // Update the query parameter
        url.searchParams.set(param, value);

        // Update the URL in the browser without reloading the page
        window.history.replaceState({}, '', url);
    }

    function updateHiddenKeywords(searchValue) {
        let hiddenkeywords = document.querySelectorAll('.hiddenkeywords');
        Array.from(hiddenkeywords).forEach(function(element) {
            element.setAttribute('value', searchValue);
        });
    }
</script>
<script type="module">
    // If there is a filter term present for a given taxonomy we open
    // its accordion and show the term selection form.
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    let t = urlParams.getAll('topic[]');
    let a = urlParams.getAll('audience[]');
    let d = urlParams.getAll('delivery_method[]');
    let taxes = document.querySelectorAll('.accordion-collapse');
    Array.from(taxes).forEach(function(element) {
        if (element.id == 'collapseTopics' && t.length > 0) {
            element.classList.add('show');
            let butt = element.parentNode.querySelectorAll('.accordion-button');
            butt[0].setAttribute('aria-expanded', 'true');
            butt[0].classList.remove('collapsed');
        }
        if (element.id == 'collapseAudience' && a.length > 0) {
            element.classList.add('show');
            let butt = element.parentNode.querySelectorAll('.accordion-button');
            butt[0].setAttribute('aria-expanded', 'true');
            butt[0].classList.remove('collapsed');
        }
        if (element.id == 'collapseDelivery' && d.length > 0) {
            element.classList.add('show');
            let butt = element.parentNode.querySelectorAll('.accordion-button');
            butt[0].setAttribute('aria-expanded', 'true');
            butt[0].classList.remove('collapsed');
        }
    });
    // If there aren't any filters at all, open the topics filter accordion
    // so that it's obvious to the learner that you can open/close the terms
    // for each.
    if (t.length == 0 && a.length == 0 && d.length == 0) {
        let opentops = document.getElementById('collapseTopics');
        opentops.classList.add('show');
        let butt = opentops.parentNode.querySelectorAll('.accordion-button');
        butt[0].setAttribute('aria-expanded', 'true');
        butt[0].classList.remove('collapsed');
    }

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
    // Expand all courses
    // Expand all courses inside the "results" div
    document.getElementById('expall').addEventListener('click', function() {
        const collapses = document.querySelectorAll('#results .collapse');
        collapses.forEach(function(collapse) {
            const bsCollapse = new bootstrap.Collapse(collapse, {
                show: true
            });
            bsCollapse.show();
        });
    });

    // Collapse all courses inside the "results" div
    document.getElementById('collapseall').addEventListener('click', function() {
        const collapses = document.querySelectorAll('#results .collapse');
        collapses.forEach(function(collapse) {
            const bsCollapse = new bootstrap.Collapse(collapse, {
                hide: true
            });
            bsCollapse.hide();
        });
    });
</script>

<?php get_footer(); ?>