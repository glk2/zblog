<?php
namespace Admin\Controller;

//use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;

use Application\Controller\BaseAdminController as BaseController;
use Admin\Form\CategoryAddForm;
use Blog\Entity\Category;

class CategoryController extends BaseController
{
    public function indexAction()
    {   //локатор позволяет получить доступ к объекту, зарегили объект (через класc, в сервис конфиг, в модуле) обращаемся к нему, 
        //создает объект, повторно не обращает, надо сообщить локатору как обращаться к объекту
        //$entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        //$query = $entityManager->createQuery('select u from Blog\Entity\Category u order by u.id desc');
        
        //$em= $this->getEntityManager();
        //$query = $em->createQuery('select u from Blog\Entity\Category u order by u.id desc');
        $query = $this->getEntityManager()->createQuery('select u from Blog\Entity\Category u order by u.id desc');
        $rows = $query->getResult();
       // var_dump($entityManager);
        //var_dump($rows);
        return array('category'=>$rows);
        //return new ViewModel();        
    }
    
    public function addAction() {
        $form = new CategoryAddForm;
        $status = $messadge = '';
        $em = $this->getEntityManager();
        $request = $this->getRequest();
        if ($request->isPost()) {
           $form->setData($request->getPost()); 
           if ($form->isValid()) {
               $category = new Category();
               $category->exchangeArray($form->getData());
               $em->persist($category);
               $em->flush();
               $status = 'success';
               $message = 'Категория добавлена';
           } else {
               $status = 'error';
               $message = 'Ошибка параметров';
           }
        } else {
            return array('form' => $form); 
        }
        if ($message){
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/category'); 
    }
    
    public function editAction() {
        $form = new CategoryAddForm;
        $status = $messadge = '';
        $em = $this->getEntityManager();
        
        $id = (int) $this->params()->fromRoute('id',0);
        $category = $em->find('Blog\Entity\Category',$id);
        
        if (empty($category)){
            $status = 'error';
            $message = 'Категория не найдена';
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
            return $this->redirect()->toRoute('admin/category');    
        }
        
        $form->bind($category); //привязка формы к категории данные автоматически ?
        $request = $this->getRequest();
        if ($request->isPost()) {
           $data = $request->getPost(); 
           $form->setData($data); 
           if ($form->isValid()) {
               $em->persist($category);
               $em->flush();
               
               $status = 'success';
               $message = 'Категория обновлена';
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
        return $this->redirect()->toRoute('admin/category');         
        
    }
    
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id',0);         
        $em = $this->getEntityManager();
        $status = 'success';
        $message = 'Запись удалена';
        try {
          $repository = $em->getRepository('Blog\Entity\Category');
          
          $category = $repository->find($id);
          $em->remove($category);
          $em->flush();
        } catch (\Exception $ex) {
            $status = 'error';
            $message = 'Ошибка удаления записи: '.$ex->getMessage();
        }

        $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);

        return $this->redirect()->toRoute('admin/category'); 

    }
    
}