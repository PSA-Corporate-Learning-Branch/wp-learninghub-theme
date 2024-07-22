<?php
//
// This is the main filter interface for the LearningHUB.
//
get_header();

// WP_Query takes a "taxquery" an array argument that allows you to query by 
// taxonomy. Let's start building that array.
$taxquery = [];
// We go through each of the 4 taxonomies that we want to filter on:
// group, topic, audience, and delivery method
// If the array exists...
if (!empty($_GET['group'])) {
    $groupterm = $_GET['group'];
    // Wordpress automatically processes arrays passed to it
    $g = array(
        'taxonomy' => 'groups',
        'field' => 'slug',
        'terms' => $groupterm,
    );
    // Add the term(s) array to the query array
    array_push($taxquery, $g);
    // Now we need to look up the names of the terms from the slugs
    // so that we can show them back to the user in the "remove filter"
    // area.
    $gterms = [];
    // Loop through each of the slugs
    foreach ($_GET['group'] as $g) {
        // Look up the term object for the slug
        $gterm = get_term_by('slug', $g, 'groups');
        // add the result to the array that we can now loop through below.
        array_push($gterms, $gterm);
    }
}

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

// This is the main Wordpress query that we pass our $taxquery to.
$post_args = array(
    'post_type'                => 'course',
    'post_status'              => 'publish',
    'posts_per_page'           => -1,
    'ignore_sticky_posts'      => 0,
    'tax_query'                => $taxquery,
    'orderby'                  => array(
        'date' => 'DESC',
        'menu_order' => 'ASC'
    ),
    'order'                    => 'ASC',
    'hide_empty'               => 0,
    'hierarchical'             => 1,
    'exclude'                  => '',
    'include'                  => '',
    'number'                   => '',
    'pad_counts'               => true,
    //'s'						   => 'ethics'
);
$post_my_query = null;
$post_my_query = new WP_Query($post_args);
?> <style>
    /* We hide the form submit button for taxonomy filters by default, 
	but the noscript below will show it if there's no JS. 
	#gracefuldegradation 
*/
    /* .applybutton {
        display: none;
    } */
</style>
<noscript>
    <style>
        .applybutton {
            display: block;
        }
    </style>
</noscript>
<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
        <div class="container-lg py-4 py-md-5">
            <h1 class="text-white title">Course Catalogue</h1>
        </div>
    </div>
    <div class="bg-secondary-subtle">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">
            <h2>Find learning using filters</h2>
            <p class="mb-4">Four types of categorization help you find exactly what you're looking for: group, audience, topic and delivery. You can also search your filtered results by keyword.</p>
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0 h-100" id="filters">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title h4 fw-semibold">Filters</h3>
                            <p class="lh-sm fs-6 card-text"><small>Select a heading to show/hide the filters from that category. Select the <strong>Apply</strong> button when you want to apply the filters.</small></p> <?php
                                                                                                                                                                                                                            if (!empty($_GET['group']) || !empty($_GET['topic']) || !empty($_GET['audience']) || !empty($_GET['delivery_method'])) :
                                                                                                                                                                                                                                // Grab the current URL
                                                                                                                                                                                                                                $url = $_SERVER['REQUEST_URI'];
                                                                                                                                                                                                                                $currenturl = urldecode($url);
                                                                                                                                                                                                                            ?> <div class="mb-3">
                                    <div class="row"> <?php if (!empty($gterms)) : ?> <div class="col-md-auto mb-2">
                                                <div>Group</div> <?php foreach ($gterms as $g) : ?> <?php
                                                                                                                                                                                                                                        $grpurl = $currenturl;
                                                                                                                                                                                                                                        $replace = 'group[]=' . $g->slug . '';
                                                                                                                                                                                                                                        $gurl = str_replace($replace, '', $grpurl);
                                                                                                                                                                                                                                        $gurl = str_replace('&&', '&', $gurl);
                                                                                                    ?> <button aria-label="remove filter: <?= $g->name ?>" class="badge bg-dark-subtle border-0 fw-normal">
                                                        <a href="<?= $gurl ?>" class="text-secondary-emphasis text-decoration-none"> <?= $g->name ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1" viewBox="0 0 16 16">
                                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                            </svg></a>
                                                    </button> <?php endforeach ?>
                                            </div> <?php endif ?> <?php if (!empty($tterms)) : ?> <div class="col-md-auto mb-2">
                                                <div>Topic</div> <?php foreach ($tterms as $t) : ?> <?php
                                                                                                                                                                                                                                        $topurl = $currenturl;
                                                                                                                                                                                                                                        $replace = 'topic[]=' . $t->slug . '';
                                                                                                                                                                                                                                        $turl = str_replace($replace, '', $topurl);
                                                                                                                                                                                                                                        $turl = str_replace('&&', '&', $turl);
                                                                                                    ?> <button aria-label="remove filter: <?= $t->name ?>" class="badge bg-dark-subtle border-0 fw-normal">
                                                        <a href="<?= $turl ?>" class="text-secondary-emphasis text-decoration-none"> <?= $t->name ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1" viewBox="0 0 16 16">
                                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                            </svg></a>
                                                    </button> <?php endforeach ?>
                                            </div> <?php endif ?> <?php if (!empty($aterms)) : ?> <div class="col-md-auto mb-2">
                                                <div>Audience</div> <?php foreach ($aterms as $a) : ?> <?php
                                                                                                                                                                                                                                        $audurl = $currenturl;
                                                                                                                                                                                                                                        $replace = 'audience[]=' . $a->slug . '';
                                                                                                                                                                                                                                        $aurl = str_replace($replace, '', $audurl);
                                                                                                                                                                                                                                        $aurl = str_replace('&&', '&', $aurl);
                                                                                                        ?> <button aria-label="remove filter: <?= $a->name ?>" class="badge bg-dark-subtle border-0 fw-normal">
                                                        <a href="<?= $aurl ?>" class="text-secondary-emphasis text-decoration-none"> <?= $a->name ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1" viewBox="0 0 16 16">
                                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                            </svg></a>
                                                    </button> <?php endforeach ?>
                                            </div> <?php endif ?> <?php if (!empty($dterms)) : ?> <div class="col-md-auto">
                                                <div>Delivery Method</div> <?php foreach ($dterms as $d) : ?> <?php
                                                                                                                                                                                                                                        $dmurl = $currenturl;
                                                                                                                                                                                                                                        $replace = 'delivery_method[]=' . $d->slug . '';
                                                                                                                                                                                                                                        $durl = str_replace($replace, '', $dmurl);
                                                                                                                                                                                                                                        $durl = str_replace('&&', '&', $durl);
                                                                                                                ?> <button aria-label="remove filter: <?= $d->name ?>" class="badge bg-dark-subtle border-0 fw-normal">
                                                        <a href="<?= $durl ?>" class="text-secondary-emphasis text-decoration-none"> <?= $d->name ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1" viewBox="0 0 16 16">
                                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                            </svg></a>
                                                    </button> <?php endforeach ?>
                                            </div> <?php endif ?> </div>
                                    <div class="mt-3">
                                        <a class="btn btn-sm btn-primary" href="/learninghub/filter/">Clear All</a>
                                    </div>
                                </div> <?php endif ?> <div class="accordion" id="filterCategories">
                                <div class="accordion-item">
                                    <h4 class="accordion-header" id="groupsHeading">
                                        <button class="accordion-button text-bg-primary py-2 px-3 py-lg-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGroups" aria-expanded="true" aria-controls="collapseGroups">
                                            <div class="d-flex flex-column align-items-start">
                                                <span class="fw-semibold">Group</span>
                                                <span class="fs-6"><small>What type of learning is it?</small></span>
                                                </span>
                                            </div>
                                        </button>
                                    </h4>
                                    <div id="collapseGroups" class="accordion-collapse collapse show" aria-labelledby="groupsHeading">
                                        <div class="accordion-body bg-light-subtle">
                                            <form action="/learninghub/filter" method="GET"> <?php if (!empty($_GET['topic'])) : ?> <?php foreach ($_GET['topic'] as $tid) : ?> <input type="hidden" name="topic[]" value="<?= $tid ?>"> <?php endforeach ?> <?php endif ?> <?php if (!empty($_GET['audience'])) : ?> <?php foreach ($_GET['audience'] as $aid) : ?> <input type="hidden" name="audience[]" value="<?= $aid ?>"> <?php endforeach ?> <?php endif ?> <?php if (!empty($_GET['delivery_method'])) : ?> <?php foreach ($_GET['delivery_method'] as $did) : ?> <input type="hidden" name="delivery_method[]" value="<?= $did ?>"> <?php endforeach ?> <?php endif ?> <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $groups = get_categories(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        array(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            'taxonomy' => 'groups',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            'orderby' => 'id',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            'order' => 'DESC',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            'hide_empty' => '0'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        )
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    );
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ?> <?php foreach ($groups as $g) : ?> <?php $active = '' ?> <?php if (!empty($_GET['group']) && in_array($g->slug, $_GET['group'])) $active = 'checked' ?> <div class="form-check fs-6">
                                                        <input class="form-check-input" type="checkbox" value="<?= $g->slug ?>" name="group[]" id="group<?= $g->term_id ?>" <?= $active ?>>
                                                        <label for="group<?= $g->term_id ?>" class="form-check-label <?php if ($active == 'checked') echo 'fw-semibold' ?>" for="group<?= $g->term_id ?>"><?= $g->name ?> (<?= $g->count ?>) </label>
                                                    </div> <?php endforeach ?> <button class="btn btn-sm bg-gov-green mt-2 applybutton">Apply</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                                        <div class="accordion-body bg-light-subtle">
                                            <form action="/learninghub/filter" method="GET"> <?php if (!empty($_GET['group'])) : ?> <?php foreach ($_GET['group'] as $gid) : ?> <input type="hidden" name="group[]" value="<?= sanitize_text_field($gid) ?>"> <?php endforeach ?> <?php endif ?> <?php if (!empty($_GET['audience'])) : ?> <?php foreach ($_GET['audience'] as $aid) : ?> <input type="hidden" name="audience[]" value="<?= $aid ?>"> <?php endforeach ?> <?php endif ?> <?php if (!empty($_GET['delivery_method'])) : ?> <?php foreach ($_GET['delivery_method'] as $did) : ?> <input type="hidden" name="delivery_method[]" value="<?= $did ?>"> <?php endforeach ?> <?php endif ?> <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $topics = get_categories(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            array(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'taxonomy' => 'topics',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'orderby' => 'name',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'order' => 'ASC',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'hide_empty' => '0'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            )
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        );
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ?> <?php foreach ($topics as $t) : ?> <?php $active = '' ?> <?php if (!empty($_GET['topic']) && in_array($t->slug, $_GET['topic'])) $active = 'checked' ?> <div class="form-check fs-6">
                                                        <input class="form-check-input" type="checkbox" value="<?= $t->slug ?>" name="topic[]" id="topic<?= $t->term_id ?>" <?= $active ?>>
                                                        <label for="topic<?= $t->term_id ?>" class="<?php if ($active == 'checked') echo 'fw-semibold' ?>"> <?= $t->name ?> (<?= $t->count ?>) </label>
                                                    </div> <?php endforeach ?> <button class="btn btn-sm bg-gov-green mt-2 applybutton">Apply</button>
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
                                        <div class="accordion-body bg-light-subtle">
                                            <form action="/learninghub/filter" method="GET"> <?php if (!empty($_GET['group'])) : ?> <?php foreach ($_GET['group'] as $gid) : ?> <input type="hidden" name="group[]" value="<?= $gid ?>"> <?php endforeach ?> <?php endif ?> <?php if (!empty($_GET['topic'])) : ?> <?php foreach ($_GET['topic'] as $tid) : ?> <input type="hidden" name="topic[]" value="<?= $tid ?>"> <?php endforeach ?> <?php endif ?> <?php if (!empty($_GET['delivery_method'])) : ?> <?php foreach ($_GET['delivery_method'] as $did) : ?> <input type="hidden" name="delivery_method[]" value="<?= $did ?>"> <?php endforeach ?> <?php endif ?> <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $audiences = get_categories(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            array(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'taxonomy' => 'audience',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'orderby' => 'id',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'order' => 'DESC',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'hide_empty' => '0'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            )
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        );
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ?> <?php foreach ($audiences as $a) : ?> <?php $active = '' ?> <?php if (!empty($_GET['audience']) && in_array($a->slug, $_GET['audience'])) $active = 'checked' ?> <div class="form-check fs-6">
                                                        <input class="form-check-input" type="checkbox" value="<?= $a->slug ?>" name="audience[]" id="audience<?= $a->term_id ?>" <?= $active ?>>
                                                        <label for="audience<?= $a->term_id ?> " class="<?php if ($active == 'checked') echo 'fw-semibold' ?>"> <?= $a->name ?> (<?= $a->count ?>) </label>
                                                    </div> <?php endforeach ?> <button class="btn btn-sm bg-gov-green mt-2 applybutton">Apply</button>
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
                                        <div class="accordion-body bg-light-subtle">
                                            <form action="/learninghub/filter" method="GET"> <?php if (!empty($_GET['group'])) : ?> <?php foreach ($_GET['group'] as $gid) : ?> <input type="hidden" name="group[]" value="<?= $gid ?>"> <?php endforeach ?> <?php endif ?> <?php if (!empty($_GET['topic'])) : ?> <?php foreach ($_GET['topic'] as $tid) : ?> <input type="hidden" name="topic[]" value="<?= $tid ?>"> <?php endforeach ?> <?php endif ?> <?php if (!empty($_GET['audience'])) : ?> <?php foreach ($_GET['audience'] as $auid) : ?> <input type="hidden" name="audience[]" value="<?= $auid ?>"> <?php endforeach ?> <?php endif ?> <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $dms = get_categories(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            array(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'taxonomy' => 'delivery_method',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'orderby' => 'id',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'order' => 'DESC',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                'hide_empty' => '0'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            )
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ); //,'include' => array(3,37,82,236,410)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ?> <?php foreach ($dms as $d) : ?> <?php $active = '' ?> <?php if (!empty($_GET['delivery_method']) && in_array($d->slug, $_GET['delivery_method'])) $active = 'checked' ?> <div class="form-check fs-6">
                                                        <input class="form-check-input" type="checkbox" value="<?= $d->slug ?>" name="delivery_method[]" id="delivery_method<?= $d->term_id ?>" <?= $active ?>>
                                                        <label forid="delivery_method<?= $d->term_id ?>" class="<?php if ($active == 'checked') echo 'fw-semibold' ?>"> <?= $d->name ?> (<?= $d->count ?>) </label>
                                                    </div> <?php endforeach ?> <button class="btn btn-sm bg-gov-green mt-2 applybutton">Apply</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="results" class="col-lg-7">
                    <div id="courselist">
                        <div class="mb-3 p-3 card topic-card rounded">
                            <?php
                            $resultcount = (int) $post_my_query->found_posts;
                            $plural = 'course';
                            if ($resultcount > 1) $plural = 'courses';
                            ?>
                            <div class="fw-bold mb-2" id="coursecount">
                                <h3 class="h4 fw-semibold"><span class="badge fs-5 bg-gov-blue me-1"><?= $post_my_query->found_posts ?></span> <?= $plural ?> found</h3>
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
    // const queryString = window.location.search;
    // const urlParams = new URLSearchParams(queryString);
    // console.log(urlParams.getAll('group'));
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