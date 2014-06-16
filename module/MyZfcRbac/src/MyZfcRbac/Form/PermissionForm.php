<?php

namespace MyZfcRbac\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;

class PermissionForm extends Form
{

    public function __construct(ObjectManager $objectManager, $excludeId = NULL)
    {
        parent::__construct('permission-form');

        // The form will hydrate an object of type "BlogPost"
        //$this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setHydrator(new DoctrineHydrator($objectManager, 'MyZfcRbac\Entity\Permission', true));

        // Add the user fieldset, and set it as the base fieldset
        $permissionFieldset = new Fieldset\PermissionFieldset($objectManager);
        if (isset($excludeId)) {
            $permissionFieldset->setExcludeId($excludeId);
        }
        $permissionFieldset->setUseAsBaseFieldset(true);
        $this->add($permissionFieldset);

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'class' => 'btn btn-primary',
                'id' => 'submitbutton',
            ),
        ));
    }

}
