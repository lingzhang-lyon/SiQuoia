<?php
	require_once("config.php");
	
class MySQLDatabase {
	
	private &connection;
	
	function __construct(){
		$this->open_connection();
	}
	
	public function open_connection(){
		// 1. Create a database connection
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		// Test if connection succeeded
		if(!$this->connection) {
			die("Database connection failed: " . mysql_error());
		} else {
			$db_select = mysql_select_db(DB_NAME,$this->connection);
			if (!$db_select){
				die ("Database selection failed: " . mysql_error());
			}
		}
	}
		
	public function close_connection(){
		if(isset($this->connection)){
			mysql_close($this->connection);
			unset($this->connection);
		}
	}
	
	public function query($sql){
	 $result= mysql_query($sql, $this->connection);
		$this->confirm_query($result);
		return $result;
	}
	
	public function mysql_prep($string) {
		$escaped_string = mysqli_real_escape_string($this->connection, $string);
		return $escaped_string;
	}
	
	private function confirm_query($result) {
		if (!$result) {
			die("Database query failed.");
		}
	}


}

	$database = new MySQLDatabase();
	$db =& $database;
	
	
?>
