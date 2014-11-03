<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Detalles de usuarios</h4>
		</div>
		<div class="modal-body">
		
			<!-- Nav tabs -->
			<ul class="nav nav-tabs">
			  <li class="active"><a href="#home" data-toggle="tab">Datos básicos</a></li>
			  <li><a href="#profile" data-toggle="tab">Roles</a></li>
			</ul>
		
			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active" id="home">
					

					<?php $this->widget('zii.widgets.CDetailView', array(
						'data'=>$model,
						'htmlOptions'=>array('class'=>'table table-striped'),
						'attributes'=>array(
							'id',
							array(
								'name'=>'img',
								'type'=>'html',
								'value'=>$model->getImageObject(),
							),
							array(
								'name'=>'email',
								'type'=>'raw',
								'value'=>Yii::app()->editable->link($model, "email", $this->createUrl("editable")),
							),
							array(
								'name'=>'name',
								'type'=>'raw',
								'value'=>Yii::app()->editable->link($model, "name", $this->createUrl("editable")),
							),
							array(
								'name'=>'lastname',
								'type'=>'raw',
								'value'=>Yii::app()->editable->link($model, "lastname", $this->createUrl("editable")),
							),
							array(
								'name'=>'state',
								'type'=>'raw',
								'value'=>$model->statusEditable($this->createUrl("editable")),
							),
							'username',
						),
					)); ?>
				

				</div>
				<div class="tab-pane" id="profile">
					<?php echo $this->renderPartial('_role',array('model'=>$model,'role'=>$role)); ?>
				</div>
			</div>

			<div class="modal-footer">
				<?php if(!Yii::app()->authManager->checkAccess('root',$model->id) or !Yii::app()->authManager->checkAccess('admin',$model->id)):?>
					<a class="btn btn-danger pull-left" href="<?php echo $this->createUrl("delete",array("id"=>$model->id))?>" data-action="delete">Eliminar</a>
				<?php endif;?>
				<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>