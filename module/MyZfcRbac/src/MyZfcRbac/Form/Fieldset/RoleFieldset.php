<?php

namespace MyZfcRbac\Form\Fieldset;

use MyZfcRbac\Entity\FlatRole as Role;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use MyZfcRbac\Entity\FlatRole;
use MainModule\Validator\Doctrine\NoObjectExists;

class RoleFieldset extends Fieldset implements InputFilterProviderInterface
{
    protected $em;
    protected $excludeId;
    
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('role');
        
        $this->em = $objectManager;

        //$this->setHydrator(new DoctrineHydrator($objectManager))
        $this->setHydrator(new DoctrineHydrator($objectManager, 'MyZfcRbac\Entity\FlatRole', true))
                ->setObject(new Role());

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'options' => array(
                'label' => 'Name'
            ),
            'attributes' => array(
                'required' => true,
            )              
        ));


        $permissionFieldset = new PermissionFieldset($objectManager);
        $ifs = $permissionFieldset->getInputFilterSpecification();

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'permissions',
            'options' => array(
                'label' => 'Select Permissions',
                'object_manager' => $objectManager,
                'should_create_template' => true,
                'target_class' => 'MyZfcRbac\Entity\Permission',
                'property' => 'name',
                'target_element' => $permissionFieldset,
            )           
        ));
        
        /**
        //Multiselect
        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'permissions',
            'options' => array(
                'label' => 'Select Permissions',
                'object_manager' => $objectManager,
                'should_create_template' => true,
                'target_class' => 'MyZfcRbac\Entity\Permission',
                'property' => 'name',
                'target_element' => $permissionFieldset,
            ),
                'attributes' => array(
                    'multiple' => 'multiple',
                )             
        ));    
         * 
         */            
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),
            'name' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'MainModule\Validator\Doctrine\NoObjectExists',
                        'options' => array(
                            'object_repository' => $this->em->getRepository('MyZfcRbac\Entity\FlatRole'),
                            'fields' => 'name',
                            'exclude' => array('field' => 'id','value' => (int) $this->excludeId),
                            'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => 
                                    "This permission already exists in database.")
                        )
                    )
                )
            ),     
            'permissions' => array(
                'required' => false
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
