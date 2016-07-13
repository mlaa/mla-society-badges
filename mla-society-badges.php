<?php
/**
 * Plugin Name: MLA Society Badges
 * Description: Add badges on member avatars to indicate society memberships.
 */

namespace MLA\Commons\Plugin\SocietyBadges;

function add_member_badges( $img ) {
	/**
	 * member profile requires bp_get_displayed_user*()
	 * member directory requires bp_get_member*()
	 */
	if ( $user = \bp_get_displayed_user() ) {
		$user_id = $user->id;
	} else {
		$user_id = \bp_get_member_user_id();
	}

	return add_badges( \bp_get_member_type( $user_id, false ), $img );
}

function add_group_badges( $img ) {
	// group_id for directory, current_group_id for single
	$group_id = \bp_get_group_id() || \bp_get_current_group_id();

	return add_badges( \bp_groups_get_group_type( $group_id, false ), $img );
}

/**
 * helper function used in member, group, & site contexts
 */
function add_badges( $types, $img ) {
	$badges = '';

	if ( $types ) {
		foreach ( $types as $type ) {
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

		\add_filter( 'bp_member_avatar', __NAMESPACE__ . '\\add_member_badges' );
		\add_action( 'wp_enqueue_scripts',  __NAMESPACE__ . '\\enqueue_style' );

	} else if ( \bp_is_groups_directory() || \bp_is_group() ) {

		\add_filter( 'bp_get_group_avatar', __NAMESPACE__ . '\\add_group_badges' );
		\add_action( 'wp_enqueue_scripts',  __NAMESPACE__ . '\\enqueue_style' );

//	} else if ( \bp_is_sites_directory() ) {
//
//		\add_filter( 'bp_site_avatar', __NAMESPACE__ . '\\add_site_badges' );
//		\add_action( 'wp_enqueue_scripts',  __NAMESPACE__ . '\\enqueue_style' );
//
	}

}
\add_filter( 'bp_init', __NAMESPACE__ . '\\init' );
