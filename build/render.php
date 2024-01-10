<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$layout = $attributes[ 'layout' ];
$videoID = $attributes[ 'videoID' ];

$transcript = new Easy_Video_Transcripts();
$transcript = $transcript->output_transcript( $videoID );

$youtube_id = get_post_meta( $videoID, 'youtube_id', true );
$player_video = '<div class="wp-block-embed__wrapper"><iframe id="youtube-video-' . $videoID . '" src="https://www.youtube-nocookie.com/embed/'.$youtube_id.'?rel=0&autoplay=1&enablejsapi=1" frameborder="0" allowfullscreen allow="autoplay" enablejsapi=true></iframe></div>';
$classes = array(
	'class' => 'evtlayout-' . $layout . ' evt-' . $videoID
);

?>

<button class="the-btn">click me</button>
<div class="container"></div>
<script>
	var ajaxurl = '<?php echo str_replace( array('http:', 'https:'), '', admin_url('admin-ajax.php') ); ?>';
jQuery(document).ready(function($) {
jQuery(".the-btn").click(function(){

    var param1 = 'something';
    var param2 = 'something else';

    $("div.container").html("content loading....");

    jQuery.ajax({
        url: ajaxurl,
        type: POST, //'post|get|put'
        data: {
            action: 'test', 'param1':'something', 'param2':'something else'
           
        },
        success: function(data) {
            // What I have to do...
            jQuery("div.container").html(data);

        }
    })
    return false;
});
});
</script>

<div <?php echo get_block_wrapper_attributes( $classes ); ?> >
	<div class="vidcol">
		<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio">
			<?php echo $player_video; ?>
		</figure>
	</div>
	<div class="tscol">
		<div class="evt-ts-wrap">
			<p><?php echo $transcript; ?></p>
		</div>
	</div>
</div>

<script src="https://www.youtube.com/iframe_api"></script>
<script type="text/javascript">
	var player<?php echo $videoID; ?>;
	function onYouTubeIframeAPIReady() {
		player<?php echo $videoID; ?> = new YT.Player("youtube-video-<?php echo $videoID; ?>", {
			events: {
				"onReady": onPlayerReady<?php echo $videoID; ?>,
				"onStateChange": onPlayerStateChange<?php echo $videoID; ?>
			}
		});
	}

jQuery(document).ready(function($) {

	$( ".btnSeek<?php echo $videoID; ?>" ).on( "click", function() {
		moveVid<?php echo $videoID; ?>( $( this ).attr( "data-seek" ) );
	} );

	var timenow;
	tsIntvs<?php echo $videoID; ?> = setInterval(tsTimer<?php echo $videoID; ?>, 100);
	
	function tsTimer<?php echo $videoID; ?>() {
		if ( player<?php echo $videoID; ?> && player<?php echo $videoID; ?>.getPlayerState ) {
			timenow = player<?php echo $videoID; ?>.getCurrentTime();
			timenow = timenow.toFixed(1);
			var thisline = $('*[data-seek="' + timenow + '"]');
			if( thisline.length ) {
				$('.btnSeek<?php echo $videoID; ?>').css('background', '');
				thisline.css("background", "#fed9cc");
				$(".evt-<?php echo $videoID; ?> .tscol").scrollTop( thisline.offset().top - thisline.parent().offset().top - 20 );
			}
		}
	}

});

	function onPlayerReady<?php echo $videoID; ?>( event ) {}

	function onPlayerStateChange<?php echo $videoID; ?>( event ) {}

	function moveVid<?php echo $videoID; ?>(time) {
		player<?php echo $videoID; ?>.seekTo(time);
		player<?php echo $videoID; ?>.playVideo();
	}
</script>