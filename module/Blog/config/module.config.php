<?php

return array(
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'blog_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Blog/Entity',
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace` 'My\Namespace' => 'my_annotation_driver'
                    'Blog\Entity' => 'blog_entity'
                )
            )
        )
    ),    
    
    'router' => array(
        'routes' => array(
            'blog' => array( // маршрут названние псевдоним, можем обращаться
                'type' => 'segment',
                'options' => array(
                    'route'    => '/[:action/][:id/]',
                    'constraints' => array(
                            'id'         => '[0-9]+',
                            'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Index', //использовали псевдоним описанный ранее
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Blog\Controller\Index' => 'Blog\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);