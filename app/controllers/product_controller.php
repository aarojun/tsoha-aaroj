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

	public static function store() {
		$params = $_POST;

		$params['price'] = floatval($params['price']);
		$params['available'] = intval($params['available']);

		// toteutetaan validointi syötteelle

		$product = new Product($params);

		$errors = $game->errors();
		$messages = array();

		if(count($errors) == 0) {
			// syöte on validi, luodaan tuote
            $id = Product::create($params);
            $messages[] = 'Tuote ' . $id . ' on lisätty tietokantaan';
            self::redirect_to('/product/' . $id, array('messages' => $messages));
		} else {
			self::redirect_to('/product/new' . $id, array('errors' => $errors, 'params' => $params));
		}
    }

	public static function create() {
		$productTypes = ProductType::all();
		self::render_view('product/new.html', array('types' => $productTypes));
	}

}