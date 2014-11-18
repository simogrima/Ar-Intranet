<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class TitleAndBread extends AbstractHelper
{

    public function __invoke($title, $bread = true)
    {
        $this->getView()->headTitle($title);
        $output  = '<div class="row page-title"><div class="col-lg-12">';
        $output .= '<h1 class="page-header">' . $this->getView()->translate($title) . '</h1>';
        $output .= '</div></div>';
        
        if ($bread) {
            $output .= $this->getView()->navigation('left_navigation')
                    ->breadcrumbs()
                    ->setMinDepth(0)
                    ->setPartial(array('partial/breadcrumb.phtml', 'Application'));            
        }

        $output .= '<div style="margin-top: 30px;"></div>';
        return $output;
    }
}