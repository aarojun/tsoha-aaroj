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

    public static function tuotteet(){
      self::render_view('suunnitelmat/tuotteet.html');
    }
  }
