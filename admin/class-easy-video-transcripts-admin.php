<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://http://jasonjalbuena.com
 * @since      1.0.0
 *
 * @package    Easy_Video_Transcripts
 * @subpackage Easy_Video_Transcripts/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easy_Video_Transcripts
 * @subpackage Easy_Video_Transcripts/admin
 * @author     forlogos <jason@jasonjalbuena.com>
 */
class Easy_Video_Transcripts_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Easy_Video_Transcripts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Easy_Video_Transcripts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-video-transcripts-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Easy_Video_Transcripts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Easy_Video_Transcripts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/easy-video-transcripts-admin.js', array( 'jquery' ), $this->version, false );

	}

	/*public function easy_video_transcripts_block() {
		wp_enqueue_script(
			'easy-video-transcripts',
			plugin_dir_url( __FILE__ ) . 'js/easy-video-transcripts.js',
			array( 'wp-blocks', 'wp-element' )
			//array( 'wp-edit-post', 'wp-element', 'wp-components', 'wp-plugins', 'wp-data', 'wp-blocks' )
		);
	}*/

	public function create_posttype() {
		register_post_type( 'vid_w_transcript',
			array(
				'labels' => array(
					'name' => __( 'Easy Video Transcripts' ),
					'singular_name' => __( 'Video with Transcript' )
				),
				'public' => true,
				'has_archive' => false,
				'show_in_rest' => true,
				'menu_icon' => 'dashicons-chart-pie',
				'supports' => array(
					'title', 'thumbnail'
				),
			)
		);
	}

	public function vid_w_transcript_addbox() {
		add_meta_box('new-meta-boxes', 'Link Information', array( $this, 'display_vid_w_transcript_mb'), 'vid_w_transcript', 'normal', 'high');
	}

	//for the custom metabox
	public $vid_w_transcript_mb_key = 'vid_w_transcript_mbox';
	public function vid_w_transcript_mb_key() {
		return $this->vid_w_transcript_mb_key;
	}

	//for the custom metabox
	public $vid_w_transcript_mbs  = array(
		"youtubeURL"=> array(
			"name"=> "youtubeURL",
			"title"=> "URL of Youtube video",
			"description"=> "The link of the Youtube video"),

		/*"target"=> array(
			"name"=> "target",
			"title"=> "Open Link In",
			"description"=> "Should clicking on the banner open the link in the same window or a new window / tab?"),*/

		"transcripts"=> array(
			"name"=> "transcripts",
			"title"=> "Transcripts",
			"description"=> "")
	);
	public function vid_w_transcript_mbs() {
		return $this->vid_w_transcript_mbs;
	}

	//show the custom metabox
	public function display_vid_w_transcript_mb() {
		global $post;
		$vid_w_transcript_mb_key = $this->vid_w_transcript_mb_key;
		$vid_w_transcript_mbs = $this->vid_w_transcript_mbs;
		?>
		<div class="form-wrap">
			<?php wp_nonce_field(plugin_basename(__FILE__),$vid_w_transcript_mb_key. '_wpnonce',false,true);
			foreach($vid_w_transcript_mbs as $meta_box) {
				//set vars
				$data=get_post_meta($post->ID,$vid_w_transcript_mb_key,true);
				$name=(!empty($meta_box['name'])?$meta_box['name']:'');
				$title=(!empty($meta_box['title'])?$meta_box['title']:'');
				$description=(!empty($meta_box['description'])?$meta_box['description']:'');
				$value=(!empty($data[$name])?$data[$name]:''); ?>
				<div class="form-field form-required">
					<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
					<?php if($name=='target') {
						if($value=='blank') {$yy=' checked';$xx='';}else{$xx=' checked';$yy='';}
						echo '<input type="radio" name="target" value="self"'.$xx.' style="width:20px;"/> Same window <br/>
						<input type="radio" name="target" value="blank"'.$yy.' style="width:20px;"/> New window / tab';
					}elseif($name=='transcripts') {
						$has_transcript = $this->has_transcript( get_the_id(), 'en' );
						if( $has_transcript ) {
							$text = 'Redownload Transcript';
						} else {
							$text = 'Get Transcript';
						}
						echo $has_transcript . '<span class="evt_ajaxlink" onclick="get_transcript( document.getElementById( \'evtyoutubeURL\').value, \'' . get_the_id() . '\', \'en\' );">' . $text . '</span>';
					}else{
						echo '<input type="text" name="'.$name.'" id="evt'.$name.'" value="'.htmlspecialchars($value).'"/>';
					} ?>
					<p><?php echo $description; ?></p>
				</div>
			<?php } ?>
		</div>
	<?php }

	//save the metabox
	function save_vid_w_transcript_mb($post_id) {
		
		$vid_w_transcript_mb_key = $this->vid_w_transcript_mb_key;
		$vid_w_transcript_mbs = $this->vid_w_transcript_mbs;

		foreach($vid_w_transcript_mbs as $meta_box) {

			if(isset($_REQUEST[$meta_box['name']])) {

				if( $meta_box['name'] == 'youtubeURL') {
					$sanitized_data = sanitize_url( $_POST[$meta_box['name']] );
					$data[$meta_box['name']] = $sanitized_data;
				} else {
					$data[$meta_box['name']] = $_POST[$meta_box['name']];	
				}

			}
		}
		if(isset($_POST[$vid_w_transcript_mb_key.'_wpnonce'])) {
			if (!wp_verify_nonce($_POST[$vid_w_transcript_mb_key. '_wpnonce'],plugin_basename(__FILE__)))
				return $post_id;
		}
/*
		foreach( $data as $field => $input ) {
			echo $field . ': ' . $input . '<br/>';
		}		

		//use this to test the save function
		echo '<pre>';
		echo print_r($data);
		echo '</pre>';
		echo 'YYYY';
		echo '<pre>';
		die(print_r($_POST));
*/
		if(!current_user_can('edit_post',$post_id))
			return $post_id;
		
		if(!empty($data)) {
			update_post_meta($post_id,$vid_w_transcript_mb_key,$data);
		}
	}

	public function get_youtube_id( $youtube_url ) {

		$youtube_url = sanitize_url( $youtube_url );

		if( substr( $youtube_url, 0, 32 ) == 'https://www.youtube.com/watch?v=' ) {

			$params = parse_url( $youtube_url );
			parse_str( $params[ 'query' ], $vars );
			return $vars[ 'v' ];

		} elseif ( substr( $youtube_url, 0, 17 ) == 'https://youtu.be/' ) {

			return substr( $youtube_url, 17 );

		} else {

			return false;

		}		
	}

	public function get_transcript() {

		$youtube_url = $_POST['youtube_url'];
		$postid = $_POST['postid'];
		$lang = $_POST['lang'];

		$youtube_id = $this->get_youtube_id( $youtube_url );

		if( $youtube_id == false ) {
			echo 'Error with Youtube Video Link. Please verify the link and try again.';
		} else {

			$options = get_option( 'easy_video_transcripts_settings' ); 
			$RapidAPI_Key = ( !empty( $options['RapidAPI_Key'] ) ? $options['RapidAPI_Key'] : '' );

			$curl = curl_init();

			curl_setopt_array(
				$curl, 
				array(
					CURLOPT_URL => "https://subtitles-for-youtube.p.rapidapi.com/subtitles/" . $youtube_id . ".srt?lang=" . $lang,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 300,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_SSL_VERIFYPEER => false, // Disabled SSL Cert checks
					CURLOPT_CUSTOMREQUEST => "GET",
					CURLOPT_HTTPHEADER => array(
						"X-RapidAPI-Host: subtitles-for-youtube.p.rapidapi.com",
						"X-RapidAPI-Key: $RapidAPI_Key"
					),
				)
			);

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			echo $response; 
			if( $response == '{"message":"You are not subscribed to this API."}' ) {
				echo "Error getting transcript.\r\n\r\nPlease check your X-RapidAPI-Key in Easy Video Transcripts > Settings";
			} elseif ( $err ) {
				echo "cURL Error:" . $err;
			} elseif( strpos( $response, '"error"') !== false ) {
				echo "ERROR: \r\n" . $response;
			} else {

				$response = $this->parse_transcript( $response );
				$meta_id = update_post_meta( $postid, 'transcript_srt_' . $lang, $response );
				$meta_id = update_post_meta( $postid, 'youtube_id', $youtube_id );

				echo 'Get Transcript success!';
			}
		}
		wp_die();
	}

	public function parse_transcript( $transcriptraw ) {

		if(strpos( $transcriptraw, "\r\n") !== false ) {
			$transcriptraw = explode( "\r\n", $transcriptraw );
		} else {
			$transcriptraw = str_replace("\n", '///', $transcriptraw);
			$transcriptraw = explode( '///', $transcriptraw );
		}
		$i = 0;
		$prevline = '';
		foreach( $transcriptraw as $n => $l ) {
			if( $l == '' ) {
				$prevline = 'empty';
			} elseif(preg_match("/[0-9]/i", substr( $l, 0, 1) )) {
				
				if( $prevline == '' || $prevline == 'empty' ) {
					$prevline = 'int 1, text line #';
				} elseif( $prevline == 'int 1, text line #' ) {
					$prevline = 'int 2, longhand time';
				} elseif( $prevline == 'int 2, longhand time' ) {
					$prevline = 'int 3, shorthand time';
				} elseif( $prevline == 'int 3, shorthand time') {//this should be the first text line
					$prevline = 'text';
				}elseif( $prevline == 'text') {//this is a second text line
					$prevline = 'text';
					$transcriptraw[ $n - 1 ] .= ' ' . $transcriptraw[ $n ];//copy current line to previous line
					unset( $transcriptraw[ $n ] );//remove current line
				}
			} else {
				if( $prevline == 'text' ) {//if the second straight line of text
					$transcriptraw[ $n - 1 ] .= ' ' . $transcriptraw[ $n ];//copy current line to previous line
					unset( $transcriptraw[ $n ] );//remove current line
				}
				$prevline = 'text';
			}
		}
		$transcript = implode( "\n", $transcriptraw );
		return $transcript;
	}

	public function has_transcript( $postid, $lang ) {
		$meta_key = 'transcript_srt_' . $lang;
		$transcript = get_post_meta( $postid, $meta_key, true );
		if( $transcript ) {
			return 'Has Transcript. ';
		}
	}

	public function easy_video_transcripts_settings_init(  ) {
		register_setting( 'easy_video_transcripts_settings_page', 'easy_video_transcripts_settings' );

		add_settings_field( 
			'RapidAPI_Key', 
			__( 'X-RapidAPI-Key', 'easy_video_transcripts' ), 
			array( $this, 'RapidAPI_Key_render'), 
			'easy_video_transcripts_settings_page', 
			'easy_video_transcripts_pluginPage_section' 
		);

		add_settings_section(
			'easy_video_transcripts_pluginPage_section', 
			__( 'RapidAPI Key', 'easy_video_transcripts' ), 
			array( $this, 'easy_video_transcripts_settings_section_callback'), 
			'easy_video_transcripts_settings_page'
		);
		
	}

	public function RapidAPI_Key_render(  ) { 
		$options = get_option( 'easy_video_transcripts_settings' ); 
		$RapidAPI_Key = ( !empty( $options['RapidAPI_Key'] ) ? $options['RapidAPI_Key'] : '' ); ?>
		<input type='text' name='easy_video_transcripts_settings[RapidAPI_Key]' value='<?php echo $RapidAPI_Key; ?>'>
		<?php
	}

	public function easy_video_transcripts_settings_section_callback(  ) {
		echo __( 'Your RapidAPI Key. Please see this <a href="">this page</a> for how to get your RapidAPI key.', 'easy_video_transcripts' );
	}

	public function easy_video_transcripts_add_admin_menu() {
		add_submenu_page( 'edit.php?post_type=vid_w_transcript', 'Easy Video Transcripts Settings', 'Settings', 'manage_options', 'settings', array( $this, 'easy_video_transcripts_options_page') );
	}

	public function easy_video_transcripts_options_page() { ?>
		<form action='options.php' method='post'>
			<h1>Easy Video Transcripts Settings</h1>
			<?php
				settings_errors();
				settings_fields( 'easy_video_transcripts_settings_page' );
				do_settings_sections( 'easy_video_transcripts_settings_page' );
				submit_button();
			?>
		</form>
		<?php
	}


}