<?php get_header() ?>
<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center" style="height: 18vh; min-height: 100px; background: rgb(35,64,117); background: linear-gradient(87deg, rgba(35,64,117,1) 0%, rgba(0,120,100,1) 50%, rgba(227,168,43,1) 91%);">
        <div class="container-lg py-4 py-md-5">
            <h1 class="text-white title">Welcome to the LearningHUB</h1>
        </div>
    </div>
    <div class="bg-light-subtle">
        <div class="container-lg py-4 py-md-5">
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2>What is corporate learning?</h2>
                    <p>In the B.C. Public Service, corporate learning is a shared space. The Learning Centre and its partners offer hundreds of courses, available to all BCPS employees. The LearningHUB is the place to see that full catalogue.</p>
                    <a href="/learninghub/filter/" class="btn btn-lg btn-primary">Course catalogue</a>
                    <div class="topic-card border-2 border rounded shadow-sm p-3 mt-4">
                        <div class="d-flex">
                            <div class="icon-square flex-shrink-0 mt-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="green-flag"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z" />
                                </svg></div>
                            <a href="/learninghub/foundational-corporate-learning/" class="text-decoration-none">
                            <div class="ms-3">
                                <h3 class="gov-green">Start here</h3>
                                <p><span class="text-decoration-underline">Foundational learning</span> for all employees and people leaders in their first year and beyond.</p>
                                <!-- <p class="mb-1"><strong>Learning journeys</strong></p>
                                <ul class="mb-2">
                                    <li><a href="/learninghub/foundational-corporate-learning/">All Employees</a></li>
                                    <li><a href="/learninghub/foundational-corporate-learning/">People Leaders</a></li>
                                </ul> -->
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mt-4 mt-lg-0 card shadow-sm rounded">
                        <div class="bg-gov-green rounded-top"><img src="https://wordpress.virtuallearn.ca/learninghub/wp-content/uploads/2024/03/Home2.jpg" class="card-img-top object-fit-cover rounded-top opacity-50" alt="" style="height:12vh;"></div>
                        <div class="card-body fs-6">
                            <h3 class=" card-title fs-4">What's new?</h3>
                            <h4 class="fs-4"><a href="/learninghub/using-race-and-ethnicity-data-webinar/">Using Race and Ethnicity Data Webinar</a></h4>
                            <p class="card-text">Learn about best practices, risks, and common pitfalls involved in the use of race and ethnicity data in research.</p>
                            <p class="card-text"><a href="/learninghub/news">Read the latest news</a></p>
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
                            <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                            <a href="<?= the_permalink() ?>" class="text-decoration-none"><img class="mt-4 border border-2 border-bottom-0 rounded-top" style="min-width: 100%" src="<?php echo $image[0]; ?>">
                            <?php endif; ?>
                            <div class="bg-gov-blue px-3 py-2 rounded-bottom shadow-sm">
                                <h3 class="text-white mb-0 p-2"><?php the_title() ?></h3>
                            </div>
                            </a>
                        <?php endwhile ?>
                    <?php endif ?>

            </div>
        </div>
    </div>
</div>
<?php get_footer() ?>