<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'Dashboard',
);
?>
<?php #return;?>
<?php foreach($this->builtDashboardCounters() as $data):?>
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box <?php echo isset($data['type'])?$this->module->getTypeClass($data['type']):'bg-aqua';?>">
        <div class="inner">
            <h3>
                <?php echo isset($data['count'])?$data['count']:Yii::t('app','Empty');?>
            </h3>
            <p>
                <?php echo isset($data['label'])?$data['label']:Yii::t('app','Empty');?>
            </p>
        </div>
        <div class="icon">
            <i class="<?php echo isset($data['icon'])?$data['icon']:'fa fa-signal';?>"></i>
        </div>
        <a href="<?php echo isset($data['url'])?CHtml::normalizeUrl($data['url']):'#';?>" class="small-box-footer">
            <?php echo Yii::t('app','More info')?> <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div><!-- ./col -->
<?php endforeach;?>
<?php foreach($this->builtDashboardReports() as $data):?>
	<section class="col-lg-6 connectedSortable ui-sortable"> 
        <!-- Box (with bar chart) -->
    <div class="box box-<?php echo isset($data['type'])?$data['type']:'danger';?>" id="loading-example">
        <div class="box-header">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <!-- <button class="btn btn-<?php echo isset($data['type'])?$data['type']:'danger';?> btn-sm refresh-btn" data-toggle="tooltip" title="" data-original-title="Reload"><i class="fa fa-refresh"></i></button> -->
                <button class="btn btn-<?php echo isset($data['type'])?$data['type']:'danger';?> btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-<?php echo isset($data['type'])?$data['type']:'danger';?> btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
            </div><!-- /. tools -->
            <i class="<?php echo isset($data['icon'])?$data['icon']:'fa fa-cog'?>"></i>

            <h3 class="box-title"><?php echo isset($data['label'])?$data['label']:Yii::t('app','Empty');?></h3>
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
        	<div class="row">
        		 <div class="col-sm-12">
        			<div class="pad">
        				<?php echo isset($data['content'])?$data['content']:Yii::t('app','Empty');?>
        			</div>
        		</div>
        	</div>
        </div>
        <!-- 
        <div class="box-footer">
            <div class="row">
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                    <div style="display: inline; width: 60px; height: 60px;"><canvas width="60" height="60"></canvas><input type="text" class="knob" data-readonly="true" value="80" data-width="60" data-height="60" data-fgcolor="#f56954" readonly="readonly" style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-size: 12px; line-height: normal; font-family: Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; -webkit-appearance: none; background: none;"></div>
                    <div class="knob-label">CPU</div>
                </div>
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                    <div style="display: inline; width: 60px; height: 60px;"><canvas width="60" height="60"></canvas><input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgcolor="#00a65a" readonly="readonly" style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-size: 12px; line-height: normal; font-family: Arial; text-align: center; color: rgb(0, 166, 90); padding: 0px; -webkit-appearance: none; background: none;"></div>
                    <div class="knob-label">Disk</div>
                </div>
                <div class="col-xs-4 text-center">
                    <div style="display: inline; width: 60px; height: 60px;"><canvas width="60" height="60"></canvas><input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgcolor="#3c8dbc" readonly="readonly" style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; font-weight: bold; font-style: normal; font-variant: normal; font-size: 12px; line-height: normal; font-family: Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; -webkit-appearance: none; background: none;"></div>
                    <div class="knob-label">RAM</div>
                </div>
            </div>
        </div>  -->
    </div>
</section>
<?php endforeach;?>