<?php

class User extends BaseModel {
	public $id, $name, $password;

	public function __construct($attributes) {
	  parent::__construct($attributes);

      $this->validators = array(
        'validate_name', 
        'validate_password');
	  
	}

	public function getID() {
		return $id;
	}

	public static function authenticate($name, $password) {
		// tarkistaa onko tietokannassa käyttäjä joilla on annettu nimi ja salasana.
		$rows = DB::query('SELECT * FROM Customer 
			               WHERE name = :name 
			               AND password = :password',
			               array('name' => $name, 'password' => $password));
	    if(count($rows) > 0) {
	    	return $rows[0]['id'];
	    } else {
	    	return null;
	    }
	}

	public static function authenticate_admin($name, $password) {
		$rows = DB::query('SELECT * FROM Administrator 
			               WHERE name = :name 
			               AND password = :password',
			               array('name' => $name, 'password' => $password)) or die ("auth failed");
	    if(count($rows) > 0) {
	    	return $rows[0]['id'];
	    } else {
	    	return null;
	    }
	}

	public static function find($id) {
		$rows = DB::query('SELECT * FROM Customer WHERE id = :id', array('id' => $id));
		if($rows) {
		  $user = new User($rows[0]);
	    } else {
	      return null;
	    }
	}

	public function errors() {
    // tarpeeton?
    return parent::errors();
  }
}