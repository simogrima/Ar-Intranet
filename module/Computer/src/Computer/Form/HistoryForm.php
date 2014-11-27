<?php

namespace Computer\Form;

use Computer\Entity\History,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form,
    Zend\InputFilter;

class HistoryForm extends Form
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('history-form');

        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Computer\Entity\History', true));

        //Id
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        //EditBy
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'edit_by'
        ));
        
        //Computer
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'computer_id'
        ));        

        /**Computer
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'computer',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Select..',
                        'label' => 'Computer',
                        'object_manager' => $objectManager,
                        'target_class' => 'Computer\Entity\Computer',
                        'property' => 'serial',
                        'is_method' => true,
                        'find_method' => array(
                            'name' => 'findBy',
                            'params' => array(
                                'criteria' => array(),
                                'orderBy' => array('serial' => 'ASC'),
                            ),
                        ),
                    ),
                    'attributes' => array(
                        'read-only' => true,
                        'required' => true,
                        'class' => 'form-control',
                    )
                )
        );
         * 
         */

        //Recipient
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'recipient',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Select..',
                        'label' => 'Destinatario',
                        'object_manager' => $objectManager,
                        'target_class' => 'User\Entity\User',
                        'property' => 'displayName',
                        'is_method' => true,
                        'find_method' => array(
                            'name' => 'findBy',
                            'params' => array(
                                'criteria' => array('state' => 1),
                                'orderBy' => array('displayName' => 'ASC'),
                            ),
                        ),
                    ),
                    'attributes' => array(
                        'required' => true,
                        'class' => 'form-control selectpicker',
                        'data-live-search' => 'true',
                        'data-style' =>'btn-info',
                    )
                )
        );

        //Type
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'type',
            'options' => array(
                'label' => 'Tipo',
                'value_options' => array(
                    '1' => 'Creazione',
                    '2' => 'Modifica',
                    '3' => 'Assegnazione',
                    '4' => 'Cambio Stato',
                ),
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));

        //Status
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'status',
            'options' => array(
                'label' => 'Stato',
                'value_options' => array(
                    '1' => 'Attivo',
                    '2' => 'Non attivo',
                ),
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
                'id' => 'category',
            )
        ));


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
        
        //Id
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'redirect'
        ));        

        $this->addInputFilter();
    }

    public function addInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        $inputFilter->add(
                array(
                    'name' => 'id',
                    'required' => false,
                )
        );

        $inputFilter->add(
                array(
                    'name' => 'recipient',
                    'required' => true,
                )
        );

        $inputFilter->add(
                array(
                    'name' => 'edit_by',
                    'required' => true,
                )
        );

        $inputFilter->add(
                array(
                    'name' => 'computer_id',
                    'required' => true,
                )
        );

        $inputFilter->add(
                array(
                    'name' => 'type',
                    'required' => true,
                )
        );

        $inputFilter->add(
                array(
                    'name' => 'status',
                    'required' => true,
                )
        );


        $this->setInputFilter($inputFilter);
    }

}
