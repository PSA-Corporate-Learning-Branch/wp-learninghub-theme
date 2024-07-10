<?php
/**
 * The template for displaying all pages of the Course content type. 
 * 
 *
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();
?>
<div class="container-fluid">
<div class="row bg-gov-green p-5 mb-3">
<div class="col-12">
	<?php the_title( '<h1 class="coursehead">', '</h1>' ); ?>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class="col-md-8">

<div class="course">

    <div class="mb-3 p-3 bg-body-tertiary rounded-3 fs-5">
        <?php the_content(); ?>
    </div>    

    <div class="coursemeta">
    <?php the_terms( $post->ID, 'delivery_method', '', ', ', ' ' ); ?>
    <?php the_terms( $post->ID, 'learning_partner', 'offered by ', ', ', ' ' ); ?>
    
    <?php $exsys = get_the_terms( $post->ID, 'external_system', '', ', ', ' ' ) ?>
    <?php if(!empty($exsys[0]->name)): ?>
        via 
        <a class="" href="/learninghub/external_system/<?= $exsys[0]->slug ?>">
            <?= $exsys[0]->name ?>
        </a>
    <?php endif ?>
    </div>
        <?php if(!empty($post->course_link)): ?>
        <div class="my-3">
        <a class="btn btn-lg bg-primary" 
            href="<?= $post->course_link ?>" 
            target="_blank" 
            rel="noopener">
                Launch 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
                    <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
                </svg>
        </a>
        <span style="font-size: 12px">
            <a title="Permanent link to this course\'s page" style="text-decoration: none;" href="<?= the_permalink() ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-link" viewBox="0 0 16 16">
                    <path d="M6.354 5.5H4a3 3 0 0 0 0 6h3a3 3 0 0 0 2.83-4H9c-.086 0-.17.01-.25.031A2 2 0 0 1 7 10.5H4a2 2 0 1 1 0-4h1.535c.218-.376.495-.714.82-1z"/>
                    <path d="M9 5.5a3 3 0 0 0-2.83 4h1.098A2 2 0 0 1 9 6.5h3a2 2 0 1 1 0 4h-1.535a4.02 4.02 0 0 1-.82 1H12a3 3 0 1 0 0-6H9z"/>
                </svg>
            </a>
        </span>
        </div>
        <?php else: ?>

            <div>Oh no! There's something wrong with this course. Please <?php the_terms( $post->ID, 'learning_partner', 'contact', ', ', ' ' ); ?></div>

        <?php endif ?>
        


        <div class="coursecats mt-1" style="display:none;">
            <?php the_terms( $post->ID, 'course_category', 'Categories: ', ', ', ' ' ); ?>
        </div>
        </div>
    



<?php endwhile; // End of the loop. ?>


</div>
<div class="col-md-4" id="filters">

<?php get_template_part('template-parts/sidebar/taxonomies') ?>

	</div>

</div>



<?php

get_footer();