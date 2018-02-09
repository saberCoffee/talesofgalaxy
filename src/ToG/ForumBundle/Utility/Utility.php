<?php

namespace ToG\ForumBundle\Utility;

class Utility
{
    public static function cleanString($string, $separator = '-')
    {
        setlocale(LC_ALL, 'fr_FR.UTF8'); // Gestion de la locale, pour les accents
        // Source: http://cubiq.org/the-perfect-php-clean-url-generator
        $string = str_replace('é', 'e', $string);
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $string = str_replace('\'', $separator, $string);
        $string = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $string);
        $string = preg_replace("/[\/_|+ -]+/", $separator, $string);
        $string = strtolower(trim($string, $separator));

        return $string;
    }
}
