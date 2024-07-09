<?php
//
// This is the main filter interface for the LearningHUB.
//
get_header();

// WP_Query takes a "taxquery" an array argument that allows you to query by 
// taxonomy. Let's start building that array.
$taxquery = [];
// We go through each of the 4 taxonomies that we want to filter on:
// group, topic, audience, and delivery method
// If the array exists...
if(!empty($_GET['group'])) {
	$groupterm = $_GET['group'];
	// Wordpress automatically processes arrays passed to it
	$g = array (
		'taxonomy' => 'groups',
		'field' => 'slug',
		'terms' => $groupterm,
	);
	// Add the term(s) array to the query array
	array_push($taxquery, $g);
	// Now we need to look up the names of the terms from the slugs
	// so that we can show them back to the user in the "remove filter"
	// area.
	$gterms = [];
	// Loop through each of the slugs
	foreach($_GET['group'] as $g) {
		// Look up the term object for the slug
		$gterm = get_term_by( 'slug', $g, 'groups');
		// add the result to the array that we can now loop through below.
		array_push($gterms,$gterm);
	}
}

if(!empty($_GET['topic'])) {
	$topicterm = $_GET['topic'];
	$t = array (
		'taxonomy' => 'topics',
		'field' => 'slug',
		'terms' => $topicterm,
	);
	array_push($taxquery, $t);
	// Now we need to look up the names of the terms from the slugs
	// so that we can show them back to the user in the "remove filter"
	// area.
	$tterms = [];
	// Loop through each of the slugs
	foreach($_GET['topic'] as $t) {
		// Look up the term object for the slug
		$tterm = get_term_by( 'slug', $t, 'topics');
		// add the result to the array that we can now loop through below.
		array_push($tterms,$tterm);
	}
}


if(!empty($_GET['audience'])) {
	$audienceterm = $_GET['audience'];
	$a = array (
		'taxonomy' => 'audience',
		'field' => 'slug',
		'terms' => $audienceterm,
	);
	array_push($taxquery, $a);
	// Now we need to look up the names of the terms from the slugs
	// so that we can show them back to the user in the "remove filter"
	// area.
	$aterms = [];
	// Loop through each of the slugs
	foreach($_GET['audience'] as $a) {
		// Look up the term object for the slug
		$aterm = get_term_by( 'slug', $a, 'audience');
		// add the result to the array that we can now loop through below.
		array_push($aterms,$aterm);
	}
}

if(!empty($_GET['delivery_method'])) {
	$dmterm = $_GET['delivery_method'];

	$dm = array (
		'taxonomy' => 'delivery_method',
		'field' => 'slug',
		'terms' => $dmterm,
	);
	array_push($taxquery, $dm);
	// Now we need to look up the names of the terms from the slugs
	// so that we can show them back to the user in the "remove filter"
	// area.
	$dterms = [];
	// Loop through each of the slugs
	foreach($_GET['delivery_method'] as $d) {
		// Look up the term object for the slug
		$dterm = get_term_by( 'slug', $d, 'delivery_method');
		// add the result to the array that we can now loop through below.
		array_push($dterms,$dterm);
	}
}

// This is the main Wordpress query that we pass our $taxquery to.
$post_args = array(
    'post_type'                => 'course',
    'post_status'              => 'publish',
    'posts_per_page'           => -1,
    'ignore_sticky_posts'      => 0,
    'tax_query' 			   => $taxquery,
    'orderby'                  => array(
									'date' =>'DESC',
									'menu_order'=>'ASC'
								), 
    'order'                    => 'ASC',
    'hide_empty'               => 0,
    'hierarchical'             => 1,
    'exclude'                  => '',
    'include'                  => '',
    'number'                   => '',
    'pad_counts'               => true, 
	//'s'						   => 'ethics'
);
$post_my_query = null;
$post_my_query = new WP_Query($post_args);
?>
<style>
/* We hide the form submit button for taxonomy filters by default, 
	but the noscript below will show it if there's no JS. 
	#gracefuldegradation 
*/
.applybutton {
	display: none;
}
</style>
<noscript>
<style>
.applybutton {
	display: block;
}
</style>
</noscript>
<div class="bg-gov-green">
<div class="container">
<div class="row py-5 mb-3">
<div class="col-12">
	<h1 class="">Course Catalogue</h1>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class="col-4" id="filters">

	<div><strong>Groups</strong></div>
	<form action="/learninghub/filter" method="GET" class="p-3 mb-3 bg-body-tertiary rounded-3">
	<?php if(!empty($_GET['topic'])): ?>
	<?php foreach($_GET['topic'] as $tid): ?>
	<input type="hidden" name="topic[]" value="<?= $tid ?>">
	<?php endforeach ?>
	<?php endif ?>
	<?php if(!empty($_GET['audience'])): ?>
	<?php foreach($_GET['audience'] as $aid): ?>
	<input type="hidden" name="audience[]" value="<?= $aid ?>">
	<?php endforeach ?>
	<?php endif ?>
	<?php if(!empty($_GET['delivery_method'])): ?>
	<?php foreach($_GET['delivery_method'] as $did): ?>
	<input type="hidden" name="delivery_method[]" value="<?= $did ?>">
	<?php endforeach ?>
	<?php endif ?>
	<?php 
	$groups = get_categories(
							array(
								'taxonomy' => 'groups',
								'orderby' => 'id',
								'order' => 'DESC',
								'hide_empty' => '0'
							));
	?>
	<?php foreach($groups as $g): ?>
		<?php $active = '' ?>
		<?php if(!empty($_GET['group']) && in_array($g->slug,$_GET['group'])) $active = 'checked' ?>
			<div>
				<label class="<?php if($active == 'checked') echo 'fw-bold' ?>">
					<input class="form-check-input" onChange="this.form.submit()" type="checkbox" value="<?= $g->slug ?>" name="group[]" id="group<?= $g->id ?>" <?= $active ?>>
					<?= $g->name ?>
					(<?= $g->count ?>)
				</label>
			</div>
	<?php endforeach ?>
	<button class="btn btn-sm bg-success mt-2 applybutton">Apply</button>
	</form>

	<div><strong>Topics</strong></div>
	<form action="/learninghub/filter" method="GET" class="p-3 mb-3 bg-body-tertiary rounded-3">
	<?php if(!empty($_GET['group'])): ?>
	<?php foreach($_GET['group'] as $gid): ?>
	<input type="hidden" name="group[]" value="<?= sanitize_text_field($gid) ?>">
	<?php endforeach ?>
	<?php endif ?>
	<?php if(!empty($_GET['audience'])): ?>
	<?php foreach($_GET['audience'] as $aid): ?>
	<input type="hidden" name="audience[]" value="<?= $aid ?>">
	<?php endforeach ?>
	<?php endif ?>
	<?php if(!empty($_GET['delivery_method'])): ?>
	<?php foreach($_GET['delivery_method'] as $did): ?>
	<input type="hidden" name="delivery_method[]" value="<?= $did ?>">
	<?php endforeach ?>
	<?php endif ?>
	<?php 
	$topics = get_categories(
							array(
								'taxonomy' => 'topics',
								'orderby' => 'name',
								'order' => 'ASC',
								'hide_empty' => '0'
							));
	?>
	<?php foreach($topics as $t): ?>
		<?php $active = '' ?>
		<?php if(!empty($_GET['topic']) && in_array($t->slug,$_GET['topic'])) $active = 'checked' ?>
			<div>
				<label class="<?php if($active == 'checked') echo 'fw-bold' ?>">
					<input class="form-check-input" onChange="this.form.submit()" type="checkbox" value="<?= $t->slug ?>" name="topic[]" id="topic<?= $t->id ?>" <?= $active ?>>
					<?= $t->name ?>
					(<?= $t->count ?>)
				</label>
			</div>
	<?php endforeach ?>

	<button class="btn btn-sm bg-success mt-2 applybutton">Apply</button>
	</form>

	<div><strong>Audience</strong></div>
	<form action="/learninghub/filter" method="GET" class="p-3 mb-3 bg-body-tertiary rounded-3">
	<?php if(!empty($_GET['group'])): ?>
	<?php foreach($_GET['group'] as $gid): ?>
	<input type="hidden" name="group[]" value="<?= $gid ?>">
	<?php endforeach ?>
	<?php endif ?>
	<?php if(!empty($_GET['topic'])): ?>
	<?php foreach($_GET['topic'] as $tid): ?>
	<input type="hidden" name="topic[]" value="<?= $tid ?>">
	<?php endforeach ?>
	<?php endif ?>
	<?php if(!empty($_GET['delivery_method'])): ?>
	<?php foreach($_GET['delivery_method'] as $did): ?>
	<input type="hidden" name="delivery_method[]" value="<?= $did ?>">
	<?php endforeach ?>
	<?php endif ?>
	
	<?php 
	$audiences = get_categories(
							array(
								'taxonomy' => 'audience',
								'orderby' => 'id',
								'order' => 'DESC',
								'hide_empty' => '0'
							));
	?>
	<?php foreach($audiences as $a): ?>
		<?php $active = '' ?>
		<?php if(!empty($_GET['audience']) && in_array($a->slug,$_GET['audience'])) $active = 'checked' ?>
			<div>
				<label class="<?php if($active == 'checked') echo 'fw-bold' ?>">
					<input class="form-check-input" onChange="this.form.submit()" type="checkbox" value="<?= $a->slug ?>" name="audience[]" id="audience<?= $a->id ?>" <?= $active ?>>
					<?= $a->name ?>
					(<?= $a->count ?>)
				</label>
			</div>
	<?php endforeach ?>
	<button class="btn btn-sm bg-success mt-2 applybutton">Apply</button>
	</form>


	<div><strong>Delivery Method</strong></div>
	<form action="/learninghub/filter" method="GET" class="p-3 mb-3 bg-body-tertiary rounded-3">
	<?php if(!empty($_GET['group'])): ?>
	<?php foreach($_GET['group'] as $gid): ?>
	<input type="hidden" name="group[]" value="<?= $gid ?>">
	<?php endforeach ?>
	<?php endif ?>
	<?php if(!empty($_GET['topic'])): ?>
	<?php foreach($_GET['topic'] as $tid): ?>
	<input type="hidden" name="topic[]" value="<?= $tid ?>">
	<?php endforeach ?>
	<?php endif ?>
	<?php if(!empty($_GET['audience'])): ?>
	<?php foreach($_GET['audience'] as $auid): ?>
	<input type="hidden" name="audience[]" value="<?= $auid ?>">
	<?php endforeach ?>
	<?php endif ?>
	<?php 
	$dms = get_categories(
							array(
								'taxonomy' => 'delivery_method',
								'orderby' => 'id',
								'order' => 'DESC',
								'hide_empty' => '0'
							)); //,'include' => array(3,37,82,236,410)
	?>
	<?php foreach($dms as $d): ?>
		<?php $active = '' ?>
		<?php if(!empty($_GET['delivery_method']) && in_array($d->slug,$_GET['delivery_method'])) $active = 'checked' ?>
			<div>
				<label class="<?php if($active == 'checked') echo 'fw-bold' ?>">
					<input class="form-check-input" onChange="this.form.submit()" type="checkbox" value="<?= $d->slug ?>" name="delivery_method[]" id="delivery_method<?= $d->id ?>" <?= $active ?>>
					<?= $d->name ?>
					(<?= $d->count ?>)
				</label>
			</div>
	<?php endforeach ?>
	<button class="btn btn-sm bg-success mt-2 applybutton">Apply</button>
	</form>


	</div>
	<div class="col-8">
	<div id="courselist">
	<?php 
	if(!empty($_GET['group']) || !empty($_GET['topic']) || !empty($_GET['audience']) || !empty($_GET['delivery_method'])): 
	// Grab the current URL
	$url = $_SERVER['REQUEST_URI'];
	$currenturl = urldecode($url);
	?>
	<div>
		<strong>Filters</strong> 
	</div>
	<div class="p-3 mb-3 bg-body-tertiary rounded-3">
	<div class="row">
		
		<?php if(!empty($gterms)): ?>
		<div class="col-md-auto">
		<div>Group</div>
		<?php foreach($gterms as $g): ?>
		<?php
		$grpurl = $currenturl;
		$replace = 'group[]=' . $g->slug . '';
		$gurl = str_replace($replace,'',$grpurl);
		$gurl = str_replace('&&','&',$gurl);
		?>
		<div>
		<span class="badge bg-dark-subtle text-dark-emphasis">
			<a href="<?= $gurl ?>" class="text-secondary-emphasis text-decoration-none">x</a> <?= $g->name ?>
		</span>
		</div>
		<?php endforeach ?>
		</div>
		<?php endif ?>
	
		<?php if(!empty($tterms)): ?>
		<div class="col-md-auto">
		<div>Topic</div>
		<?php foreach($tterms as $t): ?>
		<?php
		$topurl = $currenturl;
		$replace = 'topic[]=' . $t->slug . '';
		$turl = str_replace($replace,'',$topurl);
		$turl = str_replace('&&','&',$turl);
		?>
		<div>
		<span class="badge bg-dark-subtle text-dark-emphasis">
			<a href="<?= $turl ?>" class="text-secondary-emphasis text-decoration-none">x</a> <?= $t->name ?>
		</span>
		</div>
		<?php endforeach ?>
		</div>
		<?php endif ?>

		<?php if(!empty($aterms)): ?>
		<div class="col-md-auto">
		<div>Audience</div>
		<?php foreach($aterms as $a): ?>
		<?php
		$audurl = $currenturl;
		$replace = 'audience[]=' . $a->slug . '';
		$aurl = str_replace($replace,'',$audurl);
		$aurl = str_replace('&&','&',$aurl);
		?>
		<div>
		<span class="badge bg-dark-subtle text-dark-emphasis">
			<a href="<?= $aurl ?>" class="text-secondary-emphasis text-decoration-none">x</a> <?= $a->name ?>
		</span>
		</div>
		<?php endforeach ?>
		</div>
		<?php endif ?>

		<?php if(!empty($dterms)): ?>
		<div class="col-md-auto">
		<div>Delivery Method</div>
		<?php foreach($dterms as $d): ?>
		<?php
		$dmurl = $currenturl;
		$replace = 'delivery_method[]=' . $d->slug . '';
		$durl = str_replace($replace,'',$dmurl);
		$durl = str_replace('&&','&',$durl);
		?>
		<div>
		<span class="badge bg-dark-subtle text-dark-emphasis">
			<a href="<?= $durl ?>" class="text-secondary-emphasis text-decoration-none">x</a> <?= $d->name ?>
		</span>
		</div>
		<?php endforeach ?>
		</div>
		<?php endif ?>

		</div>
		<div class="mt-3">
		<a class="btn btn-sm bg-dark-subtle text-dark-emphasis" href="/learninghub/filter/">Clear All</a>
		</div>
	</div>
	<?php endif ?>
    <div class="pt-1 fw-bold" id="coursecount"><?= $post_my_query->found_posts ?> courses</div>
	<div class="mb-3 d-flex p-3 bg-body-tertiary rounded-3">
    <div class="dropdown">
        <button class="btn btn-sm bg-dark-subtle text-dark-emphasis dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sort by
        </button>
        <div class="dropdown-menu bg-dark-subtle text-dark-emphasis">
            <li><a class="sort dropdown-item" data-sort="published" href="#">Most Recent</a></li>
            <li><a class="sort dropdown-item" data-sort="coursename" href="#">Alphabetical</a></li>
            <li><a class="sort dropdown-item" data-sort="dm" href="#">Delivery Method</a></li>
            <li><a class="sort dropdown-item" data-sort="group" href="#">Group</a></li>
            <li><a class="sort dropdown-item" data-sort="audience" href="#">Audience</a></li>
            <li><a class="sort dropdown-item" data-sort="topic" href="#">Topic</a></li>
        </div>
    </div>
	<div class="mx-2">
    	<button id="expall" class="btn btn-sm bg-dark-subtle text-dark-emphasis px-2 d-inline-block">Expand All</button>
    	<button id="collapseall" class="btn btn-sm bg-dark-subtle text-dark-emphasis px-2 d-inline-block">Collapse All</button>
	</div>
</div>
<div class="my-3 d-flex p-3 bg-body-tertiary rounded-3">
	<input class="form-control search" placeholder="Filter these results by keyword" value="<?php echo $_GET['new'] ?>">
</div>
	<div class="list">
	<?php if( $post_my_query->have_posts() ) : ?>

	<?php while ($post_my_query->have_posts()) : $post_my_query->the_post(); ?>

		<?php get_template_part( 'template-parts/course/single-course' ) ?>

	<?php endwhile; ?>
	<?php else : ?>

		<p>Sorry, but there are no courses that match your filters.</p>

	<?php endif; ?>
	</div>

</div>

</div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script type="module">
var options = {
    valueNames: [ 'published', 'coursename', 'group', 'audience', 'topic', 'dm' ]
};

var courseList = new List('courselist', options);

courseList.on('searchComplete', function(){
	let ccount = document.getElementById('coursecount');
	let update = courseList.update().matchingItems.length + ' courses';
	ccount.innerHTML = update;
});
document.addEventListener("DOMContentLoaded", function() {
  courseList.update;
});

</script>
<script type="module">
// 
// Details/Summary niceties
//
// By default, all the courses are hidden behind a details/summary
// and subsequently the description/launch links are as well.
// This supports allowing the learner to choose to "expand all" and 
// show everything on the page all at once, or "collapse all" and 
// hide everything. 
//

// Show everything all in once fell swoop.
let expall = document.getElementById('expall');
let steplist = document.getElementById('courselist');
let deets = steplist.querySelectorAll('details');
expall.addEventListener('click', (e) => {
    Array.from(deets).forEach(function(element) {
        element.setAttribute('open','open');
    });
});
// Conversley, "collapse all" hides everyting open in one fell swoop.
let collapseall = document.getElementById('collapseall');
collapseall.addEventListener('click', (e) => {
    Array.from(deets).forEach(function(element) {
        element.removeAttribute('open');
    });
});
</script>

<?php get_footer(); ?>
