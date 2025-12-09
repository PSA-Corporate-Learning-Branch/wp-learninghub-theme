<div class="card topic-card mt-lg-0 mt-3">
    <div class="card-body">
        <h4 class="card-title">Looking for something else?</h4>
        <h5>Search using keywords</h5>
        <p class="fs-6">Find courses that use a specific keyword in their title or description.</p>
        <form method="get" action="/learninghub/filter/" class="row g-2 mb-3" role="search">
            <label for="sSide" class="visually-hidden">Search</label>
            <div class="col-auto flex-grow-1">
                <input type="search" id="sSide" class="form-control" name="keyword" placeholder="Search the catalogue" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm" aria-label="Submit Search">
                    Keyword search
                </button>
            </div>
        </form>
        <h5>Find learning using filters</h5>
        <p class="fs-6">Narrow down course results by using filters. Three types of categorization help you find exactly what you're looking for: audience, topic and delivery.</p>
        <a href="/learninghub/filter/" class="btn btn-primary btn-sm">Filter search</a>

        <?php if (isset($args['termid'])) : ?>
            <h5>Are you a partner administrator?</h5>
            <p>Looking to update the courses for this Corporate Learning Partner?</p>
            <div><a href="https://gww.bcpublicservice.gov.bc.ca/learning/hub/partners/dashboard.php?partnerid=<?= $args['termid']; ?>" class="btn btn-sm btn-primary">Administer this partner</a></div>
        <?php endif; ?>

    </div>
</div>
