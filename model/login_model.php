<?php

  /**
    * Extended Class login_model of our primary class Model
    * Used for logging in
    */

  Class login_model extends Model{

    public function check_login ($data) {

      $username = self::escape_sql($_POST['username']);
      $password = md5($_POST['password']);
      $error = array();
      $result = self::get_array("`users`", "`username` = '" . $username . "'" , "AND", "`password` = '" . $password . "'");

      if ($result) {

        $sql = "SELECT id FROM `users` WHERE `username` = '". $username ."'";
        $query = self::custom_sql($sql);
        $query = $query[0];
        $query = $query['id'];
        $_SESSION['user_id'] = $query;
        return $error;

      } else {
        $error['invalid'] =  "Username or password was incorrect.";
        return $error;
      }

    }

  }



?>
