<?php

namespace Samples\Form;

use Samples\Entity\Sample;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

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

        //model
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'model',
            'options' => array(
                'label' => 'Model',
            ),
            'attributes' => array(
                'required' => true,
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
            )              
        ));
        
        


    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
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
