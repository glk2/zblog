<?php
namespace Admin\Controller;

use Application\Controller\BaseAdminController as BaseController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator; //alias 2 Paginator
use Zend\Paginator\Paginator;
//use Admin\Form\CategoryAddForm;
use Blog\Entity\Article;

use Admin\Form\ArticleAddForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class ArticleController extends BaseController
{
    public function indexAction()
    { 
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('a')
              ->from('Blog\Entity\Article','a')
              ->orderBy('a.id','DESC');
        $adapter = new DoctrineAdapter(new ORMPaginator($query));
        $paginator = new Paginator($adapter); //шаблон проектирования адаптер
        $paginator->setDefaultItemCountPerPage(2);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page',1));
        //var_dump($paginator);
        return array('articles'=>$paginator);
    }
    
    public function addAction() {
        $em = $this->getEntityManager();
        $form = new ArticleAddForm($em);
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
           $message = $status = '';
           $data = $request->getPost();
           
           $article = new Article();
           $form->setHydrator(new DoctrineHydrator($em,'\Article')); //гидратор категорию подтянет
           $form->bind($article);
           $form->setData($data);
           
           if ($form->isValid()) {
               $em->persist($article);
               $em->flush();
               $status = 'success';
               $message = 'Статья добавлена';
           } else {
               $status = 'error';
               $message = 'Ошибка параметров';
               //собираем сообщения потому что редирект идет 
               foreach ($form->getInputFilter()->getInvalidInput() as $errors){
                   foreach ($errors->getMessages() as $error) {
                       $message .= ' '.$error;
                   }
                   
               }
           }
        } else {
            return array('form' => $form); 
        }

        if ($message){
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/article');        
        
    }

public function editAction() {
        
        $message = $status = '';
        $em = $this->getEntityManager();
        $form = new ArticleAddForm($em);
        
                
        $id = (int) $this->params()->fromRoute('id',0);
        $article = $em->find('Blog\Entity\Article',$id);
        
        if (empty($article)){
            $status = 'error';
            $message = 'Статья не найдена';
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
            return $this->redirect()->toRoute('admin/article');    
        }                
        
        $form->setHydrator(new DoctrineHydrator($em,'\Article')); //гидратор категорию подтянет
        $form->bind($article);
        
       
        $request = $this->getRequest();
        if ($request->isPost()) {
           $data = $request->getPost(); 
           $form->setData($data); 
           if ($form->isValid()) {
               $em->persist($article);
               $em->flush();
               
               $status = 'success';
               $message = 'Статья обновлена';
           } else {
               $status = 'error';
               $message = 'Ошибка параметров';
               foreach ($form->getInputFilter()->getInvalidFilter() as $errors){
                   foreach ($errors->getMessages() as $error) {
                       $message .= ' '.$error;
                   }
                   
               }
           }
        } else {
            return array('form' => $form, 'id' => $id); 
        }
        
        if ($message){
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/article');        
    
        
    }
    
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id',0);         
        $em = $this->getEntityManager();
        
        $status = 'success';
        $message = 'Запись удалена';
        try {
          $repository = $em->getRepository('Blog\Entity\Article');
          
          $item = $repository->find($id);
          $em->remove($item);
          $em->flush();
        } catch (\Exception $ex) {
            $status = 'error';
            $message = 'Ошибка удаления записи: '.$ex->getMessage();
        }

        $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);

        return $this->redirect()->toRoute('admin/article'); 

    }    
    
    
}    