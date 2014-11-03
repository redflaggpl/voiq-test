<?php
class GSecurityManager extends CSecurityManager
{

	public $keyActive="78KJkj8J6GMBbv4cfEr3Fg65Gfdk9jf5HghG6TsqWasS3ed4Fe4rCd";

	/**
	 * Encrypts data.
	 * @param string $data data to be encrypted.
	 * @param string $key the decryption key. This defaults to null, meaning using {@link getEncryptionKey EncryptionKey}.
	 * @return string the encrypted data
	 * @throws CException if PHP Mcrypt extension is not loaded
	 */
	public function encrypt($data,$key=null)
	{
	   return base64_encode($data);
		if($key===null)
			$key=$this->keyActive;
		$result = '';
	    for($i=0; $i<strlen($data); $i++) {
	      $char = substr($data, $i, 1);
	      $keychar = substr($key, ($i % strlen($key))-1, 1);
	      $char = chr(ord($char)+ord($keychar));
	      $result.=$char;
	    }
	   return base64_encode($result);
	}
	/**
	 * Decrypts data
	 * @param string $data data to be decrypted.
	 * @param string $key the decryption key. This defaults to null, meaning using {@link getEncryptionKey EncryptionKey}.
	 * @return string the decrypted data
	 * @throws CException if PHP Mcrypt extension is not loaded
	 */
	public function decrypt($data,$key=null)
	{
	   return base64_decode($data);
		if($key===null)
			$key=$this->keyActive;
	   $result = '';
	   $data = base64_decode($data);
	   for($i=0; $i<strlen($data); $i++) {
	      $char = substr($data, $i, 1);
	      $keychar = substr($key, ($i % strlen($key))-1, 1);
	      $char = chr(ord($char)-ord($keychar));
	      $result.=$char;
	   }
	   return $result;
	}


	/**
	 * @randomWord
	 *
	 * Este método ha sido tomado del sistema que implementaba
	 * anteriormente starbox ya que es un algoritmo que devuelve
	 * un número leatorio según la cantidad de digitosd que se
	 * le pasen por configuracíon este método es usado para generar el código
	 * de seguridad de los bonos generados
	 * @param $length int
	 * @return string
	*/
	public function randomWord($length=16)
	{
		$length=$length-1;
		$chars = "aAbBcCdDeEfFgGhHiIjJkKmMnNoOpPqQrRsStTuUvVwWxXyYzZ023456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$word = '' ;

		while ($i <= $length) {
			$num = rand() % 58;//33;
			$tmp = substr($chars, $num, 1);
			$word .= $tmp;
			$i++;
		}
		return $word;
	}

	/**
	 * @randomInt
	 * @Autor Gustavo Salgado <gsalgadotoledo@gmail.com>
	 *
	 * Este método ha sido tomado del sistema que implementaba
	 * @param $length int
	 * @return string
	*/
	public function randomInt($length=12)
	{
		return sprintf('%0'.$length.'s', rand(0, getrandmax()));
	}
}