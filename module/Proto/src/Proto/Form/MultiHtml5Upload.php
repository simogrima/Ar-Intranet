<?php

namespace Proto\Form;

use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element;

class MultiHtml5Upload extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->setInputFilter($this->createInputFilter());
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('file');
        $file
            ->setLabel('Allegati')
            ->setAttributes(array('multiple' => true, 'id' => 'file1'));
        $this->add($file);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'proto_id'
        ));    
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'supply_id'
        ));           
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'type'
        ));         
    }

    public function createInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        // File Input
        $file = new InputFilter\FileInput('file');
        $file->setRequired(true);
        $file->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'          => './public' . $this->options['attachmentPath'], //'./data/tmpuploads/',
                'overwrite'       => true,
                'use_upload_name' => true,
                'randomize' => true,
            )
        );
        //$file->getValidatorChain()->addByName(
        //    'fileextension', array('extension' => 'txt')
        //);
        $inputFilter->add($file);
        
        // Proto_id Input
        //$protoId = new InputFilter\Input('proto_id');
        //$protoId->setRequired(true);
        //$inputFilter->add($protoId);   
        
        // Type Input
        $type = new InputFilter\Input('type');
        $type->setRequired(true);
        $inputFilter->add($type);          

        return $inputFilter;
    }
}