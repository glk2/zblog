<?php
namespace Admin\Controller;

//use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\BaseAdminController as BaseController;
use Zend\View\Model\ViewModel;

//class IndexController extends AbstractActionController
class IndexController extends BaseController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}