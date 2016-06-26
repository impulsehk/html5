<?php

abstract class Connections {
	protected $host = "localhost";
	protected $dbname = "marcodb";
	protected $user = "marcouser";
	protected $password = "PBLV9JAK8LMq4php";
	protected function dbh() {
		try {
			$db = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $db;
		}
		catch (PDOException $e) {
			error_log(print_r($e->getMessage(), true));
		}
	}
}

?>