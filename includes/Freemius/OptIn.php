<?php

namespace ReelSoftware\Blockington\Freemius;

class OptIn
{
    public static function custom_connect_header_on_update($header_html)
    {
        $user = wp_get_current_user();
        return sprintf(
            __('Thanks %s for updating to our latest release!', 'rs-blockington'),
            $user->user_firstname
        );
    }

    public static function custom_connect_message_on_update($message, $user_first_name, $product_title, $user_login, $site_link, $freemius_link)
    {
        return sprintf(
            __('Please help us improve %2$s! If you opt-in, some data about your usage of %2$s will be sent to %5$s. If you skip this, that\'s okay! %2$s will still work just fine.', 'rs-blockington'),
            $user_first_name,
            '<b>' . $product_title . '</b>',
            '<b>' . $user_login . '</b>',
            $site_link,
            $freemius_link
        );
    }
}
