<?php

  /**
    * Extended Class add_products_model of our primary class Model
    * Used for inserting new products to database
    */

    Class add_products_model extends Model{


      public function get_all () {

        return self::get_array("`products`");

      }

      public function add_product ($data) {

        if (isset($_POST['name'])) {

          $name = $_POST['name'];
          $result = self::check_if_exists("name", $name, "products");

          if($result) {
            return 0;
          } else {

            $name = self::escape_sql($name);
            $quantity = self::escape_sql($_POST['quantity']);
            $type = self::escape_sql($_POST['type']);

            $sql = "INSERT INTO `products`(`name`,`quantity`,`quantity_type`) VALUES
                                          ('" . $name . "', '" . $quantity . "', '". $type ."')";

            self::execute_public($sql);

            $id = self::inserted_id();

            if ($id == 0)
              return 0;
            else
              return $id;
          }

        }

      }

    }

?>
