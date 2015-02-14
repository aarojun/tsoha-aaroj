<?php

class UserController extends BaseController{
   public static function login() {
       self::render_view('users/login.html')
   }

   public static function handle_login() {
      $params = $_POST;

      $userid = User::authenticate($params['username'], $params['password']);

      if(!$user){
      	$errors = array();
      	$errors[] = 'error' => 'Väärä käyttäjätunnus tai salasana!';
        self::redirect_to('/login', array('errors' => $errors));
      }else{
        $_SESSION['user'] = $userid;

        $messages = array();
        $messages[] = 'Tervetuloa takaisin' . $params['username'] . '!';
        self::redirect_to('/', array('messages' => $messages));
   }
}