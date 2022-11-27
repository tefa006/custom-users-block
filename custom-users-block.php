<?php
/**
 * Plugin Name: Custom Users Block
 * Author:      Mostafa Magdy
 * Description: Custom Users Block Plugin for testing Purpose for RGBCODE
 * Version: 1
 * Text Domain: custom-users-block
 */

defined( 'ABSPATH' ) || exit;

require __DIR__ . '/lib/class-block.php';
require __DIR__ . '/lib/class-user-profile.php';

/**
 * Block registration.
 */
function user_profile_block_register_block() {
	$asset_file = include plugin_dir_path( __FILE__ ) . 'build/index.asset.php';
	wp_register_script(
		'user-profile-block',
		plugins_url( 'build/index.js', __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version'],
		true
	);

	wp_register_style(
		'user-profile-block',
		plugins_url( 'build/index.css', __FILE__ ),
		array(),
		$asset_file['version']
	);

	$metadata     = json_decode( file_get_contents( __DIR__ . '/src/user-profile/block.json' ), true );
	$user_profile = new \RGBCODE\User_Profile_Block\User_Profile( 'user-profile-block/user-profile' );

	register_block_type(
		'user-profile-block/user-profile',
		array_merge(
			$metadata,
			array(
				'editor_script'   => 'user-profile-block',
				'style'           => 'user-profile-block',
				'render_callback' => array( $user_profile, 'render' ),
			)
		)
	);
}

add_action( 'init', 'user_profile_block_register_block' );
