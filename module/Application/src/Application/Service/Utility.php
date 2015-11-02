<?php

namespace Application\Service;

class Utility
{
    /**
     * Tronca una stringa, senza spezzare le parole (effetto text preview)
     *
     * @param string $text
     * @param int $numb
     * @param string $etc
     * @return string
     */
    public static function txtTruncat($text, $numb, $etc = ' ...')
    {
        if (strlen($text) > $numb) {
            $text = substr($text, 0, $numb);
            $text = substr($text, 0, strrpos($text, " "));
            $text = $text . $etc;
        }

        return $text;
    }    
}
