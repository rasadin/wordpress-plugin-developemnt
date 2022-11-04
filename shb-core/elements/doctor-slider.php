<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Mmvc_Hero_Carousel_Logo extends Widget_Base {

	public function get_name() {
		return 'shb-doctor-slider';
	}

	public function get_title() {
		return esc_html__( 'Team Member List', 'shb-core' );
	}

	public function get_script_depends() {
        return [
            'shb-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-slideshare';
	}

    public function get_categories() {
		return [ 'shb-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'shb-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Team Member Name', 'shb-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Team Member Name Here' , 'shb-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'shb-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'speciality', [
				'label' => __( 'Designation', 'shb-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Designation Here' , 'shb-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'qua', [
				'label' => __( 'Qualifications', 'shb-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Qualifications Here' , 'shb-core' ),
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'discription', [
				'label' => __( 'Email', 'shb-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Enter Email Here' , 'shb-core' ),
				'label_block' => true,
			]
		);
		

		$this->add_control(
			'hero_slides',
			[
				'label' => __( 'Team Member List', 'shb-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Team Member Name', 'shb-core' ),
					],
				],
				'title_field' => '{{{ title }}}',
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
		$shb = $this->get_settings_for_display();
		$this->add_render_attribute(
			'team_mmember_options',
			[
				'id' => 'fasttrac-logo-carousel-'.$this->get_id(),
			]
		);
    ?>
    <!-- Add Markup Starts -->
	<section class="our-team-section" <?php echo $this->get_render_attribute_string('team_mmember_options'); ?> >
		<div class="row no-gutters">

			<?php foreach( $shb['hero_slides'] as $slide ) : ?>
				<?php 
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$charactersLength = strlen($characters);
				$randomString = '';
				for ($i = 0; $i < 10; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
				}
				$uni = $randomString;
				?>
				<div class="col-sm-6 col-md-3 team-colume-box">
					<div class="team-box">

						<div class="team-picture">
                            <img src="<?php echo esc_url($slide['image']['url']) ?>" alt="" />
                            <div class="team-info-content">
                                <a href="mailto:<?php echo $slide['discription']; ?>" class="messenger-icon"></a>
                                <!-- <input type="text" class="copyemail-value" value="<?php //echo $slide['discription']; ?>" id="myInput"> -->

                                <div class="emailadd" id="<?php echo $uni; ?>"><?php echo $slide['discription']; ?></div>
                                <button class="copyemailbt" id="<?php echo $uni.'shb'; ?>" onclick="copyTextFromElement('<?php echo $uni ?>')">Copy Email</button>
                                <!-- <a href="#"><?php //echo $slide['discription']; ?></a> -->
                                <!-- <a href="" class="copyemailbt">Copy Email</a> -->
                            </div>
                        </div>
						<div class="name-details">
							<div class="member-name-title"><?php echo $slide['title']; ?></div>
							<div class="designation-text"><?php echo $slide['speciality']; ?></div>
							<div class="qua-text"><?php echo $slide['qua']; ?></div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
				
		</div>
	</section>        
	<!-- Add Markup Ends -->
<script>
	//If you want to copyText from Element
	function copyTextFromElement(elementID) {
		showAlert(elementID);

	let element = document.getElementById(elementID); //select the element
	console.log(element);
	let elementText = element.textContent; //get the text content from the element
	copyText(elementText); //use the copyText function below
	}

	//If you only want to put some Text in the Clipboard just use this function
	// and pass the string to copied as the argument.
	function copyText(text) {
	navigator.clipboard.writeText(text);
	// alert('Copied: ' + text);
	}

	function showAlert(elementID) {
		let new_id = elementID+'shb';
		document.getElementById(new_id).textContent = 'COPIED!!';
	}

</script>
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Mmvc_Hero_Carousel_Logo() );