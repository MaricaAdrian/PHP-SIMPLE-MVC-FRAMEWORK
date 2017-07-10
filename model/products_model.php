<?php

  /**
    * Extended Class products_model of our primary class Model
    * Used for logging in
    */

  Class products_model extends Model{

    public function get_all_products () {

      return self::get_array('products');

    }

    public function get_all_categories () {

      return self::get_array('category');

    }



  }



?>
