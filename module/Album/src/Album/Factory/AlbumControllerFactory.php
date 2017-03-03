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
        
        return new AlbumController($entityManager);
    }
}