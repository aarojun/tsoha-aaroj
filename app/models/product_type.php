<?php

class ProductType extends BaseModel {
    // tuotteen atribuutit
	public $id, $name;

	public function __construct($attributes) {
	  parent::__construct($attributes);

    $this->validators = array('validate_name');
  }

  public function errors() {
    // tarpeeton?
    return parent::errors();
  }
	

    // käy kyselyiden tuottamat rivit läpi ja palauttaa listan product-olioita
	public static function formProductTypes($rows) {
        $productTypes = array();

		foreach($rows as $row) {
		$productTypes[] = new ProductType($row);
	}
	return $productTypes;
	}


    public static function create($row) {
  	  $query = DB::query("INSERT INTO ProductType (name)
  		    VALUES(:name) RETURNING name", $row);

  	return $query[0]['name'];
  }

  public static function destroy($id) {
    $rows = DB::query('DELETE FROM ProductType WHERE id = :id', array('id' => $id));
  }

  public static function all() {
	  $rows = DB::query('SELECT * FROM ProductType');
	  return self::formProductTypes($rows);
   }

   public static function findUsedNames($name) {
   	$rows = DB::query('SELECT * FROM ProductType WHERE name = :name', array('name' => $name));

    if(count($rows) > 0){
      $types = self::formProductTypes($rows);
      return $types[0];
    }

    return null;
   }

   public static function find($id){
    $rows = DB::query('SELECT * FROM ProductType WHERE id = :id LIMIT 1', array('id' => $id));

    if(count($rows) > 0){
      $products = self::formProductTypes($rows);
      return $types[0];
    }

    return null;
  }

  public function validate_name($errors) {

    if ($this->name == '' || $this->name == null) {
      $errors[] = 'Nimi ei saa olla tyhjä';
    }
    if (strlen($this->name) < 4) {
      $errors[] = 'Nimen pituuden tulee olla vähintään neljä merkkiä';
    }

    $matchingtypes = self::findUsedNames($this->name);
    if ($matchingtypes) {
      $errors[] = 'Tuotetyyppi nimeltä ' . $this->name . ' on jo olemassa!';    
    }

    return $errors;
  }

}