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
		$params = $_POST;

		// lisää validointi!
		$matchingtypes = ProductType::findUsedNames($params['name']);
		if ($matchingtypes == null) {
          $id = ProductType::create($params);
          self::redirect_to('/product_type/new', array('message' => 'Tuotetyyppi ' . $id . ' on lisätty tietokantaan'));
		} else {
		  self::redirect_to('/product_type/new', array('alert' => 'Tuotetyyppi ' . $params['name'] . ' on jo olemassa!'));
	   }
    }

	public static function create() {
		self::render_view('product_type/new.html');
	}

}