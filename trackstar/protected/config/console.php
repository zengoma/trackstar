<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
            
            
                 'authManager'=>array(
                   'class'=>'CDbAuthManager',
                   'connectionID'=>'db',
                   'itemTable' =>'tbl_auth_item',
                   'itemChildTable' =>'tbl_auth_item_child',
                   'assignmentTable' =>'tbl_auth_assignment',
                   ),
		
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=trackstar',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'cyborg3526',
			'charset' => 'utf8',
		),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);