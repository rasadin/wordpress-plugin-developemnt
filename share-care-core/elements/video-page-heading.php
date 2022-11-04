<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_SC_Page_heading extends Widget_Base {

	public function get_name() {
		return 'sharecare-video-page-heading';
	}

	public function get_title() {
		return esc_html__( 'Video Page Heading', 'sharecare-core' );
	}

	public function get_script_depends() {
        return [
            'sharecare-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-header';
	}

    public function get_categories() {
		return [ 'sharecare-for-elementor' ];
	}

	
	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'sharecare-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'page_title_span_1',
			[
				'label' => __( 'Title Span 1', 'sharecare-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'sharecare-core' ),
				'placeholder' => __( 'Type your title here', 'sharecare-core' ),
			]
        );

        $this->add_control(
			'page_title_span_2',
			[
				'label' => __( 'Title Span 2', 'sharecare-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'sharecare-core' ),
				'placeholder' => __( 'Type your title here', 'sharecare-core' ),
			]
        );

        $this->add_control(
			'youtube_video_url_id',
			[
				'label' => __( 'YouTube Video URL ID', 'sharecare-core' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				// 'default' => __( 'Default title', 'sharecare-core' ),
				'placeholder' => __( 'Enter Video Id Here. Ex: URL: https://www.youtube.com/watch?v=FsAfZxyw3r0 ID:FsAfZxyw3r0  ', 'sharecare-core' ),
			]
        );

    	$this->end_controls_section();
	
		/**
		 * Style Tab
		 */
		$this->style_tab();
    }
	private function style_tab() {}
	protected function render() {
	$webalive = $this->get_settings_for_display();
	    $this->add_render_attribute(
			'mmvc_page_heading_options',
			[
				'id' => 'sharecare-page-heading-'.$this->get_id(),
			]
		);
    ?>
<!-- Add Markup Starts -->
<div class="header">
	<div data-video="<?php echo $webalive['youtube_video_url_id']?>" class="header__video js-background-video">
		<div class="header__background">
			<div id="yt-player"></div>
		</div>
	</div>
	<div class="header__video-overlay js-video-overlay" style="background-image: url('<?php echo home_url('/wp-content/uploads/2021/02/video_thumb.jpg'); ?>"></div>
	<h1 class="header__title">
		<span><?php echo $webalive['page_title_span_1'] ?></span>
		<span><?php echo $webalive['page_title_span_2'] ?></span>
	</h1>
</div>


<script>
		// YouTube Player API for header BG video

		// Insert the <script> tag targeting the iframe API
		const tag = document.createElement('script');
		tag.src = "https://www.youtube.com/iframe_api";
		const firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

		// Get the video ID passed to the data-video attribute
		const bgVideoID = document.querySelector('.js-background-video').getAttribute('data-video');

		// Set the player options
		const playerOptions = {
		// Autoplay + mute has to be activated (value = 1) if you want to autoplay it everywhere 
		// Chrome/Safari/Mobile
		autoplay: 1,
		mute: 1,
		autohide: 1, 
		modestbranding: 1, 
		rel: 0, 
		showinfo: 0, 
		controls: 0, 
		disablekb: 1, 
		enablejsapi: 1, 
		iv_load_policy: 3,
		// For looping video you have to have loop to 1
		// And playlist value equal to your currently playing video
		loop: 1,
		playlist: bgVideoID,
		
		}

		// Get the video overlay, to mask it when the video is loaded
		const videoOverlay = document.querySelector('.js-video-overlay');

		// This function creates an <iframe> (and YouTube player)
		// after the API code downloads.
		let ytPlayer;
		function onYouTubeIframeAPIReady() {
		ytPlayer = new YT.Player('yt-player', {
			width: '1280',
			height: '720',
			videoId: bgVideoID,
			playerVars: playerOptions,
			events: {
			'onReady': onPlayerReady,
			'onPlaybackQualityChange': onPlayerPlaybackQualityChange,
			'onStateChange': onPlayerStateChange
			}
		});
		}

        // The API will call this function when the video player is ready.
        function onPlayerReady(event) {
          event.target.playVideo();
        }

		function onPlayerPlaybackQualityChange(event) {
				var playbackQuality = event.target.getPlaybackQuality();
				var suggestedQuality = 'hd720';

				console.log("Quality changed to: " + playbackQuality );

				if( playbackQuality !== 'hd720') {
					console.log("Setting quality to " + suggestedQuality );
					event.target.setPlaybackQuality( suggestedQuality );
				}
		}

		// When the player is ready and when the video starts playing
		// The state changes to PLAYING and we can remove our overlay
		// This is needed to mask the preloading
		function onPlayerStateChange(event) {
		    
    		if (event.data == YT.PlayerState.PLAYING) {
    			videoOverlay.classList.add('header__video-overlay--fadeOut');
    		}
    		

           var YTP=event.target;
           if(event.data===1){
                var remains=YTP.getDuration() - YTP.getCurrentTime();
                if(this.rewindTO)
                    clearTimeout(this.rewindTO);
                this.rewindTO=setTimeout(function(){
                     YTP.seekTo(0);
                 },(remains-0.1)*1000);
             }

    
		}
</script>
<!-- Add Markup Ends -->

	<?php
	}
	protected function content_template() {}
}



Plugin::instance()->widgets_manager->register_widget_type( new Widget_SC_Page_heading() );