<?php

/**
 * The template for displaying Learning Journeys
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
            <h1 class="text-white title">Foundational Corporate Learning</h1>
        </div>
    </div>
    <div class="bg-secondary-subtle">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">
            <h2>Introduction</h2>
            <p class="mb-4">Foundational corporate learning refers to basic BC Public Service-specific knowledge and skills that
                all employees should have regardless of role. It includes mandatory courses.
                All BC Public Service employees at all levels take the mandatory courses for all employees.
                If you have direct reports, you'll also take the courses that are mandatory for People Leaders.</p>
            <p class="fs-6 mb-4">
                <span class="icon-svg baseline-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                    </svg>
                </span>Choose the list that applies to you. Select the heading to show or hide the content.
                <strong>Note:</strong> All course links open in a new tab or window.
            </p>
            <h3 id="all-employees">All Employees</h3>
            <details class="border border-secondary px-3 py-2 my-3 rounded">
                <summary class="h4 ms-3 mb-0">
                    <h4 class="d-inline text-body-emphasis">In Your First Year of Employment</h4>
                </summary>
                <div class="mt-2">
                    <p>This is the <strong>suggested time frame</strong> for completing your foundational learning.</p>
                    <h5>Month 1</h5>
                    <ul class="mb-4">
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/im-117-information-management-managing-government-information-privacy-access-to-information-and-security/" target="_blank" rel="noopener">Information Management (IM) 117<span class="visually-hidden"> (opens in new window)</span></a><span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/diversity-and-inclusion-essentials/" target="_blank" rel="noopener">Diversity and Inclusion (D&I) Essentials<span class="visually-hidden"> (opens in new window)</span></a><span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                        <li>Indigenous Crown Relations Essentials (Coming soon)<span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/fraud-awareness-and-prevention/" target="_blank" rel="noopener">Fraud Awareness and Prevention<span class="visually-hidden"> (opens in new window)</span></a><span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                    </ul>
                    <h5>Month 3</h5>
                    <ul class="mb-4">
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/respectful-workplace/" target="_blank" rel="noopener">Respectful Workplaces curated pathway<span class="visually-hidden"> (opens in new window)</span></a></li>
                        <li>B.C. Provincial Government Essentials (Coming soon)</li>
                    </ul>
                    <h5>Month 6</h5>
                    <ul class="mb-4">
                        <li><a href="https://gww.bcpublicservice.gov.bc.ca/Learning/health/courses/WHS_resources/Learner_Journey_AE/index.html" target="_blank" rel="noopener">Workplace Health and Safety<span class="visually-hidden"> (opens in new window)</span></a> learning resource</li>
                    </ul>
                    <h5>Month 12</h5>
                    <ul class="mb-4">
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/finance-foundations/" target="_blank" rel="noopener">Finance Foundations<span class="visually-hidden"> (opens in new window)</span></a></li>
                    </ul>

                    <hr>

                    <?php
                    $termID = 638;
                    $taxonomyname = "journey";
                    $custom_terms = get_term_children($termID, $taxonomyname);
                    $children = array();
                    foreach ($custom_terms as $child) {
                        $term = get_term_by('id', $child, $taxonomyname);
                        $children[$term->term_order] = $term;
                    }
                    ksort($children);
                    foreach ($children as $custom_term) :
                        $count = 0;
                        //echo $custom_term->slug;
                        $term = get_term_by('id', $custom_term, $taxonomyname);
                        wp_reset_query();
                        $args = array(
                            'post_type' => 'course',
                            'orderby'   => 'menu_order',
                            'order' => 'ASC',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'journey',
                                    'field' => 'slug',
                                    'terms' => $custom_term->slug,
                                ),
                            ),
                        );

                        $loop = new WP_Query($args);
                        if ($loop->have_posts()): ?>
                            <h5><?= $custom_term->name ?></h5>
                            <ul>
                                <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                                    <li class="journeycourse">
                                        <a href="<?= get_permalink() ?>"> <?= get_the_title() ?></a>
                                        <span class="badge text-bg-warning fw-medium ms-2">
                                            <?php echo the_terms($post->ID, 'groups', '', ', ', ' '); ?>
                                        </span>
                                    </li>
                                <?php endwhile; // endof course loop 
                                ?>
                            </ul>
                        <?php endif; // are there posts? 
                        ?>


                    <?php endforeach; // endof term loop 
                    ?>







                </div>
            </details>
            <details class="border border-secondary px-3 py-2 my-3 rounded">
                <summary class="h4 ms-3 mb-0">
                    <h4 class="d-inline text-body-emphasis" id="existing-employees">Existing Employees</h4>
                </summary>
                <div class="mt-2">
                    <p>After your first year, this is the <strong>suggested time frame</strong> for completing your foundational learning.</p>
                    <h5>Every year</h5>
                    <ul class="mb-4">
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/annual-review-of-the-standards-of-conduct-and-oath-of-employment/" target="_blank" rel="noopener">Annual Review of the Oath of Employment and Standards of Conduct<span class="visually-hidden"> (opens in new window)</span></a><span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                    </ul>
                    <h5>Every 2 years</h5>
                    <ul class="mb-4">
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/im-117-information-management-managing-government-information-privacy-access-to-information-and-security/" target="_blank" rel="noopener">Information Management (IM) 117<span class="visually-hidden"> (opens in new window)</span></a><span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                        <li>Indigenous Crown Relations Essentials (Coming soon)<span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                    </ul>
                    <h5>Every 3 years</h5>
                    <ul class="mb-4">
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/fraud-awareness-and-prevention/" target="_blank" rel="noopener">Fraud Awareness and Prevention<span class="visually-hidden"> (opens in new window)</span></a><span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                    </ul>
                    <h5>At least once</h5>
                    <ul class="mb-4">
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/diversity-and-inclusion-essentials/" target="_blank" rel="noopener">Diversity and Inclusion (D&I) Essentials<span class="visually-hidden"> (opens in new window)</span></a><span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/respectful-workplace/" target="_blank" rel="noopener">Respectful Workplaces curated pathway<span class="visually-hidden"> (opens in new window)</span></a></li>
                        <li>B.C. Provincial Government Essentials (Coming soon)</li>
                        <li><a href="https://gww.bcpublicservice.gov.bc.ca/Learning/health/courses/WHS_resources/Learner_Journey_AE/index.html" target="_blank" rel="noopener">Workplace Health and Safety<span class="visually-hidden"> (opens in new window)</span></a> learning resource</li>
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/finance-foundations/" target="_blank" rel="noopener">Finance Foundations<span class="visually-hidden"> (opens in new window)</span></a></li>
                    </ul>
                </div>
            </details>
            <h3 class="mt-5" id="people-leaders">People Leaders</h3>
            <details class="border border-secondary px-3 py-2 my-3 rounded">
                <summary class="h4 ms-3 mb-0">
                    <h4 class="d-inline text-body-emphasis">In Your First Year as a People Leader</h4>
                </summary>
                <div class="mt-2">
                    <p>This is the <strong>suggested time frame</strong> for completing your foundational learning, in addition to the All Employees learning above. </p>
                    <h5>Month 1 to 3</h5>
                    <ul class="mb-4">
                        <li>Enroll in <a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/hr-foundations-for-people-leaders/" target="_blank" rel="noopener">HR Foundations for People Leaders<span class="visually-hidden"> (opens in new window)</span></a><span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                        <li>Enroll in <a href="https://learningcentre.gww.gov.bc.ca/supervising-bcps/" target="_blank" rel="noopener">Supervising in the BC Public Service (SBCPS)<span class="visually-hidden"> (opens in new window)</span></a><span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                        <li>Leading People in the BCPS (Coming soon)</li>
                    </ul>
                    <h5>Month 6</h5>
                    <ul class="mb-4">
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/intro-to-coaching/" target="_blank" rel="noopener">Intro to Coaching<span class="visually-hidden"> (opens in new window)</span></a></li>
                    </ul>
                    <h5>Month 12</h5>
                    <ul class="mb-4">
                        <li>Complete <a href="https://learningcentre.gww.gov.bc.ca/supervising-bcps/" target="_blank" rel="noopener">Supervising in the BC Public Service (SBCPS)<span class="visually-hidden"> (opens in new window)</span></a><span class="badge text-bg-warning fw-medium ms-2">Mandatory</span></li>
                        <li>Conflict Competence (Coming soon)</li>
                        <li>Intro to Change Leadership (Coming soon)</li>
                        <li><a href="https://gww.bcpublicservice.gov.bc.ca/Learning/health/courses/WHS_resources/Learner_Journey_PL/index.html" target="_blank" rel="noopener">Workplace Health and Safety for People Leaders<span class="visually-hidden"> (opens in new window)</span></a> learning resource</li>
                    </ul>
                </div>
            </details>
            <details class="border border-secondary px-3 py-2 my-3 rounded">
                <summary class="h4 ms-3 mb-0">
                    <h4 class="d-inline text-body-emphasis" id="existing-people-leaders">Existing People Leaders</h4>
                </summary>
                <div class="mt-2">
                    <p>After your first year, this is the suggested time frame for completing your mandatory and foundational learning. </p>
                    <h5>At your own pace</h5>
                    <ul class="mb-4">
                        <li>Enroll in <a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/hr-foundations-for-people-leaders/" target="_blank" rel="noopener">HR Foundations for People Leaders<span class="visually-hidden"> (opens in new window)</span></a></li>
                        <li>Intro to Change Leadership (Coming soon)</li>
                        <li>Leading People in the BCPS (Coming soon)</li>
                        <li><a href="https://learningcentre.gww.gov.bc.ca/learninghub/course/intro-to-coaching/" target="_blank" rel="noopener">Intro to Coaching<span class="visually-hidden"> (opens in new window)</span></a></li>
                        <li>Introduction to Communications (Coming soon)</li>
                        <li>Conflict Competence (Coming soon)</li>
                        <li><a href="https://gww.bcpublicservice.gov.bc.ca/Learning/health/courses/WHS_resources/Learner_Journey_PL/index.html" target="_blank" rel="noopener">Workplace Health and Safety for People Leaders<span class="visually-hidden"> (opens in new window)</span></a> learning resource</li>
                    </ul>
                </div>
            </details>
        </div>
    </div>
</div>
<?php get_footer() ?>