<?php

class Product extends BaseModel {
    // tuotteen atribuutit
	public $id, $name, $type, $price, $available, $producer, $description, $countryoforigin, $added, $updated;

	public function __construct($attributes) {
	  parent::__construct($attributes);
	}

    // käy kyselyiden tuottamat rivit läpi ja palauttaa listan product-olioita
	public static function makeProduct($rows) {
        $products = array();

		foreach($rows as $row) {
		$products[] = new Product(array(
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
	}
	return $products;
	}

  public static function all() {
  	// kutsutaan luokan DB staattista metodia query
	$rows = DB::query('SELECT * FROM Product');
	return self::makeProduct($rows);
   }

   public static function find($id){
    $rows = DB::query('SELECT * FROM Product WHERE id = :id LIMIT 1', array('id' => $id));

    if(count($rows) > 0){
      $products = self::makeProduct($rows);
      return $products[0];
    }

    return null;
  }

}