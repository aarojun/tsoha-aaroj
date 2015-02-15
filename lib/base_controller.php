<?php

  class BaseController{

    public static function get_user_logged_in(){
      // Katsotaan onko user-avain sessiossa
      if(isset($_SESSION['user'])){
        // Pyydetään User-mallilta käyttäjä session mukaisella id:llä
        $userid = $_SESSION['user'];

        return User::find($userid);
      } else {
      // Käyttäjä ei ole kirjautunut sisään
      return null;
      }
    }

    public static function get_admin_logged_in(){
      // Katsotaan onko user-avain sessiossa
      if(isset($_SESSION['admin'])){
        $adminid = $_SESSION['admin'];

        return User::findAdmin($adminid);
      } else {
      // Käyttäjä ei ole kirjautunut sisään administraattorina
      return null;
      }
    }

    public static function check_logged_in(){
      // toteuttaa kirjautumisen tarkistamisen
      if(!isset($_SESSION['user'])){
        self::redirect_to('/login', array('messages' => array('Kirjaudu ensin sisään!')));
        return false;
      }
      return true;
    }

    public static function check_admin(){
      // palauttaa tosi jos kirjautuneella käyttäjällä on admin-oikeudet
      if(!isset($_SESSION['admin'])){
        self::redirect_to('/login', array('messages' => array('Pääsy vain henkilökunnalle!')));
        return false;
      }
      return true;
    }

    public static function render_view($view, $content = array()){
      Twig_Autoloader::register();

      $twig_loader = new Twig_Loader_Filesystem('app/views');
      $twig = new Twig_Environment($twig_loader);

      try{
        if(isset($_SESSION['flash_message'])){

          $flash = json_decode($_SESSION['flash_message']);

          foreach($flash as $key => $value){
            $content[$key] = $value;
          }

          unset($_SESSION['flash_message']);
        }

        $content['base_path'] = self::base_path();

        $content['user_logged_in'] = self::get_user_logged_in();
        $content['admin_logged_in'] = self::get_admin_logged_in();
        

        echo $twig->render($view, $content);
      } catch (Exception $e){
        die('Virhe näkymän näyttämisessä: ' . $e->getMessage());
      }

      exit();
    }

    public static function redirect_to($location, $message = null){
      if(!is_null($message)){
        $_SESSION['flash_message'] = json_encode($message);
      }

      header('Location: ' . self::base_path() . $location);

      exit();
    }

    public static function render_json($object){
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($object);

      exit();
    }

    public static function base_path(){
      $script_name = $_SERVER['SCRIPT_NAME'];
      $explode =  explode('/', $script_name);

      if($explode[1] == 'index.php'){
        $base_folder = '';
      }else{
        $base_folder = $explode[1];
      }

      return '/' . $base_folder;
    }

  }
