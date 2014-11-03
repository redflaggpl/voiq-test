<?php
/*
  @version 1.0rc3
  @since 1.1
  For know variables please read this link
  @see http://docs.payulatam.com/manual-integracion-web-checkout/informacion-adicional/tablas-de-variables-complementarias/
 */
class GPol extends CApplicationComponent
{
	//@TODO Hacer un módulo administrativo para que le hagan seguimiento a las
	// peticiones y respuestas de POL

	//@TODO implementar eventos del lado del servidor para 
	// las páginas de respuesta y confirmación

	//@TODO implementar en el modulo de POL
	// un simulador de pago para los casos que no pueda entrar a pol
	// tu dices los parametros que esperas el te envía un post
	
	// this data are required
	public $ApiKey;
	public $merchantId;
	

	// Es para habilitar medios de pago
	// de cada país y es un código especial
	// por cada cuenta de susuario
	public $accountId='';

	public $description='This a pay for tests';
	public $porcentTax=0;
	public $currency='COP';
	public $shipmentValue=0; // COsto de envío
	public $test=true;
	// Data for test
	
	// Nombres y apellidos
	// APPROVED
	// REJECTED
	// 5378894813179156 mc

	public $testUrl="https://stg.gateway.payulatam.com/ppp-web-gateway";
	public $prodUrl="https://gateway.payulatam.com/ppp-web-gateway/";
	public $responseUrl="site/response";
	public $confirmationUrl="site/confirmation";
	
	public $prefix="PAY00";

	public function btn($plan,$amount,$description=null)
	{
		if($description!==null)
			$this->description=$description;

			echo "<form style=\"width: 162px;height: 45px;
	margin: 10px auto;\" method=\"post\" action=\"\">
	<a class=\"btn-payu-pay\" href=\"#\"><img border=\"0\" alt=\"\" src=\"http://www.payulatam.com/img_botones_herramientas/boton_pagar_grande.png\" /></a>
			  <input id=\"plan\" name=\"plan\" type=\"hidden\" value=\"{$plan}\"/>
			  <input id=\"merchantId\" name=\"merchantId\" type=\"hidden\" value=\"\"/>
			  <input id=\"usuarioId\" name=\"usuarioId\" type=\"hidden\" value=\"\"/>
			  <input id=\"refVenta\" name=\"refVenta\" type=\"hidden\" value=\"\"/>
			  <input id=\"confirmationUrl\" name=\"confirmationUrl\" type=\"hidden\" value=\"\"/>
			  <input id=\"responseUrl\" name=\"responseUrl\" type=\"hidden\" value=\"\"/>
			  <input id=\"payerFullName\" name=\"payerFullName\" type=\"hidden\" value=\"\"/>
			  <input id=\"accountId\" name=\"accountId\" type=\"hidden\" value=\"\"/>
			  <input id=\"description\" name=\"description\" type=\"hidden\" value=\"{$this->description}\"/>
			  <input id=\"referenceCode\" name=\"referenceCode\" type=\"hidden\" value=\"\"/>
			  <input id=\"amount\" name=\"amount\" type=\"hidden\" value=\"{$amount}\"/>
			  <input id=\"tax\" name=\"tax\" type=\"hidden\" value=\"0\"/>
			  <input id=\"taxReturnBase\" name=\"taxReturnBase\" type=\"hidden\" value=\"0\"/>
			  <input id=\"shipmentValue\" name=\"shipmentValue\" value=\"0\" type=\"hidden\"/>
			  <input id=\"currency\" name=\"currency\" type=\"hidden\" value=\"COP\"/>
			  <input id=\"lng\" name=\"lng\" type=\"hidden\" value=\"es\"/>
			  <input id=\"signature\" name=\"signature\" value=\"\" type=\"hidden\"/>
			  <input id=\"test\" name=\"test\" value=\"\" type=\"hidden\"/>
			</form>";
		
	}

	public function getAction()
	{
		if($this->getIsTest())
			return $this->testUrl;
		return $this->prodUrl;
	}

	public function getSignature($amount,$refVenta,$raw=false)
	{
		$ApiKey=$this->ApiKey;
		$currency=$this->currency; // Id Comercio
		$merchantId=$this->merchantId; // Id Comercio
		$accountId=$this->accountId;
		if($raw)
			return ("{$ApiKey}~{$merchantId}~{$refVenta}~{$amount}~{$currency}");
		return md5("{$ApiKey}~{$merchantId}~{$refVenta}~{$amount}~{$currency}");
	}

	public function getIsTest()
	{
		if(YII_DEBUG)
			return true;
		return $this->test;
	}

	public function actionPay($amount,$purchaseID,$email,$name,$description=null,$currency=null,$porcentTax=null)
	{
		if($description!==null)
			$this->description=$description;
		if($currency!==null)
			$this->currency=$currency;
		if($porcentTax!==null)
			$this->porcentTax=$porcentTax;
		$refVenta=$this->prefix.$purchaseID;
		
		$tax=0;
		$taxReturnBase=0;
		
		if($this->porcentTax>0)
		{
			$orderTotal=$amount;
			$tax=round(($orderTotal*$this->porcentTax)/100);
			$taxReturnBase=round($orderTotal - (($orderTotal*$this->porcentTax)/100));
			$amount=round($orderTotal);
		} 
		else
			$amount=round($amount);

		echo CJSON::encode(array(
			"actionUrl"=>$this->getAction(),
			"merchantId"=>$this->merchantId,
			"usuarioId"=>$this->merchantId,
			"refVenta"=>$refVenta,
			"confirmationUrl"=>Yii::app()->createAbsoluteUrl($this->confirmationUrl),
			"responseUrl"=>Yii::app()->createAbsoluteUrl($this->responseUrl),
			"payerFullName"=>$name,
			"accountId"=>$this->accountId,
			"description"=>$this->description,
			"referenceCode"=>$refVenta,
			"amount"=>$amount,
			"tax"=>$tax,
			"taxReturnBase"=>$taxReturnBase,
			"buyerEmail"=>$email,
			"shipmentValue"=>$this->shipmentValue,
			"currency"=>$this->currency,
			"lng"=>substr(Yii::app()->language,0,2),
			"test"=>(int)$this->getIsTest(),
			"signature"=>$this->getSignature($amount,$refVenta),
			"signature_raw"=>$this->getIsTest()?$this->getSignature($amount,$refVenta,true):'',
		));
		Yii::app()->end();
	}
}