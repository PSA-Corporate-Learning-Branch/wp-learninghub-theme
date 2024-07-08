<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>
<div class="bg-gov-green">
<div class="container">
<div class="row py-5 mb-3">
<div class="col-12">
	<h1 class="">Keyword Search</h1>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">

    <div class="col-md-8">
        <?php if (have_posts()) : ?>
            <div class="p-3 mb-3 bg-body-tertiary rounded-3">
                <?php
                $resultcount = (int) $wp_query->found_posts;
                $plural = 'course';
                if ($resultcount > 0) $plural = 'courses';
                ?>
                We found
                <span class="badge bg-body-secondary text-body-emphasis">
                    <?= $resultcount ?>
                </span>
                <?= $plural ?> which match your search for
                <?php
                printf(
                    /* translators: %s: Search term. */
                    esc_html__('"%s"', 'twentytwentyone'),
                    '<span class="page-description search-term">' . esc_html(get_search_query()) . '</span>'
                );
                ?>
            </div>
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/course/single-course') ?>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Oh no! There are no courses that match your filters.</p>
        <?php endif; ?>

    </div>
    <div class="col-md-4" id="filters">
    
        <div><strong>Groups</strong></div>
        <div class="p-3 mb-3 bg-body-tertiary rounded-3">
        <?php
        $groups = get_categories(
            array(
                'taxonomy' => 'groups',
                'orderby' => 'id',
                'order' => 'DESC',
                'hide_empty' => '0'
            )
        );
        ?>
        <?php foreach ($groups as $g) : ?>
            <?php $active = '';
            if ($g->slug == $groupterm) $active = 'active'; ?>
            <div style="margin:0;padding:0;">
            <a class="<?= $active ?>" href="/learninghub/filter/?group[]=<?= $g->slug ?>">
                    <?= $g->name ?>
                </a>
                (<?= $g->count ?>)
            </div>
        <?php endforeach ?>
        </div>
        <div><strong>Topics</strong></div>
        <div class="p-3 mb-3 bg-body-tertiary rounded-3">
        <?php
        $topics = get_categories(
            array(
                'taxonomy' => 'topics',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => '0'
            )
        );
        ?>
        <?php foreach ($topics as $t) : ?>
            <?php $active = '';
            if ($t->slug == $topicterm) $active = 'active'; ?>
            <div style="margin:0;padding:0;">
            <a class="<?= $active ?>" href="/learninghub/filter/?topic[]=<?= $t->slug ?>">
                    <?= $t->name ?>
                </a>
                (<?= $t->count ?>)
            </div>
        <?php endforeach ?>
        </div>
        <div><strong>Audience</strong></div>
        <div class="p-3 mb-3 bg-body-tertiary rounded-3">
        <?php
        $audiences = get_categories(
            array(
                'taxonomy' => 'audience',
                'orderby' => 'id',
                'order' => 'ASC',
                'hide_empty' => '0'
            )
        );
        ?>
        <?php foreach ($audiences as $a) : ?>
            <?php $active = '';
            if ($a->slug == $audienceterm) $active = 'active'; ?>
            <div style="margin:0;padding:0;">
            <a class="<?= $active ?>" href="/learninghub/filter/?audience[]=<?= $a->slug ?>">
                    <?= $a->name ?>
                </a>
                (<?= $a->count ?>)
            </div>
        <?php endforeach ?>
        </div>
        <div><strong>Delivery Method</strong></div>
        <div class="p-3 mb-3 bg-body-tertiary rounded-3">
        <?php
        $dms = get_categories(
            array(
                'taxonomy' => 'delivery_method',
                'orderby' => 'id',
                'order' => 'ASC',
                'hide_empty' => '0',
                // 'include'   => array(65, 83, 119, 163, 567)
            )
        );
        ?>
        <?php foreach ($dms as $d) : ?>
            <?php $active = '';
            if ($d->slug == $dmterm) $active = 'active'; ?>
            <div style="margin:0;padding:0;">
            <a class="<?= $active ?>" href="/learninghub/filter/?delivery_method[]=<?= $d->slug ?>">
                    <?= $d->name ?>
                </a>
                (<?= $d->count ?>)
            </div>
        <?php endforeach ?>
        </div>

    </div>
</div>


<?php get_footer(); ?>