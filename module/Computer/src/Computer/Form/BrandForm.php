<?php

namespace Computer\Form;

use Computer\Entity\Brand,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form;


class BrandForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('brand-form');        
        
        // The form will hydrate an object of type "BlogPost"
        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Computer\Entity\Brand', true)); 

        // Add the sample fieldset, and set it as the base fieldset
        $attributeFieldset = new AttributeFieldset($objectManager);
        $attributeFieldset->setHydrator(new DoctrineHydrator($objectManager, 'Computer\Entity\Brand', true))
                ->setObject(new Brand());
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