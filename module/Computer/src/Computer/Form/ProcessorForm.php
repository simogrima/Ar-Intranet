<?php

namespace Computer\Form;

use Computer\Entity\Processor,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form;


class ProcessorForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('processor-form');        
        
        // The form will hydrate an object of type "BlogPost"
        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Computer\Entity\Processor', true)); 

        // Add the attribute fieldset, and set it as the base fieldset
        $attributeFieldset = new AttributeFieldset($objectManager);
        $attributeFieldset->setHydrator(new DoctrineHydrator($objectManager, 'Computer\Entity\Processor', true))
                ->setObject(new Processor());
        $attributeFieldset->setUseAsBaseFieldset(true);
        $this->add($attributeFieldset);

        
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