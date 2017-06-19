<?php
	class DatabaseObject {
		
		protected static $table_name;
		private static $db;
		
		protected static function init() {
			return self::$db= DBconnection::getDb();
		}
		
		
		public static function find_all() {
		
			try {
				
				static ::find_by_sql("SELECT * FROM ". static::$table_name ."");
				return !empty($res) ? static::instantiate(array_shift($res)) : false;
		
			} catch ( PDOException $e ) {
		
				throw new PDOException ( "Something went wrong, please try again later!" );
			}
		}
		
		public static function find_by_id($id=0) {
			try {
		
				$pstmt = static ::init()->prepare ("SELECT * FROM ". static::$table_name ." WHERE id = ?");
				$pstmt->execute ( array ($id) );
		
				$res = $pstmt->fetchAll ( PDO::FETCH_OBJ );
		
				return !empty($res) ? static::instantiate(array_shift($res)) : false;
		
		
			} catch ( PDOException $e ) {
		
				throw new PDOException ( "Something went wrong, please try again later!" );
			}
		}
		
		protected static function instantiate($record) {
			
			$class_name = get_called_class();
		
			$object = new $class_name;
		
			foreach ($record as $attribute=>$value) {
				if ($object->has_attribute($attribute)) {
					$object->$attribute = $value;
				}
			}
		
			return $object;
		}
		
		private function has_attribute($attribute) {
		
			$object_vars = get_object_vars($this);
		
			return array_key_exists($attribute, $object_vars);
		}
		
		
		public function delete() {
		
			try {
		
				$pstmt = static::init()->prepare("DELETE FROM ". static::$table_name ." WHERE id = ? LIMIT 1");
				$pstmt->execute(array($this->id));
				return ($pstmt->rowCount() == 1) ? true : false;
		
			} catch ( PDOException $e ) {
		
				throw new PDOException ( "Something went wrong, please try again later!" );
			}
		}
		
		
		public static function count_all() {
			try {
					
				$pstmt = static::init()->query( "SELECT COUNT(*) FROM ". static::$table_name ."" );
				$res = $pstmt->fetchAll ( PDO::FETCH_ASSOC );
				return $res[0];
		
			} catch ( PDOException $e ) {
					
				throw new PDOException ( "Something went wrong, please try again later!" );
			}
		}
		
		public static function find_by_sql($sql="") {
			$pstmt = static::init()->query($sql);
			$res = $pstmt->fetchAll ( PDO::FETCH_OBJ );
			return $res;
		}
		
		
	}

?>