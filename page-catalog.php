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
    // The production front-end cache only passes a request through to PHP
    // when `s=` appears in the query string; any other query string gets the
    // cached copy of the bare page, so the filters silently do nothing. Until
    // that cache keys on the full query string, every catalog URL must carry
    // `s`, even when it is empty.
    if ( ! isset( $params['s'] ) ) {
        $params['s'] = '';
    }
    return get_permalink() . '?' . http_build_query( $params );
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
                                        <?php // The label belongs on the link: on the wrapping div it has no role to attach to and is ignored. ?>
                                        <div class="badge bg-dark-subtle border-0 fw-normal">
                                            <a href="<?php echo esc_url( lzone_catalog_url( array( 's' => null ) ) ); ?>" class="text-secondary-emphasis text-decoration-none" aria-label="Remove keyword: <?php echo esc_attr( $kw ); ?>">
                                                <span><?php echo esc_html( $kw ); ?></span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
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
                                            <div class="badge bg-dark-subtle fw-normal d-inline-flex mb-1">
                                                <a href="<?php echo esc_url( lzone_catalog_remove_term( $cg['param'], $term->slug ) ); ?>" class="text-secondary-emphasis text-decoration-none" aria-label="Remove <?php echo esc_attr( $cg['label'] ); ?> filter: <?php echo esc_attr( $term->name ); ?>">
                                                    <?php echo esc_html( $term->name ); ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg ms-1 align-text-bottom" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
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
                        <style>
                            /* Everything below only applies when JavaScript is off, so the
                               scripted layout is untouched. Three Bootstrap widgets on this
                               page need JS to operate; without it their content is either
                               unreachable or the control is dead. */

                            /* Accordion: cannot be expanded, so show every filter group
                               open and drop the affordances on the inert toggles. */
                            #filterCategories .accordion-collapse { display: block !important; }
                            #filterCategories .accordion-button { pointer-events: none; }
                            #filterCategories .accordion-button::after { display: none; }

                            /* Course details: each "More info" is a real fragment link to
                               #course-<id>, which Bootstrap only intercepts when it is
                               running. Unintercepted, the click still navigates, so :target
                               reveals that one panel — the same one-at-a-time behaviour the
                               collapse gives, with no change to the markup. */
                            #results .collapse:target { display: block; }

                            /* Expand/Collapse-all are script-only; hide rather than leave
                               two buttons that do nothing. */
                            #expall, #collapseall { display: none; }

                            /* Sort menu: the options are ordinary links, only the disclosure
                               needs JS. Show the list inline and leave the toggle as a label
                               so the current sort is still named. */
                            #results .dropdown-toggle { pointer-events: none; }
                            #results .dropdown-toggle::after { display: none; }
                            #results .dropdown-menu { display: block; position: static; }
                        </style>
                    </noscript>

                    <?php
                    // Duplicate of the .lh-info rules from style.css. The production
                    // cache keys assets by path and ignores ?ver=, so a deployed
                    // style.css can be served stale indefinitely — which once paired
                    // a v1.5 stylesheet with v1.6 markup and left every popover
                    // unopenable. Inlined here, the rules travel with the markup they
                    // belong to and cannot skew against it. Keep in sync with
                    // style.css; remove once the cache keys on the full URL.
                    ?>
                    <style>
                        .lh-info {
                            position: relative;
                            display: inline-block;
                        }

                        .lh-info-btn { color: #767676; }
                        [data-bs-theme=dark] .lh-info-btn { color: #999; }

                        .lh-info-popover {
                            position: absolute;
                            top: 50%;
                            left: 100%;
                            translate: 0 -50%;
                            margin-left: var(--bs-popover-arrow-height, 0.5rem);
                            width: max-content;
                            max-width: min(var(--bs-popover-max-width, 276px), calc(100vw - 2rem));
                            z-index: var(--bs-popover-zindex, 1070);
                        }

                        .lh-info:focus-within .lh-info-popover {
                            display: block !important;
                        }

                        .lh-info-arrow {
                            position: absolute;
                            top: 50%;
                            transform: translateY(-50%);
                        }

                        @media (max-width: 575.98px) {
                            .lh-info-popover {
                                top: 100%;
                                left: auto;
                                right: 0;
                                translate: none;
                                margin: 0.25rem 0 0;
                            }

                            .lh-info-arrow {
                                display: none;
                            }
                        }
                    </style>

                    <?php
                    // A single form wraps all three filter groups, so any combination
                    // of topic / audience / delivery checkboxes is submitted together
                    // by the Apply button below. No JavaScript is involved.
                    ?>
                    <form action="<?php echo esc_url( get_permalink() ); ?>" method="get">
                        <?php
                        // Preserve keyword and sort across a filter submission. `s` is
                        // submitted even when empty: the production cache only lets
                        // ?s= requests through to PHP (see lzone_catalog_url).
                        ?>
                        <input type="hidden" name="s" value="<?php echo esc_attr( $kw ); ?>">
                        <?php if ( $orderby_param !== '' ) : ?>
                            <input type="hidden" name="orderby" value="<?php echo esc_attr( $orderby_param ); ?>">
                        <?php endif; ?>

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
                                        <fieldset>
                                            <legend class="visually-hidden">Filter by <?php echo esc_html( $group['label'] ); ?></legend>

                                            <?php foreach ( $items as $item ) : ?>
                                                <?php
                                                $active   = in_array( $item->slug, $current, true ) ? 'checked' : '';
                                                $has_desc = ! empty( $item->description );
                                                $desc     = $item->description;
                                                $input_id = $group['param'] . $item->term_id;
                                                $desc_id  = $input_id . '-desc';
                                                ?>
                                                <div class="form-check fs-6">
                                                    <input class="form-check-input" type="checkbox" value="<?php echo esc_attr( $item->slug ); ?>" name="<?php echo esc_attr( $group['param'] ); ?>[]" id="<?php echo esc_attr( $input_id ); ?>" <?php echo $has_desc ? 'aria-describedby="' . esc_attr( $desc_id ) . '"' : ''; ?> <?php echo $active; ?>>
                                                    <label for="<?php echo esc_attr( $input_id ); ?>" class="<?php echo $active === 'checked' ? 'fw-semibold' : ''; ?>"><?php echo esc_html( $item->name ); ?></label>
                                                    <?php
                                                    // Description panel: shown by :focus-within when the button takes focus,
                                                    // so no JavaScript is involved. Bootstrap's .popover classes give it the
                                                    // same appearance as the Popper-driven popover this replaced, and the
                                                    // panel doubles as the checkbox's aria-describedby target.
                                                    //
                                                    // The `hidden` attribute — not a stylesheet rule — is what keeps the panel
                                                    // closed, so a stale or missing style.css cannot dump every description
                                                    // onto the page. That means .popover has to sit on an inner element:
                                                    // it carries `display: block`, and an author declaration would override
                                                    // the [hidden] UA rule on the element it shares.
                                                    ?>
                                                    <?php if ( $has_desc ) : ?>
                                                        <span class="lh-info">
                                                            <button type="button" class="lh-info-btn p-0 border-0 bg-transparent align-baseline" aria-label="About <?php echo esc_attr( $item->name ); ?>">
                                                                <span class="icon-svg baseline-svg">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" aria-hidden="true" focusable="false">
                                                                        <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                            <span id="<?php echo esc_attr( $desc_id ); ?>" class="lh-info-popover" role="tooltip" hidden>
                                                                <span class="popover bs-popover-end d-block">
                                                                    <span class="popover-arrow lh-info-arrow"></span>
                                                                    <span class="popover-header d-block"><?php echo esc_html( $group['label'] ); ?> description</span>
                                                                    <span class="popover-body d-block"><?php echo esc_html( $desc ); ?></span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-lg bg-gov-green">Apply filters</button>
                        </div>
                    </form>
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
    // Lightweight enhancement only: Expand/Collapse-all for the course detail
    // panels. All searching, filtering, and sorting are server-rendered above,
    // and the filter term descriptions use the native Popover API — no JS.
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
