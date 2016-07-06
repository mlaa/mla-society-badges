<?php
/**
 * Plugin Name: MLA Society Badges
 * Description: Add badges on member avatars to indicate society memberships.
 */

namespace MLA\Commons\Plugin\SocietyBadges;

function add_badges( $img ) {
	$badges = '';
	$member_types = \bp_get_member_type( \bp_get_member_user_id(), false );

	foreach ( $member_types as $type ) {
		$badges .= "<span class=\"society-badge $type\"></span>";
	}

	return $badges . $img;
}
\add_filter( 'bp_member_avatar', __NAMESPACE__ . '\\add_badges' );

function enqueue_style() {
	\wp_enqueue_style( 'mla_society_badges', \plugins_url() . '/mla-society-badges/css/style.css' );
}
\add_action( 'wp_enqueue_scripts',  __NAMESPACE__ . '\\enqueue_style' );
