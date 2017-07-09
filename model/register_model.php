<?php

  /**
    * Extended Class register_model of our primary class Model
    * Used for inserting new users to database
    */

    Class register_model extends Model{

      public function user_register ($data) {

        $username = self::escape_sql($_POST['username']);
        $email = self::escape_sql($_POST['email']);
        $error = array();

        $result = self::get_array("`users`", "`username` = '" . $username . "'" , "OR", "`email` = '" . $email . "'");

        if ($result) {
          $error['duplicate'] = "Username or email already exists.";
          return $error;
        } else {

          $name = $this->escape_sql($_POST['name']);

          if (strlen($_POST['username']) < 4)
            $error['username'] = "Username length must exceed 3 characters.";

          if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $error['email'] = "Invalid email format.";

          if ($_POST['rpassword'] != $_POST['password'])
            $error['password'] = "Passwords does not match.";
          else
            $password = md5($_POST['password']);

          if(!isset($_POST['remember'])) {
            $error['remember'] = "You must accept terms and conditions.";
          }

          if (empty($error)) {

            $sql = "INSERT INTO `users`(`username`, `password`, `name`, `email`) VALUES
                                       ('".$username."','".$password."','".$name."','".$email."')";

            $query  = self::execute_public($sql);

            if ($query)
              return 0;

          } else {
            $error['username_r'] = $_POST['username'];
            $error['email_r'] = $_POST['email'];
            $error['name_r'] = $_POST['name'];
            return $error;
          }

        }

      }

    }

?>
