<?php


  /**
  * Class products_controller extends our primary Controller. It's the controller for the products page.
  */


  Class products_controller extends Controller {

    public function index_action ($data) {

      $model = $this->model->load_model('products');

      $data['products'] = $model->get_all_products();

      $data['categories'] = $model->get_all_categories();

      $data['title'] = "Products";

      $this->view->generate_view("view_products.php", "template.php",  $data);

    }

  }


?>
