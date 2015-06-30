<?php
namespace Samples\Form;

use Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form,
    Zend\Form\Element;

class SearchForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        //setto il nome chimando il parent’s constructor
        parent::__construct('search-form');
        $this->setAttribute('class', 'navbar-form navbar-right');
        $this->setAttribute('method', 'post');

        //id
        $this->add(array(
            'type' => 'Zend\Form\Element\Number',
            'name' => 'id',
            'options' => array(
                'label' => 'ID'
            ),
            'attributes' => array(
                'min' => '0',
                'step' => '1', // default step interval is 1
                'class' => 'form-control',
                'required' => FALSE,
                'id' => 'id',
                'placeholder' => 'ID',
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
                'required' => FALSE,
                'class' => 'form-control',
                'id' => 'model',
                'placeholder' => 'Modello',
            )
        ));
        
        //customer
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'customer',
            'options' => array(
                'label' => 'Cliente',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
                'id' => 'customer',
                'placeholder' => 'Cliente',
            )
        ));  
        
        //status
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'status',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Tutti',
                        'label' => 'Stato',
                        'object_manager' => $objectManager,
                        'target_class' => 'Samples\Entity\Status',
                        'property' => 'name',
                        'is_method' => true,
                        'find_method' => array(
                            'name' => 'findBy',
                            'params' => array(
                                'criteria' => array(),
                                //'criteria' => array('name' => 'Attivo'),
                                'orderBy' => array('id' => 'ASC'),
                            ),
                        ),
                    ),
                    'attributes' => array(
                        'required' => FALSE,
                        'class' => 'form-control',
                        'id' => 'status',
                    )
                )
        );       
        
        //Applicant
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'applicant',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Qualunque',
                        'label' => 'Richiedente',
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
                        'required' => false,
                        'class' => 'form-control selectpicker',
                        'data-live-search' => 'true',
                        'id' => 'applicant',
                    )
                )
        );         

        $submit = new Element\Submit('submit');
        $submit->setValue('Search')
                ->setAttribute('class', 'btn btn-primary');


        $this->add($submit);

    }
}