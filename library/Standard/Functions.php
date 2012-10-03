<?php
class Standard_Functions {
	public static $MYSQL_DATETIME_FORMAT = "Y-m-d H:i:s";
	public static $MYSQL_DATE_FORMAT = "Y-m-d";
	public static function getCurrentUser() {
		return Zend_Auth::getInstance ()->getStorage ()->read ();
	}
	public static function getCurrentDateTime($timestamp = null, $format = null) {
		if ($format == null)
			$format = Standard_Functions::$MYSQL_DATETIME_FORMAT;
		if ($timestamp == null)
			$timestamp = time ();
		$datetime = new DateTime ();
		
		$datetime->setTimestamp ( $timestamp );
		return $datetime->format ( $format );
	}
	public static function getDefaultDbAdapter() {
		return Zend_Db_Table::getDefaultAdapter ();
	}
	public static function getResourcePath() {
		return APPLICATION_PATH . "/../public/resource/";
	}
	public static function saveBookmarkFromUrl($url="",$user_id = "",$format = ".jpg"){
		if ($url == "" || $user_id == ""){
			return false;
		}
		
		$usersFolder = APPLICATION_PATH . "/../public/resources/users";
		if(!is_dir($usersFolder)){
			mkdir($usersFolder);
		}
		
		// Check for user specific folder
		$userFolder = $usersFolder . "/" . $user_id;
		if(!is_dir($userFolder)){
			mkdir($userFolder);
		}
		
		$ch = curl_init('http://example.com/image.php');
		$fp = fopen('/my/folder/flower.gif', 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}
}