<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(

    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'theme'=>'classic',
    'defaultController'=>'admin',
    'modules' => require(dirname(__FILE__).DIRECTORY_SEPARATOR.'modules.php'),
    'name' => 'VOIQ Test',
     // path aliases
    'aliases' => array(
        // yiistrap configuration
        'bootstrap' => realpath(__DIR__ . '/../extensions/yiistrap'), // change if necessary
        // yiiwheels configuration
        'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'), // change if necessary
    ),
    // preloading 'log' component
    'preload' => array('log'),
    // 'defaultController' => 'admin',
    // autoloading model and component classes
    'import' => array(
        'ext.modules.users.models.*',
        'application.components.*',
        'bootstrap.helpers.TbHtml',
    ),
    // application components
    'components' => array(
        // yiistrap configuration
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),
        // yiiwheels configuration
        'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',   
        ),
        'pol' => array(
            'class' => 'ext.components.pol.GPol',
          
            // Estas son de prueba
            'ApiKey' => '6u39nqhq8ftd0hlvnjfs66eh8c',
            'merchantId' => '500238',
            'accountId' => '500538',
            
            // 'responseUrl' => '/gym/page/response',
            // 'confirmationUrl' => '/gym/page/confirmation',

            'currency' => 'COP',
        ),
        'excel'=>array(
            'class' => 'ext.office.excel.GExcel',
        ),
        'api'=>array(
            'class' => 'ext.components.api.GSlim',
        ),
        'email' => array(
            'class' => 'ext.components.email.GPHPMailer',
            'colorTemplate'=>'#53B6CF',
            'colorFontTemplate'=>'#7f8c8d',
        ),
        'editable' => array(
            'class' => 'ext.components.editable.DEEditable'
        ),
        'format' => array(
            'class' => 'ext.components.format.BFormatter',
        ),
        'security' => array(
            'class' => 'ext.components.security.GSecurityManager',
        ),
        'user' => array(
            'class' => 'ext.components.auth.GSWebUser',
            'allowAutoLogin' => true,
            'loginUrl' => array('/users/page/login'),
            'loginRequiredAjaxResponse' => 'YII_LOGIN_REQUIRED',
        ),
        'cache' => array(
            'class' => 'CFileCache',
            'enabled'=>!YII_DEBUG,
        ),
        'browser' => array(
            'class' => 'ext.components.browser.BrowserHelper',
        ),
        'country' => array(
            'class' => 'ext.components.countries.GCountries',
        ),
        'authManager' => array(
            "class" => "CDbAuthManager",
            "connectionID" => "db",
            "itemTable" => 'users_authitem',
            "itemChildTable" => 'users_authitemchild',
            "assignmentTable" => 'users_authassignment',
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            // 'urlSuffix' => '.html',
            'rules' => array(
                'themes/<theme:\w+>/view/site/<page:\w+\.php>' => 'site/<page>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        // uncomment the following to use a MySQL database
        'db' => require(dirname(__FILE__).DIRECTORY_SEPARATOR.'db.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => '/site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            // array(
            // 	'class'=>'CWebLogRoute',
            // ),
            // array(
            // 	'class'=>'ext.components.log.GEmailLogRoute',
            // 	'enabled'=>!YII_DEBUG,
            // 	'emails'=>array("developer@email.com"),
            // 	'subject'=>"[ERRORS] APP ".time(),
            // 	'levels'=>'error, warning',
            // ),
            ),
        ),
    ),
    'controllerMap'=>array(
        'site'=>array(
            'class'=>'ext.actions.SiteController'
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'adminmail@mail.com',
        'developerEmail' => 'developer@mail.com',
        'version' => 'v1.9.0',
    ),
);
