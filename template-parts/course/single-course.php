<div class="course p-2 mb-2 bg-body-tertiary border border-secondary-subtle rounded-3">
    <details>
        <summary class="coursename mb-0 ms-3" style="list-style-position: outside;">
            <div class="d-flex justify-content-between">
                <span class="coursename fw-bold"><?= the_title(); ?></span>
                <span class="published d-none"><?= the_date(); ?></span>
                <div class="text-muted text-decoration-none text-end flex-shrink-0 mt-1" style="font-size: 12px;">
                    <div class="ms-3">
                        <div title="Delivery Method">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-inline-block" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path d="M160 64c0-35.3 28.7-64 64-64H576c35.3 0 64 28.7 64 64V352c0 35.3-28.7 64-64 64H336.8c-11.8-25.5-29.9-47.5-52.4-64H384V320c0-17.7 14.3-32 32-32h64c17.7 0 32 14.3 32 32v32h64V64L224 64v49.1C205.2 102.2 183.3 96 160 96V64zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352h53.3C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7H26.7C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z" />
                            </svg>
                            <span class="dm">
                            <?php $dms = get_the_terms($post->ID, 'delivery_method') ?>
                            <a href="/learninghub/filter/?delivery_method[]=<?= $dms[0]->slug ?>"><?= $dms[0]->name ?></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </summary>
        <div class="mt-2 ms-3">
            <?php the_content(); ?>
            <?php if (!empty($post->mandatory_notes)) : ?>
                <div class="mandonotes" style="background-color: #fffede; border-radius: 5px; margin: 1em 0 0 0; padding: 1em;">
                    <?= $post->mandatory_notes ?>
                </div>
            <?php endif ?>

            <?php if (!empty($post->course_link)) : ?>
                <div class="mb-1">
                    <a class="btn btn-primary" href="<?= $post->course_link ?>" target="_blank" rel="noopener">
                        Launch
                        <div class="icon-svg baseline-svg"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                                <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                            </svg></div>
                    </a>
                    <div class="d-inline-block ms-2" style="font-size: 14px">
                        <a title="Permanent link to this course's page" style="text-decoration: none;" href="<?= the_permalink() ?>">
                            <div class="icon-svg baseline-svg"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M6.354 5.5H4a3 3 0 0 0 0 6h3a3 3 0 0 0 2.83-4H9c-.086 0-.17.01-.25.031A2 2 0 0 1 7 10.5H4a2 2 0 1 1 0-4h1.535c.218-.376.495-.714.82-1z" />
                                    <path d="M9 5.5a3 3 0 0 0-2.83 4h1.098A2 2 0 0 1 9 6.5h3a2 2 0 1 1 0 4h-1.535a4.02 4.02 0 0 1-.82 1H12a3 3 0 1 0 0-6H9z" />
                                </svg></div>Course page
                        </a>
                    </div>
                </div>

            <?php else : ?>

            <!-- There's no course link. What to do? -->

            <?php endif ?>
            <div class="text-muted text-decoration-none" style="font-size: 14px;">
                <p>
                    <strong>Partner:</strong>
                    <span class="partners"><?php the_terms($post->ID, 'learning_partner'); ?></span>

                    <?php $exsys = get_the_terms($post->ID, 'external_system', '', ', ', ' ') ?> <br>
                    <?php if (!empty($exsys[0]->name)) : ?>
                        <strong>Platform:</strong> <a class="text-decoration-none" href="/learninghub/external_system/<?= $exsys[0]->slug ?>">
                            <?= $exsys[0]->name ?>
                        </a>
                </p>
            <?php endif ?>

            <div class="d-flex flex-wrap align-items-center gap-3 mb-2">
                <div title="Group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-inline-block" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z" />
                    </svg>
                    <span class="group">
                    <?php $gs = get_the_terms($post->ID, 'groups'); ?>
                    <a href="/learninghub/filter/?group[]=<?= $gs[0]->slug ?>"><?= $gs[0]->name ?></a>
                    </span>
                </div>
                <div title="Audience">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16" height="16" fill="currentColor" class="d-inline-block"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" />
                    </svg>
                    <span class="audience">
                    <?php $au = get_the_terms($post->ID, 'audience'); ?>
                    <a href="/learninghub/filter/?audience[]=<?= $au[0]->slug ?>"><?= $au[0]->name ?></a>
                    </span>
                </div>
                <div title="Topic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="d-inline-block" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M0 80V229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7H48C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                    </svg>
                    <span class="topic">
                    <?php $to = get_the_terms($post->ID, 'topics'); ?>
                    <a href="/learninghub/filter/?topic[]=<?= $to[0]->slug ?>"><?= $to[0]->name ?></a>
                    </span>
                </div>
            </div>
            </div>
            <div class="coursecats mt-1" style="display:none;">
                <?php the_terms($post->ID, 'course_category', 'Categories: ', ', ', ' '); ?>
            </div>
        </div>

    </details>

</div> <!-- /.course -->