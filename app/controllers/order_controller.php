<?php

class OrderController extends BaseController{
	public static function ostoskassi(){
      self::check_logged_in();
      
      self::render_view('order/index.html');
    }
}