<?php
/* @var $this AppsController */
/* @var $model Apps */

$this->breadcrumbs=array(
	'Apps'=>array('admin'),
	'API',
);

?>
<div class="row">
	<div class="col-lg-12">

<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">
				
        <p> You've created an Access Token for making API calls on behalf of : </p>
        <div class="bs-example">
            <pre class="alert-info"><h3><?php echo $token->acces_token?></h3><h3></h3></pre>
        </div>
    
        <p>
            Now you can <a href="<?php echo $this->createUrl('/api')?>">call the APIs</a>!
        </p>
    
        </div>
    </div>
</section>


		
	</div>
</div>