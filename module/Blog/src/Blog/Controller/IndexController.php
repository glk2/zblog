<?php
namespace Blog\Controller;

//use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;

use Application\Controller\BaseAdminController as BaseController;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator; //alias 2 Paginator
use Zend\Paginator\Paginator;

use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Blog\Entity\Comment;

//use Blog\Entity\Article;



class IndexController extends BaseController
{
    public function indexAction()
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query -> add('select','a')
               -> add('from','Blog\Entity\Article a')
               -> add('where','a.isPublic=1')
               -> add('orderBy','a.id ASC');
        $adapter = new DoctrineAdapter(new ORMPaginator($query));
        
        $paginator = new Paginator($adapter); //шаблон проектирования адаптер
        $paginator->setDefaultItemCountPerPage(1);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page',1));

        return array('articles'=>$paginator);
    }
    public function getCommentForm(Comment $comment)
    {
     $builder = new AnnotationBuilder($this->getEntityManager());
     $form = $builder->createForm(new Comment());   
     $form->setHydrator(new DoctrineHydrator($this->getEntityManager(),'\Comment'));
     $form->bind($comment);
     return $form;
    }
    
    public function articleAction()
    {
        $id = (int) $this->params()->fromRoute('id',0);
        $em = $this->getEntityManager();
        $article = $em->find('Blog\Entity\Article',$id);
        if (empty($article)){
            return $this->notFoundAction();
        }
        
        $comment = new Comment();
        $form = $this->getCommentForm($comment);
        
        return array('article'=>$article, 'form' => $form);
    }    
    
}