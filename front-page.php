<?php get_header() ?>
<div id="content">
    <div class="d-flex p-4 p-md-5align-items-center" style="height: 18vh; min-height: 100px; background: rgb(35,64,117); background: linear-gradient(87deg, rgba(35,64,117,1) 0%, rgba(0,120,100,1) 50%, rgba(227,168,43,1) 91%);">
        <div class="container-lg p-4 p-md-5">
            <h1 class="text-white title">Welcome to the LearningHUB</h1>
        </div>
    </div>
</div>

<div class="container-lg pt-4 pt-md-5 px-4 px-md-5">
    <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <h2 class="fs-1">What is corporate learning?</h2>
            <p>In the B.C. Public Service, corporate learning is a shared space. The Learning Centre and its partners offer hundreds of courses, available to all BCPS employees. The LearningHUB is the place to see that full catalogue.</p>
            <a href="/learninghub/filter/" class="btn btn-lg btn-primary">Catalogue of courses</a>
            <div class="topic-card border-2 border rounded shadow-sm p-3 mt-4">
                <div class="d-flex">
                    <div class="icon-square flex-shrink-0 mt-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="green-flag"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z" />
                        </svg></div>
                    <div class="ms-3">
                        <h3 class="gov-green">Start here</h3>
                        <p>Wondering where to start? These learning journeys will guide you.</p>
                        <p class="mb-1"><strong>Learning journeys</strong></p>
                        <ul class="mb-2">
                            <li><a href="/learninghub/foundational-corporate-learning/">All Employees</a></li>
                            <li><a href="/learninghub/foundational-corporate-learning/">People Leaders</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mt-4 card shadow-sm rounded">
                <img src="http://nori.virtuallearn.ca/learninghub/wp-content/uploads/2024/03/Home2.jpg" class="card-img-top object-fit-cover rounded-top" alt="" style="height:18vh; ">
                <div class="card-body">
                    <h3 class="mb-3 text-reset">What's new?</h3>
                    <h4>Improved search</h4>
                    <p class="card-text">Explore new features including course search filters and learning journeys.</p>
                    <a href="/learninghub/about/">About the LearningHUB</a>
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
                    <img class="mt-4 border border-2 rounded-top" style="min-width: 100%" src="<?php echo $image[0]; ?>">
                <?php endif; ?>
                <div class="bg-primary px-3 py-2 rounded-bottom">
                    <h3><a href="<?= the_permalink() ?>"><?php the_title() ?></a></h3>
                </div>
            <?php endwhile ?>
        <?php endif ?>

    </div>
</div>


<div class="container-lg pt-4 pt-md-5 px-4 px-md-5 bg-light">
    <div class="row">
        <div style="padding: 1em;">
            <h3>How is learning organized?</h3>
            <p>Four types of categorization help you find exactly what you're looking for:
                group, audience, topic and delivery. </p>
            <p class="mt-3">

                <strong>Tip:</strong> Click on any category link for search results filtered by that term.
            </p>
            <div class="my-3 p-1">
                <div class="row mb-lg-3 mb-0">
                    <div class="col-lg-6 mb-3 mb-lg-0 h-100" >
                        <div class="shadow-sm">
                            <div class="d-flex bg-gov-green px-3 py-2 rounded-top mb-2" >
                                <div class="icon-square flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 576 512" class="icon "><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path fill="#ffffff" d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white">Group</h4>
                                    <p class="lh-sm fs-6  mb-1">What type of learning is it?</p>
                                </div>
                            </div>
                            <div class="pe-3 pb-3">
                                <ul>
                                    <?php
                                    $groups = get_terms(array(
                                        'taxonomy' => 'groups',
                                        'hide_empty' => false,
                                        'orderby'    => 'alpha',
                                        'order'   => 'DESC'
                                    ));
                                    ?>
                                    <?php foreach ($groups as $g) : ?><li>
                                            <a href="/learninghub/filter/?group[]=<?= $g->slug ?>"><?= $g->name ?>:</a> <?= $g->description ?>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3 mb-lg-0 h-100">
                        <div class="shadow-sm">
                            <div class="d-flex bg-gov-green px-3 py-2 rounded-top mb-2" >
                                <div class="icon-square flex-grow-0 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="icon"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path fill="#fff" d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white">Audience</h4>
                                    <p class="lh-sm fs-6  mb-1  mb-1">Who is the learning for?</p>
                                </div>
                            </div>
                            <div class="pe-3 pb-3">
                                <ul>
                                    <?php
                                    $audiences = get_terms(array(
                                        'taxonomy' => 'audience',
                                        'hide_empty' => false,
                                        'orderby'    => 'count',
                                        'order'   => 'DESC'
                                    )); // 121 = Office of Compt General, 372 = unknown, 144 = labour relations
                                    ?>
                                    <?php foreach ($audiences as $a) : ?>
                                        <li>
                                            <a href="/learninghub/filter/?audience[]=<?= $a->slug ?>"><?= $a->name ?></a>:
                                            <?= $a->description ?>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-lg-3 mb-3">
                    <div class="d-flex bg-gov-green px-3 py-2 rounded-top mb-2" >
                        <div class="icon-square flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="icon"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path fill="#ffffff" d="M0 80V229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7H48C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white">Topic</h4>
                            <p class="lh-sm fs-6  mb-1">What is the learning about?</p>
                        </div>
                    </div>
                    <div class="row px-2">
                        <?php
                        $topics = get_terms(array(
                            'taxonomy' => 'topics',
                            'hide_empty' => false,
                            'orderby'    => 'alpha',
                            'order'   => 'ASC'
                        ));
                        ?>
                        <?php foreach ($topics as $t) : ?>
                            <div class="col-lg-6 col-12 p-0">
                                <a href="/learninghub/filter/?topic[]=<?= $t->slug ?>" class="text-decoration-none">
                                    <div class="border rounded shadow-sm px-3 py-2 m-1 topic-card"><?= $t->name ?></div>
                                </a>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-8 h-100">
                        <div class="shadow-sm">
                            <div class="d-flex bg-gov-green px-3 py-2 rounded-top mb-2">
                                <div class="icon-square flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="icon"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path fill="#ffffff" d="M160 64c0-35.3 28.7-64 64-64H576c35.3 0 64 28.7 64 64V352c0 35.3-28.7 64-64 64H336.8c-11.8-25.5-29.9-47.5-52.4-64H384V320c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v32h64V64L224 64v49.1C205.2 102.2 183.3 96 160 96V64zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352h53.3C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7H26.7C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white">Delivery Method</h4>
                                    <p class="lh-sm fs-6  mb-1">How is the learning offered?</p>
                                </div>
                            </div>
                            <div class="pe-3 pb-3">
                                <ul>
                                    <?php
                                    $delivery = get_terms(array(
                                        'taxonomy' => 'delivery_method',
                                        'hide_empty' => false,
                                        'orderby'    => 'count',
                                        'order'   => 'DESC',

                                    ));
                                    //'include'   => array(65, 83, 119, 163, 567)
                                    ?>
                                    <?php foreach ($delivery as $d) : ?>
                                        <li>
                                            <a href="/learninghub/filter/?delivery_method[]=<?= $d->slug ?>"><?= $d->name ?></a>:
                                            <?= $d->description ?>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h3 class="fs-3">Accommodations</h3>
                                <p class="card-text">Please let us know if you require course materials in alternate formats or if you require other accommodation to successfully attend a course. <a href="https://sfs7.gov.bc.ca/affwebservices/public/saml2sso?SPID=urn:ca:bc:gov:customerportal:prod">Submit an AskMyHR service request</a> using the category "Learning Centre". The Learning Centre will endeavour to accommodate your request.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php get_footer() ?>