<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo Yii::app()->theme->baseUrl?>/css/style.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo Yii::app()->theme->baseUrl?>/css/ionicons.min.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="skin-black fixed">

        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo $this->createUrl('/admin')?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                CMS <?php echo ucwords(strtolower(Yii::app()->name));?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                            
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        
                        <li class="dropdown user user-menu">

                            <?php if(!Yii::app()->user->isGuest):?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo Yii::app()->user->name?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue" style="height:40px">
                                       <?php echo Yii::app()->user->email?>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?php echo CHtml::link('Profile',Yii::app()->getModule('users')->urlProfile,array('class'=>'btn btn-default btn-flat'))?>
                                    </div>
                                    <div class="pull-right">
                                        <?php echo CHtml::link('Log out',Yii::app()->getModule('users')->urlLogout,array('class'=>'btn btn-default btn-flat'))?>
                                    </div>
                                </li>
                            </ul>
                            <?php endif;?>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo Yii::app()->user->img?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo Yii::app()->user->name?></p>
                            <a class="text-success" href="<?php echo $this->createUrl('/')?>">
                                <i class="fa fa-desktop"></i>
                                <span>Ver sitio</span>
                            </a>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                    <?php foreach($this->builtMenu() as $menu):?>
                    <?php if(isset($menu['visible']) and !$menu['visible']) continue;?>
                    <?php $sub=array();?>
                    <?php $activeMenu='';?>
                    <?php if(isset($menu['items']) and $menu['items']!==array()) $sub=$menu['items']; ?>
                    <?php $activeMenu=(!empty($menu["url"]) and strpos(Yii::app()->request->getRequestUri(),CHtml::normalizeUrl($menu["url"]))!==false)?"active":""?>
                    <?php $tree=($sub!==array())?$activeMenu." treeview":$activeMenu."";?>
                    
                    <li class="<?php echo $tree?>">
                        <a href="<?php echo empty($menu["url"])?"#":CHtml::normalizeUrl($menu["url"]);?>">
                            <?php if(!empty($menu["icon"])):?>
                                <i class="<?php echo $menu["icon"]?>"></i>
                            <?php endif;?>
                            <span><?php echo $menu["label"]?></span>
                            <?php echo $sub!==array()?"<i class=\"fa fa-angle-left pull-right\"></i>":"";?>
                        </a>
                        <?php if($sub!==array()):?>
                            <?php $style=""?>
                            <?php foreach($sub as $submenu):?>
                            <?php if((!empty($submenu["url"]) and strpos(Yii::app()->request->getRequestUri(),CHtml::normalizeUrl($submenu["url"]))!==false)):?>
                                <?php $style="overflow: hidden; display: block;"?>
                            <?php endif;?>
                            <?php endforeach;?>
                            <ul class="treeview-menu" style="<?php echo $style?>">
                            <?php foreach($sub as $submenu):?>
                            <?php if(isset($submenu['visible']) and !$submenu['visible']) continue;?>
                                <li>
                                    <a class="<?php echo (!empty($submenu["url"]) and strpos(Yii::app()->request->getRequestUri(),CHtml::normalizeUrl($submenu["url"]))!==false)?"active":""?>" 
                                        href="<?php echo empty($submenu["url"])?"#":CHtml::normalizeUrl($submenu["url"]);?>">
                                        <?php if(!empty($submenu["icon"])):?>
                                            <i class="<?php echo $submenu["icon"]?>"></i>
                                        <?php endif;?>
                                        <?php echo $submenu["label"]?>
                                    </a>
                                </li>
                            <?php endforeach;?>
                            </ul>
                        <?php endif;?>
                    </li>
                    <?php endforeach;?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                    <?php if(isset($this->title) and $this->title!==null):?>
                        <?php echo $this->title;?>
                        <?php if(isset($this->subTitle) and $this->subTitle!==null):?>
                            <small><?php echo $this->subTitle?></small>    
                        <?php endif;?>    
                    <?php else:?>
                        &nbsp;    
                    <?php endif;?>    
                    <span class="loading"></span></h1>
                    <?php if(!empty($this->breadcrumbs)):?>
                      <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                        'htmlOptions'=>array("class"=>"breadcrumb"),
                        'homeLink'=>CHtml::link("Home",Yii::app()->homeUrl),
                        'links'=>$this->breadcrumbs,
                      )); ?><!-- breadcrumbs -->
                    <?php endif?>
                </section>

                <!-- Main content -->
                <section class="content">
                <?php echo $content;?>
                <div class="text-center"><small>Elfic <?php echo Yii::app()->params['version']?></small></div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- add new calendar event modal -->

        <script src="<?php echo Yii::app()->theme->baseUrl?>/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl?>/js/AdminLTE/app.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootbox.min.js"></script>
        <script src="<?php echo $this->themeUrl(); ?>/js/moment-with-locales.js"></script>
    </body>
</html>