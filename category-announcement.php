<?php get_header(); ?>

<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
        <div class="container-lg py-4 py-md-5">
            <h1 class="text-white mb-0">Announcements</h1>
        </div>
    </div>
    <div class="bg-secondary-subtle">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">
            <p>Stay up to date with the latest announcements from the Corporate Learning Branch.</p>
            <?php if (have_posts()) : ?>
            <div class="row">
                <?php while (have_posts()) : the_post(); ?>
                <div class="col-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <h2 class="h5 mb-1"><a href="<?php the_permalink(); ?>" class="text-decoration-none"><?php the_title(); ?></a></h2>
                                <span class="text-muted fs-6 text-nowrap ms-3"><?php echo get_the_date('M j, Y'); ?></span>
                            </div>
                            <div class="fs-6 mt-2"><?php the_excerpt(); ?></div>
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
            <p>No announcements at this time.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
