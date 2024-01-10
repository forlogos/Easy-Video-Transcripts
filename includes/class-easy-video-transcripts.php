<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://http://jasonjalbuena.com
 * @since      1.0.0
 *
 * @package    Easy_Video_Transcripts
 * @subpackage Easy_Video_Transcripts/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Easy_Video_Transcripts
 * @subpackage Easy_Video_Transcripts/includes
 * @author     forlogos <jason@jasonjalbuena.com>
 */
class Easy_Video_Transcripts {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Easy_Video_Transcripts_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'EASY_VIDEO_TRANSCRIPTS_VERSION' ) ) {
			$this->version = EASY_VIDEO_TRANSCRIPTS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'easy-video-transcripts';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Easy_Video_Transcripts_Loader. Orchestrates the hooks of the plugin.
	 * - Easy_Video_Transcripts_i18n. Defines internationalization functionality.
	 * - Easy_Video_Transcripts_Admin. Defines all hooks for the admin area.
	 * - Easy_Video_Transcripts_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-easy-video-transcripts-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-easy-video-transcripts-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-easy-video-transcripts-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-easy-video-transcripts-public.php';

		$this->loader = new Easy_Video_Transcripts_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Easy_Video_Transcripts_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Easy_Video_Transcripts_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Easy_Video_Transcripts_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		//$this->loader->add_action( 'enqueue_block_editor_assets', $plugin_admin, 'easy_video_transcripts_block' );

		$this->loader->add_action( 'init', $plugin_admin, 'create_posttype' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'easy_video_transcripts_add_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'easy_video_transcripts_settings_init' );
		//$this->loader->add_action( 'init', $plugin_admin, 'test_test_select_block_init' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'vid_w_transcript_addbox' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_vid_w_transcript_mb' );

		$this->loader->add_action( 'wp_ajax_gettranscript', $plugin_admin, 'get_transcript' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Easy_Video_Transcripts_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		//$this->loader->add_action( 'render_block', $plugin_public, 'filter_easy_video_transcripts_frontend', 10, 2 );
		$this->loader->add_action('wp_ajax_load_test', $plugin_public, 'test'); 
		$this->loader->add_action('wp_ajax_nopriv_test', $plugin_public, 'test'); 
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Easy_Video_Transcripts_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function output_transcript( $videoID ) {
		$en = get_post_meta( $videoID, 'transcript_srt_en', true );

		$transcriptraw = $en;
		$transcript = '';

		if(strpos( $transcriptraw, "\r\n") !== false ) {
			$transcriptraw = explode( "\r\n", $transcriptraw );
		} else {
			$transcriptraw = str_replace("\n", '///', $transcriptraw);
			$transcriptraw = explode( '///', $transcriptraw );
		}

		$t_line = 1;
		$i = 1;
		foreach( $transcriptraw as $t) {
			if( $i == 1 ) {
				$t_line = $t;
			}elseif( $i == 3 ) {
				$timestartsec = explode( '-->', $t );
				$timestartsec = $timestartsec[0];
				$timestartsec = round( $timestartsec, 1 );
				$timestartsec = number_format( $timestartsec, 1);
				$timestartsec = str_replace(',', '', $timestartsec);
				$transcript .= '<span class="btnSeek' . $videoID . '" data-seek="' . $timestartsec . '" id="t' . $t_line . '">';
			}elseif( $i == 4 ) {
				$transcript .= $t . '</span> ';
			}elseif( $i == 5 ) {
				$i = 0;
			}
			$i++;
		}
      	return $transcript;
	}


}
