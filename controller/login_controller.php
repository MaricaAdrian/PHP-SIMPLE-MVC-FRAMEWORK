<?php

  /**
  * Class login_controller extends our primary Controller for login purpose
  */

  Class login_controller extends Controller{

    public function index_action ($data) {

      if (isset($_SESSION['user_id'])) {
        Web::relocate('products');
      }

      $this->view->generate_view("view_login.php", "template.php", $data);


    }

    public function check_action ($data) {

      if (isset($_SESSION['user_id'])) {
        Web::relocate('products');
      }

      if (isset($_POST['username'])) {

        $model =  $this->model->load_model('login');

        $error = $model->check_login($_POST);

        if (!empty($error))
          $this->view->generate_view("view_login.php", "template.php", $error);
        else
          Web::relocate('products');

      } else {
        Web::Page404("Post method not initialized in function: " . __METHOD__ );
      }

    }

  }


?>
