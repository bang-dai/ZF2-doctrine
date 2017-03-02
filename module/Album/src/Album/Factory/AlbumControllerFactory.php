<?php

namespace Album\Factory;

use Album\Controller\AlbumController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AlbumControllerFactory implements FactoryInterface
{

   
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        $entityManager = $services->get('doctrine.entitymanager.orm_default');
        $albumForm = $services->get('FormElementManager')->get('Album\Form\AlbumForm');
        
        return new AlbumController($entityManager, $albumForm);
    }
}