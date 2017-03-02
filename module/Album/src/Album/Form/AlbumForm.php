<?php
namespace Album\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class AlbumForm extends Form
{
    protected $entityManager;

    public function __construct(EntityManager $em)
    {
        // we want to ignore the name passed
        parent::__construct('album');
        $this->entityManager = $em;
    }

    public function init()
    {
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'artist',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'object_manager' => $this->entityManager, //usefull when we want to call custom find method
                'label' => 'Artist',
                'target_class' => 'Album\Entity\Artist',
                'property' => 'label',
                'empty_item_label' => 'Select Artist',
                'required' => true
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}