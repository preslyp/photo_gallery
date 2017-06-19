<?php

	
	class Comments extends DatabaseObject{
		
		private static $db;
		protected static $table_name = "comments";
		public $id;
		public $photograph_id;
		public $created;
		public $author;
		public $body;
		

		protected static function init() {
			return self::$db= DBconnection::getDb();
		}
		
	    
		
		public static function make($photo_id, $author = "Anonymous", $body = "") {
			
			if (!empty($photo_id) && !empty($author) && !empty($body)) {
					
				$comment = new Comments();
				$comment->photograph_id = (int)$photo_id;
				$comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
				$comment->author = $author;
				$comment->body = $body;
				return $comment;
				
			} else {

				return false;
			
			}
		}
		
		public static function find_all() {
		
			try {
			
				return self::find_by_sql("SELECT * FROM ". static::$table_name ."");
		
			} catch ( PDOException $e ) {
		
				throw new PDOException ( "Something went wrong, please try again later!" );
			}
		}
		
		
		public static function find_comments_on($photo_id = 0) {
			
			try {
			
				$pstmt = self::init()->prepare ("SELECT * FROM ". self::$table_name ." WHERE photograph_id = ? ORDER BY created ASC");
				
				$pstmt->execute ( array ($photo_id) );
				
				$res = $pstmt->fetchAll ( PDO::FETCH_OBJ );
			
				return $res;
			
			} catch ( PDOException $e ) {
		
				throw new PDOException ( "Something went wrong, please try again later!" );
			}
			
		}
		
		public function save() {
			try {
				$pstmt = self::init()->prepare ("INSERT INTO ". self::$table_name ." (photograph_id, created, author, body) VALUES (?, ?, ?, ?)");
					
				if ( $pstmt->execute(array($this->photograph_id, $this->created,$this->author, $this->body))){
					$this->id = self::init()->lastInsertId();
					return true;
				}else{
					return false;
				}
			} catch ( PDOException $e ) {
		
				throw new PDOException ( "Something went wrong, please try again later!" );
			}
		}
		
	}

?>