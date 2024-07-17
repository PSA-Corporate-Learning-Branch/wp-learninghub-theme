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

$post_args = array(
    'post_type'                => 'course',
    'post_status'              => 'publish',
    'posts_per_page'           => -1
);
$post_my_query = null;
$post_my_query = new WP_Query($post_args);
$nogroups = [];
$noauds = [];
$notops = [];
$nomethods = [];
if( $post_my_query->have_posts() ) : 
while ($post_my_query->have_posts()) : $post_my_query->the_post(); 
    $courseid = get_the_ID();
    $name = get_the_title();
    $slug = basename(get_permalink());
    $grp = get_the_terms($post_my_query->ID, 'groups', '', ', ', ' ');
    $top = get_the_terms($post_my_query->ID, 'topics', '', ', ', ' ');
    $aud = get_the_terms($post_my_query->ID, 'audience', '', ', ', ' ');
    $dm = get_the_terms($post_my_query->ID, 'delivery_method', '', ', ', ' ');
    $ext = get_the_terms($post_my_query->ID, 'external_system', '', ', ', ' ');
    $part = get_the_terms($post_my_query->ID, 'learning_partner', '', ', ', ' ');
    $taxs = [
                $grp[0]->name,
                $top[0]->name,
                $aud[0]->name,
                $dm[0]->name,
                $ext[0]->name,
                $part[0]->name
            ];
    $c = [
            $slug,
            $name,
            $taxs,
            $courseid
        ];
     if(empty($grp[0]->name)) array_push($nogroups, $c);
     if(empty($top[0]->name)) array_push($notops, $c);
     if(empty($aud[0]->name)) array_push($noauds, $c);
     if(empty($dm[0]->name)) array_push($nomethods, $c);
endwhile;
endif; 
?>
<div class="bg-gov-green">
<div class="container">
<div class="row py-5 mb-3 justify-content-md-center">
<div class="col-md-8">
	<h1>Taxonomy Audit</h1>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row justify-content-md-center">
<div class="col-md-8">

<p>Choose a taxonomy to see courses in the catalogue which do NOT have a term applied.</p>

<details>
<summary>Topic <span class="badge bg-warning text-black"><?= count($notops) ?></span></summary>
<?php foreach($notops as $nt): ?>
<div class="p-3 mb-3 bg-light-subtle rounded-3">
<div>
    <a href="/learninghub/course/<?= $nt[0] ?>"><?= $nt[1] ?></a>
    <a href="/learninghub/wp-admin/post.php?post=<?= $nt[3] ?>&action=edit">Edit</a>
</div>
<div>Partner: <?= $nt[2][5] ?></div>
<?php if($nt[2][4] == 'PSA Learning System'): ?>
<div>Platform: <span class="badge bg-primary text-white"><?= $nt[2][4] ?></span></div>
<?php else: ?>
<div>Platform: <?= $nt[2][4] ?></div>
<?php endif ?>
<div>Group: <?= $nt[2][0] ?></div>
<div>Topic: <?= $nt[2][1] ?></div>
<div>Audience: <?= $nt[2][2] ?></div>
<div>Delivery: <?= $nt[2][3] ?></div>
</div>
<?php endforeach ?>
</details>

<details>
<summary>Group <span class="badge bg-warning text-black"><?= count($nogroups) ?></span></summary>
<?php foreach($nogroups as $ng): ?>
<div class="p-3 mb-3 bg-light-subtle rounded-3">
<div>
    <a href="/learninghub/course/<?= $ng[0] ?>"><?= $ng[1] ?></a>
    <a href="/learninghub/wp-admin/post.php?post=<?= $ng[3] ?>&action=edit">Edit</a>
</div>
<div>Partner: <?= $ng[2][5] ?></div>
<?php if($ng[2][4] == 'PSA Learning System'): ?>
<div>Platform: <span class="badge bg-primary text-white"><?= $ng[2][4] ?></span></div>
<?php else: ?>
<div>Platform: <?= $ng[2][4] ?></div>
<?php endif ?>
<div>Group: <?= $ng[2][0] ?></div>
<div>Topic: <?= $ng[2][1] ?></div>
<div>Audience: <?= $ng[2][2] ?></div>
<div>Delivery: <?= $ng[2][3] ?></div>
</div>
<?php endforeach ?>
</details>

<details>
<summary>Audience <span class="badge bg-warning text-black"><?= count($noauds) ?></span></summary>
<?php foreach($noauds as $a): ?>
<div class="p-3 mb-3 bg-light-subtle rounded-3">
<div>
    <a href="/learninghub/course/<?= $a[0] ?>"><?= $a[1] ?></a>
    <a href="/learninghub/wp-admin/post.php?post=<?= $a[3] ?>&action=edit">Edit</a>
</div>
<div>Partner: <?= $a[2][5] ?></div>
<?php if($a[2][4] == 'PSA Learning System'): ?>
<div>Platform: <span class="badge bg-primary text-white"><?= $a[2][4] ?></span></div>
<?php else: ?>
<div>Platform: <?= $a[2][4] ?></div>
<?php endif ?>
<div>Group: <?= $a[2][0] ?></div>
<div>Topic: <?= $a[2][1] ?></div>
<div>Audience: <?= $a[2][2] ?></div>
<div>Delivery: <?= $a[2][3] ?></div>
</div>
<?php endforeach ?>
</details>

<details>
<summary>Delivery Method <span class="badge bg-warning text-black"><?= count($nomethods) ?></span></summary>
<?php foreach($nomethods as $m): ?>
<div><a href="/learninghub/course/<?= $m[0] ?>"><?= $m[1] ?></a></div>
<?php endforeach ?>
</details>
</div>
</div>
<?php 	

get_footer();
