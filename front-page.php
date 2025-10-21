<?php get_header() ?>
<div style="height: 18vh; min-height: 80px; background: rgba(227,168,43,1);">
 <strong>   Scheduled Moodle Outage – Oct 17 </strong><br>
Please be advised that Moodle LMS will be unavailable on Friday, October 17 starting @ 2pm for scheduled maintenance. The outage is expected to last 2–3 hours, during which time access to all our Moodle courses will be unavailable. We appreciate your patience and understanding.
</div>
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
                    <div class="mt-4 mt-lg-0 card shadow-sm rounded">
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
                                <div class="bg-gov-green rounded-top">
                                    <?php if (has_post_thumbnail($recent_post->ID)) : ?>
                                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($recent_post->ID), 'large'); ?>
                                        <a href="<?= the_permalink() ?>" class="text-decoration-none p-0">
                                            <img alt="" aria-label="<?= the_title() ?>" style="height:12vh;" class="card-img-top object-fit-cover rounded-top opacity-50" src="<?php echo $image[0]; ?>">
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body fs-6">
                                    <h3 class=" card-title fs-4">What's new?</h3>

                                    <h4 class="fs-5"><a href="<?= the_permalink() ?>"><?= the_title() ?></a></h4>
                                    <p class="card-text"><?= the_excerpt() ?></p>
                            <?php endwhile;
                            wp_reset_postdata(); // Reset query
                        endif;
                            ?>
                            <p class="card-text"><a href="/learninghub/news">Read the latest news</a></p>
                                </div>
                    </div>
                </div>
            </div>
            <?php
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
            ?>
                <?php while (have_posts()) : ?>
                    <?php the_post() ?>
                    <?php if (has_post_thumbnail($post->ID)) : ?>
                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large'); ?>
                        <a href="<?= the_permalink() ?>" class="text-decoration-none p-0">
                            <img alt="" aria-label="<?php the_title() ?>" class="mt-4 border border-2 border-gov-blue border-bottom-0 rounded-top w-100 object-fit-contain" src="<?php echo $image[0]; ?>">
                        </a>
                    <?php endif; ?>
                    <div class="bg-gov-blue px-3 py-2 rounded-bottom shadow-sm">
                        <h3 class="text-white mb-0 p-2"><?php the_title() ?></h3>
                    </div>
                <?php endwhile ?>
            <?php endif ?>
        </div>
    </div>

</div>
<div class="bg-secondary-subtle pt-4">
    <div class="container-lg p-lg-5 p-4 bg-light-subtle">
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
</div>
<?php get_footer() ?>
