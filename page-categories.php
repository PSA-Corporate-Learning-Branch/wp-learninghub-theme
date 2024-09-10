<?php

/**
 * The template for displaying About the LearningHUB
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
            <h1 class="text-white title">Course Categorization</h1>
        </div>
    </div>
    <div class="bg-secondary-subtle">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">
            <h2>How is learning organized?</h2>
            <p class="mb-5">Three types of categorization help you find exactly what you're looking for: topic, audience, and delivery.</p>
            <p>
                <span class="icon-svg baseline-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                    </svg>
                </span> Select on any category link to open a search results page filtered by that term.
            </p>
            <div class="mt-lg-3 mb-3 card shadow-sm">
                <div class="d-flex bg-gov-green px-3 py-2 rounded-top mb-2">
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
                <div class="row card-body">
                    <?php
                    $topics = get_terms(array(
                        'taxonomy' => 'topics',
                        'hide_empty' => false,
                        'orderby'    => 'alpha',
                        'order'   => 'ASC'
                    ));
                    ?>
                    <?php foreach ($topics as $t) : ?>
                        <div class="col-lg-6  mb-3">
                            <div class="card shadow-sm h-100">
                                <a href="/learninghub/filter/?topic%5B%5D=<?= $t->slug ?>" class="text-decoration-none stretched-link">
                                    <div class="rounded px-3 py-2 m-0 topic-card rounded-bottom-0"><?= $t->name ?></div>
                                </a>
                                <?php $desc = 'No description set';
                                if (!empty($t->description)) $desc = $t->description; ?>
                                <div class="card-body">
                                    <p class="card-text fs-6"><?= $desc ?></p>
                                </div>
                            </div>
                        </div>

                    <?php endforeach ?>
                </div>
            </div>
            <div class="row mb-lg-3 mb-0">
                <div class="col-lg-6 mb-3 mb-lg-0 h-100">
                    <div class="card shadow-sm">
                        <div class="d-flex bg-gov-green px-3 py-2 rounded-top mb-2">
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
                        <div class="card-body">
                            <ul class="card-text">
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
                                        <a href="/learninghub/filter/?audience%5B%5D=<?= $a->slug ?>"><?= $a->name ?></a>:
                                        <?= $a->description ?>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3 mb-lg-0 h-100">
                    <div class="card shadow-sm">
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
                        <div class="card-body">
                            <ul class="card-text">
                                <?php
                                $delivery = get_terms(array(
                                    'taxonomy' => 'delivery_method',
                                    'hide_empty' => false,
                                    'orderby'    => 'count',
                                    'order'   => 'DESC'
                                ));
                                //'include'   => array(65, 83, 119, 163, 567)
                                ?>
                                <?php foreach ($delivery as $d) : ?>
                                    <li>
                                        <a href="/learninghub/filter/?delivery_method%5B%5D=<?= $d->slug ?>"><?= $d->name ?></a>:
                                        <?= $d->description ?>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer() ?>