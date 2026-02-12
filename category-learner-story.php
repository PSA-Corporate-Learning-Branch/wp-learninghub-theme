<?php get_header(); ?>

<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
        <div class="container-lg py-4 py-md-5">
            <h1 class="text-white mb-0">Learning Stories</h1>
        </div>
    </div>
    <div class="bg-secondary-subtle">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">
            <p>Read how BC Public Service employees are using corporate learning to grow, connect and make a difference.</p>
            <?php if (have_posts()) : ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                <?php while (have_posts()) : the_post(); ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <?php if (has_post_thumbnail()) : ?>
                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large'); ?>
                        <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                            <img alt="" aria-label="<?php the_title_attribute(); ?>" style="height: 15vh;" class="card-img-top object-fit-cover" src="<?php echo $image[0]; ?>">
                        </a>
                        <?php endif; ?>
                        <div class="card-body fs-6 d-flex flex-column">
                            <h2 class="fs-5 card-title"><a href="<?php the_permalink(); ?>" class="text-decoration-none"><?php the_title(); ?></a></h2>
                            <p class="card-text"><?php the_excerpt(); ?></p>
                            <span class="text-muted mt-auto" style="font-size: 0.75rem;"><?php echo get_the_date('M j, Y'); ?></span>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="mt-4">
                <?php the_posts_pagination(array(
                    'prev_text' => '&laquo; Previous',
                    'next_text' => 'Next &raquo;',
                    'class'     => 'pagination justify-content-center',
                )); ?>
            </div>
            <?php else : ?>
            <p>No learning stories at this time.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
