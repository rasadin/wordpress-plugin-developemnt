<?php 
namespace WCC\Blocks\HelloBlock;

class HelloBlock {
    /**
     * Construct Function
     * @author Rabiul
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'init', [ $this, 'register_block' ] );
    }

    /**
     * Register Block Type
     * @author Rabiul
     * @since 1.0.0
     */
    public function register_block() {
        register_block_type('WCC-blocks/hello-block', [
            'editor_script' => 'hello-block'
        ]);
    }
}