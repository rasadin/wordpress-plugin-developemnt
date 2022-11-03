<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WTH_Products extends Widget_Base {

    public function get_name()
    {
        return 'wth-product';
    }

    public  function get_title()
    {
        return esc_html__( 'Products', 'wth' );
    }

    public function get_icon()
    {
        return "eicon-products";
    }

    public function get_categories()
    {
        return ["wth-elements-elementor"];
    }

    protected function _register_controls()
    {
        /**
         * General Settings
         */
        $this->start_controls_section(
            'wth_general_settings',
            [
                'label' => esc_html__( 'General Settings', 'wth' )
            ]
        );

        $this->add_control(
            'wth_product_per_row',
            [
                'label'       	=> esc_html__( 'Product per row', 'wth' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 3,
                'label_block' 	=> false,
                'description'   => 'How many product show in a row',
            ]
        );

        $this->end_controls_section();

        /**
         * Content Settings
         */
        $this->start_controls_section(
            'wth_content_settings',
            [
                'label' => esc_html__( 'Content Settings', 'wth' )
            ]
        );

        $this->add_control(
            'wth_products',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => [
                    [ 'wth_product_title' => 'test product' ]
                ],
                'fields' => [
                    [
                        'name' => 'wth_product_title',
                        'label' => esc_html__( 'Content', 'wth' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__( 'Product Title', 'wth' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'wth_product_image',
                        'label' => __( 'Choose Image', 'wth' ),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            // 'url' => \Elementor\Utils::get_placeholder_image_src(),
                            'url' => 'https://placeimg.com/1000/600/any',
                        ],
                    ],
                    [
                        'name' => 'wth_product_content',
                        'label' => esc_html__( 'Content', 'wth' ),
                        'type' => Controls_Manager::WYSIWYG,
                        'default' => esc_html__( '', 'wth' ),
                        'condition' => [],
                    ],
                ],
                'title_field' => '{{wth_product_title}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $wth = $this->get_settings_for_display();
        $this->add_render_attribute(
            'wth_product_option',
            [
                'id'                         => 'wth-product-'.$this->get_id(),
                'wth_product_per_row'       =>$wth['wth_product_per_row']

            ]
        );

          $item_width = 100 / $wth['wth_product_per_row'];

        ?>
        <div class="wth-products-section" <?php echo $this->get_render_attribute_string('wth_product_option'); ?>>
            <ul>
                <?php foreach( $wth['wth_products'] as $product ) : ?>
                    <li style="width: <?php echo $item_width; ?>%; float: left">
                        <h3><?php echo $product['wth_product_title']; ?></h3>
                        <img src="<?php echo esc_url( $product['wth_product_image']['url'] ); ?>" title="<?php echo $product['wth_product_title']; ?>" />
                        <p><?php echo $product['wth_product_content']; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WTH_Products() );