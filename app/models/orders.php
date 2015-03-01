<?php

class Orders extends BaseModel {
    // tuotteen atribuutit
	public $id, $product, $customer, $quantity;

	public function __construct($attributes) {
	  parent::__construct($attributes);

    $this->validators = array(
      'validate_product', 
      'validate_customer', 
      'validate_quantity');
	}

  public function errors() {
    // tarpeeton?
    return parent::errors();
  }

  public static function formOrders($rows) {
        $orders = array();

    foreach($rows as $row) {
    //muutetaan product-muuttuja pelkästä ID:stä kokonaiseksi product-olioksi
    $productid = $row['product'];
    $row['product'] = Product::find($productid);
    $orders[] = new Orders($row);
  }
  return $orders;
  }

  public static function create($row) {
    $query = DB::query("INSERT INTO Orders (product, customer, quantity) VALUES (:product, :customer, :quantity)
       RETURNING id", $row);
    return $query[0]['id'];
  }

  public static function destroy($id) {
    $rows = DB::query('DELETE FROM Orders WHERE id = :id', array('id' => $id));
  }

  public static function all() {
  	// kutsutaan luokan DB staattista metodia query
	$rows = DB::query('SELECT * FROM Orders 
                     ORDER BY id');
	return self::formOrders($rows);
   }

   public static function find($id) {
    $rows = DB::query('SELECT * FROM Orders WHERE id = :id LIMIT 1', array('id' => $id));

    if(count($rows) > 0){
      return new Orders($rows[0]);
    }

    return null;
  }

   public static function matchesUser($user) {
   	$rows = DB::query('SELECT * FROM Orders WHERE customer = :user
                       ORDER BY product', array('user' => $user));
    return self::formOrders($rows);
   }

   public static function existsMatchingUserAndProduct($user, $product) {
    $rows = DB::query('SELECT * FROM Orders WHERE customer = :user AND product = :product', array('user' => $user, 'product' => $product));
    if ($rows) {
      return true;
    } else {
      return false;
    }
   }

   public function validate_product($errors) {
    if($this->product == null) {
      $errors[] = "Tilausta vastaavaa tuotetta ei ole olemassa!";
    }
    return $errors;
   }

   public function validate_customer($errors) {
    
    return $errors;
   }

   public function validate_quantity($errors) {
    if($this->quantity < 1) {
       $errors[] = "Tuotetta voi tilata vähintään 1 kappaletta.";
    }
    return $errors;
   }

}