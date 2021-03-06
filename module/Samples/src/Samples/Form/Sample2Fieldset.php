<?php

namespace Samples\Form;

use Samples\Entity\Sample,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Fieldset,
    Zend\InputFilter\InputFilterProviderInterface,
    \Application\Form\CountryFieldset;

class Sample2Fieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('sample');

        //$this->setHydrator(new DoctrineHydrator($objectManager))
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Samples\Entity\Sample', true))
                ->setObject(new Sample());

        //id
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));
        
        //model
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'model',
            'options' => array(
                'label' => 'Modello',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
                'id' => 'model',
            )
        ));

        //voltageProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'voltageProvided',
            'options' => array(
                'label' => 'Tensione fornita',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));        

        
        //plugProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'plugProvided',
            'options' => array(
                'label' => 'Spina fornita',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));          

        
        //cableProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'cableProvided',
            'options' => array(
                'label' => 'Cavo fornito',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));          

        
        //frequencyProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'frequencyProvided',
            'options' => array(
                'label' => 'Frequenza fornita',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));          
        
        //serigraphyProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'serigraphyProvided',
            'options' => array(
                'label' => 'Frequenza fornita',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));          
        
        //colorsProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'colorsProvided',
            'options' => array(
                'label' => 'Colore fornito',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));          
        
        //accessoriesProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'accessoriesProvided',
            'options' => array(
                'label' => 'Accerssori forniti',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));             
        
        //bookletProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'bookletProvided',
            'options' => array(
                'label' => 'Libretto fornito',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));           
        
        //packagingProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'packagingProvided',
            'options' => array(
                'label' => 'Imballo fornito',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));   
        
        //absorptionProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'absorptionProvided',
            'options' => array(
                'label' => 'Assorbimento fornito',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));  
        
        //pressureProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'pressureProvided',
            'options' => array(
                'label' => 'Pressione fornito',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));  
        
        //sfasamentoProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'sfasamentoProvided',
            'options' => array(
                'label' => 'Sfasamento fornito',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));  
        
        //edtProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'edtProvided',
            'options' => array(
                'label' => 'EDT fornita',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));          
        
        //status
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'status',
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
        
        //paynting
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'painting',
            'options' => array(
                'label' => 'Da verniciare',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),         
            'attributes' => array(
                'id' => 'painting',
            )               
        ));        
        
        //toBeSerigraphy
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'toBeSerigraphy',
            'options' => array(
                'label' => 'Da serigrafare',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),         
            'attributes' => array(
                'id' => 'toBeSerigraphy',
            )               
        ));          
        
        //noteProvided
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'noteProvided',
            'options' => array(
                'label' => 'Note evasione',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));        
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => true
            ),
            'model' => array(
                'required' => true,
            ),
        );
    }

}
