<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'category' => 'Admin\Controller\CategoryController',
            'article' => 'Admin\Controller\ArticleController'
        ),
    ),

    'router' => array(
        'routes' => array(
            'admin' => array( // маршрут названние псевдоним, можем обращаться
                'type' => 'literal',
                'options' => array(
                    'route'    => '/admin/', // для сео оптимизации /
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index', //использовали псевдоним описанный ранее
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,    
                'child_routes' => array(
                    'category' => array( // маршрут названние псевдоним, можем обращаться
                        'type' => 'segment',
                        'options' => array(
                            'route'    => 'category/[:action/][:id/]', //
                            'defaults' => array(
                                'controller' => 'category', //использовали псевдоним описанный ранее
                                'action'     => 'index',
                            ),
                        ),
                    ),
                     'article' => array( // маршрут названние псевдоним, можем обращаться
                        'type' => 'segment',
                        'options' => array(
                            'route'    => 'article/[:action/][:id/]', //
                            'defaults' => array(
                                'controller' => 'article', //использовали псевдоним описанный ранее
                                'action'     => 'index',
                            ),
                        ),
                    ),                    
                ), //child_routes            
            ), //main routes
        
    ),
    ), //router
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'pagination_control' => __DIR__ . '/../view/layout/pagination_control.phtml',
        ),        
    ),
);