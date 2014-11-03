<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/ico/favicon.ico">

    <!-- Custom styles for this template + core an l¡more mixin for this template -->
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.min.css" rel="stylesheet">
    
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php echo $this->builtHeader()?>
 
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      
    </div>
  
    <div class="container session-message">
		<?php if(($msgs=$this->builtMessages())!==null and $msgs!==array()):?>
		<div class="row">
		  <div class="col-lg-12">
		    <?php foreach($msgs as $type => $message):?>
		      <div class="alert alert-<?php echo $type?>">
		        <button type="button" class="close" data-dismiss="alert">&times;</button>
		        <?php echo $message?>
		      </div>
		    <?php endforeach;?>
		  </div>
		</div>
		<?php endif;?>
	  </div>
    
    <div class="container">
      <?php echo $content; ?>
    </div><!-- content -->


    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootbox.min.js"></script>
    <?php echo $this->builtEndBody()?>
  </body>
</html>