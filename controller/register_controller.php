<?php

  /**
  * Class register_controller extends our primary Controller for register purpose.
  */


  Class register_controller extends Controller {

    public function index_action ($data) {

      $this->view->generate_view("view_register.php", "template.php", $data);

    }

    public function user_register_action ($data) {

      if (isset($_POST['name'])) {

        $error = array();

        $model = $this->model->load_model('register');

        $error = $model->user_register($_POST);

        $this->view->generate_view("view_register.php", "template.php", $error);

      } else {
        Web::Page404("Post method not initialized in function: " . __METHOD__ );
      }
    }

  }

?>
