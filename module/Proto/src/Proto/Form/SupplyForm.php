<?php

namespace Proto\Form;

use Proto\Entity\Supplies,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form,
    Zend\InputFilter;

class SupplyForm extends Form
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('supply-form');

        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Proto\Entity\Supplies', true))->setObject(new Supplies());

        //Id
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));
        
        //Proto
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'proto'
        ));     
        
        //orderNr
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'orderNr',
            'options' => array(
                'label' => 'N° Ordine*',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));        
        
        //supplier
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'supplier',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Select..',
                        'label' => 'Fornitore*',
                        'object_manager' => $objectManager,
                        'target_class' => 'Application\Entity\Supplier',
                        'property' => 'companyName',
                        'is_method' => true,
                        'find_method' => array(
                            'name' => 'findBy',
                            'params' => array(
                                'criteria' => array(),
                                'criteria' => array('status' => 1),
                                'orderBy' => array('companyName' => 'ASC'),
                            ),
                        ),
                    ),
                    'attributes' => array(
                        'required' => true,
                        'class' => 'form-control',
                        'id' => 'supplier',
                    )
                )
        );        
           

        //supplyDate
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'supplyDate',
            'options' => array(
                'label' => 'Data fornitura*'
            ),
            'attributes' => array(
                //'min' => date('Y-m-d', time()),
                // 'max' => '2020-01-01',
                'step' => '1', // days; default step interval is 1 day
                'class' => 'form-control',
                'required' => true,
            )
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
                    'name' => 'supplier',
                    'required' => true,
                )
        );            

        $inputFilter->add(
                array(
                    'name' => 'proto',
                    'required' => true,
                )
        );
        
        $inputFilter->add(
                array(
                    'name' => 'supplyDate',
                    'required' => true,
                )
        );    
        
        $inputFilter->add(
                array(
                    'name' => 'orderNr',
                    'required' => true,
                )
        );          

        $this->setInputFilter($inputFilter);
    }

}
