<?php
/**
 * /learninghub/filter/ — legacy filter page.
 *
 * Retired in favour of /catalog/. 301 to the new page, translating the old
 * ?keyword= param to ?s= so existing bookmarks (e.g. those still in the
 * intake-process page or scattered through email links) keep working.
 *
 * @package wp-learninghub-theme
 */

$params = $_GET;

if ( isset( $params['keyword'] ) ) {
    if ( $params['keyword'] !== '' && ! isset( $params['s'] ) ) {
        $params['s'] = $params['keyword'];
    }
    unset( $params['keyword'] );
}

$qs = empty( $params ) ? '' : '?' . http_build_query( $params );

wp_safe_redirect( home_url( '/catalog/' . $qs ), 301 );
exit;
