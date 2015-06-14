<?php

namespace Samples\Form;

use Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form;


class SampleForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('sample-form');        
        
        // The form will hydrate an object of type "BlogPost"
        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Samples\Entity\Sample', true)); 

        // Add the sample fieldset, and set it as the base fieldset
        $sampleFieldset = new SampleFieldset($objectManager);
        $sampleFieldset->setUseAsBaseFieldset(true);
        $this->add($sampleFieldset);
     

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'class' => 'btn btn-primary',
                'id' => 'submitbutton',
            ),
        ));
    }
}