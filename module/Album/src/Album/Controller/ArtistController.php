<?php
namespace Album\Controller;

use Album\Entity\Artist;
use Album\Form\ArtistForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Album\Entity\Album;

class ArtistController extends AbstractActionController
{
    /**   
     * Entity manager instance
     *           
     * @var Doctrine\ORM\EntityManager
     */                
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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
                'artists' => $this->getEntityManager()->getRepository('Album\Entity\Artist')->findAll() 
            )
        );
    }

    public function addAction()
    {
        $form = new ArtistForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $artist = new Artist();
            $form->setInputFilter($artist->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $artist->populate($form->getData());
                $this->getEntityManager()->persist($artist);
                $this->getEntityManager()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('artist');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('artist', array(
                'action' => 'add'
            ));
        }
        $artist = $this->getEntityManager()->find('Album\Entity\Artist', $id);

        $form  = new ArtistForm();
        $form->bind($artist);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($artist->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('artist');
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
            return $this->redirect()->toRoute('artist');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $artist = $this->getEntityManager()->find('Album\Entity\Artist', $id);
                if ($artist) {
                    // TODO : if artist is deleted, album deleted too ?
                    $this->getEntityManager()->remove($artist);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('artist');
        }

        return array(
            'id'    => $id,
            'artist' => $this->getEntityManager()->find('Album\Entity\Artist', $id)
        );
    }
}