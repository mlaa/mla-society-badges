<?php
/**
 * Plugin Name: MLA Society Badges
 * Description: Add badges on member avatars to indicate society memberships.
 */

namespace MLA\Commons\Plugin\SocietyBadges;

function add_wrapper( $html ) {
	$member_type = \bp_get_member_type( \bp_get_member_user_id() );
	if ( ! empty( $member_type ) ) {
		$html = "<span class=\"society-badge $member_type\">" . $html . "</span>";
	}
	return $html;
}
\add_filter( 'bp_member_avatar', __NAMESPACE__ . '\\add_wrapper' );

function enqueue_style() {
	\wp_enqueue_style( 'mla_society_badges_style', \plugins_url() . '/mla-society-badges/css/style.css' );
}
\add_action( 'wp_enqueue_scripts',  __NAMESPACE__ . '\\enqueue_style' );
