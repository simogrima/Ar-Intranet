<?php
/**
 * Strategia personalozzata x accessi bloccati.
 * Se l'utente non è loggato allora usa la Redirect Strategy (redirect to login page)
 * altrimenti usa Unauthorized Strategy.
 * 
 * Ps. se avessi usato la Redirect Strategy avrebbe reindirizzato alla homepage in caso
 * di utente loggato. Valutare quale usare.
 */

namespace MyZfcRbac\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcRbac\View\Strategy\RedirectStrategy;
use ZfcRbac\View\Strategy\UnauthorizedStrategy;
/**
 * Factory to create a redirect strategy
 */
class DynamicStrategyFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \ZfcRbac\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('ZfcRbac\Options\ModuleOptions');
        /** @var \Zend\Authentication\AuthenticationService $authenticationService */
        $authenticationService = $serviceLocator->get('Zend\Authentication\AuthenticationService');

        if(!$authenticationService->hasIdentity()) {
            return new RedirectStrategy($moduleOptions->getRedirectStrategy(), $authenticationService);
        } else {
            return new UnauthorizedStrategy($moduleOptions->getUnauthorizedStrategy());
        }
    }
}
