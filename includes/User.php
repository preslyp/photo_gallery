<?php


class User extends DatabaseObject{
	
	private static $db;
	protected static $table_name = "users";
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	

	protected static function init() {
		return self::$db= DBconnection::getDb();
	}
	

	public static function find_all() {
	
		try {
				
			$pstmt =  self::init()->query("SELECT * FROM ". self::$table_name ."");
			$res = $pstmt->fetchAll ( PDO::FETCH_OBJ );
	
			return !empty($res) ? self::instantiate(array_shift($res)) : false;
				
		} catch ( PDOException $e ) {
				
			throw new PDOException ( "Something went wrong, please try again later!" );
		}
	}
	

	
	public function full_name() {
		if (isset($this->first_name) && isset($this->last_name)) {
			return $this->first_name . " " . $this->last_name;
		} else {
			return "";
		}
	}
	
	public static function authenticate($username ="", $password="") {
	
		try {
	
			$pstmt = self::init()->prepare ("SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1");
			$pstmt->execute ( array ($username, $password) );
			$res = $pstmt->fetchAll ( PDO::FETCH_OBJ );
			return !empty($res) ? self::instantiate(array_shift($res)) : false;
				
		} catch ( PDOException $e ) {
				
			throw new PDOException ( "Something went wrong, please try again later!" );
		}
	
	}
	
	
	public function save() {
		return isset($this->id) ? $this->update() : $this->create();
	}

	public function create() {
		try {
			$pstmt = self::init()->prepare ("INSERT INTO ". self::$table_name ." (username, password, first_name, last_name) VALUES (?, ?, ?, ?)");
			
			if ( $pstmt->execute(array($this->username, $this->password,$this->first_name, $this->last_name))){
				$this->id = self::init()->lastInsertId();
				return true;
			}else{
				return false;
			}
		} catch ( PDOException $e ) {
				
			throw new PDOException ( "Something went wrong, please try again later!" );
		}
	}
	
	
	public function update() {
		
		try {
		
			$pstmt = self::init()->prepare("UPDATE ". self::$table_name ." SET username = ?, password = ?, first_name = ?, last_name = ? WHERE id = ?");
			$pstmt->execute(array($this->username, $this->password, $this->first_name, $this->last_name, $this->id ));
			return ($pstmt->rowCount() == 1) ? true : false;
		
		} catch ( PDOException $e ) {
				
			throw new PDOException ( "Something went wrong, please try again later!" );
		}

	}
	
	
	public function delete() {
		
		try {
		
			$pstmt = self::init()->prepare("DELETE FROM ". self::$table_name ." WHERE id = ? LIMIT 1");
			$pstmt->execute(array($this->id));
			return ($pstmt->rowCount() == 1) ? true : false;
		
		} catch ( PDOException $e ) {	
		
			throw new PDOException ( "Something went wrong, please try again later!" );
		}
	}
	

}

