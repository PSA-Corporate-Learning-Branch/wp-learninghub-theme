<?php
/**
 * Page template for the Catalog page (slug: catalog, post ID 8881).
 *
 * This is the single browse-and-search interface for the LearningHUB:
 *  - Keyword search via ?s=                  (uses the plugin's tax-aware search)
 *  - Filters via ?topic[]/audience[]/delivery_method[]
 *  - Sort via ?orderby=relevance|date|title
 *
 * It replaces the old /filter/ page entirely. There is no list.js — sorting
 * and filtering are server-rendered via WP_Query so behaviour is identical
 * with JS disabled.
 *
 * @package wp-learninghub-theme
 */

// ---------------------------------------------------------------------------
// Build taxonomy filter args from GET params. Slug-based, sanitized.
// ---------------------------------------------------------------------------
$taxquery = array();

$tterms = array();
if ( ! empty( $_GET['topic'] ) && is_array( $_GET['topic'] ) ) {
    $topic_slugs = array_map( 'sanitize_title', $_GET['topic'] );
    $taxquery[]  = array(
        'taxonomy' => 'topics',
        'field'    => 'slug',
        'terms'    => $topic_slugs,
    );
    foreach ( $topic_slugs as $slug ) {
        $tterm = get_term_by( 'slug', $slug, 'topics' );
        if ( $tterm ) {
            $tterms[] = $tterm;
        }
    }
}

$aterms = array();
if ( ! empty( $_GET['audience'] ) && is_array( $_GET['audience'] ) ) {
    $audience_slugs = array_map( 'sanitize_title', $_GET['audience'] );
    $taxquery[]     = array(
        'taxonomy' => 'audience',
        'field'    => 'slug',
        'terms'    => $audience_slugs,
    );
    foreach ( $audience_slugs as $slug ) {
        $aterm = get_term_by( 'slug', $slug, 'audience' );
        if ( $aterm ) {
            $aterms[] = $aterm;
        }
    }
}

$dterms = array();
if ( ! empty( $_GET['delivery_method'] ) && is_array( $_GET['delivery_method'] ) ) {
    $dm_slugs   = array_map( 'sanitize_title', $_GET['delivery_method'] );
    $taxquery[] = array(
        'taxonomy' => 'delivery_method',
        'field'    => 'slug',
        'terms'    => $dm_slugs,
    );
    foreach ( $dm_slugs as $slug ) {
        $dterm = get_term_by( 'slug', $slug, 'delivery_method' );
        if ( $dterm ) {
            $dterms[] = $dterm;
        }
    }
}

$kw = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';

// ---------------------------------------------------------------------------
// Sort handling.
//
//  - With keyword: default = relevance (plugin builds custom CASE ORDER BY).
//  - Without keyword: default = most recent (post_date DESC).
//  - Either way, ?orderby=date | ?orderby=title overrides.
// ---------------------------------------------------------------------------
$allowed_orderby = array( 'relevance', 'date', 'title' );
$orderby_param   = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : '';
if ( ! in_array( $orderby_param, $allowed_orderby, true ) ) {
    $orderby_param = ''; // empty = pick default below
}

if ( $orderby_param === '' ) {
    $orderby_effective = ( $kw !== '' ) ? 'relevance' : 'date';
} else {
    $orderby_effective = $orderby_param;
}

switch ( $orderby_effective ) {
    case 'title':
        $wp_orderby = 'title';
        $wp_order   = 'ASC';
        break;
    case 'date':
        $wp_orderby = 'date';
        $wp_order   = 'DESC';
        break;
    case 'relevance':
    default:
        // 'relevance' is our sentinel — the plugin's posts_orderby filter
        // takes over and emits its CASE-based ranking.
        $wp_orderby = 'relevance';
        $wp_order   = 'DESC';
        break;
}

$post_args = array(
    'post_type'              => 'course',
    'post_status'            => 'publish',
    'posts_per_page'         => -1,
    'ignore_sticky_posts'    => 1,
    'tax_query'              => $taxquery,
    's'                      => $kw,
    'orderby'                => $wp_orderby,
    'order'                  => $wp_order,
    'custom_search'          => 1, // opt in to the plugin's tax-aware search
    'update_post_meta_cache' => false,
);

$post_my_query = new WP_Query( $post_args );

/**
 * Build a URL for the current Catalog page with one query var overridden /
 * removed. Used by the sort dropdown and the active-filter "remove" chips.
 *
 * @param array $overrides Map of param => value. Pass null to remove a param.
 *                         For taxonomy params (topic, audience, delivery_method)
 *                         pass an array of remaining slugs.
 */
function lzone_catalog_url( $overrides = array() ) {
    $params = $_GET;
    foreach ( $overrides as $k => $v ) {
        if ( $v === null || $v === '' || ( is_array( $v ) && empty( $v ) ) ) {
            unset( $params[ $k ] );
        } else {
            $params[ $k ] = $v;
        }
    }
    $base = get_permalink();
    if ( empty( $params ) ) {
        return $base;
    }
    return $base . '?' . http_build_query( $params );
}

/** Helper: URL with a single slug removed from a taxonomy param. */
function lzone_catalog_remove_term( $param, $slug ) {
    $current = isset( $_GET[ $param ] ) && is_array( $_GET[ $param ] ) ? array_map( 'sanitize_title', $_GET[ $param ] ) : array();
    $remaining = array_values( array_diff( $current, array( $slug ) ) );
    return lzone_catalog_url( array( $param => $remaining ) );
}

get_header();
?>
<div id="content">
    <div class="d-flex p-4 p-md-5 align-items-center bg-gov-green bg-gradient" style="height: 12vh; min-height: 100px;">
        <div class="container-lg px-0 px-md-3 py-4 py-md-5">
            <h1 class="mb-0 text-white">Course Catalogue</h1>
        </div>
    </div>
    <div class="bg-secondary-subtle">
        <div class="container-lg p-lg-5 p-4 bg-light-subtle">
            <h2>Find exactly what you're looking for</h2>
            <p>The LearningHUB offers two main ways to find corporate learning: search by keyword and filter by category. Use both together to get as specific as you like.</p>
            <p class="mb-lg-4"><strong>Not sure where to start?</strong> Check out <a href="/learninghub/foundational-corporate-learning/">Mandatory and Foundational learning</a> for all employees and people leaders.</p>

            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0 h-100" id="filters">
                    <div class="mb-3 p-3 card topic-card rounded">
                        <h3 class="h4">Search using a keyword</h3>
                        <p class="fs-6">Find courses that match a keyword in their title, description, or category tags.</p>
                        <form role="search" method="get" action="<?php echo esc_url( get_permalink() ); ?>">
                            <?php // Preserve filter + sort selections when submitting a new keyword. ?>
                            <?php foreach ( array( 'topic', 'audience', 'delivery_method' ) as $p ) : ?>
                                <?php if ( ! empty( $_GET[ $p ] ) && is_array( $_GET[ $p ] ) ) : ?>
                                    <?php foreach ( $_GET[ $p ] as $val ) : ?>
                                        <input type="hidden" name="<?php echo esc_attr( $p ); ?>[]" value="<?php echo esc_attr( $val ); ?>">
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if ( $orderby_param !== '' ) : ?>
                                <input type="hidden" name="orderby" value="<?php echo esc_attr( $orderby_param ); ?>">
                            <?php endif; ?>
                            <div class="d-flex gap-2">
                                <input id="searchfilter" type="search" class="form-control" aria-label="Search" placeholder="Search catalogue by keyword" name="s" value="<?php echo esc_attr( $kw ); ?>">
                                <button type="submit" class="btn bg-gov-green">Search</button>
                            </div>
                        </form>
                    </div>

                    <h3 class="h4 mt-4">Find learning using filters</h3>
                    <p class="fs-6 mb-0">Three <a href="/learninghub/categories/">types of categorization</a> help you find exactly what you're looking for: audience, topic and delivery.</p>

                    <?php
                    $has_any_filter = ( $kw !== '' ) || ! empty( $tterms ) || ! empty( $aterms ) || ! empty( $dterms );
                    if ( $has_any_filter ) :
                        ?>
                        <div class="mb-3">
                            <div class="row">
                                <?php if ( $kw !== '' ) : ?>
                                    <div class="col-md-auto mb-2">
                                        <div>Keyword</div>
                                        <div aria-label="remove keyword: <?php echo esc_attr( $kw ); ?>" class="badge bg-dark-subtle border-0 fw-normal">
                                            <a href="<?php echo esc_url( lzone_catalog_url( array( 's' => null ) ) ); ?>" class="text-secondary-emphasis text-decoration-none">
                                                <span><?php echo esc_html( $kw ); ?></span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1" viewBox="0 0 16 16">
                                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php
                                $chip_groups = array(
                                    array( 'param' => 'topic',           'label' => 'Topic',           'terms' => $tterms ),
                                    array( 'param' => 'audience',        'label' => 'Audience',        'terms' => $aterms ),
                                    array( 'param' => 'delivery_method', 'label' => 'Delivery Method', 'terms' => $dterms ),
                                );
                                foreach ( $chip_groups as $cg ) :
                                    if ( empty( $cg['terms'] ) ) continue;
                                    ?>
                                    <div class="col-md-auto mb-2">
                                        <div><?php echo esc_html( $cg['label'] ); ?></div>
                                        <?php foreach ( $cg['terms'] as $term ) : ?>
                                            <div aria-label="remove filter: <?php echo esc_attr( $term->name ); ?>" class="badge bg-dark-subtle fw-normal d-inline-flex mb-1">
                                                <a href="<?php echo esc_url( lzone_catalog_remove_term( $cg['param'], $term->slug ) ); ?>" class="text-secondary-emphasis text-decoration-none">
                                                    <?php echo esc_html( $term->name ); ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1 align-text-bottom" viewBox="0 0 16 16">
                                                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>

                                <div class="mt-1">
                                    <a class="btn btn-sm btn-secondary" href="<?php echo esc_url( get_permalink() ); ?>">Clear all</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <noscript>
                        <p class="alert alert-info fs-6 mt-2">JavaScript is disabled. Use the <em>Apply</em> button below each filter group to update the list.</p>
                    </noscript>

                    <div class="accordion" id="filterCategories">
                        <?php
                        $filter_groups = array(
                            array(
                                'taxonomy'   => 'topics',
                                'param'      => 'topic',
                                'collapse'   => 'collapseTopics',
                                'heading_id' => 'topicsHeading',
                                'label'      => 'Topic',
                                'subtitle'   => 'What is the learning about?',
                                'orderby'    => 'name',
                            ),
                            array(
                                'taxonomy'   => 'audience',
                                'param'      => 'audience',
                                'collapse'   => 'collapseAudience',
                                'heading_id' => 'audienceHeading',
                                'label'      => 'Audience',
                                'subtitle'   => 'Who is the learning for?',
                                'orderby'    => 'id',
                            ),
                            array(
                                'taxonomy'   => 'delivery_method',
                                'param'      => 'delivery_method',
                                'collapse'   => 'collapseDelivery',
                                'heading_id' => 'deliveryHeading',
                                'label'      => 'Delivery Method',
                                'subtitle'   => 'How is the learning offered?',
                                'orderby'    => 'id',
                            ),
                        );

                        foreach ( $filter_groups as $group ) :
                            $current = isset( $_GET[ $group['param'] ] ) ? (array) $_GET[ $group['param'] ] : array();
                            $items   = get_categories( array(
                                'taxonomy'   => $group['taxonomy'],
                                'orderby'    => $group['orderby'],
                                'order'      => 'ASC',
                                'hide_empty' => 0,
                            ) );
                            $has_active = ! empty( $current );
                            ?>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="<?php echo esc_attr( $group['heading_id'] ); ?>">
                                    <button class="accordion-button text-bg-primary py-2 px-3 py-lg-3 <?php echo $has_active ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $group['collapse'] ); ?>" aria-expanded="<?php echo $has_active ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $group['collapse'] ); ?>">
                                        <div class="d-flex flex-column align-items-start">
                                            <span class="fw-semibold"><?php echo esc_html( $group['label'] ); ?></span>
                                            <span class="fs-6"><small><?php echo esc_html( $group['subtitle'] ); ?></small></span>
                                        </div>
                                    </button>
                                </h4>
                                <div id="<?php echo esc_attr( $group['collapse'] ); ?>" class="accordion-collapse collapse <?php echo $has_active ? 'show' : ''; ?>" aria-labelledby="<?php echo esc_attr( $group['heading_id'] ); ?>">
                                    <div class="accordion-body bg-light-subtle p-3">
                                        <form action="<?php echo esc_url( get_permalink() ); ?>" method="GET">
                                            <?php // Preserve keyword, other taxonomy selections, and sort. ?>
                                            <?php if ( $kw !== '' ) : ?>
                                                <input type="hidden" name="s" value="<?php echo esc_attr( $kw ); ?>">
                                            <?php endif; ?>
                                            <?php if ( $orderby_param !== '' ) : ?>
                                                <input type="hidden" name="orderby" value="<?php echo esc_attr( $orderby_param ); ?>">
                                            <?php endif; ?>
                                            <?php foreach ( $filter_groups as $other ) : ?>
                                                <?php if ( $other['param'] === $group['param'] ) { continue; } ?>
                                                <?php if ( ! empty( $_GET[ $other['param'] ] ) && is_array( $_GET[ $other['param'] ] ) ) : ?>
                                                    <?php foreach ( $_GET[ $other['param'] ] as $val ) : ?>
                                                        <input type="hidden" name="<?php echo esc_attr( $other['param'] ); ?>[]" value="<?php echo esc_attr( $val ); ?>">
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                            <?php foreach ( $items as $item ) : ?>
                                                <?php
                                                $active   = in_array( $item->slug, $current, true ) ? 'checked' : '';
                                                $desc     = ! empty( $item->description ) ? $item->description : 'No description set';
                                                $input_id = $group['param'] . $item->term_id;
                                                ?>
                                                <div class="form-check fs-6">
                                                    <input class="form-check-input" onchange="this.form.submit()" type="checkbox" value="<?php echo esc_attr( $item->slug ); ?>" name="<?php echo esc_attr( $group['param'] ); ?>[]" id="<?php echo esc_attr( $input_id ); ?>" <?php echo $active; ?>>
                                                    <label for="<?php echo esc_attr( $input_id ); ?>" class="<?php echo $active === 'checked' ? 'fw-semibold' : ''; ?>"><?php echo esc_html( $item->name ); ?></label>
                                                    <a aria-label="<?php echo esc_attr( $item->name ); ?>" tabindex="0" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-title="<?php echo esc_attr( $group['label'] ); ?> description" data-bs-content="<?php echo esc_attr( $desc ); ?>">
                                                        <span class="icon-svg baseline-svg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                <path fill="#999" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                            <noscript>
                                                <button type="submit" class="btn btn-sm bg-gov-green mt-2">Apply</button>
                                            </noscript>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div id="results" class="col-lg-7">
                    <h3 class="h4">
                        <?php if ( $kw !== '' ) : ?>
                            Search results for <span class="fw-semibold">&ldquo;<?php echo esc_html( $kw ); ?>&rdquo;</span>
                        <?php else : ?>
                            Course list
                        <?php endif; ?>
                    </h3>
                    <div class="fw-bold mb-2" id="coursecount">
                        <h3 class="h4 fw-semibold">
                            <span class="badge fs-5 bg-gov-blue me-1"><?php echo (int) $post_my_query->found_posts; ?></span>
                            <?php echo $post_my_query->found_posts === 1 ? 'course' : 'courses'; ?> found
                        </h3>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-4 align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Sort:
                                <?php
                                $sort_labels = array(
                                    'relevance' => 'Best match',
                                    'date'      => 'Most recent',
                                    'title'     => 'Alphabetical',
                                );
                                echo esc_html( $sort_labels[ $orderby_effective ] );
                                ?>
                            </button>
                            <ul class="dropdown-menu bg-dark-subtle text-dark-emphasis">
                                <?php if ( $kw !== '' ) : ?>
                                    <li><a class="dropdown-item <?php echo $orderby_effective === 'relevance' ? 'active' : ''; ?>" href="<?php echo esc_url( lzone_catalog_url( array( 'orderby' => 'relevance' ) ) ); ?>">Best match</a></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item <?php echo $orderby_effective === 'date' ? 'active' : ''; ?>" href="<?php echo esc_url( lzone_catalog_url( array( 'orderby' => 'date' ) ) ); ?>">Most recent</a></li>
                                <li><a class="dropdown-item <?php echo $orderby_effective === 'title' ? 'active' : ''; ?>" href="<?php echo esc_url( lzone_catalog_url( array( 'orderby' => 'title' ) ) ); ?>">Alphabetical</a></li>
                            </ul>
                        </div>
                        <button id="expall" type="button" class="btn btn-sm btn-secondary px-2">Expand all</button>
                        <button id="collapseall" type="button" class="btn btn-sm btn-secondary px-2">Collapse all</button>
                    </div>

                    <div class="course-results">
                        <?php if ( $post_my_query->have_posts() ) : ?>
                            <?php while ( $post_my_query->have_posts() ) : $post_my_query->the_post(); ?>
                                <?php get_template_part( 'template-parts/course/single-course' ); ?>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <p>
                                <?php if ( $kw !== '' ) : ?>
                                    Sorry, no courses match <span class="fw-semibold">&ldquo;<?php echo esc_html( $kw ); ?>&rdquo;</span><?php if ( ! empty( $tterms ) || ! empty( $aterms ) || ! empty( $dterms ) ) : ?> with the currently selected filters<?php endif; ?>. Try a different keyword or clear some filters.
                                <?php else : ?>
                                    Sorry, no courses match the selected filters. <a href="<?php echo esc_url( get_permalink() ); ?>">Clear filters</a> to see the full catalogue.
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php wp_reset_postdata(); ?>
<script type="module">
    // Lightweight enhancement only: bootstrap popovers for the filter info
    // icons, and Expand/Collapse-all for the course detail panels. All
    // searching, filtering, and sorting are server-rendered above.
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    [...popoverTriggerList].map(el => new bootstrap.Popover(el));

    document.getElementById('expall').addEventListener('click', function () {
        document.querySelectorAll('#results .collapse').forEach(function (c) {
            new bootstrap.Collapse(c, { show: true }).show();
        });
    });
    document.getElementById('collapseall').addEventListener('click', function () {
        document.querySelectorAll('#results .collapse').forEach(function (c) {
            new bootstrap.Collapse(c, { hide: true }).hide();
        });
    });
</script>
<?php get_footer(); ?>
