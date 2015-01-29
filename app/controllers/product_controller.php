<?php

class ProductController extends BaseController{
	public static function index() {
		// haetaan kaikki tuotteet tietokannasta
		$products = Product::all();
		// renderöidään views/product kansioosa sijaitseva tiedosto index.html $product datalla
		self::render_view('product/index.html', array('products' => $products));
	}

	public static function show($id) {
		$product = Product::find($id);
        // renderoidaan näkymä annetulle tuotteelle
        self::render_view('product/show.html', array('product' => $product));
	}
}