<?php
	require_once("databaseClass.php");
	
class User {
	
	public $id;
	public $username;
	public $password;
	
	public static function find_all(){
		return self::find_by_sql("select * from users");
	}
	
	public static function find_by_id($id=0) {
		global $database;
		$result_set = self::find_by_sql("select * from users where id={$id} limit1");
		$found = $database->fetch_array($result_set);
		return $found;
	}
		
	public static function find_by_sql($sql=""){
		global $database;
		$result_set =$database->query($sql);
		return $result_set;
	}
	
	private static function instantiate ($record){
		$object =new self;
		$object->id =$record['id'];
		$object->username =$record['username'];
		$object->password =$record['hashedpassword'];
		return $object;
	}
	
}

	
?>
