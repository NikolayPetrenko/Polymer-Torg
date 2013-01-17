<?php

	function emailSendMass($array, $message, $subject) 
	{
		foreach ($array as $email) {
			$headers= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <info@polymer-torg.com>\r\n";
			mail(	$email,
					$subject, 
					$message,
					$headers
			);	
		}
		return;
	}

	function toCut($str,$len=16,$div=" ")
	{
		if (strlen($str)<=$len){
			return $str;
		}
		else{
			$str=substr($str,0,$len);
			$pos=strrpos($str,$div);
			$str=substr($str,0,$pos);
			return $str;
		}
	}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    function translit($str) 
    {
        $translit = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", "/"=>"-"
        );
        return strtr($str, $translit);
    }
	
	function friendlyAlias($name) 
	{
		$name = translit($name);
		$name = strtolower($name);
		return preg_replace('/[^А-Яа-яA-Za-z0-9_\.\/~]+/','-', $name);
	}
	
    function print_flex($data = false)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    
class JsonResponse
{
	public $result	= '';
	public $error 	= '';
	public $html	= '';

	protected $_supressHeaders = false;

	public function supressHeaders()
	{
		$this->_supressHeaders = true;
	}

	public function __toString()
	{
		if ($this->_supressHeaders == FALSE)
//		json_header();
			
		return json_encode($this);
	}
}
?>
