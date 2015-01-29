<?php

class ProductController extends BaseController{
	public static function index() {
		// haetaan kaikki tuotteet tietokannasta
		$products = Product::all();
		// renderöidään views/product kansioosa sijaitseva tiedosto index.html $product datalla
		self::render_view('product/index.html', array('products' => $products));
	}

	public static function indexByType($type) {
		$products = Product::matchesType($type);

		self::render_view('product/index.html', array('products' => $products, 'type' => $type));
	}

	public static function show($id) {
		$product = Product::find($id);
        // renderoidaan näkymä annetulle tuotteelle
        self::render_view('product/show.html', array('product' => $product));
	}

	public static function storeTest() {
		$query = DB::query("INSERT INTO Product (name, type, available, price, added) VALUES ('Toblerone suklaa', 'testi', 7, 3.00, NOW()) RETURNING id;");
		echo $query->fetchColumn();
	}

	public static function store() {
		$params = $_POST;

		if($params['name'] != '' && strlen($params['name']) >= 3){
          self::storeFinalize($params);
        // ...
        }else{
          self::render_view('game/new.html', array('error' => 'Nimessä oli virhe!'));
    }

	}

	public static function storeFinalize($params) {
        $id = Product::create(array(
			'name' => $params['name'],
			'type' => $params['type'],
			'price' => $params['price'],
			'available' => $params['available'],
			'producer' => $params['producer'],
			'description' => $params['description'],
			'countryoforigin' => $params['countryoforigin']
			));
		self::redirect_to('/product/' . $id, array('message' => 'Tuote ' . $id . ' on lisätty tietokantaan'));
	}

	public static function create() {
		self::render_view('product/new.html');
	}

}