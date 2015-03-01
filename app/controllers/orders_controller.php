<?php

class OrdersController extends BaseController{

	public static function indexByUser() {
      self::check_logged_in();

      $userid = $_SESSION['user']->id;
      $orders = Orders::matchesUser($userid);
      self::render_view('orders/index.html', array('orders' => $orders));
    }

    public static function addtocart($productid) {
      self::check_logged_in();

      $userid = $_SESSION['user']->id;

      //tarkistetaan onko vastaava tilaus jo olemassa
      if(!Orders::existsMatchingUserAndProduct($userid,$productid)) {
      	//validoidaan uusi tilaus
        $params = array();

        $params['product'] = $productid;
        $params['customer'] = $_SESSION['user']->id;
        $params['quantity'] = 1;

        $order = new Orders($params);

        $errors = $order->errors();

        if($errors == null) {
          //tilauksen syöte oli validi, lisätään tilaus tietokantaan
        	echo "test";
          Orders::create($params);
          $messages = array("Tuote on lisätty ostoskoriisi.");
          self::redirect_to('/product', array('messages' => $messages));
        } else {
          //tilauksen syöte ei ollut validi, ohjataan käyttäjä takaisin tuotelistaan
          self::redirect_to('/product', array('errors' => $errors));
        }
      } else {
      	// vastaava tilaus oli jo olemassa
      	$errors[] = "Tuote ".$productid." on jo ostoskorissasi!";
      	self::redirect_to('/ostoskassi', array('errors' => $errors));
      }
    }

    public static function destroy($orderid) {
      self::check_logged_in();

      // tarkistetaan vastaako tilaus pyyntöä tekevää käyttäjää
      $order = Orders::find($orderid);
      $userid = $_SESSION['user']->id;

      if($order->customer == $userid) {
      	// tilaus vastaa käyttäjää joten poistetaan se
      	Orders::destroy($orderid);
      	$messages = array();
        $messages[] = 'Tilaus on poistettu ostoskorista';
        self::redirect_to('/ostoskassi', array('messages' => $messages));
      } else {
        $errors = array();
        $errors[] = 'Käyttäjälläsi ei ole oikeuksia poistaa annettua tilausta';
        self::redirect_to('/ostoskassi', array('errors' => $errors));
      }
    }
}