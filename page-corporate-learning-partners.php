<?php

/**
 * The template for displaying all Learning Partners
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
get_header();
?>
<!-- <h1>TEST</h1> -->
<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
        <div class="container-lg px-0 px-md-3 py-4 py-md-5">
            <h1 class="mb-0 text-white">Corporate Learning Partners</h1>
        </div>
    </div>
    <div class="bg-light-subtle">
        <div class="container-lg p-lg-5 p-4">
            <h2>Learning together</h2>
            <p>In the BC Public Service, corporate learning is a shared space. Corporate learning partners are all committed to offering learning, development and growth opportunities for all our employees.</p>
            <div class="card topic-card">
                <div class="card-body">
                    <h3 class="card-title">Are you interested in becoming a partner?</h3>
                    <p>To be a corporate learning partner, you must have developed or designed a course that is aligned with the Corporate Learning Framework and beneficial to all BC Public Service employees regardless of their ministry.</p>
                    <details>
                        <summary class="fs-6 text-primary ms-3">
                            More info</summary>
                        <h4 class="mt-3">What corporate learning partners do</h4>
                        <p>We meet virtually bi-monthly to identify, prioritize, track, and improve alignment of corporate learning priorities for the BC Public Service. They also collaborate asynchronously through a Microsoft TEAMS page.</p>
                        <h4>What's in it for you</h4>
                        <p>As a partner, you will gain access to a wealth of shared resources, including best practices and innovative ideas for developing corporate learning. Your involvement will not only provide you with timely updates and materials but also offer a voice in shaping the strategic direction of corporate learning within the BC Public Service Agency.</p>
                        <p>We highly value the time and effort that goes into developing corporate learning. We would love to include you and your amazing courses in the LearningHUB.</p>
                        <p><a href="https://gww.bcpublicservice.gov.bc.ca/learning/hub/partners/new-partner-form.php" target="_blank">Request partnership</a></p>
                    </details>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-secondary-subtle pt-4">
        <div class="container-lg p-lg-5 p-4">
            <h2 class="text-warning">Meet the partners</h2>
            <p class="mb-4 text-white">Curious about our existing partners and which courses they offer? You're in the right spot.</p>

            <style>
                .partner-tab-input {
                    display: none;
                }

                .partner-tabs-wrapper {
                    display: flex;
                    gap: 0;
                    margin-bottom: -3px;
                    position: relative;
                    z-index: 1;
                }

                .partner-tab-label {
                    background-color: #f5a623;
                    border-radius: 5px 5px 0 0;
                    color: #333;
                    border: 3px solid #f5a623;
                    border-bottom: none;
                    padding: 0.75rem 1.5rem;
                    font-weight: 800;
                    display: inline-block;
                    margin-right: 5px;
                    font-size: 1.2rem;
                    cursor: pointer;
                    text-decoration: none;
                }

                .partner-tab-label:hover {
                    background-color: #d89420;
                    color: #333;
                }

                .partner-tab-input:checked + .partner-tab-label {
                    background-color: var(--bs-secondary-bg-subtle);
                    color: #f5a623;
                    border-bottom: 3px solid var(--bs-secondary-bg-subtle);
                }

                .partner-content-wrapper {
                    border: 3px solid #f5a623;
                    border-radius: 0 5px 5px 5px;
                    padding: 2rem;
                    position: relative;
                }

                .partner-tab-content {
                    display: none;
                }

                .partner-tabs-wrapper:has(#tab-corporate:checked) ~ .partner-content-wrapper #content-corporate,
                .partner-tabs-wrapper:has(#tab-development:checked) ~ .partner-content-wrapper #content-development {
                    display: block;
                }

                .partner-content-wrapper h3 {
                    color: #f5a623;
                }

                .partner-content-wrapper .card {
                    background-color: var(--bs-light-bg-subtle) !important;
                    color: #fff;
                }

                .partner-content-wrapper .card .card-title h3 {
                    color: #f5a623;
                }

                .partner-content-wrapper .card a {
                    color: #7db9e8;
                }
            </style>

            <div class="partner-tabs-wrapper">
                <input type="radio" name="partner-tabs" id="tab-corporate" class="partner-tab-input" checked>
                <label for="tab-corporate" class="partner-tab-label">
                    Corporate Learning Partners
                </label>
                <input type="radio" name="partner-tabs" id="tab-development" class="partner-tab-input">
                <label for="tab-development" class="partner-tab-label">
                    Development Partners
                </label>
            </div>

            <div class="partner-content-wrapper">
                <!-- Corporate Learning Partners Content -->
                <div id="content-corporate" class="partner-tab-content">
                <?php
                $terms = get_terms(array(
                    'taxonomy' => 'learning_partner',
                    'hide_empty' => false,
                    'orderby'    => 'count',
                    'order'   => 'DESC',
                    'exclude' => [121, 372, 144]
                )); // 121 = Office of Compt General, 372 = unknown, 144 = labour relations
                ?>
                <div id="partnerlist">
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <?php $count = 1 ?>
                        <?php foreach ($terms as $category) : ?>
                            <?php
                            $pcount = $category->count . ' course';
                            if ($category->count > 1) $pcount = $category->count . ' courses';
                            $category_link = sprintf(
                                '<a href="%1$s" title="%2$s" class="partnerofferings">View %3$s from this partner</a>',
                                esc_url(get_category_link($category->term_id)),
                                esc_attr(sprintf(__('View all posts in %s', 'textdomain'), $category->name)),
                                esc_html($pcount)
                            );
                            $partnerurl = '';
                            $partnerlogo = '';
                            $term_vals = get_term_meta($category->term_id);
                            foreach ($term_vals as $key => $val) {
                                if ($key == 'partner-url') {
                                    $partnerurl = $val[0];
                                }
                                if ($key == 'category-image-id') {
                                    $partnerlogo = $val[0];
                                }
                            }
                            ?>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body" style="font-size: 1.125rem;">
                                        <div class="card-title">
                                            <h3 class="h4 fw-semibold"><?= esc_html($category->name) ?></h3>
                                        </div>
                                        <div class="card-text">
                                            <?= sprintf(esc_html__('%s', 'textdomain'), $category->description) ?>
                                        </div>

                                        <?php if (!empty($partnerurl)) : ?>
                                            <div class="partner-url mt-2">
                                                <a target="_blank" rel="noopener" href="<?= $partnerurl ?>">
                                                    View partner website<span class="visually-hidden"> (Opens in a new tab)</span>
                                                </a>
                                            </div>
                                        <?php endif ?>
                                        <div class="hublink">
                                            <?php if ($category->count > 0) : ?>
                                                <?= sprintf(esc_html__('%s', 'textdomain'), $category_link) ?>
                                            <?php else : ?>
                                                <div class="bg-warning-subtle mt-2 p-2 text-dark">
                                                    This partner does not currently have any courses listed in the LearningHUB.
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                </div>

                <!-- Development Partners Content -->
                <div id="content-development" class="partner-tab-content">
                    <?php
                    $devpterms = get_terms(array(
                        'taxonomy' => 'development_partner',
                        'hide_empty' => false,
                        'orderby'    => 'count',
                        'order'   => 'DESC'
                    ));
                    ?>
                    <?php if (!empty($devpterms) && !is_wp_error($devpterms)) : ?>
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            <?php foreach ($devpterms as $dp) : ?>
                                <?php
                                $pcount = $dp->count . ' course';
                                if ($dp->count > 1) $pcount = $dp->count . ' courses';
                                $category_link = sprintf(
                                    '<a href="%1$s" title="%2$s" class="partnerofferings">View %3$s from this development partner</a>',
                                    esc_url(get_term_link($dp->term_id)),
                                    esc_attr(sprintf(__('View all courses from %s', 'textdomain'), $dp->name)),
                                    esc_html($pcount)
                                );
                                ?>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body" style="font-size: 1.125rem;">
                                            <div class="card-title">
                                                <h3 class="h4 fw-semibold"><?= esc_html($dp->name) ?></h3>
                                            </div>
                                            <div class="card-text">
                                                <?= esc_html($dp->description) ?>
                                            </div>
                                            <div class="hublink mt-2">
                                                <?php if ($dp->count > 0) : ?>
                                                    <?= sprintf(esc_html__('%s', 'textdomain'), $category_link) ?>
                                                <?php else : ?>
                                                    <div class="bg-warning-subtle mt-2 p-2 text-dark">
                                                        This development partner does not currently have any courses listed in the LearningHUB.
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php else : ?>
                        <p class="text-white">No development partners found.</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    var hash = window.location.hash;

    // Check hash on page load and select appropriate tab
    if (hash === '#content-development' || hash === '#development-partners') {
        document.getElementById('tab-development').checked = true;
    } else if (hash === '#content-corporate' || hash === '#corporate-learning-partners') {
        document.getElementById('tab-corporate').checked = true;
    }

    // Update hash when tabs are clicked
    document.getElementById('tab-corporate').addEventListener('change', function() {
        if (this.checked) {
            history.replaceState(null, null, '#content-corporate');
        }
    });

    document.getElementById('tab-development').addEventListener('change', function() {
        if (this.checked) {
            history.replaceState(null, null, '#content-development');
        }
    });
})();
</script>

<!-- / -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script>
var courseoptions = {
    valueNames: [ 'partnername', 'partnerdesc' ]
};
var partners = new List('partnerlist', courseoptions);
document.getElementById('pcount').innerHTML = partners.update().matchingItems.length;
partners.on('searchComplete', function(){
    //console.log(upcomingClasses.update().matchingItems.length);
    //console.log(courses.update().matchingItems.length);
    document.getElementById('pcount').innerHTML = partners.update().matchingItems.length;
});
</script> -->
<?php get_footer() ?>
