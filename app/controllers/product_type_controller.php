<?php 

class ProductTypeController extends BaseController{
	public static function index() {
		// haetaan kaikki tuotteet tietokannasta
		$types = ProductType::all();
		// renderöidään views/product kansioosa sijaitseva tiedosto index.html $product datalla
		self::render_view('product_type/index.html', array('types' => $types));
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
          $name = ProductType::create($params);
          $messages[] = 'Tuotetyyppi ' . $name . ' on lisätty tietokantaan';
          self::redirect_to('/product_type/new', array('messages' => $messages));
		} else {
		  self::render_view('/product_type/new.html', array('errors' => $errors, 'params' => $params));
	   }
    }

	public static function create() {
		self::check_admin();

		self::render_view('product_type/new.html');
	}

	public static function destroy($id) {
		self::check_admin();

		ProductType::destroy($id);

		$messages = array();
		$messages[] = 'Tuotetyyppi on poistettu onnistuneesti!';
		self::redirect_to('/product_type', array('messages' => $messages));
	}

}