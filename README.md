# How to Install? #

## Step 1 Download ##
Clone the project 

## Step 2 Setting database ##
- Create a MYSQL database from your favorite database admin and run the sql file located in:
/protected/agenda.sql 

- Them we're gonna to 
/protected/config/db.php

Here's config database for each host that you use
```
#!php

$db=array(
// if you have an virtual host created on your local machine you
// must put it here instead of localhost for example
// 	'miproyect.local'=>array(
	
        'localhost'=>array(
        'connectionString' => 'mysql:host=localhost;dbname=agenda',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ),
);

```


## Step 3 Open your browser ##
Open your browser on http://localhost/myprojectname and enjoy the modules

PD: If you are using Mac(OS) or Linux you need to give some permissions
```
#!bash
sudo chmod -R 777 myprojectname/protected/runtime 
sudo chmod -R 777 myprojectname/assets
sudo chmod -R 777 myprojectname/uploads
```


If you want to be more carefully use the group of apache process
```
#!bash
sudo chown -R nameyouruser:wwworapachegroup myprojectname

# And then you just give 775 access 
sudo chmod -R 775 myprojectname/protected/runtime 
sudo chmod -R 775 myprojectname/assets
sudo chmod -R 775 myprojectname/uploads
```

 


PD: If you had clone from of git repository this is the .htaccess content file recommended in your download is included 
```
#!bash

RewriteEngine on
# Maybe you will need uncomment this line according to your BasePath
# RewriteBase /~menteswe/myproyectname/

# This is for OAuth2 Implementation of "Authorization" parameter
RewriteCond %{HTTP:Authorization} ^(.*)
RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]

# This is for uploader pluging
# php_value post_max_size 100M
# php_value upload_max_filesize 100M

# if a directory or a file exists, use it directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# otherwise forward it to index.php
RewriteRule . index.php
```
