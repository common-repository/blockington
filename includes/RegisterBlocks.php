<?php

namespace ReelSoftware\Blockington;

class RegisterBlocks
{
    /**
     * Setup instance.
     *
     * @var RegisterBlocks
     */
    private static $instance;

    /**
     * Initialize the class.
     *
     * @since 1.0.0
     */
    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof RegisterBlock)) {
            self::$instance = new Self();
        }

        return self::$instance;
    }

    /**
     * Register Gutenberg blocks.
     * 
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function register_blocks()
    {
        $blocks = [
            ['name' => 'responsive-container'],
            ['name' => 'responsive-row'],
            ['name' => 'responsive-column'],
            ['name' => 'web-icon'],
            ['name' => 'accordion-container'],
            ['name' => 'accordion-item'],
            ['name' => 'alignment-container']
        ];

        // Include blocks only if wpforms plugin is active
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');

        if (is_plugin_active("wpforms-lite/wpforms.php") || is_plugin_active("wpforms/wpforms.php")) {
            array_push($blocks, ['name' => 'wpforms-style-container']);
        }

        foreach ($blocks as $block) {
            register_block_type(
                RS_BLOCKINGTON_PLUGIN_DIR . 'build/blocks/' . $block['name'],
                isset($block['options']) ? $block['options'] : []
            );
        }
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
        add_action('init', array($this, 'register_blocks'));
    }
}
