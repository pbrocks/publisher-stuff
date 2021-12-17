<?php
/**
 * [base_block_welcome description]
 *
 * @return [type] [description]
 */
function base_block_welcome() {
	if ( ! get_transient( 'base_block_activated' ) ) {
		return;
	}

	// Delete the plugin activated transient
	delete_transient( 'base_block_activated' );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page' => 'base-block-tabs.php',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}

add_action( 'admin_init', 'base_block_welcome', 11 );

/**
 * [create_base_block_panel description]
 *
 * Adding a block category creates a Panel
 *
 * @param  [type] $categories [description]
 * @param  [type] $post       [description]
 * @return [type]             [description]
 */
function create_base_block_panel( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'base-block',
				'title' => __( 'Base Block Panel', 'base-block' ),
			),
		)
	);
}
add_filter( 'block_categories', 'create_base_block_panel', 10, 2 );
