<?php

namespace Application\Controller;

class BaseAdminController extends BaseController
{

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        //$this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
         
        return parent::onDispatch($e);
    }
    
  

    
}