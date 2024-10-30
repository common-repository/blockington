<?php

namespace ReelSoftware\Blockington\Freemius;

class Freemius
{
    /**
     * Setup instance.
     *
     * @var Freemius
     */
    private static $instance;

    /**
     * Initialize the class.
     *
     * @since 1.0.2
     */
    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof Freemius)) {
            self::$instance = new Self();
        }

        return self::$instance;
    }

    /**
     * Initialize the freemius.
     *
     * @since 1.0.2
     */
    private function init()
    {
        // Init freemius
        $this->freemius();
        // Signal that SDK was initiated
        do_action('rs_blockington_freemius_loaded');
    }

    /**
     * Enqueues scripts
     *
     * @since 1.0.2
     */
    public function freemius()
    {
        global $rs_blockington_freemius;

        if (!isset($rs_blockington_freemius)) {
            // Activate multisite network integration.
            if (
                !defined('WP_FS__PRODUCT_11607_MULTISITE')
            ) {
                define('WP_FS__PRODUCT_11607_MULTISITE', true);
            }

            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/sdk/start.php';

            $rs_blockington_freemius = fs_dynamic_init(array(
                'id'                  => '11607',
                'slug'                => 'blockington',
                'type'                => 'plugin',
                'public_key'          => 'pk_3dc13318dbda8faeb9f63def490c0',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'first-path'     => 'plugins.php',
                    'account'        => false,
                    'contact'        => false,
                    'support'        => false,
                ),
            ));
        }

        return $rs_blockington_freemius;
    }

    /**
     * Register hooks and filters with WordPress.
     * 
     * @since 1.0.2
     * @access public
     * @return void
     */
    public function register()
    {
        $this->init();

        $this->freemius()->add_filter('connect_message_on_update', array(OptIn::class, 'custom_connect_header_on_update'));
        $this->freemius()->add_filter('connect_message_on_update', array(OptIn::class, 'custom_connect_message_on_update'), 10, 6);
    }
}
