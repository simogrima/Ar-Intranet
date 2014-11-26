<?php
namespace Application\Form;

use Zend\Form\Form;
use \Zend\Form\Element;

class SearchForm extends Form
{
    public function __construct($name = null)
    {
        //setto il nome chimando il parent’s constructor
        parent::__construct('search-form');
        $this->setAttribute('class', 'navbar-form navbar-right');
        $this->setAttribute('method', 'post');

        $search = new Element\Text('search');
        $search->setLabel('Search')
                ->setAttribute('class', 'form-control')
                ->setAttribute('placeholder', 'Search');

        $submit = new Element\Submit('submit');
        $submit->setValue('Search')
                ->setAttribute('class', 'btn btn-primary');

        $this->add($search);
        $this->add($submit);

    }
}