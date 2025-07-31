<?php

/**
 * The template for displaying all pages of the Course content type. 
 * 
 *
 */

get_header();

/* Start the Loop */
while (have_posts()) :
    the_post();
?>
    <div id="content">
        <div class="d-flex p-4 p-lg-5 align-items-center bg-gov-green" style="height: 12vh; min-height: 100px;">
            <div class="container-lg py-4 py-lg-5">
                <h1 class="text-white">Course Details</h1>

            </div>
        </div>
        <div class="bg-secondary-subtle">
            <div class="container-lg p-lg-5 p-4 bg-light-subtle">
                <div class="row mx-0">
                    <div class="col-lg-8">
                        <h2><?php the_title(); ?></h2>
                        <?php the_content(); ?>
                        <?php if (!empty($post->mandatory_notes)) : ?>
                            <div class="mandonotes" style="background-color: #fffede; border-radius: 5px; margin: 1em 0 0 0; padding: 1em;">
                                <?= $post->mandatory_notes ?>
                            </div>
                        <?php endif ?>

                        <?php if (!empty($post->course_link)) : ?>
                            <?php if (!empty($post->persist_state != 'inactive')) : ?>

                                <div class="mt-3">
                                    <a class="btn btn-primary" href="<?= $post->course_link ?>" target="_blank" rel="noopener">
                                        Launch<span class="visually-hidden"> (opens in new window)</span>
                                    </a>
                                </div>

                            <?php else : ?>
                                <div class="alert alert-warning mt-3">
                                    <?= $post->persist_message ?>
                                </div>
                                <a class="" href="<?= $post->course_link ?>" target="_blank" rel="noopener">
                                        View the registration page<span class="visually-hidden"> (opens in new window)</span>
                                    </a>
                            <?php endif ?>

                        <?php else : ?>

                            <!-- There's no course link. What to do? -->

                        <?php endif ?>


                        <div class="fw-normal border-top pt-3 mt-4">
                            <h3 class="h4">About this course</h3>
                            <div class="fw-semibold">
                            <div title="Topic">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-inline-block" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M0 80V229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7H48C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                    </svg>
                                    <span class="topic">Topic:
                                        <?php $to = get_the_terms($post->ID, 'topics'); ?>
                                        <a href="/learninghub/filter/?topic[]=<?= $to[0]->slug ?>" class=" fw-normal"><?= $to[0]->name ?></a>
                                    </span>
                                </div>

                                <div title="Audience">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16" height="16" fill="currentColor" class="d-inline-block"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" />
                                    </svg>
                                    <span class="audience">Audience:
                                        <?php $au = get_the_terms($post->ID, 'audience'); ?>
                                        <a href="/learninghub/filter/?audience[]=<?= $au[0]->slug ?>" class=" fw-normal"><?= $au[0]->name ?></a>
                                    </span>
                                </div>
                                <div title="Delivery Method">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-inline-block" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M160 64c0-35.3 28.7-64 64-64H576c35.3 0 64 28.7 64 64V352c0 35.3-28.7 64-64 64H336.8c-11.8-25.5-29.9-47.5-52.4-64H384V320c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v32h64V64L224 64v49.1C205.2 102.2 183.3 96 160 96V64zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352h53.3C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7H26.7C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z" />
                                    </svg>
                                    <span class="dm">Delivery Method:
                                        <?php $dms = get_the_terms($post->ID, 'delivery_method') ?>
                                        <a href="/learninghub/filter/?delivery_method[]=<?= $dms[0]->slug ?>" class=" fw-normal"><?= $dms[0]->name ?></a>
                                    </span>
                                </div>
                                <p class="mb-0">Partner: <span class="partners fw-normal text-decoration-underline"><?php the_terms($post->ID, 'learning_partner'); ?></span>

                                    <?php $exsys = get_the_terms($post->ID, 'external_system', '', ', ', ' ') ?> </p>
                                <?php if (!empty($exsys[0]->name)) : ?><p class="mb-0">

                                        Platform: <span class="fw-normal">
                                            <a class="" href="/learninghub/external_system/<?= $exsys[0]->slug ?>">
                                                <?= $exsys[0]->name ?>
                                            </a>
                                        </span>
                                    </p>
                                <?php endif ?>
                                
                            </div>
                            <div class="coursecats mt-1" style="display:none">
                                <?php the_terms($post->ID, 'keywords', 'Keywords: ', ', ', ' '); ?>
                            </div>

                        <?php endwhile; // End of the loop. 
                        ?>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <?php get_template_part('template-parts/sidebar/taxonomies') ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php

    get_footer();
