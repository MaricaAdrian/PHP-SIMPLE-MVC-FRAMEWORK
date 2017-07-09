<?php


  Class add_products_controller extends Controller {

    public function index_action ($data) {

      if (isset($_SESSION['user_id'])) {

        $data['title'] = "Add products";

        $this->view->generate_view("view_add_products.php", "template_add_products.php", $data);

      } else {

          Web::relocate('login');

      }

    }

  }



?>
