<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php'; //конфиги
    }

    public function getAutoloaderConfig()
    { //исходники модуля
        return array(
            'Zend\Loader\StandardAutoloader' => array( //исходники
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
         return array(
             'factories'=> array(
             'Admin\Service\IsExistValidator' => function ($serviceLocator) {
               $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
               $repository = $entityManager->getRepository('Blog\Entity\User');
               return new \Admin\Service\IsExistValidator($repository); //замена сервиса
             },
            ),           
          );
        }
    
    
    
    }
