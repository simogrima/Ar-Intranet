<?php

namespace Computer\Form;

use Computer\Entity\Computer,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Fieldset,
    Zend\InputFilter\InputFilterProviderInterface;
   // \Application\Form\CountryFieldset;

class CategoryFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('category');

        //$this->setHydrator(new DoctrineHydrator($objectManager))
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Computer\Entity\Category', true))
                ->setObject(new Computer());


        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        //serial
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'serial',
            'options' => array(
                'label' => 'Seriale',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));

        //model
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'options' => array(
                'label' => 'Nome',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));

     $this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'status',
             'options' => array(
                     'label' => 'Stato',
                     'value_options' => array(
                             '1' => 'Enable',
                             '0' => 'Disable',
                     ),
             )
     ));
        
      
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),
            'name' => array(
                'required' => true,
            ),
            'status' => array(
                'required' => true,
            ),
        );
    }

}
