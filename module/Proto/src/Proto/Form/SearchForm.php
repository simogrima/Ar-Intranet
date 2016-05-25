<?php
namespace Prototyping\Form;

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
        
        //codice progetto
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'projectCode',
            'options' => array(
                'label' => 'Codice progetto',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
                'id' => 'model',
                'placeholder' => 'Codice Progetto',
            )
        ));
        
        //codice prodotto
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'productCode',
            'options' => array(
                'label' => 'Codice prodotto',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
                'id' => 'model',
                'placeholder' => 'Codice Prodotto',
            )
        ));        
        
        //status
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'family',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Tutti',
                        'label' => 'Famiglia',
                        'object_manager' => $objectManager,
                        'target_class' => 'Application\Entity\Family',
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
                        'id' => 'family',
                    )
                )
        );       
        
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
                        'target_class' => 'Prototyping\Entity\Status',
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
        
      

        $submit = new Element\Submit('submit');
        $submit->setValue('Search')
                ->setAttribute('class', 'btn btn-primary');


        $this->add($submit);

    }
}