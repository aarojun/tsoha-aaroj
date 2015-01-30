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

		// lisää validointi!

		$id = Product::create($params);
		self::redirect_to('/product/' . $id, array('message' => 'Tuote ' . $id . ' on lisätty tietokantaan'));
    }

	public static function create() {
		$productTypes = ProductType::all();
		self::render_view('product/new.html', array('types' => $productTypes));
	}

}