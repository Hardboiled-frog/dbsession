<?php

class Session {
	private $db;
	
	public function __construct() {
		
		// instantiate the new database object
		$this->db = new Database();
		
		// set handler to override session
		session_set_save_handler(
			array($this, "_open"),
			array($this, "_close"),
			array($this, "_read"),
			array($this, "_write"),
			array($this, "_destroy"),
			array($this, "_gc")
		);
		
		// start the session
		session_start();
	}
	
	// check if the database connection is up
	public function _open() {
		if ($this->db) {
			return true;
		} 
		
		return false;
	}
	
	// close the database connection
	public function _close() {
		if ($this->db->close()) {
			return true;
		}
		
		return false;
	}
	
	// read session values
	public function _read($id) {
		$this->db->query('call get_session(?)');
				
		if ($this->db->execute(array($id))) {
			$row = $this->db->single();
			return $row->data;
		} else {
			return '';
		}
	}
	
	// write session values
	public function _write($id, $data) {
		$access = time();
		$this->db->query('call mod_session(?, ?, ?)');
        
		if ($this->db->execute(array($id, $access, $data))) {
			return true;
		}
		
		return false;
	}
	
	// destroy session
	public function _destroy($id) {
		$this->db->query('call rem_session(?)');

		if ($this->db->execute(array($id))) {
			return true;
		}
		
		return false;
	}
	
	// garbage collection
	public function _gc($max) {
		$old = time() - $max;
		
		$this->db->query('call rem_sessions(?)');
		
		if ($this->db->execute(array($old))) {
			return true;
		}
		
		return false;
	}
}