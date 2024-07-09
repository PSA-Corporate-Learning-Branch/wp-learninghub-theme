<?php
/**
 * The template for displaying all Learning Partners
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
	<h1 class="">Learning Platforms</h1>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class="col-md-6">

<p class="lead p-3 bg-body-tertiary rounded-3">The LearningHUB is a directory of courses available to all BC Public Service employees. It includes courses from more than a dozen platforms.</p>



<h3>Featured Platforms</h3>

<div class="mb-3 p-3 bg-body-tertiary rounded-3">
<h4 class="wp-block-heading">PSA Learning System</h4>

<p>The PSA Learning System has the largest selection of courses available for registration for BCPS employees. It acts as a primary training record for current and completed learning.</p>

<p><a href="https://learning.gov.bc.ca/CHIPSPLM/signon.html">Visit PSALS</a></p>

</div>
<div class="p-3 bg-body-tertiary rounded-3">
<h4 class="wp-block-heading">Learning Curator</h4>

<p>The Learning Curator hosts pathways and activities curated by BC Public Service experts. Choose a pathway and work towards your learning goals at your own pace.</p>

<p><a href="https://learningcurator.gww.gov.bc.ca/">Visit the Curator</a></p>
</div>
</div>
<div class="col-md-6">
<h3 class="wp-block-heading">All Systems</h3>

<p>Select a learning system below to show a list of courses hosted on that platform.</p>

        <div class="p-3 mb-3 bg-body-tertiary rounded-3">
        <?php
        $topics = get_categories(
            array(
                'taxonomy' => 'external_system',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => '1'
            )
        );
        ?>
        <?php foreach ($topics as $t) : ?>
            <?php $active = '';
            if ($t->slug == $topicterm) $active = 'active'; ?>
            <div style="margin:0;padding:0;">
            <a class="<?= $active ?>" href="/learninghub/external_system/<?= $t->slug ?>">
                    <?= $t->name ?>
                </a>
                (<?= $t->count ?>)
            </div>
        <?php endforeach ?>

</div>
</div>
</div>
<?php get_footer() ?>
