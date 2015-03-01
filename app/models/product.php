<?php

class Product extends BaseModel {
    // tuotteen atribuutit
	public $id, $name, $type, $price, $available, $producer, $description, $countryoforigin, $added, $updated;

	public function __construct($attributes) {
	  parent::__construct($attributes);

    $this->validators = array(
      'validate_name', 
      'validate_type', 
      'validate_price',
      'validate_available',
      'validate_producer',
      'validate_description',
      'validate_countryoforigin');
	}

  public function errors() {
    // tarpeeton?
    return parent::errors();
  }

    // käy kyselyiden tuottamat rivit läpi ja palauttaa listan product-olioita
	public static function formProducts($rows) {
        $products = array();

		foreach($rows as $row) {
		$products[] = new Product($row);
	}
	return $products;
	}


    public static function create($row) {
  	  $query = DB::query("INSERT INTO Product (name, type, price, available, producer, description, countryoforigin, added, updated) 
  		    VALUES(
  		    :name,
          :type,
          :price,
          :available,
          :producer,
          :description,
          :countryoforigin,
          NOW(),
          NOW())
  	        RETURNING id", $row);

  	return $query[0]['id'];
  }

  public static function update($params) {
    // siisti loopiksi?
    $sql = "UPDATE Product SET ";
    if($params['name']) {
      $sql .= "name='".$params['name']."', ";
    }
    if($params['type']) {
      $sql .= "type='".$params['type']."', ";
    }
    if($params['price']) {
      $sql .= "price=".$params['price'].",";
    }
    if($params['available']) {
      $sql .= "available=".$params['available'].",";
    }
    if($params['producer']) {
      $sql .= "producer='".$params['producer']."', ";
    }
    if($params['description']) {
      $sql .= "description='".$params['description']."', ";
    }
    if($params['countryoforigin']) {
      $sql .= "countryoforigin='".$params['countryoforigin']."', ";
    }

    $sql = $sql . "updated=NOW() WHERE id = ".$params['id'];
    $query = DB::query($sql) or die("Update failed. the SQL was $sql");
  }

  public static function destroy($id) {
    $rows = DB::query('DELETE FROM Product WHERE id = :id', array('id' => $id));
  }

  public static function all() {
  	// kutsutaan luokan DB staattista metodia query
	$rows = DB::query('SELECT * FROM Product 
                     ORDER BY added DESC');
	return self::formProducts($rows);
   }

   public static function matchesType($type) {
   	$rows = DB::query('SELECT * FROM Product WHERE type = :type
                       ORDER BY name', array('type' => $type));
    return self::formProducts($rows);
   }

   public static function find($id) {
    $rows = DB::query('SELECT * FROM Product WHERE id = :id LIMIT 1', array('id' => $id));

    if(count($rows) > 0){
      return new Product($rows[0]);
    }

    return null;
  }

  public static function findUsedNames($name) {
    $rows = DB::query('SELECT * FROM Product WHERE name = :name', array('name' => $name));

    if(count($rows) > 0){
      $types = self::formProducts($rows);
      return $types[0];
    }

    return null;
   }

  public function validate_name($errors) {
    if ($this->name == '' || $this->name == null) {
      $errors[] = 'Nimi ei saa olla tyhjä';
    }
    if (strlen($this->name) < 4) {
      $errors[] = 'Tuotteen nimen pituuden tulee olla vähintään neljä merkkiä';
    } else if (strlen($this->name) >20) {
      $errors[] = 'Tuotteen nimen pituuden tulee enintään 20 merkkiä';
    }

    $matchingNames = self::findUsedNames($this->name);
    if ($matchingNames && $this->id != null) {
      if($this->id != $matchingNames->id) {
        $errors[] = 'Tuote nimeltä ' . $this->name . ' on jo olemassa!';    
      }
    }

    return $errors;
  }

  public function validate_type($errors) {
    if ($this->type == '' || $this->type == null) {
      $errors[] = 'Tuotetyyppi ei saa olla tyhjä';
    }

    $matchingtypes = ProductType::findUsedNames($this->type);
    if ($matchingtypes == null) {
      $errors[] = 'Tuotetyyppiä nimeltä ' . $this->name . ' ei ole olemassa! Syötetyn tuotetyypin täytyy olla tietokannassa.';    
    }

    return $errors;
  }

  public function validate_price($errors) {
    if($this->price == null) {
      $errors[] = 'Tuotteen hinnan täytyy olla määrätty!';
    }

    if($this->price < 0) {
      $errors[] = 'Tuotteen hinta ei voi olla negatiivinen.';
    }

    return $errors;
  }

  public function validate_available($errors) {
    //valinnainen kenttä

    if($this->available && $this->available < 0) {
      $errors[] = 'Saatavilla olevien tuotteiden määrä ei voi olla negatiivinen.';
    }

    return $errors;
  }

  public function validate_producer($errors) {
    //valinnainen kenttä

    if ($this->producer && strlen($this->producer) < 4) {
      $errors[] = 'Tuottajan nimen pituuden tulee olla vähintään neljä merkkiä';
    } else if ($this->producer && strlen($this->producer) > 20) {
      $errors[] = 'Tuottajan nimen pituuden tulee olla enintään 20 merkkiä';
    }

    return $errors;
  }

  public function validate_description($errors) {
    //valinnainen kenttä

    if ($this->producer && strlen($this->producer) > 400) {
      $errors[] = 'Tuotteen kuvauksen pituuden tulee olla enintään 400 merkkiä';
    }

    return $errors;
  }

  public function validate_countryoforigin($errors) {
    if ($this->countryoforigin == null || strlen($this->countryoforigin) < 5) {
      $errors[] = 'Valmistusmaan nimen pituuden tulee olla vähintään viisi merkkiä';
    } else if (strlen($this->countryoforigin) > 20) {
      $errors[] = 'Valmistusmaan nimen pituuden tulee olla enintään 20 merkkiä';
    }

    return $errors;
  }

}