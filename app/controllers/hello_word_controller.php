<?php

  class HelloWorldController extends BaseController{

    public static function index(){
   	  self::render_view('suunnitelmat/etusivu.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä	
      self::render_view('helloworld.html');
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
