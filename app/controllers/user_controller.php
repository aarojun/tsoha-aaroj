<?php

class UserController extends BaseController{
   public static function login() {
       self::render_view('users/login.html');
   }

   public static function logout() {
   	self::end_sessions();
   	self::redirect_to('/', array('messages' => array('Olet kirjautunut ulos!')));
   }

   private static function end_sessions() {
   	 $_SESSION['user'] = null;
   	 $_SESSION['admin'] = null;
   }

   public static function handle_login() {
   	  // suorittaa kirjautumistoiminnon. Käyttäjä voi valita kirjautuuko asiakkaana vai administraattorina.
   	  self::end_sessions();
      $params = $_POST;

      $usertype = $params['usertype'];
      if($usertype == 'user') {
        $user = User::authenticate($params['username'], $params['password']);

        if(!$user){
      	  $errors = array();
      	  $errors[] = 'Väärä käyttäjätunnus tai salasana!';
          self::redirect_to('/login', array('errors' => $errors));
        }else{
          $_SESSION['user'] = $user;

          $messages = array();
          $messages[] = 'Tervetuloa takaisin, ' . $params['username'];
          self::redirect_to('/', array('messages' => $messages));
        }

      } else if($usertype == 'admin') {
      	$admin = User::authenticate_admin($params['username'], $params['password']);

      	if(!$admin){
      	  $errors = array();
      	  $errors[] = 'Väärä käyttäjätunnus tai salasana!';
          self::redirect_to('/login', array('errors' => $errors));
        }else{
          $_SESSION['admin'] = $admin;

          $messages = array();
          $messages[] = 'Tervetuloa takaisin, admin ' . $params['username'];
          self::redirect_to('/', array('messages' => $messages));
        }
      }
   }
}

?>