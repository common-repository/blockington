<?php

namespace ReelSoftware\Blockington;

class Setup
{
    /**
     * Setup instance.
     *
     * @var Setup
     */
    private static $instance;

    /**
     * Initialize the class.
     *
     * @since 1.0.0
     */
    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof Setup)) {
            self::$instance = new Self();
        }

        return self::$instance;
    }

    /**
     * Adds new category for Gutenberg blocks.
     * 
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function add_new_block_category($block_categories)
    {
        return array_merge(
            $block_categories,
            [
                [
                    'slug'  => 'rs-blockington-blockington-blocks',
                    'title' => esc_html__('Blockington', 'rs-blockington')
                ],
                [
                    'slug'  => 'rs-blockington-bootstrap-blocks',
                    'title' => esc_html__('Bootstrap', 'rs-blockington')
                ]
            ]
        );
    }

    /**
     * Register hooks and filters with WordPress.
     * 
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function register()
    {
        add_filter('block_categories_all', array($this, 'add_new_block_category'));
    }
}
