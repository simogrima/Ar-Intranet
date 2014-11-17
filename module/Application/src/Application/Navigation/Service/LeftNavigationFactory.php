<?php

namespace Application\Navigation\Service;
use Zend\Navigation\Service\DefaultNavigationFactory;

class LeftNavigationFactory extends DefaultNavigationFactory
{
    protected function getName()
    {
        return 'leftnav';
    }
}
