<?php get_header() ?> <div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center" style="height: 18vh; min-height: 100px; background: rgb(35,64,117); background: linear-gradient(87deg, rgba(35,64,117,1) 0%, rgba(0,120,100,1) 50%, rgba(227,168,43,1) 91%);">
        <div class="container-lg py-4 py-md-5">
            <h1 class="text-white title">Welcome to the LearningHUB</h1>
        </div>
    </div>
    <div class="bg-light-subtle">
        <div class="container-lg p-lg-5 p-4 ">
            <div class="row mx-0">
                <div class="col-lg-8 mb-4 mb-lg-0 ps-lg-0">
                    <h2>What is corporate learning?</h2>
                    <p>The PSA Corporate Learning Branch and its partners offer hundreds of courses, available to all BCPS employees. The LearningHUB is the place to see that full catalogue of corporate offerings.</p>
                    <a href="/learninghub/filter/" class="btn btn-lg btn-primary mt-2 mb-5 py-2 fs-4">Corporate learning catalogue</a>
                    <h3>Not sure where to start?</h3>
                    <p>Get the details on <a href="/learninghub/foundational-corporate-learning/">Mandatory and Foundational learning</a> for all employees and people leaders in their first year and beyond.</p>
                </div>
                <div class="col-lg-4 pe-lg-0">
                    <div class="card shadow-sm">
                        <div class="bg-gov-blue card-header pt-3">
                            <h4 class="text-white mb-1">New and updated courses</h4>
                        </div>
                        <div class="card-body fs-6">
                            <ul class="card-text" style="line-height: 1.75;">
                                <li><a href="#">2SLGBTQIA+ Learning Series</a></li>
                                <li><a href="#">Moose Hide Campaign Day (2026) - In-person and Online Gathering and Day of Fasting on May 14, 2026</a></li>
                                <li><a href="#">L@WW 2023 Session Recordings</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card shadow-sm mt-3">
                        <div class="card-body fs-6">
                            <h3 class="card-title fs-4">Corporate learning newsletter</h3>
                            <p class="card-text">Stay updated about all things corporate learning with our monthly email newsletter.</p>
                            <a href="#" class="btn btn-primary">Subscribe to the newsletter</a>
                        </div>
                    </div>
                </div>
            </div> <?php
            $sticky = get_option('sticky_posts');
            // check if there are any
            if (!empty($sticky)) :
                // optional: sort the newest IDs first
                rsort($sticky);
                // override the query
                $args = array(
                    'post__in' => $sticky
                );
                query_posts($args);
            ?> <?php while (have_posts()) : ?> <?php the_post() ?> <?php if (has_post_thumbnail($post->ID)) : ?> <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large'); ?> <a href="<?= the_permalink() ?>" class="text-decoration-none p-0">
                <img alt="" aria-label="<?php the_title() ?>" class="mt-4 border border-2 border-gov-blue border-bottom-0 rounded-top w-100 object-fit-contain" src="<?php echo $image[0]; ?>">
            </a> <?php endif; ?> <div class="bg-gov-blue px-3 py-2 rounded-bottom shadow-sm">
                <h3 class="text-white mb-0 p-2"><?php the_title() ?></h3>
            </div> <?php endwhile ?> <?php endif ?>
        </div>
    </div>
</div>
<div class="bg-secondary-subtle pt-4">
    <div class="container-lg p-lg-5 p-4 bg-light-subtle">
        <h3>What's new in corporate learning?</h3> <?php
                        $sticky_posts = get_option('sticky_posts');
                        $newsargs = array(
                            'posts_per_page' => 1, // Only get one post
                            'post_status'    => 'publish', // Ensure the post is published
                            'post__not_in' => $sticky_posts, // Ignore stickied posts
                            'orderby'        => 'date', // Order by date
                            'order'          => 'DESC', // Get the most recent post
                        );
                        $recent_post = new WP_Query($newsargs);
                        if ($recent_post->have_posts()) :
                            while ($recent_post->have_posts()) : $recent_post->the_post();
                        ?> <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 mt-4">
            <div class="col mb-3">
                <div class="d-flex">
                    <div class="flex-shrink-0 blue-fill align-self-start pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="icon-lg">
                            <!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                            <path d="M288 88C288 74.7 298.7 64 312 64C457.8 64 576 182.2 576 328C576 341.3 565.3 352 552 352C538.7 352 528 341.3 528 328C528 208.7 431.3 112 312 112C298.7 112 288 101.3 288 88zM144 160C170.5 160 192 181.5 192 208L192 432C192 458.5 213.5 480 240 480C266.5 480 288 458.5 288 432C288 405.5 266.5 384 240 384C231.2 384 224 376.8 224 368L224 304C224 295.2 231.2 288 240 288C319.5 288 384 352.5 384 432C384 511.5 319.5 576 240 576C160.5 576 96 511.5 96 432L96 208C96 181.5 117.5 160 144 160zM312 160C404.8 160 480 235.2 480 328C480 341.3 469.3 352 456 352C442.7 352 432 341.3 432 328C432 261.7 378.3 208 312 208C298.7 208 288 197.3 288 184C288 170.7 298.7 160 312 160z" />
                        </svg>
                    </div>
                    <h4 class="ms-2 pt-3 pb-2">Blog</h4>
                </div>
                <div class="card shadow-sm rounded">
                    <div class="rounded-top"> <?php if (has_post_thumbnail($recent_post->ID)) : ?> <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($recent_post->ID), 'large'); ?> <a href="<?= the_permalink() ?>" class="text-decoration-none p-0">
                            <img alt="" aria-label="<?= the_title() ?>" style="height:10vh;" class="card-img-top object-fit-cover rounded-top " src="<?php echo $image[0]; ?>">
                        </a> <?php endif; ?> </div>
                    <div class="card-body fs-6">
                        <h5 class="fs-5"><a href="<?= the_permalink() ?>"><?= the_title() ?></a></h5>
                        <p class="card-text"><?= the_excerpt() ?></p> <?php endwhile;
                        wp_reset_postdata(); // Reset query
                    endif;
                        ?>
                    </div>
                </div>
                <ul class="mt-2">
                    <li><a href="/learninghub/news">Read the latest blog posts</a></li>
                </ul>
            </div>
            <div class="col mb-3">
                <div class="d-flex">
                    <div class="flex-shrink-0 blue-fill align-self-start pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="icon-lg">
                            <!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                            <path d="M320 216C368.6 216 408 176.6 408 128C408 79.4 368.6 40 320 40C271.4 40 232 79.4 232 128C232 176.6 271.4 216 320 216zM320 514.7L320 365.4C336.3 358.6 352.9 351.7 369.7 344.7C408.7 328.5 450.5 320.1 492.8 320.1L512 320.1L512 480.1L492.8 480.1C433.7 480.1 375.1 491.8 320.5 514.6L320 514.8zM320 296L294.9 285.5C248.1 266 197.9 256 147.2 256L112 256C85.5 256 64 277.5 64 304L64 496C64 522.5 85.5 544 112 544L147.2 544C197.9 544 248.1 554 294.9 573.5L307.7 578.8C315.6 582.1 324.4 582.1 332.3 578.8L345.1 573.5C391.9 554 442.1 544 492.8 544L528 544C554.5 544 576 522.5 576 496L576 304C576 277.5 554.5 256 528 256L492.8 256C442.1 256 391.9 266 345.1 285.5L320 296z" />
                        </svg>
                    </div>
                    <h4 class="ms-2 pt-3 pb-2">Case study</h4>
                </div>
                <div class="card shadow-sm rounded">
                    <div class="rounded-top"> <a href="http://localhost:8181/learninghub/working-and-connecting-through-change/" class="text-decoration-none p-0">
                            <img alt="" aria-label="Working and Connecting Through Change" style="height:10vh;" class="card-img-top object-fit-cover rounded-top " src="http://localhost:8181/learninghub/wp-content/uploads/2025/11/Reintegration-1.png">
                        </a> </div>
                    <div class="card-body fs-6">
                        <h5 class="fs-5"><a href="http://localhost:8181/learninghub/working-and-connecting-through-change/">Working and Connecting Through Change</a></h5>
                        <p class="card-text"></p>
                        <p>Change is our only constant, and learning to navigate change isn’t always simple. Working together and leaning on each other for support can clear and […]</p>
                    </div>
                </div>
                <ul class="mt-2">
                    <li><a href="/learninghub/news">Read the latest case studies</a></li>
                </ul>
            </div>
            <div class="col mb-3">
                <div class="d-flex">
                    <div class="flex-shrink-0 blue-fill align-self-start pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="icon-lg">
                            <!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                            <path d="M525.2 82.9C536.7 88 544 99.4 544 112L544 528C544 540.6 536.7 552 525.2 557.1C513.7 562.2 500.4 560.3 490.9 552L444.3 511.3C400.7 473.2 345.6 451 287.9 448.3L287.9 544C287.9 561.7 273.6 576 255.9 576L223.9 576C206.2 576 191.9 561.7 191.9 544L191.9 448C121.3 448 64 390.7 64 320C64 249.3 121.3 192 192 192L276.5 192C338.3 191.8 397.9 169.3 444.4 128.7L491 88C500.4 79.7 513.9 77.8 525.3 82.9zM288 384L288 384.2C358.3 386.9 425.8 412.7 480 457.6L480 182.3C425.8 227.2 358.3 253 288 255.7L288 384z" />
                        </svg>
                    </div>
                    <h4 class="ms-2 pt-3 pb-2">Announcements</h4>
                </div>
                <!-- Add code to bring in announcement titles from posts tagged as announcement -->
                <ul class="ms-3">
                    <li class="mb-2"><a href="#">L@WW Your Time to Learn Q&A results posted</a> <span class="text-muted fs-6">Feb 20, 2026</span></li>
                    <li class="mb-2"><a href="#">New SBCPS cohorts open for registration</a> <span class="text-muted fs-6">Feb 5, 2026</span> </li>
                    <li class="mb-2"><a href="#">Scheduled Moodle outage Feb 14, 2026</a> <span class="text-muted fs-6">Jan 25, 2026</span></li>
                    <li><a href="#">Read all announcements</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <h3>Where the learning happens</h3>
        <p>The LearningHUB includes courses from more than a dozen learning platforms. <a href="/learninghub/learning-systems/">Check out the full list of learning platforms</a>.</p>
        <h4>Featured platforms</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="bg-gov-green card-header pt-3">
                        <h4 class="text-white mb-1">PSA Learning System</h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text">The PSA Learning System has the largest selection of courses available for registration for BCPS employees. It acts as a primary training record for current and completed learning.</p>
                        <ul style="line-height: 1.75;">
                            <li><a href="/learninghub/external_system/psa-learning-system">PSA Learning System course list</a></li>
                            <li><a href="https://learning.gov.bc.ca/CHIPSPLM/signon.html" target="_blank" rel="noopener noreferrer">Visit the PSA Learning System<i class="bi bi-box-arrow-up-right ms-2" aria-hidden="true"></i><span class="visually-hidden"> (opens a new window)</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mt-3 mt-md-0">
                    <div class="bg-gov-green card-header pt-3">
                        <h4 class="text-white mb-1">Your Digital Workplace</h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Your Digital Workplace is the hub for discovering the Microsoft 365 (M365) tools available to BC Public Service employees to support their daily work.</p>
                        <ul style="line-height: 1.75;">
                            <li><a href="/learninghub/external_system/your-digital-workplace">Your Digital Workplace course list</a></li>
                            <li>
                                <a href="https://bcgov.sharepoint.com/:u:/r/SitePages/Home.aspx?csf=1&amp;web=1&amp;e=r2fJcZ" target="_blank" rel="noopener noreferrer">Visit Your Digital Workplace<i class="bi bi-box-arrow-up-right ms-2" aria-hidden="true"></i><span class="visually-hidden"> (opens a new window)</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <?php get_footer() ?>