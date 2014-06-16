<?php

namespace Samples\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;

class CreateSampleForm extends Form
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('create-sample-form');

        // The form will hydrate an object of type "BlogPost"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the user fieldset, and set it as the base fieldset
        $sampleFieldset = new SampleFieldset($objectManager);
        $sampleFieldset->setUseAsBaseFieldset(true);
        $this->add($sampleFieldset);

        // … add CSRF and submit elements …

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-primary',
                'value' => 'Crea',
            ),
        ));

        // Optionally set your validation group here
    }

}
