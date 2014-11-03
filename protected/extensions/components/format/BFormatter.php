<?php
class BFormatter extends CFormatter
{

	/**
	* Trunca una cadena a un límite de palabras y agrega un caracter al final
	*
	* @access public
	* @param String $str Cadena original
	* @param Integer $limit límite de palabras
	* @param String $endchar
	* @return String cadena truncada
	*/
	public function formatWordLimiter($str, $limit = 100, $end_char = '&#8230;')
	{
		if (trim($str) == '')
		{
			return $str;
		}

		preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);

		if (strlen($str) == strlen($matches[0]))
		{
			$end_char = '';
		}

		return rtrim($matches[0]).$end_char;
	}

	/**
	* Trunca una cadena a un límite de palabras y agrega un caracter al final
	*
	* @access public
	* @param String $str Cadena original
	* @param Integer $limit límite de palabras
	* @param String $endchar
	* @return String cadena truncada
	*/
	public function toBr($str='')
	{
		return nl2br($str);
	}

	/**
	 * Character Limiter
	 *
	 * Limits the string based on the character count.  Preserves complete words
	 * so the character count may not be exactly as specified.
	 *
	 * @access	public
	 * @param	string
	 * @param	integer
	 * @param	string	the end character. Usually an ellipsis
	 * @return	string
	 */
	public function formatCharacterLimiter($str, $n = 500, $end_char = '&#8230;')
	{
		if (strlen($str) < $n)
		{
			return $str;
		}

		$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

		if (strlen($str) <= $n)
		{
			return $str;
		}

		$out = "";
		foreach (explode(' ', trim($str)) as $val)
		{
			$out .= $val.' ';

			if (strlen($out) >= $n)
			{
				$out = trim($out);
				return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
			}
		}
	}


	public function formatDayComment($data)
	{
		$data=date("Y-m-d",strtotime($data));
		$diferencia=(strtotime(date("Y-m-d")) - strtotime($data)) / 60 / 60 / 24;
		if(date("Y-m-d")==$data)
		{
			return "Hoy";
		}
		if($diferencia < 0)
		{
			if($diferencia==-1)
				return "Mañana";
			else if($diferencia==-2)
				return "Pasado mañana";
			else
				return "En ".abs((int)$diferencia)." Días";
		}

		if($diferencia==1)
			return "Ayér";
		elseif($diferencia==2)
			return "Antes de ayér";
		else
			return "Hace ".abs((int)$diferencia)." Días ";
	}

	public $dias=array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
	public $meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	public $mesesShort=array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

	/**
	* Cadena con fecha en formato de oración
	* @param Date $date
	* @param Boolean $hora true para concatenar hora
	*/
	public function formatShort($date)
	{
		$fecha=
		date("j",strtotime($date))."-".
		$this->mesesShort[date("n",strtotime($date))]."-".
		date("Y",strtotime($date));

		return $fecha;
	}

	/**
	* Cadena con fecha en formato de oración
	* @param Date $date
	* @param Boolean $hora true para concatenar hora
	*/
	public function formatShortTime($date)
	{
		$fecha=
		date("j",strtotime($date))."-".
		$this->mesesShort[date("n",strtotime($date))]."-".
		date("Y",strtotime($date))." ".date("h:i a",strtotime($date));

		return $fecha;
	}

	/**
	* Cadena con fecha en formato de oración
	* @param Date $date
	* @param Boolean $hora true para concatenar hora
	*/
	public function formatSayDate($date,$hora=true)
	{
		$fecha = $this->dias[date("w",strtotime($date))]." ".
		date("j",strtotime($date))." de ".
		$this->meses[date("n",strtotime($date))]." del ".
		date("Y",strtotime($date));
		if($hora === true)
			$fecha .= " a las ".date("h:i a",strtotime($date));

		return $fecha;
	}

	/**
	* Cadena con fecha en formato de oración
	* @param Date $date
	* @param Boolean $hora true para concatenar hora
	*/
	public function formatSayDay($date)
	{
		$fecha = $this->dias[date("w",strtotime($date))];
		return $fecha;
	}

	public function formatDateInDays($ndias)
	{
		$dia = date('d',time()+(84600*$ndias));
		$mes = date('n',time()+84600*$ndias);
		$ano = date('Y',time()+84600*$ndias);

		return $this->dias[date("w",strtotime(date('Y-m-d', time()+(84600*$ndias))))] . " " . $dia; //  . " de " . $mes;
	}

	public function formatMonth($value)
	{
		$meses = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
		return $meses[(int)$value];
	}

	public function formatAgoComment($ptime)
	{
		$ptime=strtotime($ptime);
	    $etime = time() - $ptime;

	    if ($etime < 1)
	        return 'Justo ahora';
	   
	    $a = array( 12 * 30 * 24 * 60 * 60  =>  'año',
	                30 * 24 * 60 * 60       =>  'mes',
	                24 * 60 * 60            =>  'día',
	                60 * 60                 =>  'hora',
	                60                      =>  'minuto',
	                1                       =>  'segunto'
	                );

	    foreach ($a as $secs => $str)
	    {
	        $d = $etime / $secs;
	        if ($d >= 1)
	        {
	            $r = round($d);
	            return 'Hace '.$r . ' ' . $str . ($r > 1 ? '(s)' : '') . '';
	        }
	    }
	}

	public function trimAndLower($cadena)
	{
	    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
	    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	    $cadena = utf8_decode($cadena);
	    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
	    $cadena = strtolower($cadena);
	    $return=utf8_encode($cadena);
	    return strtr($return,array(" "=>"-","/"=>"-","\\"=>"-","\'"=>"-","?"=>"-","="=>"-"));
	}

	/**
	 * Formats the value as a number using PHP number_format() function.
	 * @param mixed $value the value to be formatted
	 * @return string the formatted result
	 * @see numberFormat
	 */
	public function formatMoney($value)
	{
		return number_format($value,2,".",",");
	}

	public function prettyJSON($value='')
	{
		return strtr(strtr(json_encode($value,true),array("{"=>"{\n","\"}"=>"\"\n}","\","=>"\",\n")),array("\n\""=>"\n&nbsp;&nbsp;&nbsp;&nbsp;\"","}]}"=>"&nbsp;&nbsp;&nbsp;&nbsp;}]\n}","},{"=>"&nbsp;&nbsp;&nbsp;&nbsp;},{","]]}"=>"]]\n}","[["=>"[\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[","[\""=>"[\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\"","}}"=>"&nbsp;&nbsp;&nbsp;&nbsp;}\n}",",\""=>",\n&nbsp;&nbsp;&nbsp;&nbsp;\""));
	}

	public function sirToHtml($field_sir)
	{
		$html="";
		foreach(CJSON::decode($field_sir)['data'] as $data)
		{
 			if($data['type']==='heading')
				$html.="<h1>".$data['data']['text']."</h1>";
 			if($data['type']==='text')
				$html.="<p>".$data['data']['text']."</p>";
 			if($data['type']==='list')
				$html.="<ul>".implode("</li><li>",explode("-",$data['data']['text']))."</li></ul>";
 			if($data['type']==='quote')
 			{
				$html.="<blockquote class=\"blockquote-reverse\">";
				$html.="<p>".$data['data']['text']."</p>";
				$html.="<footer><cite title=\"Source Title\">".$data['data']['cite']."</cite></footer>";
				$html.="</blockquote>";
 			}
 			if($data['type']==='image')
 				$html.="<img class=\"img-responsive mbm mtm\" src=\"".@$data['data']['file']['url']."\">";
			if($data['type']==='video')
 			{
				if(strpos($data['data']['source'],"youtube")!==false)
					$html.="<div class=\"embed-responsive embed-responsive-16by9\"><iframe class=\"embed-responsive-item\" src=\"http://www.youtube.com/embed/".$data['data']['remote_id']."\" width=\"580\" height=\"320\" frameborder=\"0\" allowfullscreen=\"\"></iframe></div>";
 				else
					$html.="<div class=\"embed-responsive embed-responsive-16by9\"><iframe class=\"embed-responsive-item\" src=\"http://player.vimeo.com/video/".$data['data']['remote_id']."?title=0&amp;byline=0\" width=\"580\" height=\"320\" frameborder=\"0\"></iframe></div>";
 			}
			if($data['type']==='tweet')
				$html.="TODO";
		}
		return $html;
	}
}