<?php

  /**
    * Extended Class add_category_model of our primary class Model
    * Used for managing categories
    */

    Class add_category_model extends Model{


      public function get_all () {

        return self::get_array("`category`");

      }

      public function add_category ($data) {

        if (isset($_POST['name'])) {

          $name = $_POST['name'];
          $result = self::check_if_exists("name", $name, "category");

          if($result) {
            return 0;
          } else {

            $name = self::escape_sql($name);

            $sql = "INSERT INTO `category`(`name`) VALUES
                                          ('" . $name . "')";

            self::execute_public($sql);

            $id = self::inserted_id();

            if ($id == 0)
              return 0;
            else {
              $name = str_replace(" ", "_", $_POST['name']);
              mkdir('images/uploads/' . $name, 0777, true);
              return $id;
            }

          }

        }

      }

      public function delete_category ($delete) {

        if (isset($_POST['delete'])) {

          $delete = self::escape_sql($delete);

          $sql = "DELETE FROM `category` WHERE `name` = '". $delete ."'";

          $result = self::execute_public($sql);

          if($result) {

            $delete = str_replace(" ", "_", $_POST['delete']);
            self::delete_dir('images/uploads/' . $delete);

            return 1;

          } else
            return 0;

        }

      }

      public function edit_category ($edit) {

        if (isset($_POST['edit_name'])) {

          $name = self::escape_sql($edit['edit_name']);
          $unmodified_name = self::escape_sql($edit['unmodified_name']);

          $sql = "UPDATE `products` SET `quantity_type` = '" . $name . "' WHERE `quantity_type` = '". $unmodified_name ."'";

          $result = self::execute_public($sql);

          if(!$result)
            return 0;

          $sql = "UPDATE `category` SET `name` = '". $name ."' WHERE `name` = '". $unmodified_name ."' ";

          $result = self::execute_public($sql);

          if($result) {

            $unmodified_name = str_replace(" ", "_", $edit['unmodified_name']);
            $name = str_replace(" ", "_", $edit['edit_name']);
            rename("images/uploads/". $unmodified_name, "images/uploads/". $name);
            return 1;

          } else
            return 0;

        }

      }

    }

?>
