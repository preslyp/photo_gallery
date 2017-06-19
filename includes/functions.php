<?php

	function strip_zeros_from_date($marked_string = "") {
		// first remove the marked zeros
		$no_zeros = str_replace ( '*0', '', $marked_string );
		// then remove any remaining marks
		$cleaned_string = str_replace ( '*', '', $no_zeros );
		return $cleaned_string;
	}
	function redirect_to($location = NULL) {
		if ($location != NULL) {
			header ( "Location: {$location}" );
			exit ();
		}
	}
	function output_message($message = "") {
		if (! empty ( $message )) {
			return "<p class=\"message\">{$message}</p>";
		} else {
			return "";
		}
	}
	
	function log_action($action, $message="") {
		$logfile = '../../logs/log.txt';
		$new = file_exists($logfile) ? false : true;
		if($handle = fopen($logfile, 'a')) { 
			$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
			$content = "{$timestamp} | {$action}: {$message}\n";
			fwrite($handle, $content);
			fclose($handle);
			if($new) { chmod($logfile, 0755); }
		} else {
			echo "Could not open log file for writing.";
		}
	}
	
	function datetime_to_text($datetime = "") {
		$unixdatatime = strtotime($datetime);
		return strftime("%d %B %Y at %I:%M %p", $unixdatatime);
	}
	
?>