<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Album\Entity\Album;
use Album\Form\AlbumForm;

class AlbumController extends AbstractActionController
{
    /**   
     * Entity manager instance
     *           
     * @var Doctrine\ORM\EntityManager
     */                
    protected $em;
    protected $albumForm;

    public function __construct(EntityManager $em, AlbumForm $albumForm)
    {
        $this->em = $em;
        $this->albumForm = $albumForm;
    }

    /**
     * Returns an instance of the Doctrine entity manager loaded from the service 
     * locator
     * 
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
    
    /**
     * Index action displays a list of all the albums
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(
            array(
                'albums' => $this->getEntityManager()->getRepository('Album\Entity\Album')->findAll() 
            )
        );
    }

    public function addAction()
    {
        $form = $this->albumForm;
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                $album->populate($data);
                $artist = $this->getEntityManager()->getRepository('Album\Entity\Artist')->find($data['artist']);
                if($artist){
                    $album->setArtist($artist);
                    $this->getEntityManager()->persist($album);
                    $this->getEntityManager()->flush();
                }
                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'add'
            ));
        }
        $album = $this->getEntityManager()->find('Album\Entity\Album', $id);

        $form  = $this->albumForm;
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $album = $this->getEntityManager()->find('Album\Entity\Album', $id);
                if ($album) {
                    $this->getEntityManager()->remove($album);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return array(
            'id'    => $id,
            'album' => $this->getEntityManager()->find('Album\Entity\Album', $id)
        );
    }
}