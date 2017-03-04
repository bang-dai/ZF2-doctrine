<?php


namespace AlbumTest\Controller;


use Album\Controller\ArtistController;
use Album\Entity\Artist;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ArtistControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp()
    {

        $this->setApplicationConfig(
            //include dirname(__DIR__).'/../../../../config/application.config.php'
            include dirname(__DIR__).'/../TestConfig.php'
        );
        parent::setUp();
    }



    public function testIndexActionCanBeAccessed()
    {

        /*
        $artist = $this->createMock(Artist::class);

        $artist->expects($this->once())
            ->method('getLabel')
            ->will($this->returnValue('label'));

        $artistRepo = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $artistRepo->expects($this->once())
            ->method('find')
            ->will($this->returnValue($artist));

        $em = $this
            ->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($artistRepo));

        $emMock  = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->setMethods(array('persist', 'flush'))
            ->disableOriginalConstructor()
            ->getMock();

        $emMock->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));
        $emMock->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));


        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('doctrine.orm.default_entity_manager', $emMock);
        */


        $this->dispatch('/artist');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Artist');
        $this->assertControllerName('Album\Controller\Artist');
        $this->assertControllerClass('ArtistController');
        $this->assertMatchedRouteName('artist');

    }

}