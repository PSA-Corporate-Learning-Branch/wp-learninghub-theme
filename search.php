<?php
/**
 * /?s=KEYWORD — legacy WordPress search URL.
 *
 * The single browse-and-search interface now lives at /catalog/. Forward any
 * direct hit on the old search URL to the canonical page, preserving all
 * query params (s, topic[], audience[], delivery_method[], orderby).
 *
 * @package wp-learninghub-theme
 */

$qs = isset( $_SERVER['QUERY_STRING'] ) && $_SERVER['QUERY_STRING'] !== ''
    ? '?' . $_SERVER['QUERY_STRING']
    : '';

wp_safe_redirect( home_url( '/catalog/' . $qs ), 301 );
exit;
