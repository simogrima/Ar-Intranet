<?php

namespace User\Form;

use Computer\Entity\History,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Form,
    Zend\InputFilter;

class SelectUserForm extends Form
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('select-user-from');
        $this->setAttribute('method', 'get');

        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'User\Entity\User', true));

        //User
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'userId',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Select..',
                        'label' => 'Utente',
                        'object_manager' => $objectManager,
                        'target_class' => 'User\Entity\User',
                        'property' => 'displayName',
                        'is_method' => true,
                        'find_method' => array(
                            'name' => 'findBy',
                            'params' => array(
                                'criteria' => array(),
                                //'criteria' => array('state' => 1),
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
        
        //Submit
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Select',
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
                    'name' => 'userId',
                    'required' => true,
                )
        );

        $this->setInputFilter($inputFilter);
    }

}
