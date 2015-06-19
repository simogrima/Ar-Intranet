<?php

namespace Samples\Form;

use Samples\Entity\History,
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
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Samples\Entity\History', true))->setObject(new History());

        //Id
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        //EditBy
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'editBy'
        ));
        
        //Sample
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'sample'
        ));        

        //status
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'sampleStatus',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Select..',
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
                        'required' => true,
                        'class' => 'form-control',
                        'id' => 'status',
                    )
                )
        );             

        //editDate
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'editDate',
            'options' => array(
                'label' => 'Data'
            ),
            'attributes' => array(
                //'min' => date('Y-m-d', time()),
                // 'max' => '2020-01-01',
                'step' => '1', // days; default step interval is 1 day
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
                    'name' => 'editBy',
                    'required' => true,
                )
        );            

        $inputFilter->add(
                array(
                    'name' => 'sample',
                    'required' => true,
                )
        );

        $this->setInputFilter($inputFilter);
    }

}
