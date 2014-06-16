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

        $this->setHydrator(new DoctrineHydrator($objectManager))
                ->setObject(new Sample());

        //model
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'model',
            'options' => array(
                'label' => 'Model',
            ),    
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'voltage',
            'options' => array(
                'label' => 'Voltage',
                'value_options' => array(
                    'Standard',
                    'Value1',
                    'Value2',
                    'Value3',
                ),
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'model' => array(
                'required' => true
            ),
        );
    }

}
