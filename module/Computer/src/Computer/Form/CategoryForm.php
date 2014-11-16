<?php

namespace Computer\Form;

use Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form;


class CategoryForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('category-form');        
        
        // The form will hydrate an object of type "BlogPost"
        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Computer\Entity\Category', true)); 

        // Add the sample fieldset, and set it as the base fieldset
        $categoryFieldset = new CategoryFieldset($objectManager);
        $categoryFieldset->setUseAsBaseFieldset(true);
        $this->add($categoryFieldset);

        
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