<?php

  class HelloWorldController extends BaseController{

    public static function index(){
   	  echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä	
      self::render_view('helloworld.html');
    }

    public static function login(){
    	self::render_view('suunnitelmat/login.html');
    }
  }
