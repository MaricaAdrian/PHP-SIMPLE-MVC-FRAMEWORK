<?php


  /**
  * Class home_controller extends our primary Controller. It's the controller for homepage.
  */


  Class home_controller extends Controller {

    public function index_action ($data) {
      $data['title'] = "Home";

      $this->view->generate_view("view_home.php", "template.php",  $data);

    }

  }


?>
