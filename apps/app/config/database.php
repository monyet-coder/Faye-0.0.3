<?php
return array (
    'active' => 'default',

    'default' => array(
        'driver'    => array(
            'type' => 'sql',
            'name' => 'mysql',
        ),
        'host'      => 'localhost',
        'username'  => 'root',
        'password'  => '',
        'name'      => 'faye',
    ),

    'mongo' => array(
        'driver'    => array(
            'type' => 'nosql',
            'name' => 'mongo',
        ),
        'host'      => 'localhost',
        'username'  => 'tralala',
        'password'  => 'trilili',
        'name'      => 'faye'
    ),
);