<?php

	class Session {
		
		private $loged_in = false;
		public $user_id;
		public $message;
				
		public function __construct() {
			session_start();
			$this->check_message();
			$this->check_login();
		}
		
		public function is_logged_in() {
			return $this->loged_in;
		}
		
		
		public function login($user) {
			if($user) {
				$this->user_id = $_SESSION['user_id'] = $user->id;
				$this->loged_in = true;
			}
		}
		
		
		private function check_login() {
			
			if (isset($_SESSION['user_id'])) {
				$this->user_id = $_SESSION['user_id'];
				$this->loged_in = true;
			} else {
				unset($this->user_id);
				$this->loged_in = false;
			}
			
		}
		
		public function logout() {
			unset($_SESSION['user_id']);
			unset($this->user_id);
			$this->loged_in = false;
		}
		
		public function message($msg = "") {
			if (! empty ( $msg )) {
				$_SESSION ['message'] = $msg;
			} else {
				return $this->message;
			}
		}
		
		public function check_message() {
			if (isset($_SESSION['message'])) {
				$this->message = $_SESSION['message'];
				unset($_SESSION['message']);
			} else {
				$this->message="";
			}
		}
	
	}
	
	
	$session = new Session();
	$message = $session->message();

?>