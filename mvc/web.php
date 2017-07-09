<?php

  /**
   * Our primary Web class for our MVC
   */
  Class Web {
      /**
       * Begin function of our MVC
       */
      public static function begin() {
          $controller_name = 'home';
          $action_name = 'index';
          $params = array();

          //Preparing routes
          include "mvc/routing.php";

          // Rewrite route to our current format
          $controller_name = $controller_name . '_controller';
          $action_name = $action_name . '_action';

          $controller_file = 'controller/' . $controller_name . '.php';
          if (file_exists($controller_file)) {
              require $controller_file;
          } else {
              self::Page404('Controller ' . $controller_name . ' does not exist!');
          }

          /** @var $controller Creates a new object with our controller name */
          $controller = new $controller_name;

          if (method_exists($controller, $action_name)) {
              //Call given action
              $controller->$action_name($params);
          } else {
              self::Page404('Method ' . $action_name . ' does not exist in ' . $controller_name);
          }
      }

      /**
       * @function Page404 Prints given message than kills the script
       *
       * @param $error_message Message to be printed
       */
      public static function Page404($error_message) {
          if (MODE === 'devON') {
              $view = new View();
              $view->generate_view('view_error.php', 'template.php', array('message' => $error_message));
              die();
          } else {
              self::relocate('error404');
          }
      }

      /**
       * @function relocate Relocate function for users
       *
       * @param $location Relocates user to given location
       */
      public function relocate($location)
      {
          header("Location: " . BASE_URL . $location);
          die();
      }

  }

?>
