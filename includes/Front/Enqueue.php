<?php

namespace ReelSoftware\Blockington\Front;

class Enqueue
{
    /**
     * Setup instance.
     *
     * @var Enqueue
     */
    private static $instance;

    /**
     * Initialize the class.
     *
     * @since 1.0.0
     */
    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof Enqueue)) {
            self::$instance = new Self();
        }

        return self::$instance;
    }

    /**
     * Enqueues scripts
     *
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style(
            'rs_blockington_bootstrap_css', 
            plugins_url(RS_BLOCKINGTON_PLUGIN_DIR_NAME . '/public/css/bootstrap/bootstrap.min.css')
        );
        wp_enqueue_script(
            'rs_blockington_bootstrap_js', 
            plugins_url(RS_BLOCKINGTON_PLUGIN_DIR_NAME . '/public/js/bootstrap/bootstrap.bundle.min.js')
        );
        wp_enqueue_script(
            'rs_blockington_functions_js', 
            plugins_url(RS_BLOCKINGTON_PLUGIN_DIR_NAME . '/public/js/functions.js')
        );
    }

    /**
     * Enqueues editor scripts
     *
     * @since 1.0.1
     */
    public function enqueue_editor_scripts()
    {
        $editorAssets = include(RS_BLOCKINGTON_PLUGIN_DIR . 'build/editor/index.asset.php');

        wp_register_script(
            'rs_blockington_editor_js',
            plugins_url(RS_BLOCKINGTON_PLUGIN_DIR_NAME . '/build/editor/index.js'),
            $editorAssets['dependencies'],
            $editorAssets['version'],
            true
        );

        wp_enqueue_script('rs_blockington_editor_js');
        wp_enqueue_style('rs_blockington_editor_css', plugins_url(RS_BLOCKINGTON_PLUGIN_DIR_NAME . '/build/editor/index.css'));
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
        // Enqueue scripts for block editor
        add_action('enqueue_block_assets', array($this, 'enqueue_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_editor_scripts'));
    }
}
