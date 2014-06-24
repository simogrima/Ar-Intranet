<?php

namespace Samples\Form;

use Samples\Entity\Sample,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Fieldset,
    Zend\InputFilter\InputFilterProviderInterface,
    \Application\Form\CountryFieldset;

class SampleFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('sample');

        //$this->setHydrator(new DoctrineHydrator($objectManager))
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Samples\Entity\Sample', true))
                ->setObject(new Sample());


        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        //customer
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'customer',
            'options' => array(
                'label' => 'Customer',
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
                'label' => 'Model',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));

        //qta
        $this->add(array(
            'type' => 'Zend\Form\Element\Number',
            'name' => 'qta',
            'options' => array(
                'label' => 'Quantity'
            ),
            'attributes' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1', // default step interval is 1
                'class' => 'form-control',
            )
        ));


        //qtaExpected
        $this->add(array(
            'type' => 'Zend\Form\Element\Number',
            'name' => 'qtaExpected',
            'options' => array(
                'label' => 'Expected Quantity'
            ),
            'attributes' => array(
                'min' => '0',
                'class' => 'form-control',
            )
        ));

        //requestedDeliveryDate
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'requestedDeliveryDate',
            'options' => array(
                'label' => 'Requested Delivery Date'
            ),
            'attributes' => array(
                'min' => date('Y-m-d', time()),
                // 'max' => '2020-01-01',
                'step' => '1', // days; default step interval is 1 day
                'class' => 'form-control',
            )
        ));

        //paymentTerm
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'paymentTerm',
            'options' => array(
                'label' => 'Payment Term',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));

        //standardProduct
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'standardProduct',
            'options' => array(
                'label' => 'Standard Product',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),         
            'attributes' => array(
                'id' => 'standardProduct',
            )               
        ));
        
        //approvalSample
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'approvalSample',
            'options' => array(
                'label' => 'Approval Sample',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            )         
        ));        

        //voltage
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'voltage',
            'options' => array(
                'label' => 'Voltage',
                'value_options' => array(
                    'Standard' => 'Standard',
                    '100 V' => '100 V',
                    '120 V' => '120 V',
                    '220 V' => '220 V',
                    '230 V' => '230 V',
                    '220-240 V' => '220-240 V',
                    '230-240 V' => '230-240 V',
                    '240 V' => '240 V',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'voltage',
                'required' => true,
            )
        ));

        //plug
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'plug',
            'options' => array(
                'label' => 'Plug',
                'value_options' => array(
                    'Standard' => 'Standard',
                    'Cebec 2P' => 'Cebec 2P',
                    'Cebec 2P +T+T' => 'Cebec 2P +T+T',
                    'UL' => 'UL',
                    'Japan' => 'Japan',
                    'Australia' => 'Australia',
                    'UK' => 'UK',
                    'Argentina' => 'Argentina',
                    'Israele' => 'Israele',
                    'Sud Affrica' => 'Sud Affrica',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'plug',
                'required' => true,
            )
        ));

        //cable
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'cable',
            'options' => array(
                'label' => 'Cable',
                'value_options' => array(
                    'Standard' => 'Standard',
                    'Europa' => 'Europa',
                    'UL' => 'UL',
                    'Japan' => 'Japan',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cable',
                'required' => true,
            )
        ));

        //frequency
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'frequency',
            'options' => array(
                'label' => 'Frequency',
                'value_options' => array(
                    'Standard' => 'Standard',
                    '50 Hz' => '50 Hz',
                    '60 Hz' => '60 Hz',
                    '50 - 60 Hz' => '50 - 60 Hz',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'frequency',
                'required' => true,
            )
        ));

        //serigraphy
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'serigraphy',
            'options' => array(
                'label' => 'Serigraphy',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
                'id' => 'serigraphy',
            )
        ));

        //colors
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'colors',
            'options' => array(
                'label' => 'Colors',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
                'id' => 'colors',
            )
        ));

        //accessories
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'accessories',
            'options' => array(
                'label' => 'Accessories',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
                'id' => 'accessories',
            )
        ));
        
        //vpp
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'vpp',
            'options' => array(
                'label' => 'VPP',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
                'id' => 'vpp',
            )
        ));        
        
        //booklet
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'booklet',
            'options' => array(
                'label' => 'Booklet',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
                'id' => 'booklet',
            )
        )); 
        
        //packaging
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'packaging',
            'options' => array(
                'label' => 'Packaging',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
                'id' => 'packaging',
            )
        ));        

        //country
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'country',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Select..',
                        'label' => 'Country',
                        'object_manager' => $objectManager,
                        'target_class' => 'Application\Entity\Country',
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
            'customer' => array(
                'required' => true,
            ),
            'model' => array(
                'required' => true,
            ),
            'serigraphy' => array(
                'required' => true,
            ),
            'colors' => array(
                'required' => true,
            ),
            'accessories' => array(
                'required' => true,
            ),
        );
    }

}
