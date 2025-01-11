<?php

class WebinarSysteemTextOverride
{
    public static function get_text($key) {
        $text = [
            'woocommerce-webinar-tickets-title' => __('My Webinar Tickets', WebinarSysteem::$lang_slug),
            'woocommerce-webinar-tickets-webinar' => __('Webinar', WebinarSysteem::$lang_slug),
            'woocommerce-webinar-tickets-date' => __('Session', WebinarSysteem::$lang_slug),
            'woocommerce-webinar-tickets-join' => __('Join', WebinarSysteem::$lang_slug),
            'woocommerce-webinar-tickets-join-webinar' => __('Join webinar', WebinarSysteem::$lang_slug),
            'woocommerce-webinar-tickets-time' => __('Time', WebinarSysteem::$lang_slug),
            'woocommerce-webinar-tickets-order' => __('Order', WebinarSysteem::$lang_slug)
        ];

        return apply_filters('wpws_text_override', $text[$key], $key);
    }

    public static function e($key) {
        echo self::get_text($key);
    }
}
