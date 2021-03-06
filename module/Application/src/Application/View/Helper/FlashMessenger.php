<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class FlashMessenger extends AbstractHelper
{

    public function __invoke()
    {
        $flash = $this->getView()->flashMessenger();
        $flash->setMessageOpenFormat('<div%s>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            &times;
            </button>
            <ul><li>')
                ->setMessageSeparatorString('</li><li>')
                ->setMessageCloseString('</li></ul></div>');

        echo $flash->render('error', array('alert', 'alert-dismissable', 'alert-danger'));
        echo $flash->render('info', array('alert', 'alert-dismissable', 'alert-info'));
        echo $flash->render('default', array('alert', 'alert-dismissable', 'alert-warning'));
        echo $flash->render('success', array('alert', 'alert-dismissable', 'alert-success'));
    }

}
