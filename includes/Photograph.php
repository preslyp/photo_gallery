<?php


	class Photograph extends DatabaseObject{
		
		private static $db;
		protected static $table_name = "photographs";
		public $id;
		public $filename;
		public $type;
		public $size;
		public $caption;
		
		private $temp_path;
		protected $upload_dir = "images";
		public $errors = array();
		
		protected $upload_errors = array (
		
				UPLOAD_ERR_OK => "No errors.",
				UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
				UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
				UPLOAD_ERR_PARTIAL => "Partial upload.",
				UPLOAD_ERR_NO_FILE => "No file.",
				UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
				UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
				UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
		);
		
		
		protected static function init() {
			return self::$db= DBconnection::getDb();
		}
		
		public static function find_all() {
			try {
				return self::find_by_sql("SELECT * FROM ". self::$table_name ."" );
			} catch ( PDOException $e ) {
					
				throw new PDOException ( "Something went wrong, please try again later!" );
			}
		}
		
		public function attach_file($file) {
			
			if (!$file || empty($file) || !is_array($file)) {
				
				$this->errors[] = "No file was uploaded";
				return false;
				
			} elseif( $file['error'] !=0 ) {
				
				$this->errors[] = $this->upload_errors[$file['error']];
				return false;
				
			} else {
			
				$this->temp_path = $file['tmp_name'];
				$this->filename =  basename($file['name']);
				$this->type = $file['type'];
				$this->size = $file['size'];
				return true;
				
			}
			
		}
				
		public function create() {
			try {
				$pstmt = self::init()->prepare ("INSERT INTO ". self::$table_name ." (filename, type, size, caption) VALUES (?, ?, ?, ?)");
					
				if ( $pstmt->execute(array($this->filename, $this->type, $this->size, $this->caption))){
					return true;
				}else{
					return false;
				}
			} catch ( PDOException $e ) {
		
				throw new PDOException ( "Something went wrong, please try again later!" );
			}
		}
		
		public function image_path() {
			
			return "../".$this->upload_dir."/".$this->filename;
			
		}
				
		public function save() {
			
				
				if (!empty($this->errors)) {
					return false;
				}
				
				if (strlen($this->caption) > 255) {
					
					$this->errors[] = "The caption can be only 255 characters long";
					return false;
				}
				
				if (empty($this->filename) || empty($this->temp_path)) {
					
					$this->errors[] = "The file location is not available";
					
				}
				
				$target_path = $this->image_path();
				
				if (file_exists($target_path)) {
					$this->errors[] = "The file {$this->filename} already exist.";
				}
				
				if (move_uploaded_file($this->temp_path, $target_path)) {
					
					if($this->create()) {
						unset($this->temp_path);
						return true;
					}

				} else {
					$this->errors[] = "The file upload failed";
					return false;
				}
				
		}
		
		public function delete() {
		
			try {
		
				$pstmt = self::init()->prepare(" DELETE FROM ". self::$table_name ." WHERE id = ? LIMIT 1");
				$pstmt->execute(array($this->id));
				
				if ($pstmt->rowCount() == 1) {
					
					return true;

				} else {
					return false;
				}
		
			} catch ( PDOException $e ) {
		
				throw new PDOException ( "Something went wrong, please try again later!" );
			}
		}
		
		
		public function comments() {
			return Comments::find_comments_on($this->id);
		}
		
		
		public static function count_all() {
			try {
					
				$pstmt = self::init()->query( "SELECT COUNT(*) FROM ". self::$table_name ."" );
				$res = $pstmt->fetchAll ( PDO::FETCH_NUM );
				return array_shift($res[0]);
				
			} catch ( PDOException $e ) {
					
				throw new PDOException ( "Something went wrong, please try again later!" );
			}
		}
		
		
	}

?>