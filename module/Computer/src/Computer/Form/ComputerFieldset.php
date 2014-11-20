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
        
        //invoice
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'invoice',
            'options' => array(
                'label' => 'Nr. Fattura',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));
        
        //invoiceDate
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'invoiceDate',
            'options' => array(
                'label' => 'Data Fattura'
            ),
            'attributes' => array(
                //'min' => date('Y-m-d', time()),
                // 'max' => '2020-01-01',
                'step' => '1', // days; default step interval is 1 day
                'class' => 'form-control',
                'required' => true,
            )
        ));        
        
        //ddt
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'ddt',
            'options' => array(
                'label' => 'Nr. DDT',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));        
        
        //ddtDate
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'ddtDate',
            'options' => array(
                'label' => 'Data DDT'
            ),
            'attributes' => array(
                //'min' => date('Y-m-d', time()),
                // 'max' => '2020-01-01',
                'step' => '1', // days; default step interval is 1 day
                'class' => 'form-control',
                'required' => true,
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
        
        //Category
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
        //Brand
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'brand',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Select..',
                        'label' => 'Brand',
                        'object_manager' => $objectManager,
                        'target_class' => 'Computer\Entity\Brand',
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
                        'id' => 'brand',
                    )
                )
        );    
        //Processor
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'processor',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Select..',
                        'label' => 'Processore',
                        'object_manager' => $objectManager,
                        'target_class' => 'Computer\Entity\Processor',
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
                        'id' => 'processor',
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
                'required' => FALSE,
            ),
            'model' => array(
                'required' => true,
            ),
            'invoice' => array(
                'required' => true,
            ),
            'ddt' => array(
                'required' => true,
            ),       
            'status' => array(
                'required' => true,
            ),  
            'brand' => array(
                'required' => true,
            ),  
            'processor' => array(
                'required' => true,
            ),              
        );
    }

}
