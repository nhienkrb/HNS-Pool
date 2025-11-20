<?php

class Helpers
{
    public static function excerpt($length = 12)
    {
        return  wp_trim_words(get_the_excerpt(), $length, '...');
    }
    public static function trim($text, $length = 12)
    {
        $raw = strip_tags($text);
        return wp_trim_words($raw, $length, '...');
    }
}
