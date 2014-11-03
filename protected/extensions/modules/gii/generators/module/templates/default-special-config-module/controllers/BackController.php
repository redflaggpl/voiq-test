<?php echo "<?php\n"; ?>

class BackController extends CmsController
{
	public $title='<?php echo ucfirst($this->moduleID); ?>';
	public $subTitle='Administrar <?php echo $this->moduleID; ?>';
	
	public function actionIndex()
	{
		$this->render('index');
	}
}