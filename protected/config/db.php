<?php
$db=array(
	'localhost'=>array(
        'connectionString' => 'mysql:host=127.0.0.1;dbname=voiq-test',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ),
    '199.168.188.18'=>array(
        'connectionString' => 'mysql:host=localhost;dbname=edison',
        'emulatePrepare' => true,
        'username' => 'serveruser',
        'password' => 'serverpassword',
        // 'schemaCachingDuration' => (3600*24*8), // guarda los metadatas en cache
        'charset' => 'utf8',
    ),
);

if(isset($db[$_SERVER['HTTP_HOST']]))
	return $db[$_SERVER['HTTP_HOST']];
return $db['localhost'];
