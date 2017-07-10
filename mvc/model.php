<?php

/**

* @file model.php

* @brief Main model file of our web application.

*

* @author  © Marica Adrian-Gabriel

*

* @date 10/07/2017

*/


  /**
  *
  * Primary model class for our application
  *
  */

  Class Model {

    /** @var dbconnect For connecting to the database*/

    private $dbconnect;

    /**
    *
    * Constructor of our model class
    *
    */

    function __construct() {

      $this->dbconnect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      if ($this->dbconnect->errno) {

        Web::Page404('Failed connecting to database: ' . $this->dbconnect->error);

      }

      $this->dbconnect->set_charset('utf8');

    }

    /**
    * function load_model Load function of our model
    *
    * @param $model The model to load
    *
    * @return The model or false;
    */

    public function load_model($model) {

      $model_name = $model . "_model";

      $model_file = 'model/' . $model_name . '.php';

      if (file_exists($model_file)) {
        require $model_file;
        return new $model_name;
      }

      Web::Page404('Model ' . $model_name . ' not found.');

      return false;


    }

    /**
    *
    * function escape_sql Function that escapes the given string
    *
    * @param $string our string that has to be escaped
    *
    * @return string that has been escaped
    */

    public function escape_sql($string) {

      return $this->dbconnect->real_escape_string($string);

    }

    /**
    *
    * function inserted_id Function that returns the last id inserted by a query.
    *
    * @return The last id inserted or false.
    */

    public function inserted_id() {

      return $this->dbconnect->insert_id;

    }



    /**
    * function execute Executs the given sql command
    *
    * @param $sql Sql that needs to be executed
    *
    * @return MySqli Result
    */
   private function execute($sql) {
       $result = $this->dbconnect->query($sql);
       if ($this->dbconnect->errno) {
           Web::Page404("Query has failed in function " . __METHOD__ . ": " . $this->dbconnect->error . "<br> $sql");
       }

       return $result;
   }

   /**
   * function execute Executs the given sql command
   *
   * @param $sql Sql that needs to be executed
   *
   * @return MySqli Result
   */
  public function execute_public($sql) {

      $result = $this->execute($sql);
      return $result;

  }

    /**
    *
    * function get_array() Function that tries to give us an array from the database
    *
    * @param $table Table from where we want to get the array from
    *
    * @param $condition1 First condition if neccessary
    *
    * @param $condition_operator Operator for second condition
    *
    * @param $condition2 Second condition if neccessary
    *
    * @return The wanted array or false;
    */

    public function get_array($table, $condition1 = NULL, $condition_operator = NULL , $condition2 = NULL) {

      if (!is_null($condition1) && is_null($condition_operator)) {
        $sql = "SELECT * FROM " . $table . " WHERE " . $conditon1;
        $array = self::execute($sql);
        $return = array();
        while($data = $array->fetch_assoc()) {
          $return[] = $data;
        }

        if (count($return) > 0)
          return $return;
        else
          return false;
      } elseif (!is_null($condition1) && !is_null($condition_operator)) {

        if (is_null($condition2)) {
            Web::Page404('Second condition was not set thus having a condition operator in function: ' . __METHOD__);
            return false;
        }

        $sql = "SELECT * FROM " . $table . " WHERE " . $condition1 . " " . $condition_operator . " " . $condition2;
        $array = self::execute($sql);
        $return = array();
        while($data = $array->fetch_assoc()) {
          $return[] = $data;
        }

        if (count($return) > 0)
          return $return;
        else
          return false;

      } elseif (is_null($condition1)) {

        $sql = "SELECT * FROM " . $table;
        $array = self::execute($sql);
        $return = array();
        while($data = $array->fetch_assoc()) {
          $return[] = $data;
        }

        if (count($return) > 0)
          return $return;
        else
          return false;
      }

    }


    /**
     * function get_by_id Returns data about our given id
     *
     * @param $id The id we want to get from
     *
     * @param $table Tabel name we want to get from
     *
     * @return Array if id exists else false
     */
    public function get_by_id($id, $table) {

        $sql = "SELECT * FROM " . $table . " WHERE id = '" . self::escape($id) . "'";
        $result = self::execute($sql);
        $data = $result->fetch_assoc();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }


  /**
   * function custom_sql Executes the given SQL command
   *
   * @param $sql The sql command we want to be executed
   *
   * @return Array if query successfully or error page otherwise
   */

  public function custom_sql($sql) {

    $result = self::execute($sql);
    $return = array();

    while ($c = $result->fetch_assoc()) {

      $return[] = $c;

    }

    if (count($return) > 0) {

      return $return;

    } else {

     Web::Page404("Faild to execute query \"" . $sql . "\" in function " . __METHOD__);
   }

  }


   /**
   * function check_if_exists Function that checks if key is equal to the value in the given table
   *
   * @param $key Key that we want to check if exists
   *
   * @param $value Value that we want to check if is equal to the key
   *
   * @param $table The table where we make the check
   *
   * @return True or false
   */

  public function check_if_exists($key, $value, $table) {
      $sql = "SELECT * FROM `" . $table . "` WHERE `" . self::escape_sql($key) . "` = '" . self::escape_sql($value) . "'";
      $result = self::execute($sql);
      $data = $result->fetch_assoc();
      if ($data) {
          return true;
      } else {
          return false;
      }
  }



  /**
     * function Deletes the given id from the given table
     *
     * @param $id Id that we want to be deleted
     *
     * @param $table Table we want to delete from
     *
     * @return True or false
  */
  public function delete($id, $table) {

    $sql = "DELETE FROM " . $table . " WHERE id = '" . self::escape($id) . "'";

    if (self::execute($sql)) {
        return true;
      } else {
        return false;
      }
  }


  /**
    * Destructor of our Model class
  */
    function __destruct(){
        if (!$this->dbconnect->connect_errno) {
            $this->dbconnect->close();
        }
    }

  }

?>
