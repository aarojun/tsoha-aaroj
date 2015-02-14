<?php

class User extends BaseModel {
	private $id, $name, $password;

	public function __construct($attributes) {
	  parent::__construct($attributes);

      $this->validators = array(
        'validate_name', 
        'validate_password');
	  }
	}

	public function getID() {
		return $id;
	}

	public static function authenticate($name, $password) {
		// tarkistaa onko tietokannassa käyttäjä joilla on annettu nimi ja salasana.
		$rows = DB::query('SELECT User 
			                WHERE name = :name AND password = :password
			                RETURNING id',
			                array('id' = $name, 'password' = $password));
	    if(count($rows) > 0) {
	    	return $rows[0]['id'];
	    } else {
	    	return null;
	    }
	}

	public function errors() {
    // tarpeeton?
    return parent::errors();
  }
}