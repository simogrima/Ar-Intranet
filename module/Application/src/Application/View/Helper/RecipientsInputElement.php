<?php

/**
 * View Helper che aggiunge un campo "recipients" x destinatari email.
 * Utilizza il plugin: http://www.dimartino.it/assets/bootstrap-tagsinput/examples/
 * Come sorgente dati (JSON): /application/index/json-users
 */
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class RecipientsInputElement extends AbstractHelper
{

    /**
     * Formato x dati default:
     * $defaultData = [
     *     0 => ['value' => 'gessica.fanti@ariete.net','text' => 'Gessica Fanti'],
     *     1 => ['value' => 'grimani@ariete.net','text' => 'Simone Grimani'],
     * ]    
     *
     * @param boolean $defaultValues array di valori di default
     * @param type $requiredRecipients il campo "recipiens" non può essere vuoto?
     * @return view
     */
    public function __invoke($defaultValues = [], $requiredRecipients = true)
    {

        //Zend\View\Renderer\PhpRenderer
        $renderer = $this->getView();
        $model = new ViewModel();
        $model->setVariable('requiredRecipients', $requiredRecipients);
        if (!empty($defaultValues)) {
            $model->setVariable('defaultValues', $defaultValues);
        }

        $model->setTemplate('partial/recipients-input-element.phtml');
        return $renderer->render($model);
    }

}
