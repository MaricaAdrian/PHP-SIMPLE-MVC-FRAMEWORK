<?php

  /**
  * Class add_products_controller extends our primary Controller for adding products
  */

  Class add_products_controller extends Controller {

    public function index_action ($data) {

      if (isset($_SESSION['user_id'])) {

        $data['title'] = "Add products";

        $this->view->generate_view("view_add_products.php", "template_add_products.php", $data);

      } else {

          Web::relocate('login');

      }

    }

    public function populate_action ($data) {

      if (isset($_POST['initialize'])) {

        $model = $this->model->load_model('add_products');

        $message = $model->get_all();

        echo json_encode($message);

      }

    }

    public function add_action ($data) {

      if (isset($_POST['name'])) {

        $model = $this->model->load_model('add_products');

        $message = $model->add_product($data);

        echo $message;

      }

    }

    public function delete_action ($data) {

      if (isset($_POST['delete'])) {

        $model = $this->model->load_model('add_products');

        $message = $model->delete_product($_POST['delete']);

        echo $message;

      }

    }

    public function edit_action ($data) {

      if (isset($_POST['edit_name'])) {

        $model = $this->model->load_model('add_products');

        $message = $model->edit_product($_POST);

        echo $message;

      }

    }

  }



?>
