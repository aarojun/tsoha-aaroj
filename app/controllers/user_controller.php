<?php

class UserController extends BaseController{
   public static function login() {
       self::render_view('users/login.html');
   }

   public static function handle_login() {
   	  // suorittaa kirjautumistoiminnon. Käyttäjä voi valita kirjautuuko asiakkaana vai administraattorina.
      $params = $_POST;

      $usertype = $params['usertype'];
      if($usertype = 'user') {
        $userid = User::authenticate($params['username'], $params['password']);

        if(!$userid){
      	  $errors = array();
      	  $errors[] = 'Väärä käyttäjätunnus tai salasana!';
          self::redirect_to('/login', array('errors' => $errors));
        }else{
          $_SESSION['user'] = $userid;

          $messages = array();
          $messages[] = 'Tervetuloa takaisin, ' . $params['username'];
          self::redirect_to('/', array('messages' => $messages));
        }

      } else if($usertype = 'admin') {
      	$adminid = User::authenticate_admin($params['username'], $params['password']);

      	if(!$adminid){
      	  $errors = array();
      	  $errors[] = 'Väärä käyttäjätunnus tai salasana!';
          self::redirect_to('/login', array('errors' => $errors));
        }else{
          $_SESSION['admin'] = $adminid;

          $messages = array();
          $messages[] = 'Tervetuloa takaisin, admin ' . $params['username'];
          self::redirect_to('/', array('messages' => $messages));
        }
      }
   }
}