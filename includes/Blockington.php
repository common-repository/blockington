<?php

namespace ReelSoftware\Blockington;

use ReelSoftware\Blockington\RegisterBlocks;
use ReelSoftware\Blockington\Setup;
use ReelSoftware\Blockington\Front\Enqueue;
use ReelSoftware\Blockington\Admin\RateUs;
use ReelSoftware\Blockington\Admin\AdminPost;

/**
 * Main Blockington Class.
 *
 * @since  1.0.0
 */
class Blockington
{
    /**
     * Blockington instance.
     *
     * @var Blockington
     */
    private static $instance;

    /**
     * Plugin prefix.
     *
     * @var string
     */
    public static $pluginPrefix;


    /**
     * Initialize properties.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        self::$pluginPrefix = "rs_blockington_";

        // Include all files inside includes folder
        $rootFiles = glob(RS_BLOCKINGTON_PLUGIN_DIR . 'includes/*.php');
        $subdirectoryFiles = glob(RS_BLOCKINGTON_PLUGIN_DIR . 'includes/**/*.php');
        $allFiles = array_merge($rootFiles, $subdirectoryFiles);

        foreach ($allFiles as $filename) {
            include_once($filename);
        }
    }

    /**
     * Initialize the plugin.
     *
     * @since 1.0.0
     */
    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof Blockington)) {
            self::$instance = new Self();
        }

        return self::$instance;
    }

    /**
     * Register hooks and filters with WordPress.
     * 
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function register(): void
    {
        Setup::instance()->register();
        RegisterBlocks::instance()->register();
        Enqueue::instance()->register();
        RateUs::instance()->register();
        AdminPost::instance()->register();
    }
}
