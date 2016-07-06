<?php
/**
 * Plugin Name: MLA Society Badges
 * Description: Add badges on member avatars to indicate society memberships.
 */

namespace MLA\Commons\Plugin\SocietyBadges;

function add_badges( $img ) {
	$badges = '';

	/**
	 * member profile requires bp_get_displayed_user*()
	 * member directory requires bp_get_member*()
	 */
	if ( $user = \bp_get_displayed_user() ) {
		$user_id = $user->id;
	} else {
		$user_id = \bp_get_member_user_id();
	}

	if ( $member_types = \bp_get_member_type( $user_id, false ) ) {
		foreach ( $member_types as $type ) {
			$badges .= "<span class=\"society-badge $type\"></span>";
		}
	}

	return $badges . $img;
}

function enqueue_style() {
	\wp_enqueue_style( 'mla_society_badges', \plugins_url() . '/mla-society-badges/css/style.css' );
}

function init() {
	if ( \bp_is_members_directory() || \bp_is_user_profile() ) {
		\add_filter( 'bp_member_avatar', __NAMESPACE__ . '\\add_badges' );
		\add_action( 'wp_enqueue_scripts',  __NAMESPACE__ . '\\enqueue_style' );
	}
}
\add_filter( 'bp_init', __NAMESPACE__ . '\\init' );
