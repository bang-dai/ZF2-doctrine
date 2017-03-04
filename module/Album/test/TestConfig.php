<?php
return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'Album',
        'Application'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            __DIR__.'/testing.config.php',
        ),
        'module_paths' => array(
            'module',
            'vendor',
        ),
    ),

);