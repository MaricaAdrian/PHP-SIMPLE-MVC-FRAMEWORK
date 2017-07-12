<?php

  /**
    * Extended Class add_products_model of our primary class Model
    * Used for managing products
    */

    Class add_products_model extends Model{

      public function populate_category () {

        return self::get_array("`category`");

      }

      public function get_all () {

        return self::get_array("`products`");

      }

      public function add_image ($data) {

        if ( 0 < $_FILES['file']['error'] ) {
          return 0;
        } else {

          $temp = str_replace(" ", "_", $_FILES['file']['name']);

          $name = $data[1] . "_" . $data[0] . "_" . $temp;

          $product_name = self::escape_sql($data[2]);

          $uploads_dir = 'images/uploads/' . $data[1];


          if (move_uploaded_file($_FILES['file']['tmp_name'], "$uploads_dir/$name")) {

            $name = self::escape_sql($name);

            $sql = "UPDATE `products` SET `image` = '". $name ."' WHERE `name` = '". $product_name ."'";

            $result = self::execute_public($sql);

            if ($result)
              return 1;
            else
              return 0;

          }

        }

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

          $sql = "SELECT `image`, `quantity_type` FROM `products` WHERE `name` = '". $delete ."'";

          $result = self::custom_sql($sql);

          $image = $result[0]['image'];

          $category = $result[0]['quantity_type'];

          $category = str_replace(" ", "_", $category);

          unlink("images/uploads/" . $category . "/" . $image);

          $sql = "DELETE FROM `products` WHERE `name` = '". $delete ."'";

          $result = self::execute_public($sql);

          if ($result)
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

          $sql = "SELECT `id` FROM `products` WHERE `name` = '". $unmodified_name ."' ";

          $result = self::custom_sql($sql);

          $id = $result[0]['id'];

          if ($edit['edit_image'] == 0) {

            $sql = "SELECT `image`, `quantity_type` FROM `products` WHERE `name` = '". $unmodified_name ."'";

            $result = self::custom_sql($sql);

            $old_image = $result[0]['image'];
            $old_category = $result[0]['quantity_type'];

            $old_category = str_replace(" ", "_", $old_category);

            $old_dir = "images/uploads/" . $old_category . "/" . $old_image;

            $category = str_replace(" ", "_", $edit['edit_type']);

            $image = str_replace("_" . $id . "_", "", str_replace($old_category, "", $old_image));

            $image = $category . "_" . $id . "_" . $image;

            $new_dir = "images/uploads/" . $category . "/" . $image;

            rename($old_dir, $new_dir);

            $sql = "UPDATE `products` SET `image` = '". $image ."' WHERE `name` = '". $unmodified_name ."'";

            $result = self::execute_public($sql);

            if (!$result)
              return 0;

          }

          $sql = "UPDATE `products` SET `name` = '". $name ."', `quantity` = '". $quantity ."', `quantity_type` = '". $quantity_attr ."' WHERE `name` = '". $unmodified_name ."' ";

          $result = self::execute_public($sql);

          if ($result)
            return $id;
          else
            return 0;


        }

      }

      public function edit_image ($edit) {

        if ( 0 < $_FILES['file']['error'] ) {
          return "Something went wrong at image uploading.";
        } else {

          $name = $edit[1] . "_" . $edit[0] . "_" . str_replace(" ", "_", $_FILES['file']['name']);

          $product_name = self::escape_sql($edit[2]);

          $uploads_dir = 'images/uploads/' . $edit[1];

          $sql = "SELECT `image` FROM `products` WHERE `name` = '". $data[3] ."'";

          $result = self::custom_sql($sql);

          $old_image = $result[0]['image'];

          if (file_exists("images/uploads/" . $edit[3] . "/" . $old_image)) {
              unlink("images/uploads/" . $edit[3] . "/" . $old_image);
          }


          if (move_uploaded_file($_FILES['file']['tmp_name'], "$uploads_dir/$name")) {

            $name = self::escape_sql($name);

            $sql = "UPDATE `products` SET `image` = '". $name ."' WHERE `name` = '". $product_name ."'";

            $result = self::execute_public($sql);

            if ($result)
              return 1;
            else
              return 0;

          }

      }

    }

    }

?>
