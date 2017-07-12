<?php

  /**
  * Class add_category_controller extends our primary Controller for managing categories
  */

  Class add_category_controller extends Controller {

    public function __construct () {
      parent::__construct();
      if (!isset($_SESSION['user_id']))
        Web::relocate('login');
    }


    public function index_action ($data) {

      $data['title'] = "Manage categories";

      $this->view->generate_view("view_add_category.php", "template_manage.php", $data);


    }

    public function populate_action ($data) {

      if (isset($_POST['initialize'])) {

        $model = $this->model->load_model('add_category');

        $message = $model->get_all();

        echo json_encode($message);

      }

    }

    public function add_action ($data) {

      if (isset($_POST['name'])) {

        $model = $this->model->load_model('add_category');

        $message = $model->add_category($data);

        echo $message;

      }

    }

    public function delete_action ($data) {

      if (isset($_POST['delete'])) {

        $model = $this->model->load_model('add_category');

        $message = $model->delete_category($_POST['delete']);

        echo $message;

      }

    }

    public function edit_action ($data) {

      if (isset($_POST['edit_name'])) {

        $model = $this->model->load_model('add_category');

        $message = $model->edit_category($_POST);

        echo $message;

      }

    }

  }



?>
