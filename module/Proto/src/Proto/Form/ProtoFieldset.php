<?php

namespace Prototyping\Form;

use Prototyping\Entity\Prototyping,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Fieldset,
    Zend\InputFilter\InputFilterProviderInterface;

class PrototypingFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('prototyping');

        //$this->setHydrator(new DoctrineHydrator($objectManager))
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Prototyping\Entity\Prototyping', true))
                ->setObject(new Prototyping());


        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));             
        
        //status
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'status'
        ));        
        

        //customer
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'customer',
            'options' => array(
                'label' => 'Cliente',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));

        //projectCode
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'projectCode',
            'options' => array(
                'label' => 'Codice Progetto*',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));
        
        //productCode
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'productCode',
            'options' => array(
                'label' => 'Codice Prodotto',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));        

        //voltage
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'voltage',
            'options' => array(
                'label' => 'Tensione',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));      
        
        //frequency
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'frequency',
            'options' => array(
                'label' => 'Frequenza',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));          
        
        //absorption
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'absorption',
            'options' => array(
                'label' => 'Assorbimento',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));  
        
        //pressure
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'pressure',
            'options' => array(
                'label' => 'Pressione',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));          
                     
        //description
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'options' => array(
                'label' => 'Descrizione*',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));   
        
        //progress
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'progress',
            'emptyOption' => 'Select..',
            'options' => array(
                'label' => 'Avanzamento*',
                'value_options' => array(
                    '' => 'Select..',
                    'Prototipo' => 'Prototipo',
                    'T1' => 'T1',
                    'T2' => 'T2',
                    'T3' => 'T3',
                    'Final Sample' => 'Final Sample',
                    'Pilot Run' => 'Pilot Run',
                    'Production' => 'Production',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'progress',
                'required' => true,
            )
        ));        
        
        //status
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'status',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        //'empty_option' => 'Select..',
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
                        //'required' => true,
                        'class' => 'form-control',
                        'id' => 'status',
                    )
                )
        );         
        
        //family
        $this->add(
                array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'family',
                    'emptyOption' => 'Select..',
                    'options' => array(
                        'empty_option' => 'Select..',
                        'label' => 'Famiglia*',
                        'object_manager' => $objectManager,
                        'target_class' => 'Application\Entity\Family',
                        'property' => 'name',
                        'is_method' => true,                        
                        'find_method' => array(
                            'name' => 'findBy',
                            'params' => array(
                                'criteria' => array(),
                                'criteria' => array('status' => 1),
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

        
        
        
        //createdDate (boostrap datepicker) [Non funge in modifica]
        /*
         * 
         
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'createdDate',
            'options' => array(
                'label' => 'Data inizio',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));      
         * 
         */
        
        //createdDate (html 5 API)
        //provvisiorio visto che vogliono mettere la da ta inizio a mano (per pregresso)
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'createdDate',
            'options' => array(
                'label' => 'Data inizio*'
            ),
            'attributes' => array(
                //'min' => date('Y-m-d', time()),
                'max' => date('Y-m-d', time()),
                'step' => '1', // days; default step interval is 1 day
                'class' => 'form-control',
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
            'status' => array(
                'required' => false
            ),               
            'projectCode' => array(
                'required' => true,
            ),
            'family' => array(
                'required' => true,
            ),
            'progress' => array(
                'required' => true,
            ),            
        );
    }

}
