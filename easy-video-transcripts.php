<?php
/**
 * Plugin Name:       Easy Video Transcripts
 * Plugin URI:        https://jasonjalbuena.com/easy-video-transcripts
 * Description:       A plugin made to test making a select block that freaking saves
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.0 pre-release
 * Author:            forlogos
 * Author URI:        https://http://jasonjalbuena.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       easy-video-transcripts
 * Domain Path:       /languages


 * @link              https://http://jasonjalbuena.com
 * @since             1.0.0
 * @package           Easy_Video_Transcripts
 *
 * @wordpress-plugin
 
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function test_test_select_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'test_test_select_block_init' );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EASY_VIDEO_TRANSCRIPTS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-easy-video-transcripts-activator.php
 */
function activate_easy_video_transcripts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-easy-video-transcripts-activator.php';
	Easy_Video_Transcripts_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-easy-video-transcripts-deactivator.php
 */
function deactivate_easy_video_transcripts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-easy-video-transcripts-deactivator.php';
	Easy_Video_Transcripts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_easy_video_transcripts' );
register_deactivation_hook( __FILE__, 'deactivate_easy_video_transcripts' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-easy-video-transcripts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_easy_video_transcripts() {

	$plugin = new Easy_Video_Transcripts();
	$plugin->run();

}
run_easy_video_transcripts();