<?php

namespace Album\Factory;

use Album\Controller\ArtistController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ArtistControllerFactory implements FactoryInterface
{

   
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        
        return new ArtistController($em);
    }
}