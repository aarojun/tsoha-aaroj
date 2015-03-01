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
      if(self::matchesUser()) {
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

    public static function matchesUser($orderid) {
    	// tarkistaa onko nykyinen käyttäjä tilaukseen liitetty asiakas
    	$order = Orders::find($orderid);
        $userid = $_SESSION['user']->id;
        if($order->customer == $userid) {
        	return true;
        } else {
        	return false;
        }
    }

    public static function update($orderid) {
    	self::check_logged_in();

        if(self::matchesUser($orderid)) {
      	  // tilaus vastaa käyttäjää
      	  $newquantity = intval($_POST['quantity']);

          $order = Orders::find($orderid);
          $order->quantity = $newquantity;

          $errors = $order->errors();

          if($errors == null) {

            Orders::update($orderid, $newquantity);
      	    $messages = array();
            $messages[] = 'Tilauksen lukumäärä on päivitetty';
            self::redirect_to('/ostoskassi', array('messages' => $messages));
          } else {
          	self::redirect_to('/ostoskassi', array('errors' => $errors));
          }
        } else {
          // tilaus ei vastannut käyttäjää
          $errors = array();
          $errors[] = 'Käyttäjälläsi ei ole oikeuksia muokata annettua tilausta';
          self::redirect_to('/ostoskassi', array('errors' => $errors));
        }
    }
}