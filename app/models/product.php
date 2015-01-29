<?php

class Product extends BaseModel {
    // tuotteen atribuutit
	public $id, $name, $type, $price, $available, $producer, $description, $countryoforigin, $added, $updated;

	public function __construct($attributes) {
	  parent::__construct($attributes);

	}

	public static function formProduct($row) {
        $product = new Product(array(
			'id' => $row['id'],
			'name' => $row['name'],
			'type' => $row['type'],
			'price' => $row['price'],
			'available' => $row['available'],
			'producer' => $row['producer'],
			'description' => $row['description'],
			'countryoforigin' => $row['countryoforigin'],
			'added' => $row['added'],
			'updated' => $row['updated']
			));
	return $product;
	}

    // käy kyselyiden tuottamat rivit läpi ja palauttaa listan product-olioita
	public static function formProducts($rows) {
        $products = array();

		foreach($rows as $row) {
		$products[] = self::formProduct($row);
	}
	return $products;
	}

  public function validate_name() {
    if($this->name == '' || $this->name == null){
      $errors[] = 'Nimi ei saa olla tyhjä!';
    }
    if(strlen($this->name) < 3){
      $errors[] = 'Nimen pituuden tulee olla vähintään kolme merkkiä!';
    }

  return $errors;
  }


  public static function create($row) {
  	$query = DB::query("INSERT INTO Product (name, type, price, available, producer, description, countryoforigin, added, updated) 
  		    VALUES(
  		    :row['name'],
  			:row['type'],
  			:row['price'],
  			:row['available'],
  			:row['producer'],
  			:row['description'],
  			:row['countryoforigin'],
  			NOW(),
  			NOW())
  	        RETURNING id");

  	return $query;
  }

  public static function create2($row) {
  	return DB::query('INSERT INTO Product (name, type, available, price, added) VALUES ("Jotain", "testi", 7, 3.00, NOW()) RETURNING id;');
  }

  public static function all() {
  	// kutsutaan luokan DB staattista metodia query
	$rows = DB::query('SELECT * FROM Product');
	return self::formProducts($rows);
   }

   public static function matchesType($type) {
   	$rows = DB::query('SELECT * FROM Product WHERE type = :type', array('type' => $type));
    return self::formProducts($rows);
   }

   public static function find($id){
    $rows = DB::query('SELECT * FROM Product WHERE id = :id LIMIT 1', array('id' => $id));

    if(count($rows) > 0){
      $products = self::formProducts($rows);
      return $products[0];
    }

    return null;
  }

}