<?php

namespace Proto\Form;

use Proto\Entity\Proto,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
    Zend\Form\Fieldset,
    Zend\InputFilter\InputFilterProviderInterface;

class ProtoFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ObjectManager $objectManager, $editmode = false)
    {
        parent::__construct('proto');

        //$this->setHydrator(new DoctrineHydrator($objectManager))
        $this->setHydrator(new DoctrineHydrator($objectManager, 'Proto\Entity\Proto', true))
                ->setObject(new Proto());


        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        //EditBy (richiedente)
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'applicant'
        ));


        if (!$editmode) {
            //status
            $this->add(array(
                'type' => 'Zend\Form\Element\Hidden',
                'name' => 'status'
            ));

            //createdDate (boostrap datepicker) [Non funge in modifica]


            $this->add(array(
                'type' => 'Zend\Form\Element\Text',
                'name' => 'requestedDeliveryDate',
                'options' => array(
                    'label' => 'Data inizio',
                ),
                'attributes' => array(
                    'required' => true,
                    'class' => 'form-control',
                )
            ));
        } else {
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
                            'target_class' => 'Proto\Entity\Status',
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

            //requestedDeliveryDate (html 5 API)
            $this->add(array(
                'type' => 'Zend\Form\Element\Date',
                'name' => 'requestedDeliveryDate',
                'options' => array(
                    'label' => 'Data consegna richiesta*'
                ),
                'attributes' => array(
                    //'min' => date('Y-m-d', time()),
                    //'max' => date('Y-m-d', time()),
                    'step' => '1', // days; default step interval is 1 day
                    'class' => 'form-control',
                    'required' => true,
                )
            ));
            //expectedDeliveryDate (html 5 API)
            $this->add(array(
                'type' => 'Zend\Form\Element\Date',
                'name' => 'expectedDeliveryDate',
                'options' => array(
                    'label' => 'Data consegna prevista'
                ),
                'attributes' => array(
                    //'min' => date('Y-m-d', time()),
                    //'max' => date('Y-m-d', time()),
                    'step' => '1', // days; default step interval is 1 day
                    'class' => 'form-control',
                    'required' => false,
                )
            ));            
        }



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

        //partiPlastiche
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'partiPlastiche',
            'options' => array(
                'label' => 'Parti Plastiche',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
            'attributes' => array(
                'id' => 'partiPlastiche',
            )
        ));

        //partiLavMetallo
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'partiLavMetallo',
            'options' => array(
                'label' => 'Parti Lavorazione Metallo',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
            'attributes' => array(
                'id' => 'partiLavmetallo',
            )
        ));

        //partiTrasparenti
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'partiTrasparenti',
            'options' => array(
                'label' => 'Parti Trasparenti',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
            'attributes' => array(
                'id' => 'partiTrasparenti',
            )
        ));

        //partiVerniciate
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'partiVerniciate',
            'options' => array(
                'label' => 'Parti Verniciate',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
            'attributes' => array(
                'id' => 'partiVerniciate',
            )
        ));

        //partiGomma
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'partiGomma',
            'options' => array(
                'label' => 'Parti in Gomma',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
            'attributes' => array(
                'id' => 'partiGomma',
            )
        ));

        //partiMatSpeciale
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'partiMatSpeciale',
            'options' => array(
                'label' => 'Parti Mat. Speciale',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
            'attributes' => array(
                'id' => 'partiMatSpaciale',
            )
        ));

        //serigrafie
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'serigrafie',
            'options' => array(
                'label' => 'Serigrafie',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
            'attributes' => array(
                'id' => 'serigrafie',
            )
        ));

        //notePartiMatSpeciale
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'notePartiMatSpeciale',
            'options' => array(
                'label' => 'Note Parti Mat. Speciale',
            ),
            'attributes' => array(
                'required' => false,
                'class' => 'form-control',
            )
        ));




        //tensione
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'tensione',
            'options' => array(
                'label' => 'Tensione',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));

        //frequenza
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'frequenza',
            'options' => array(
                'label' => 'Frequenza',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));

        //potenza
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'potenza',
            'options' => array(
                'label' => 'Potenza',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));

        //spina
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'spina',
            'options' => array(
                'label' => 'Spina',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));

        //cavo
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'cavo',
            'options' => array(
                'label' => 'Cavo',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));

        //vpp
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'vpp',
            'options' => array(
                'label' => 'Cartella progetto di riferimento o VPP',
            ),
            'attributes' => array(
                'required' => FALSE,
                'class' => 'form-control',
            )
        ));

        //destinazioneUso
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'destinazioneUso',
            'options' => array(
                'label' => 'Destinazione d\'uso*',
            ),
            'attributes' => array(
                'required' => true,
                'class' => 'form-control',
            )
        ));

        //note
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'note',
            'options' => array(
                'label' => 'Note',
            ),
            'attributes' => array(
                'required' => false,
                'class' => 'form-control',
            )
        ));

        //varie
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'varie',
            'options' => array(
                'label' => 'Varie',
            ),
            'attributes' => array(
                'required' => false,
                'class' => 'form-control',
            )
        ));

        //type
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'type',
            'emptyOption' => 'Select..',
            'options' => array(
                'label' => 'Tipo*',
                'value_options' => array(
                    '' => 'Select..',
                    'Prototipo Funzionale' => 'Prototipo funzionale',
                    'Modello Estetico' => 'Modello estetico',
                    'Spare parts per verifiche' => 'Spare parts per verifiche',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'type',
                'required' => true,
            )
        ));


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
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),
            'applicant' => array(
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
            'type' => array(
                'required' => true,
            ),
            'destinazioneUso' => array(
                'required' => true,
            ),
            'requestedDeliveryDate' => array(
                'required' => true,
            ), 
            'expectedDeliveryDate' => array(
                'required' => false,
            ),             
        );
    }

}
