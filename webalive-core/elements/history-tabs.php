<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Webalive_History_Tabs extends Widget_Base {

	public function get_name() {
		return 'webalive-history-tabs';
	}

	public function get_title() {
		return esc_html__( 'History Tabs', 'webalive2019-core' );
	}

	public function get_script_depends() {
        return [
            'webalive-public'
        ];
    }

	public function get_icon() {
		return 'fa fa-window-restore';
	}

    public function get_categories() {
		return [ 'webalive-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_title', [
				'label' => __( 'Tab Title', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Tab title', 'webalive2019-core' )
			]
		);
		$repeater->add_control(
			'tab_id', [
				'label' => __( 'Tab ID', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'tab-1', 'webalive2019-core' ),
			]
		);
		$repeater->add_control(
			'tab_content', [
				'label' => __( 'Tab Content', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
			]
		);
		$repeater->add_control(
			'tab_image',
			[
				'label' => __( 'Choose Image', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'tabs',
			[
				'label' => __( 'History Tab', 'webalive2019-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __( 'Tab Title #1', 'webalive2019-core' ),
						'tab_content' => __( 'Item content. Click the edit button to change this text.', 'webalive2019-core' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
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
			'webalive_project_showcase_options',
			[
				'id' => 'webalive-project-shocase-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
        <div class="webalive-history-tab">
			<!-- Scrollifier Content Starts -->
            <div class="history-block">
                <div class="arrow-block">
                    <div class="history-pagination"><span class="current">01</span><span>/</span><span>03</span></div>
                    <div class="history-line"></div>
                </div>
            </div>
			<div class="history-pills">
            	<?php foreach( $webalive['tabs'] as $key=>$tab ) : ?>
                <div class="pills <?php if($key == 0) : echo 'active'; endif; ?>" id="<?php echo 'tab-'.$key; ?>" data-tab="<?php echo ($key+1); ?>">
                    <?php echo $tab['tab_content']; ?>
                </div>
				<?php endforeach; ?>
            </div>
			
			<div class="history-content">
				<?php foreach( $webalive['tabs'] as $key=>$tab ) : ?>
				<div class="image <?php if($key > 0 ) : echo 'hide-image'; else: echo 'active'; endif; ?>" id="<?php echo 'image-tab-'.$key; ?>" data-id="<?php echo 'tab-'.$key ?>">
                    <img src="<?php echo esc_url($tab['tab_image']['url']); ?>" alt="<?php echo $tab['tab_title']; ?>-image">
				</div>
				<?php endforeach; ?>
            </div>
            
            <!-- Scrollifier Content Ends -->
        </div>
        <!-- Add Markup Ends -->

	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Webalive_History_Tabs() );