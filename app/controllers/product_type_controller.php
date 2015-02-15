<?php 

class ProductTypeController extends BaseController{
	public static function index() {
		// haetaan kaikki tuotteet tietokannasta
		$products = ProductType::all();
		// renderöidään views/product kansioosa sijaitseva tiedosto index.html $product datalla
		self::render_view('product_type/index.html', array('products' => $products));
	}

	public static function indexByName($name) {
		$types = ProductType::findByName($name);

		self::render_view('product_type/index.html', array('products' => $products, 'type' => $type));
	}

	public static function store() {
		self::check_admin();
		
		$params = $_POST;

		// toteutetaan validointi syötteelle

		$productType = new ProductType($params);

		$errors = $productType->errors();
		$messages = array();
		
		if ($errors == null) {
	      // syöte on validi, luodaan tuotetyyppi
          $id = ProductType::create($params);
          $messages[] = 'Tuotetyyppi ' . $id . ' on lisätty tietokantaan';
          self::redirect_to('/product_type/new', array('messages' => $messages));
		} else {
		  self::render_view('/product_type/new.html', array('errors' => $errors, 'params' => $params));
	   }
    }

	public static function create() {
		self::check_admin();

		self::render_view('product_type/new.html');
	}

	public static function destroy() {
		self::check_admin();

		$messages = array();
		$messages[] = 'Tuotetyyppi on poistettu onnistuneesti!';
		self::redirect_to('product_type', array('messages' => $messages));
	}

}