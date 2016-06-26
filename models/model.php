<?php

include($_SERVER['DOCUMENT_ROOT']."/includes/connection.php");
include("connections.php");

class Model extends Connections {

	function __construct($table, $id_field = "id") {
		$this->table = $table;
		$this->id_field = $id_field;
	}
	private function _get($str) {
		return $this->dbh()->prepare($str);
	}
	public function all() {
		$s = $this->_get("SELECT * FROM $this->table");
		$s->execute();
		return $s->fetchAll();
	}
	public function find($id) {
		$s = $this->_get("SELECT * FROM $this->table WHERE $this->id_field = :id");
		$s->execute(array(':id' => "$id"));
		return (array) $s->fetch();
	}
	public function find_by($field, $value) {
		$s = $this->_get("SELECT * FROM $this->table WHERE $field = :field");
		$s->execute(array(':field' => "$value"));
		return (object) $s->fetchAll();
	}
	public function priceplan_find_by($field, $value) {
		$s = $this->_get("SELECT * FROM $this->table WHERE $field = :field AND capacity_id <> '1001'");
		$s->execute(array(':field' => "$value"));
		return (object) $s->fetchAll();
	}
	public function find_by_and($field1, $value1, $field2, $value2) {
		$s = $this->_get("SELECT * FROM $this->table WHERE $field1 = :field1 AND $field2 = :field2");
		$s->execute(array( ':field1'=> "$value1", ':field2'=>"$value2" ));
		return $s->fetchAll();
	}
	public function where($query) {
		$s = $this->_get($query);
		$s->execute();
		return $s->fetchAll();
	}
	public function update($id, $field, $value) {
		$s = $this->_get("UPDATE $this->table SET $field = $value WHERE $this->id_field = :id");
		$s->execute(array( ':id'=>"$id" ));
		return false;
	}
	public function insert($values = []) {
		$santi_values = array();
		$keys = [];
		$onUpdate = [];
		foreach ( $values as $field => $value ) {
			array_push($keys, $field);
			array_push($onUpdate, $field.' = :'.$field);
			$santi_values[":".$field] = $value;
		}
		$_fields = implode(', ', $keys);
		$_values = implode(', :', $keys);
		$_update = implode(' AND ', $onUpdate);
		$s = $this->_get("INSERT INTO $this->table ($_fields) VALUES (:$_values) ON DUPLICATE KEY UPDATE $_update");
		return $s->execute($santi_values);
	}
	public function last() {
		$s = $this->_get("SELECT * FROM $this->table ORDER BY $this->id_field DESC LIMIT 1");
		$s->execute();
		return $s->fetchAll()[0];
	}
}
class PriceModel extends Model {
	function __construct($table = "bsi_priceplan") {
		parent::__construct($table);
	}
	private function _get($str) {
		return $this->dbh()->prepare($str);
	}
	public function finding($hid, $rtid) {
		$s = $this->_get("SELECT * FROM $this->table WHERE hotel_id = :hid AND room_type_id = :rtid AND capacity_id <> '1001'");
		$s->execute( array(':hid'=> "$hid", ':rtid' => "$rtid") );
		return $s->fetchAll();
	}
	
}
class Rooms extends Model {
	function __construct($table = "bsi_room") {
		parent::__construct($table);
	}
	private function _get($str) {
		return $this->dbh()->prepare($str);
	}
	public function get_reserve($hotel_id, $roomtype_id) {
		$s = $this->_get(
			"SELECT room_id FROM $this->table
				WHERE hotel_id = :hotel_id AND roomtype_id = :roomtype_id
				AND room_id NOT IN
				(SELECT room_id FROM bsi_reservation WHERE timestamp >= CURDATE() - INTERVAL 1 DAY )"
		);
		$s->execute(array(':hotel_id'=>"$hotel_id", ':roomtype_id'=>"$roomtype_id"));
		return $s->fetchAll();
	}
}
class Configure extends Model {
	function __construct($table = "bsi_configure") {
		parent::__construct($table, 'conf_id');
	}
	private function _get($str) {
		return $this->dbh()->prepare($str);
	}
	public function key(){
		$s = $this->_get("SELECT conf_key, conf_value FROM $this->table");
		$s->execute();
		return $s->$fetchAll();
		// while($currentRow = $result){
		// 	if($currentRow["conf_key"]){
		// 		if($currentRow["conf_value"]){
		// 			$this->config[trim($currentRow["conf_key"])] = trim($currentRow["conf_value"]);
		// 		}else{
		// 			$this->config[trim($currentRow["conf_key"])] = false;
		// 		}
		// 	}
		// }
	}
}

?>