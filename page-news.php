    <?php
/**
 * The template for displaying all single posts
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
            <h1 class="text-white title">Learning News </h1>
        </div>
    </div>

    <div class="bg-secondary-subtle pt-4">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">


<div class="row">
<div class="col-md-7">



<?php
$args = array(
	'numberposts' => 10
);
?>
<?php $latest_posts = get_posts( $args ) ?>
<?php foreach($latest_posts as $post) : ?>
<?php setup_postdata( $post ) ?>
<div class="card mb-3">
	
        <?php if($post->news_link): ?>
        <a class="card-img-top" href="<?php echo $post->news_link ?>" target="_blank" rel="noopener" title="<?php the_title() ?>">
            <?php the_post_thumbnail(); ?>
		</a>
        <?php else: ?>
		<a class="card-img-top" href="<?php the_permalink() ?>"  title="<?= the_title() ?>">
            <?php the_post_thumbnail(); ?>
		</a>
        <?php endif ?>

        <div class="card-body">
        
        <?php if($post->news_link): ?>
        <h3>
            <a href="<?php echo $post->news_link ?>" target="_blank" rel="noopener" title="<?php the_title() ?>">
				<?php the_title() ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
                    <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
                </svg>
			</a>
		</h3>
        <?php else: ?>
        <h3>
			<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
				<?php the_title() ?>
			</a>
		</h3>
        <?php endif ?>

    
        <?php the_content(); ?>
    </div>
    <!-- <a href="<?= the_permalink() ?>">Read More</a> -->
</div>

<?php endforeach ?>


</div>
<div class="col-md-5">


<?php get_template_part('template-parts/sidebar/taxonomies') ?>

</div>
</div>
</div>
</div>





<?php get_footer() ?>