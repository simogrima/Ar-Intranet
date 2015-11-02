<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class TruncateTxt extends AbstractHelper
{
    /**
     * Tronca una stringa, senza spezzare le parole (effetto text preview)
     *
     * @param string $text
     * @param int $numb
     * @param string $etc
     * @return string
     */
    public function __invoke($text, $numb, $etc = ' ...')
    {
        return \Application\Service\Utility::txtTruncat($text, $numb, $etc);
    }
}