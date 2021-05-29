<?php
/**
 * Plugin Name: BuddyPress REST API
 * Plugin URI: https://buddypress.org
 * Description: BuddyPress extension for WordPress' JSON-based REST API.
 * Author: The BuddyPress Community
 * Author URI: https://buddypress.org/
 * Version: 0.4.0
 * Text Domain: buddypress
 * Requires at least: 4.9
 * Tested up to: 5.6
 * Requires PHP: 5.6
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package BuddyPress
 * @since 0.1.0
 */

/**
 * Copyright (c) 2020 BuddyPress (email: contact@buddypress.org)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register BuddyPress endpoints.
 *
 * @since 0.1.0
 */
function bp_rest() {
	// Bail early if no core rest support.
	if ( ! class_exists( 'WP_REST_Controller' ) ) {
		return;
	}

	require_once dirname( __FILE__ ) . '/includes/bp-components/classes/class-bp-rest-components-endpoint.php';
	$controller = new BP_REST_Components_Endpoint();
	$controller->register_routes();

	if ( bp_is_active( 'members' ) ) {
		require_once dirname( __FILE__ ) . '/includes/bp-members/classes/class-bp-rest-members-endpoint.php';
		$controller = new BP_REST_Members_Endpoint();
		$controller->register_routes();

		require_once dirname( __FILE__ ) . '/includes/bp-attachments/classes/trait-attachments.php';

		// Support Member's Avatar.
		require_once dirname( __FILE__ ) . '/includes/bp-members/classes/class-bp-rest-attachments-member-avatar-endpoint.php';
		$controller = new BP_REST_Attachments_Member_Avatar_Endpoint();
		$controller->register_routes();

		// Support Member's Cover.
		if ( bp_is_active( 'members', 'cover_image' ) ) {
			require_once dirname( __FILE__ ) . '/includes/bp-members/classes/class-bp-rest-attachments-member-cover-endpoint.php';
			$controller = new BP_REST_Attachments_Member_Cover_Endpoint();
			$controller->register_routes();
		}

		if ( bp_get_signup_allowed() ) {
			require_once dirname( __FILE__ ) . '/includes/bp-members/classes/class-bp-rest-signup-endpoint.php';
			$controller = new BP_REST_Signup_Endpoint();
			$controller->register_routes();
		}
	}

	if ( bp_is_active( 'activity' ) ) {
		require_once dirname( __FILE__ ) . '/includes/bp-activity/classes/class-bp-rest-activity-endpoint.php';
		$controller = new BP_REST_Activity_Endpoint();
		$controller->register_routes();
	}

	if ( bp_is_active( 'blogs' ) ) {
		require_once dirname( __FILE__ ) . '/includes/bp-blogs/classes/class-bp-rest-blogs-endpoint.php';
		$controller = new BP_REST_Blogs_Endpoint();
		$controller->register_routes();

		// Support to Blog Avatar.
		if ( bp_is_active( 'blogs', 'site-icon' ) ) {
			require_once dirname( __FILE__ ) . '/includes/bp-attachments/classes/trait-attachments.php';
			require_once dirname( __FILE__ ) . '/includes/bp-blogs/classes/class-bp-rest-attachments-blog-avatar-endpoint.php';
			$controller = new BP_REST_Attachments_Blog_Avatar_Endpoint();
			$controller->register_routes();
		}
	}

	if ( bp_is_active( 'xprofile' ) ) {
		require_once dirname( __FILE__ ) . '/includes/bp-xprofile/classes/class-bp-rest-xprofile-fields-endpoint.php';
		$controller = new BP_REST_XProfile_Fields_Endpoint();
		$controller->register_routes();

		require_once dirname( __FILE__ ) . '/includes/bp-xprofile/classes/class-bp-rest-xprofile-field-groups-endpoint.php';
		$controller = new BP_REST_XProfile_Field_Groups_Endpoint();
		$controller->register_routes();

		require_once dirname( __FILE__ ) . '/includes/bp-xprofile/classes/class-bp-rest-xprofile-data-endpoint.php';
		$controller = new BP_REST_XProfile_Data_Endpoint();
		$controller->register_routes();
	}

	if ( bp_is_active( 'groups' ) ) {
		require_once dirname( __FILE__ ) . '/includes/bp-groups/classes/class-bp-rest-groups-endpoint.php';
		$controller = new BP_REST_Groups_Endpoint();
		$controller->register_routes();

		require_once dirname( __FILE__ ) . '/includes/bp-groups/classes/class-bp-rest-group-membership-endpoint.php';
		$controller = new BP_REST_Group_Membership_Endpoint();
		$controller->register_routes();

		require_once dirname( __FILE__ ) . '/includes/bp-groups/classes/class-bp-rest-group-invites-endpoint.php';
		$controller = new BP_REST_Group_Invites_Endpoint();
		$controller->register_routes();

		require_once dirname( __FILE__ ) . '/includes/bp-groups/classes/class-bp-rest-group-membership-request-endpoint.php';
		$controller = new BP_REST_Group_Membership_Request_Endpoint();
		$controller->register_routes();

		require_once dirname( __FILE__ ) . '/includes/bp-attachments/classes/trait-attachments.php';
		require_once dirname( __FILE__ ) . '/includes/bp-groups/classes/class-bp-rest-attachments-group-avatar-endpoint.php';
		$controller = new BP_REST_Attachments_Group_Avatar_Endpoint();
		$controller->register_routes();

		// Support to Group Cover.
		if ( bp_is_active( 'groups', 'cover_image' ) ) {
			require_once dirname( __FILE__ ) . '/includes/bp-groups/classes/class-bp-rest-attachments-group-cover-endpoint.php';
			$controller = new BP_REST_Attachments_Group_Cover_Endpoint();
			$controller->register_routes();
		}
	}

	if ( bp_is_active( 'messages' ) ) {
		require_once dirname( __FILE__ ) . '/includes/bp-messages/classes/class-bp-rest-messages-endpoint.php';
		$controller = new BP_REST_Messages_Endpoint();
		$controller->register_routes();
	}

	if ( bp_is_active( 'notifications' ) ) {
		require_once dirname( __FILE__ ) . '/includes/bp-notifications/classes/class-bp-rest-notifications-endpoint.php';
		$controller = new BP_REST_Notifications_Endpoint();
		$controller->register_routes();
	}

	if ( bp_is_active( 'friends' ) ) {
		require_once dirname( __FILE__ ) . '/includes/bp-friends/classes/class-bp-rest-friends-endpoint.php';
		$controller = new BP_REST_Friends_Endpoint();
		$controller->register_routes();
	}
}
add_action( 'bp_rest_api_init', 'bp_rest', 5 );

/**
 * Load functions so that they can also be used out of a REST request.
 *
 * @since 0.1.0
 */
add_action(
	'bp_include',
	function() {
		// BuddyPress is already including the needed functions.
		if ( function_exists( 'bp_rest_namespace' ) ) {
			return;
		}

		require_once dirname( __FILE__ ) . '/includes/functions.php';
	}
);

/**
 * Filter the Blog url in the WP_REST_Request::from_url().
 *
 * @param WP_REST_Request $request Request used to generate the response.
 * @param string          $url     URL being requested.
 * @return WP_REST_Request
 */
function bp_filter_rest_request_blog_url( $request, $url ) {

	if ( ! bp_is_active( 'blogs' ) || empty( $url ) ) {
		return $request;
	}

	// Get url info.
	$bits      = wp_parse_url( $url );
	$home_bits = wp_parse_url( get_home_url() );

	if ( empty( $bits['host'] ) || empty( $home_bits['host'] ) ) {
		return $request;
	}

	// Bail early if the request URL is the same as the current site.
	if ( $bits['host'] === $home_bits['host'] ) {
		return $request;
	}

	// Create a fake request to bypass the current logic.
	$request = new WP_REST_Request( 'GET', $bits['path'] );
	$request->set_query_params( array( 'bp_blogs_url' => $url ) );

	return $request;
}
add_filter( 'rest_request_from_url', 'bp_filter_rest_request_blog_url', 10, 2 );

/**
 * Output BuddyPress blog response.
 *
 * @param WP_REST_Response $response Response generated by the request.
 * @param WP_REST_Server   $instance Server instance.
 * @param WP_REST_Request  $request  Request used to generate the response.
 * @return WP_REST_Response
 */
function bp_rest_post_dispatch( $response, $instance, $request ) {
	global $wpdb;

	if (
		! bp_is_active( 'blogs' )
		|| 404 !== $response->get_status()
		|| 'embed' !== $request->get_param( 'context' )
		|| empty( $request->get_param( 'bp_blogs_url' ) )
		|| empty( $request->get_route() )
	) {
		return $response;
	}

	// Get domain from url.
	$bits = wp_parse_url( $request->get_param( 'bp_blogs_url' ) );

	// We need those two to proceed.
	if ( empty( $bits['host'] ) || empty( $bits['path'] ) ) {
		return $response;
	}

	// Request route and requested URL path should match.
	if ( $request->get_route() !== $bits['path'] ) {
		return $response;
	}

	// Get blog id.
	// @todo update with a cached version.
	// @todo send a patch to BuddyPress core with a way to fetch a single blog object directly,
	// with a blog_id or domain.
	$blog_id = $wpdb->get_var( // phpcs:ignore
		$wpdb->prepare(
			"SELECT blog_id FROM {$wpdb->base_prefix}blogs WHERE domain = %s",
			$bits['host']
		)
	);

	if ( empty( $blog_id ) ) {
		return $response;
	}

	switch_to_blog( absint( $blog_id ) );

	$response = rest_do_request(
		new WP_REST_Request(
			'GET',
			str_replace(
				'/wp-json',
				'',
				$request->get_route()
			)
		)
	);

	restore_current_blog();

	// Return it, regardless if it was successfull or not.
	return $response;
}
add_filter( 'rest_post_dispatch', 'bp_rest_post_dispatch', 10, 3 );
