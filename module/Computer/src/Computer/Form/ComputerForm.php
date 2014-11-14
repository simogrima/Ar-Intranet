<?php

namespace Computer\Form;

use Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form;


class ComputerForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('computer-form');        
        
        // The form will hydrate an object of type "BlogPost"
        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Computer\Entity\Computer', true)); 

        // Add the sample fieldset, and set it as the base fieldset
        $computerFieldset = new ComputerFieldset($objectManager);
        $computerFieldset->setUseAsBaseFieldset(true);
        $this->add($computerFieldset);

        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ));        

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