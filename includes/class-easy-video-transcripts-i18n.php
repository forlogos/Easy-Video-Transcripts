<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://http://jasonjalbuena.com
 * @since      1.0.0
 *
 * @package    Easy_Video_Transcripts
 * @subpackage Easy_Video_Transcripts/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Easy_Video_Transcripts
 * @subpackage Easy_Video_Transcripts/includes
 * @author     forlogos <jason@jasonjalbuena.com>
 */
class Easy_Video_Transcripts_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'easy-video-transcripts',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
