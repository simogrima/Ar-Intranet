<?php

namespace Proto\Form;

use Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form;


class ProtoForm extends Form
{
    public function __construct(ObjectManager $objectManager, $editmode = FALSE)
    {
        parent::__construct('proto-form');        
        
        // The form will hydrate an object of type "BlogPost"
        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Proto\Entity\Proto', true)); 

        // Add the proto fieldset, and set it as the base fieldset
        $protoFieldset = new ProtoFieldset($objectManager, $editmode);
        $protoFieldset->setUseAsBaseFieldset(true);
        $this->add($protoFieldset);
     

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