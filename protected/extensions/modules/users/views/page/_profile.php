<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
  <?php $form=$ctr->beginWidget('CActiveForm', array(
        'id'=>'users-form',
        'action'=>$ctr->createUrl('/'.$module->id.'/page/profile'),
        'htmlOptions'=>array("class"=>"form-horizontal","role"=>"form"),
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true
        ),
  )); ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="profileModalLabel"><?php echo Yii::t('app','Profile')?></h4>
      </div>
    <div class="modal-body">
    <div class="row">
    
    <?php #echo $form->errorSummary($user,"","",array("class"=>"alert alert-danger")); ?>
    <div class="col-lg-6">

    <div class="form-group" style="margin-left:0;margin-right:0;">
        <?php echo $form->labelEx($user,'email',array('class'=>'control-label')); ?>
        <?php echo $form->textField($user,'email',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
        <?php echo $form->error($user,'email',array('class'=>'help-block')); ?>
    </div>
   
    <div class="form-group" style="margin-left:0;margin-right:0;">
        <?php echo $form->labelEx($user,'name',array('class'=>'control-label')); ?>
        <?php echo $form->textField($user,'name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($user,'name',array('class'=>'help-block')); ?>
    </div>
   
    <div class="form-group" style="margin-left:0;margin-right:0;">
        <?php echo $form->labelEx($user,'lastname',array('class'=>'control-label')); ?>
        <?php echo $form->textField($user,'lastname',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($user,'lastname',array('class'=>'help-block')); ?>
    </div>

    <div class="form-group" style="margin-left:0;margin-right:0;">
        <?php echo $form->labelEx($user,'address',array('class'=>'control-label')); ?>
        <?php echo $form->textField($user,'address',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($user,'address',array('class'=>'help-block')); ?>
    </div>

    <div class="form-group" style="margin-left:0;margin-right:0;">
        <?php echo $form->labelEx($user,'phone',array('class'=>'control-label')); ?>
        <?php echo $form->textField($user,'phone',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($user,'phone',array('class'=>'help-block')); ?>
    </div>

    <div class="form-group" style="margin-left:0;margin-right:0;">
        <?php echo $form->labelEx($user,'birthdate',array('class'=>'control-label')); ?>
        <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $user,
                'attribute' => 'birthdate',
                'language' =>  Yii::app()->language,
                'htmlOptions' => array('class'=>'form-control',"autocomplete"=>'off'),
                'options' => array(
                    'showButtonPanel' => true,
                    'changeYear' => true,
                    'dateFormat' => 'yy-mm-dd',
                ),
            ));
        ?>
        <?php echo $form->error($user,'birthdate',array('class'=>'help-block')); ?>
    </div>
    
    <div class="form-group" style="margin-left:0;margin-right:0;">
        <?php echo $form->labelEx($user,'newPassword',array('class'=>'control-label')); ?>
        <?php echo $form->passwordField($user,'newPassword',array('class'=>'form-control',"placeholder"=>$user->getAttributeLabel('newPassword'),"autocomplete"=>'off')); ?>
        <?php echo $form->error($user,'newPassword',array('class'=>'help-block')); ?>
    </div>            
        </div>

        <div class="col-lg-6">
            <div class="">
                <?php #echo $form->labelEx($user,'img',array('class'=>'control-label')); ?>
                <?php echo $this->widget('ext.inputs.uploader.GUpload', array(
                            'model' => $user,
                            'attribute' => 'img',
                            //'sizeValidate' => array('width'=>'300','height'=>'300'),
                            'allowedExtensions'=>array('png','jpg','jpeg','gif'),
                            'actionUrl' => $this->createUrl('upload'),
                        ),true)?>
                <?php echo $form->error($user,'img',array('class'=>'help-block')); ?>
            </div>
        </div>
        
    </div>
    </div>
     
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?php echo CHtml::submitButton(Yii::t('app','Change'),array("class"=>"btn btn-lg btn-primary")); ?>
     </div>
  <?php $ctr->endWidget(); ?>
    
    </div>
  </div>
</div>
