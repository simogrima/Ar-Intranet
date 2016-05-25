<?php

namespace Prototyping\Form;

use Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form;


class PrototypingForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('prototyping-form');        
        
        // The form will hydrate an object of type "BlogPost"
        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Prototyping\Entity\Prototyping', true)); 

        // Add the prototyping fieldset, and set it as the base fieldset
        $prototypingFieldset = new PrototypingFieldset($objectManager);
        $prototypingFieldset->setUseAsBaseFieldset(true);
        $this->add($prototypingFieldset);
     

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