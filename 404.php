<?php
/**
 * The template for displaying 404 page not found
 *
 */

get_header();

?>
<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
        <div class="container-lg py-4 py-md-5">
            <h1 class="text-white title">Page not found</h1>
        </div>
    </div>
    <div class="bg-light-subtle">
        <div class="container-lg py-4 py-md-5">

			<p>Sorry, we can't find that page.</p>
			<div class="row">
			<div class="col-md-4">
			<div class="card">
			<div class="card-header">
				<h2 class="fs-5">Search</h2>
			</div>
			<div class="card-body">
				<form method="get" action="/learninghub/filter/" data-bs-theme="light" role="search">
					<label for="s" class="visually-hidden">Search</label>
					<input type="search" id="keyword" class="s w-100 form-control" name="keyword" placeholder="Search catalogue" required value="<?php //esc_html($_GET['keyword']) ?>">

						<button type="submit" class="btn btn-secondary" aria-label="Submit Search">
							Search
						</button>

				</form>
			</div>
			</div>
			</div>
			</div>

		</div>
	</div>
</div>
<?php 	

get_footer();
