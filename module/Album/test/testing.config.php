<?php

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'default_repository_class_name' => 'DoctrineORMModuleTest\Assets\RepositoryClass',
            ],
        ],
        'driver' => [
            'DoctrineORMModuleTest\Assets\Entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/DoctrineORMModuleTest/Assets/Entity'
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'DoctrineORMModuleTest\Assets\Entity' => 'DoctrineORMModuleTest\Assets\Entity',
                ],
            ],
        ],
        'entity_resolver' => [
            'orm_default' => [
                'resolvers' => [
                    'DoctrineORMModuleTest\Assets\Entity\TargetInterface'
                    => 'DoctrineORMModuleTest\Assets\Entity\TargetEntity',
                ],
            ],
        ],
        'connection' => [
            'orm_default' => [
                'configuration' => 'orm_default',
                'eventmanager'  => 'orm_default',
                'driverClass'   => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => [
                    'memory' => true,
                ],
            ],
        ],
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'build/',
            ],
        ],
    ],
];