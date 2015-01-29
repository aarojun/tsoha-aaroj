<?php

// luokka-riippuvuudet hallittu composer.json -riippuvuuksienhallitsijassa (vko3)

  class HelloWorldController extends BaseController{

    public static function index(){
   	  self::render_controller('product/index.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä	

      //testaa product-mallin kaikkien olioiden haku
      $products = Product::all();

      print_r($products);

      //testaa product-mallin yhden olion haku ('id' mukaan)
      $product2 = Product::find(2);

      print_r($product2);
    }

    public static function login(){
    	self::render_view('suunnitelmat/login.html');
    }

    public static function tuotelista(){
      self::render_view('suunnitelmat/tuotelista.html');
    }

    public static function ostoskassi(){
      self::render_view('suunnitelmat/ostoskassi.html');
    }

    public static function product_show(){
      self::render_view('suunnitelmat/product_show.html');
    }

    public static function product_modify(){
      self::render_view('suunnitelmat/product_modify.html');
    }

    public static function product_add(){
      self::render_view('suunnitelmat/product_add.html');
    }
  }
