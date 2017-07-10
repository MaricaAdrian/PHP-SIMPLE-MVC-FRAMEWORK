<?php

/**

* @file controller.php

* @brief Main controller file of our web application.

*

* @author  © Marica Adrian-Gabriel

*

* @date 10/07/2017

*/


  /**
   * Our primary Controller class
   */
  Class Controller {

      public $model;

      public $view;

      public $data = array();

      /**
       * Controller constructor.
       */
      function __construct()
      {
          $this->view = new View();
          $this->model = new Model();
      }
  }

?>
