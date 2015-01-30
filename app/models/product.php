<?php

class Product extends BaseModel {
    // tuotteen atribuutit
	public $id, $name, $type, $price, $available, $producer, $description, $countryoforigin, $added, $updated;

	public function __construct($attributes) {
	  parent::__construct($attributes);

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