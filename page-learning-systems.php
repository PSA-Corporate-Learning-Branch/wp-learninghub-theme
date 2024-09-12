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
<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
        <div class="container-lg py-4 py-md-5">
            <h1 class="text-white">Learning Platforms</h1>
        </div>
    </div>

    <div class="bg-secondary-subtle">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">
            <h2>Where the learning happens</h2>
            <p class="mb-5">The LearningHUB is a directory of courses available to all BC Public Service employees. It includes courses from more than a dozen platforms.</p>
            <div class="row">
                <div class="col-md-6">

                    <h3>Featured Platforms</h3>
                    <div class="mb-3 p-2 card topic-card rounded">
                        <div class="card-body">
                            <h4>PSA Learning System</h4>
                            <p>The PSA Learning System has the largest selection of courses available for registration for BC Public Service employees. It acts as a primary training record for current and completed learning.</p>
                            <a href="https://learning.gov.bc.ca/CHIPSPLM/signon.html" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Visit the PSA Learning System<i class="bi bi-box-arrow-up-right ms-2" aria-hidden="true"></i><span class="visually-hidden"> (opens a new window)</span></a>
                        </div>
                    </div>
                    <div class="mb-3 p-2 card topic-card rounded">
                        <div class="card-body">
                            <h4>Learning Curator</h4>
                            <p>The Learning Curator hosts pathways and activities curated by BC Public Service experts. Choose a pathway and work towards your learning goals at your own pace.</p>

                            <a href="https://learningcurator.gww.gov.bc.ca/" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Visit the Learning Curator<i class="bi bi-box-arrow-up-right ms-2" aria-hidden="true"></i><span class="visually-hidden"> (opens a new window)</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>All Systems</h3>
                    <p>Select a learning system below to show a list of courses hosted on that platform.</p>
                    <?php
                    $topics = get_categories(
                        array(
                            'taxonomy' => 'external_system',
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => '1'
                        )
                    );
                    ?><ul>
                        <?php foreach ($topics as $t) : ?>
                            <?php $active = '';
                            if ($t->slug == $topicterm) $active = 'active'; ?>
                            <li>
                                <a class="<?= $active ?>" href="/learninghub/external_system/<?= $t->slug ?>">
                                    <?= $t->name ?>
                                </a>
                                (<?= $t->count ?>)
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer() ?>