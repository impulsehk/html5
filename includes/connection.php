<?php
class Connection{
	protected $host = "localhost";
	protected $dbname = "marcodb";
	protected $user = "marcouser";
	protected $password = "PBLV9JAK8LMq4php";
	protected $DBH;

	function __construct() {
		try {
			$this->DBH = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
			$this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// foreach($this->DBH->query('SELECt * from bsi_hotels') as $row) {
			// 	print_r($row);
			// }
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	public function close() {
		$this->DBH = NULL;
	}
	public function getAll() {
		$rows = [];
		foreach($this->DBH->query('SELECT * from bsi_hotels') as $row) {
			array_push($rows, $row);
		}
		return $rows;
	}
	public function find($id) {
		// $statement = $this->DBH->prepare("SELECT ")
	} 

}
?>
