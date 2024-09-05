<div class="card shadow-sm rounded mb-2">
    <div class="card-body">
        <h4 class="text-primary h5 mb-0"><?= the_title(); ?></h4>
        <h5 class="published d-none"><?= the_date(); ?></h5>
        <div class="d-flex flex-wrap align-items-center gap-3 mb-2 mt-2 fw-normal text-body-secondary" style="font-size: 0.75rem;">
            <div title="Topic">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-inline-block" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M0 80V229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7H48C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                </svg>
                <span class="topic">
                    <?php $to = get_the_terms($post->ID, 'topics'); ?>
                    <a href="/learninghub/filter/?topic[]=<?= $to[0]->slug ?>" class="text-body-secondary"><?= $to[0]->name ?></a>
                </span>
            </div>
            <div title="Audience">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16" height="16" fill="currentColor" class="d-inline-block"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" />
                </svg>
                <span class="audience">
                    <?php $au = get_the_terms($post->ID, 'audience'); ?>
                    <a href="/learninghub/filter/?audience[]=<?= $au[0]->slug ?>" class="text-body-secondary"><?= $au[0]->name ?></a>
                </span>
            </div>
            <div title="Delivery Method">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-inline-block" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M160 64c0-35.3 28.7-64 64-64H576c35.3 0 64 28.7 64 64V352c0 35.3-28.7 64-64 64H336.8c-11.8-25.5-29.9-47.5-52.4-64H384V320c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v32h64V64L224 64v49.1C205.2 102.2 183.3 96 160 96V64zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352h53.3C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7H26.7C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z" />
                </svg>
                <span class="dm">
                    <?php $dms = get_the_terms($post->ID, 'delivery_method') ?>
                    <a href="/learninghub/filter/?delivery_method[]=<?= $dms[0]->slug ?>" class="text-body-secondary"><?= $dms[0]->name ?></a>
                </span>
            </div>
        </div>

        <details>
            <summary class="fs-6 text-primary ms-3">More info</summary>
            <div class="coursedesc fs-6"><?php the_content(); ?></div>


            <?php if (!empty($post->mandatory_notes)) : ?>
                <div class="mandonotes" style="background-color: #fffede; border-radius: 5px; margin: 1em 0 0 0; padding: 1em;">
                    <?= $post->mandatory_notes ?>
                </div>
            <?php endif ?>


            <div class="fw-semibold" style="font-size: 0.75rem;">
                <p class="mb-0">Partner: <span class="partners fw-normal"><?php the_terms($post->ID, 'learning_partner'); ?></span>

                    <?php $exsys = get_the_terms($post->ID, 'external_system', '', ', ', ' ') ?> </p>
                <p>
                    <?php if (!empty($exsys[0]->name)) : ?>
                        Platform: <span class="fw-normal">
                            <a class="text-decoration-none" href="/learninghub/external_system/<?= $exsys[0]->slug ?>">
                                <?= $exsys[0]->name ?>
                            </a>
                        </span>
                </p>
            <?php endif ?>
            </div>

            <?php if (!empty($post->course_link)) : ?>
                <div class="mt-3">
                    <a class="btn btn-primary" href="<?= $post->course_link ?>" target="_blank" rel="noopener">
                        Launch<span class="visually-hidden"> (opens in new window)</span>
                    </a>
                </div>

            <?php else : ?>

                <!-- There's no course link. What to do? -->

            <?php endif ?>
            <div class="mt-0 text-end" style="font-size: 0.75rem;">
                <a class="fw-normal text-decoration-none" href="<?= the_permalink() ?>">
                    <div class="icon-svg baseline-svg"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M6.354 5.5H4a3 3 0 0 0 0 6h3a3 3 0 0 0 2.83-4H9c-.086 0-.17.01-.25.031A2 2 0 0 1 7 10.5H4a2 2 0 1 1 0-4h1.535c.218-.376.495-.714.82-1z" />
                            <path d="M9 5.5a3 3 0 0 0-2.83 4h1.098A2 2 0 0 1 9 6.5h3a2 2 0 1 1 0 4h-1.535a4.02 4.02 0 0 1-.82 1H12a3 3 0 1 0 0-6H9z" />
                        </svg></div>Direct link to course page
                </a>
            </div>
            <div class="coursekeywords mt-1 d-none">
                <?php the_terms($post->ID, 'keywords', 'Keywords: ', ', ', ' '); ?>
            </div>

        </details>
    </div>


</div> <!-- /.course -->