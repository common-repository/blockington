<?php

/**
 * Plugin Name:       Blockington
 * Plugin URI:        https://blockington.com
 * Description:       Get the most out of the Gutenberg Block Editor and build websites faster, easier, and more intuitively with custom blocks.
 * Version:           1.0.2
 * Requires at least: 6.0
 * Requires PHP:      7.2
 * Author:            Reel Software
 * Author URI:        https://reel.software
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rs-blockington
 * Domain Path:       /languages
 */

require_once("vendor/autoload.php");

if (!function_exists('add_action')) {
    echo 'Seems like you stumbled here by accident. 😛';
    exit;
}

// Init Freemius
\ReelSoftware\Blockington\Freemius\Freemius::instance()->register();

// Setup
define('RS_BLOCKINGTON_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RS_BLOCKINGTON_PLUGIN_DIR_NAME', basename(dirname(__FILE__)));

if (class_exists('\ReelSoftware\Blockington\Blockington')) {
    register_activation_hook(__FILE__, array(\ReelSoftware\Blockington\Activate::instance(), 'activate_plugin'));
}

if (class_exists('\ReelSoftware\Blockington\Blockington')) {
    \ReelSoftware\Blockington\Blockington::instance()->register();
}