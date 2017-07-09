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

      public function delete_product ($delete) {

        if (isset($_POST['delete'])) {

          $delete = self::escape_sql($delete);

          $sql = "DELETE FROM `products` WHERE `name` = '". $delete ."'";

          $result = self::execute_public($sql);

          if($result)
            return 1;
          else
            return 0;

        }

      }

      public function edit_product ($edit) {

        if (isset($_POST['edit_name'])) {

          $name = self::escape_sql($edit['edit_name']);
          $quantity = self::escape_sql($edit['edit_quantity']);
          $quantity_attr = self::escape_sql($edit['edit_type']);
          $unmodified_name = self::escape_sql($edit['unmodified_name']);

          $sql = "UPDATE `products` SET `name` = '". $name ."', `quantity` = '". $quantity ."', `quantity_type` = '". $quantity_attr ."' WHERE `name` = '". $unmodified_name ."' ";

          $result = self::execute_public($sql);

          if($result)
            return 1;
          else
            return 0;

        }

      }

    }

?>
