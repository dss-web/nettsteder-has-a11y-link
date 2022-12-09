<?php
/**
 * Check if a site has a link to the accessibility statement.
 *
 * @package     Namespace
 * @author      Per Soderlind
 * @copyright   2021 Per Soderlind
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: A11y link checker
 * Plugin URI: https://github.com/dss-web/nettsteder-has-a11y-link
 * GitHub Plugin URI: https://github.com/dss-web/nettsteder-has-a11y-link
 * Description: Check if a site has a link to the accessibility statement.
 * Version:     1.0.0
 * Author:      Per Soderlind
 * Author URI:  https://soderlind.no
 * Text Domain: nettsteder-has-a11y-link
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Nerwork:     true
 */

declare( strict_types = 1 );
namespace Soderlind\Plugin\Multisite\HasA11yLink;

if ( ! defined( 'ABSPATH' ) ) {
	wp_die();
}
add_filter( 'wpmu_blogs_columns', __NAMESPACE__ . '\\add_a11y_link' );
add_action( 'manage_sites_custom_column', __NAMESPACE__ . '\\populate_a11y_link', 10, 2 );

/**
 * Add a11y link column to the sites list.
 *
 * @param array $columns The columns.
 * @return array
 */
function add_a11y_link( array $columns ) : array {
	$columns['a11y_link'] = 'A11y';
	return $columns;
}

/**
 * Populate the a11y link column.
 *
 * @param string $column_name The column name.
 * @param int    $blog_id The blog id.
 * @return void
 */
function populate_a11y_link( string $column_name, int $blog_id ) : void {
	$data = '';
	if ( 'a11y_link' === $column_name ) {
		$data = get_blog_option( $blog_id, 'options_uu_url', null );
		if ( ! $data ) {
			$data = '<span style="color:red;" class="dashicons dashicons-dismiss"></span>';
		} else {
			$data = sprintf( '<a href="%s" target="_blank"><span class="dashicons dashicons-admin-links"></span></a>', esc_url( $data ) );
		}
	}

	echo $data; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
