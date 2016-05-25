<?php

namespace Prototyping\Form;

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
            'name' => 'prototyping_id'
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
        
        // Prototyping_id Input
        $prototypingId = new InputFilter\Input('prototyping_id');
        $prototypingId->setRequired(true);
        $inputFilter->add($prototypingId);         

        return $inputFilter;
    }
}