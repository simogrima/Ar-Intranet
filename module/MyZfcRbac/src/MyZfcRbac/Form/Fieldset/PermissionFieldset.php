<?php

namespace MyZfcRbac\Form\Fieldset;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use MyZfcRbac\Entity\Permission;
use MainModule\Validator\Doctrine\NoObjectExists;


class PermissionFieldset extends Fieldset implements InputFilterProviderInterface
{

    protected $em;
    protected $excludeId;

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('permission');

        $this->em = $objectManager;

        //$this->setHydrator(new DoctrineHydrator($objectManager))
          $this->setHydrator(new DoctrineHydrator($objectManager, 'MyZfcRbac\Entity\Permission', true))
                ->setObject(new Permission());

        $this->add(array(
            'type' => 'hidden',
            'name' => 'id',
            'value' => 0,
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'name',
            'options' => array(
                'label' => 'Permission'
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => FALSE
            ),
            'name' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'MainModule\Validator\Doctrine\NoObjectExists',
                        'options' => array(
                            'object_repository' => $this->em->getRepository('MyZfcRbac\Entity\Permission'),
                            'fields' => 'name',
                            'exclude' => array('field' => 'id','value' => (int) $this->excludeId),
                            'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => 
                                    "This permission already exists in database.")
                        )
                    )
                )
            )
        );
    }
    
    /**
     * Usata in edit mode dal mio MainModule\Validator\Doctrine\NoObjectExists
     * per escludere l'id del record editato.
     * 
     * @param int $id
     */
    public function setExcludeId($id)
    {
        $this->excludeId = $id;
    }        

}
