<?php

namespace Application\Form;

use Application\Entity\Supplier,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form,
    Zend\InputFilter;

class SupplierForm extends Form
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('supplier-form');

        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Application\Entity\Supplier', true))->setObject(new Supplier());

        //Id
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        //companyName
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'companyName',
            'options' => array(
                'label' => 'Ragione Sociale*',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));

        //status   
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'status',
            'options' => array(
                'label' => 'Stato',
                'value_options' => array(
                    '1' => 'Enable',
                    '0' => 'Disable',
                ),
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
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
                    'name' => 'companyName',
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
