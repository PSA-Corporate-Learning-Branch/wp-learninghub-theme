<?php get_header() ?> 
<div id="content">
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
                            <?php
                            $recent_courses_args = array(
                                'post_type' => 'course', 
                                'posts_per_page' => 3,
                                'orderby' => 'modified', // Orders by last modified date to show recently added/updated
                                'order' => 'DESC',
                                'post_status' => 'publish'
                            );
                            $recent_courses = new WP_Query($recent_courses_args);

                            if ($recent_courses->have_posts()) :
                            ?>
                            <ul class="card-text" style="line-height: 1.75;">
                                <?php while ($recent_courses->have_posts()) : $recent_courses->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile; ?>
                            </ul>
                            <?php
                                wp_reset_postdata();
                            else :
                            ?>
                                <p class="card-text">No recent courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card shadow-sm mt-3">
                        <div class="card-body fs-6">
                            <h3 class="card-title fs-4">Corporate learning newsletter</h3>
                            <p class="card-text">Stay updated about all things corporate learning with our monthly email newsletter.</p>
                            <a href="https://submit.digital.gov.bc.ca/app/form/submit?f=6632e28b-b8ab-4552-a489-78f6c41bbdc8" target="_blank" class="btn btn-primary">Subscribe to the newsletter</a>
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
        <h3>What's new in corporate learning?</h3> 
        <?php
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
            ?> 
            <div class="row row-cols-1 row-cols-md-2 mt-4">
            <div class="col mb-3">
                <div class="card border-primary shadow border-2 px-1 flex-column h-100">
                    <div class="d-flex">
                        <div class="flex-shrink-0 blue-fill align-self-start icon-square pt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="icon-lg">
                                <!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                                <path d="M288 88C288 74.7 298.7 64 312 64C457.8 64 576 182.2 576 328C576 341.3 565.3 352 552 352C538.7 352 528 341.3 528 328C528 208.7 431.3 112 312 112C298.7 112 288 101.3 288 88zM144 160C170.5 160 192 181.5 192 208L192 432C192 458.5 213.5 480 240 480C266.5 480 288 458.5 288 432C288 405.5 266.5 384 240 384C231.2 384 224 376.8 224 368L224 304C224 295.2 231.2 288 240 288C319.5 288 384 352.5 384 432C384 511.5 319.5 576 240 576C160.5 576 96 511.5 96 432L96 208C96 181.5 117.5 160 144 160zM312 160C404.8 160 480 235.2 480 328C480 341.3 469.3 352 456 352C442.7 352 432 341.3 432 328C432 261.7 378.3 208 312 208C298.7 208 288 197.3 288 184C288 170.7 298.7 160 312 160z" />
                            </svg>
                        </div>
                        <h4 class="ms-2 pt-3 pb-2">Blog</h4>
                    </div>
                    <div class="card rounded mx-3 mb-3">
                        <div class="rounded-top"> <?php if (has_post_thumbnail($recent_post->ID)) : ?> <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($recent_post->ID), 'large'); ?> <a href="<?= the_permalink() ?>" class="text-decoration-none p-0">
                                <img alt="" aria-label="<?= the_title() ?>" style="height:10vh;" class="card-img-top object-fit-cover rounded-top " src="<?php echo $image[0]; ?>">
                            </a> <?php endif; ?> </div>
                        <div class="card-body fs-6">
                            <h5 class="fs-5 card-title"><a href="<?= the_permalink() ?>"><?= the_title() ?></a></h5>
                            <p class="card-text"><?= the_excerpt() ?></p> <?php endwhile;
                        wp_reset_postdata(); // Reset query
                    endif;
                        ?>
                        <!-- TO FIX excerpt isn't going into the card-text p tag, instead adding p below -->
                        </div>
                    </div>
                    <ul class="mx-2 mt-auto">
                        <li><a href="/learninghub/news">Read the latest blog posts</a></li>
                    </ul>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card border-primary shadow border-2 px-2 flex-column h-100">
                    <div class="d-flex">
                        <div class="flex-shrink-0 blue-fill align-self-start icon-square pt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="icon-lg">
                                <!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                                <path d="M525.2 82.9C536.7 88 544 99.4 544 112L544 528C544 540.6 536.7 552 525.2 557.1C513.7 562.2 500.4 560.3 490.9 552L444.3 511.3C400.7 473.2 345.6 451 287.9 448.3L287.9 544C287.9 561.7 273.6 576 255.9 576L223.9 576C206.2 576 191.9 561.7 191.9 544L191.9 448C121.3 448 64 390.7 64 320C64 249.3 121.3 192 192 192L276.5 192C338.3 191.8 397.9 169.3 444.4 128.7L491 88C500.4 79.7 513.9 77.8 525.3 82.9zM288 384L288 384.2C358.3 386.9 425.8 412.7 480 457.6L480 182.3C425.8 227.2 358.3 253 288 255.7L288 384z" />
                            </svg>
                        </div>
                        <h4 class="ms-2 pt-3 pb-2">Announcements</h4>
                    </div>
                    <?php
                    $announcement_args = array(
                        'post_type'      => 'post',
                        'post_status'    => 'publish',
                        'category_name'  => 'announcement',
                        'posts_per_page' => 3,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    );
                    $announcements = new WP_Query($announcement_args);
                    if ($announcements->have_posts()) :
                    ?>
                    <ul class="mx-3 mb-3 fs-6">
                        <?php while ($announcements->have_posts()) : $announcements->the_post(); ?>
                        <li class="mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <span class="text-muted fs-6"><?php echo get_the_date('M j, Y'); ?></span></li>
                        <?php endwhile; ?>
                    </ul>
                    <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                    <p class="mx-3 mb-3">No announcements at this time.</p>
                    <?php endif; ?>
                    <ul class="mx-2 mt-auto">
                        <li><a href="<?php echo esc_url(get_category_link(get_cat_ID('Announcement'))); ?>">Read all announcements</a></li>
                    </ul>
                </div>
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