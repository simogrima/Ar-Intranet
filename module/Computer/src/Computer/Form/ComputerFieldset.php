<?php

namespace Computer\Form;

use Computer\Entity\Computer,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Fieldset,
    Zend\InputFilter\InputFilterProviderInterface;
   // \Application\Form\CountryFieldset;

class ComputerFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('computer');

        //$this->setHydrator(new DoctrineHydrator($objectManager))
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Computer\Entity\Computer', true))
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
            'name' => 'model',
            'options' => array(
                'label' => 'Modello',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));

        //status
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'status',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Select..',
                        'label' => 'Stato',
                        'object_manager' => $objectManager,
                        'target_class' => 'Computer\Entity\Status',
                        'property' => 'name',
                        'is_method' => true,
                        'find_method' => array(
                            'name' => 'findBy',
                            'params' => array(
                                'criteria' => array(),
                                //'criteria' => array('name' => 'Attivo'),
                                'orderBy' => array('name' => 'ASC'),
                            ),
                        ),
                    ),
                    'attributes' => array(
                        'required' => true,
                        'class' => 'form-control',
                        'id' => 'status',
                    )
                )
        );
        
        //status
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'category',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Select..',
                        'label' => 'Categoria',
                        'object_manager' => $objectManager,
                        'target_class' => 'Computer\Entity\Category',
                        'property' => 'name',
                        'is_method' => true,
                        'find_method' => array(
                            'name' => 'findBy',
                            'params' => array(
                                'criteria' => array('status' => 1),
                                'orderBy' => array('name' => 'ASC'),
                            ),
                        ),
                    ),
                    'attributes' => array(
                        'required' => true,
                        'class' => 'form-control',
                        'id' => 'category',
                    )
                )
        );        
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),
            'serial' => array(
                'required' => true,
            ),
            'model' => array(
                'required' => true,
            ),
        );
    }

}
