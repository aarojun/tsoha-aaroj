<?php

class Product extends BaseModel {
    // tuotteen atribuutit
	public $id, $product, $user, $quantity;

	public function __construct($attributes) {
	  parent::__construct($attributes);

    $this->validators = array(
      'validate_product', 
      'validate_user', 
      'validate_quantity');
	}

  public function errors() {
    // tarpeeton?
    return parent::errors();
  }

  public static function destroy($id) {
    $rows = DB::query('DELETE FROM Orders WHERE id = :id', array('id' => $id));
  }

  public static function all() {
  	// kutsutaan luokan DB staattista metodia query
	$rows = DB::query('SELECT * FROM Orders 
                     ORDER BY id');
	return self::formProducts($rows);
   }

   public static function matchesUser($user) {
   	$rows = DB::query('SELECT * FROM Orders WHERE user = :user
                       ORDER BY name', array('user' => $user));
    return self::formProducts($rows);
   }

   public function validate_product() {

   }

   public function validate_user() {

   }

   public function validate_quantity($errors) {
    if(quantity < 1) {
       $errors[] = "Tuotetta voi tilata vähintään 1 kappaletta";
    }

    return $errors;
   }

}