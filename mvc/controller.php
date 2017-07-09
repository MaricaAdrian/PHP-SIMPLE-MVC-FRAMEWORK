<?php

  /**
   * Our primary Controller class
   */
  Class Controller {
      /** @var Model initialize our model class */
      public $model;

      /** @var View initialize our view class */
      public $view;

      /** @var array data we want to display on page*/
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
