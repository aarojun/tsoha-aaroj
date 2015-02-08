<?php

class ProductController extends BaseController{
	public static function index() {
		// haetaan kaikki tuotteet tietokannasta
		$products = Product::all();
		// renderöidään views/product kansioosa sijaitseva tiedosto index.html $product datalla
		self::render_view('product/index.html', array('products' => $products));
	}

	public static function indexByType($typeName) {
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

		$errors = $product->errors();
		$messages = array();

		if($errors == null) {
			// syöte on validi, luodaan tuote
            $id = Product::create($params);
            $messages[] = 'Tuote ' . $id . ' on lisätty tietokantaan';
            self::redirect_to('/product/' . $id, array('messages' => $messages));
		} else {
			self::redirect_to('/product/new' . $id, array('errors' => $errors, 'params' => $params));
		}
    }

    public static function update($id) {
		$params = $_POST;

        $params['entry_id'] = $id;
		$params['price'] = floatval($params['price']);
		$params['available'] = intval($params['available']);

		// toteutetaan validointi syötteelle

		$product = Product::find($id);

		$errors = $product->errors();
		$messages = array();

		if($errors == null) {
			// syöte on validi, luodaan tuote
            $id = Product::update($params);
            $messages[] = 'Tuote ' . $id . ' on päivitetty';
            self::redirect_to('/product/' . $id, array('messages' => $messages));
		} else {
			self::redirect_to('/product/' . $id . '/edit', array('errors' => $errors, 'params' => $params));
		}
    }

	public static function create() {
		$productTypes = ProductType::all();
		self::render_view('/product/new.html', array('types' => $productTypes));
	}

	public static function edit($id) {
		$productTypes = ProductType::all();
		$product = Product::find($id);

		if($product) {
		  self::render_view('product/edit.html', array('params' => $product, 'types' => $productTypes));
	    } else {
	    	$errors = array();
	    	$errors[] = "Tuotetta " . $id . " ei ole olemassa.";
          self::redirect_to('/product/new', array('errors' => $errors));
	    }
	}

    public static function destroy() {
		self::redirect_to('product', array('message' => 'Tuote on poistettu onnistuneesti!'));
	}
}