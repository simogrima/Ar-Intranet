<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Samples\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Controller\EntityUsingController;
use Samples\Entity\Sample;

//Doctrine
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
//Form
use Samples\Form\CreateSampleForm;

class IndexController extends EntityUsingController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    /**
     * Non-existing entity in the association
     * 
     * Creo il post ed i tags
     * Poi idrato.
     * Funziona xchè nell'entità BlogPost ho definito due funzioni: addTags e removeTags. 
     * Tali funzioni devono essere sempre definite e vengono chiamate automaticamente dal 
     * Doctrine hydrator quando si tratta di collezioni.
     * 
     * Inoltre affinche siano memorizzati anche i tags (nuovi) è necessario 
     * modificare leggermente la mappatura, in modo che Doctrine possa persistere 
     * nuove entità sulle associazioni (notare le opzioni a cascade sulla associazione OneToMany):
     * nell'entità BlogPost
     * @ORM\OneToMany(targetEntity="Application\Entity\Tag", mappedBy="blogPost", cascade={"persist"})
     */
    public function example1Action()
    {
        $hydrator = new DoctrineHydrator($this->getEntityManager());
        $blogPost = new BlogPost();

        $tags = array();

        $tag1 = new Tag();
        $tag1->setName('PHP');
        $tags[] = $tag1;

        $tag2 = new Tag();
        $tag2->setName('STL');
        $tags[] = $tag2;

        $data = array(
            'title' => 'The best blog post in the world !',
            'tags' => $tags // Note that you can mix integers and entities without any problem
        );

        $blogPost = $hydrator->hydrate($data, $blogPost);

        echo $blogPost->getTitle(); // prints "The best blog post in the world !"
        echo count($blogPost->getTags()); // prints 2

        return false;
    }

    /**
     * Existing entity in the association
     * Vedi example1Action
     */
    public function example2Action()
    {
        $hydrator = new DoctrineHydrator($this->getEntityManager());
        $blogPost = new BlogPost();
        $data = array(
            'title' => 'The best blog post in the world !',
            'tags' => array(
                array('id' => 3), // add tag whose id is 3
                array('id' => 8)  // also add tag whose id is 8
            )
        );

        $blogPost = $hydrator->hydrate($data, $blogPost);

        echo $blogPost->getTitle(); // prints "The best blog post in the world !"
        echo count($blogPost->getTags()); // prints 2

        return FALSE;
    }

    public function createAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        // Create the form and inject the ObjectManager
        $form = new CreateSampleForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $sample = new Sample();
        $form->bind($sample);




        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $objectManager->persist($sample);
                $objectManager->flush();
            }
        }


        return array('form' => $form);
    }

    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        // Create the form and inject the ObjectManager
        $form = new CreateBlogPostForm($objectManager);

        // Create a new, empty entity and bind it to the form

        $blogPost = $this->getEntityManager()->getRepository('Application\Entity\BlogPost')->find(2);
        ;
        var_dump($blogPost->getTags()->toArray());
        $form->bind($blogPost);

        $form->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'numbers',
            'options' => array(

		'value_options' => array(

        	"1" => 'One',

            "2"	=> "Two", 

			"3"	=> "Three",

			"4"	=> "Four",

			"5"	=> "Five",

	    ),

	),
            'attributes' => array(
                'value' => '',
                'id' => 'numbers',
                'size' => '5',
                'multiple' => 'multiple'
            )
        ));

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                // Save the changes
                $objectManager->flush();
            }
        }

        return array('form' => $form);
    }

}
