<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Maxpak_Tab extends Widget_Base {

	public function get_name() {
		return 'maxpak-solar-maxpak-tab';
	}

	public function get_title() {
		return esc_html__( 'Maxpak Tab', 'maxpak-core' );
	}

	public function get_script_depends() {
        return [
            'maxpak-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-sun-o';
	}

    public function get_categories() {
		return [ 'maxpak-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'maxpak-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title_maxpak', [
				'label' => __( 'Title-', 'maxpak-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'List Title' , 'maxpak-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'item_description_maxpak',
			[
				'label' => __( 'Description', 'maxpak-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Default description', 'maxpak-core' ),
				'placeholder' => __( 'Type your description here', 'maxpak-core' ),
			]
		);
		$repeater->add_control(
			'image_maxpak',
			[
				'label' => __( 'Add Images-', 'maxpak-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'list_maxpak',
			[
				'label' => __( 'Repeater List-', 'maxpak-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title_maxpak' => __( 'Title #1', 'maxpak-core' ),
						'image_maxpak' => __( 'Item content. Click the edit button to change this text.', 'maxpak-core' ),
					],
					
				],
				'title_field' => '{{{ title_maxpak }}}',
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
		$maxpak = $this->get_settings_for_display();
    ?>
        <!-- Add Markup Starts -->
		<nav>
			<div class="nav nav-tabs maxpak-tabs" id="nav-tab-maxpak" role="tablist-">
			     <?php foreach (  $maxpak['list_maxpak'] as $uni=> $item2 ) : ?>
			         <a class="nav-item nav-link <?php if($uni==0): echo 'active'; endif; ?>" id="nav-home-tab-maxpak" data-toggle="tab" href="#<?php echo 'tab-maxpak-maxpak-'.$uni;?>" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo $item2['title_maxpak']; ?></a>
				 <?php endforeach; ?>
			</div>
		</nav>
			<div class="tab-content maxpak-page-tab" id="nav-tabContent-maxpak">
			     <?php foreach (  $maxpak['list_maxpak'] as $uni=> $item2 ) : ?>
			         <div class="tab-pane <?php if($uni==0): echo 'active'; endif; ?> <?php if($uni!=0): echo 'fade'; endif; ?>" id="<?php echo 'tab-maxpak-maxpak-'.$uni;?>" role="tabpanel" aria-labelledby="nav-home-tab">
			             <div class="container-maxpak">
							
			     			     <?php echo $item2['item_description_maxpak']; ?> <br>
				           
			             </div>
			         </div>
			     <?php endforeach; ?>
			</div>
        <!-- Add Markup Ends -->
	<?php
	}
	protected function content_template() {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Maxpak_Tab() );