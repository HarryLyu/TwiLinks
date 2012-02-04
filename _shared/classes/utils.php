<?php
function array_htmlspecialchars(&$input){
	if (is_array($input)){
		foreach ($input as $key => $value){
			if (is_array($value)) $input[$key] = array_htmlspecialchars($value);
			else $input[$key] = htmlspecialchars($value);
		}
		return $input;
	}
	return htmlspecialchars($input);
}

function array_htmlspecialchars_decode(&$input){
	if (is_array($input))
	{
		foreach ($input as $key => $value)
		{
			if (is_array($value)) $input[$key] = array_htmlspecialchars_decode($value);
			else $input[$key] = htmlspecialchars_decode($value);
		}
		return $input;
	}
	return htmlspecialchars_decode($input);
}

function addslash ($text) {
	if (get_magic_quotes_gpc())
		return $text;
	else
		return addslashes($text);
}

function stripAllSlashes(&$ArrayElement){
	$ArrayElement = stripslashes($ArrayElement);
}
function addAllSlashes(&$ArrayElement){
	$ArrayElement = addslash($ArrayElement);
}

function StartsWith($Haystack, $Needle){
	return strpos($Haystack, $Needle) === 0;
}

class StringUtils {
	public static function startsWith($where,$what){
		return strpos($where, $what) === 0;
	}
}

class DateUtils{
	public static function fromDate($date){
		$temp = explode(".",$date); 
		$date = mktime (0, 0, 0, $temp[1] , $temp[0], $temp[2]);
		return $date;
	}
}

class URLUtils{
	public static function getSiteURL($url = "", $host = "", $protocol = ""){
		if (strlen($protocol) == 0)
			$protocol = 
					isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'
					? 'https://'
					: 'http://';
		
		if (strlen($host) == 0)
			$host = $_SERVER['HTTP_HOST'];
		
		$currentUrl = $protocol . $host;
		
		if (StringUtils::startsWith($url,"/")){
			return $currentUrl.$url;
		}else{
			return $currentUrl."/".$url;
		}
	}
	
	public static function getSiteURLEncoded($url = "", $host = "", $protocol = ""){
		return urlencode(self::getSiteURL($url,$host,$protocol));
	}
	
	public static function makeForURL($text){
		
	}
}

function printr($what){
	echo '<pre>'.print_r($what,true).'</pre>';
}

class ArrayUtils{
public static function getByPath($path,$array){
		$pathArr = explode("/", $path);
	
		$newPath = array_shift($pathArr);
		
		$nextPath = preg_replace("/^".$newPath."\//",'',$path);
		
		if (count($pathArr) > 0)
			return self::getByPath($nextPath,$array[$newPath]);
		else
			return isset($array[$newPath]) ? $array[$newPath] : NULL;
	}
	
	public static function setByPath($path,&$array,$value){
		$pathArr = explode("/", $path);
	
		$newPath = array_shift($pathArr);
	
		$nextPath = preg_replace("/^".$newPath."\//",'',$path);
	
		if (count($pathArr) > 0){
			if (!isset($array[$newPath]))
				$array[$newPath] = array();
			return self::setByPath($nextPath,$array[$newPath],$value);
		} else{
			return $array[$newPath] = $value;
		}
	}
}