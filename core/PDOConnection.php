<?php
// file: /core/PDOConnection.php

class PDOConnection {
	//[NO COMMITEAR] Si queremos trabajar con la base de datos en local comentamos la primera linea y descomentamos la segunda
	//private static $dbhost = "89.128.199.181";
	private static $dbhost = "127.0.0.1";
	private static $port = ";port=3306";
	private static $dbname = "abp32";
	private static $dbuser = "padeloptare";
	private static $dbpass = "padeloptare";
	private static $db_singleton = null;

	public static function getInstance() {
		if (self::$db_singleton == null) {
			self::$db_singleton = new PDO(
			"mysql:host=".self::$dbhost.";dbname=".self::$dbname.self::$port.";charset=utf8", // connection string
			self::$dbuser,
			self::$dbpass,
			array( // options
				PDO::ATTR_EMULATE_PREPARES => false,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			)
		);
	}
	return self::$db_singleton;
}
}
?>
