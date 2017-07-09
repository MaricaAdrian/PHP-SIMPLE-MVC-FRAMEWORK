<?php

  /**
  * Class logout_controller extends our primary Controller for login purpose
  */

  Class logout_controller extends Controller{

    public function index_action ($data) {

      if (isset($_SESSION['user_id'])) {

        unset($_SESSION['user_id']);
        session_destroy();
        Web::relocate('login');
      }

      Web::relocate('login');


    }

  }


?>
