<?php
  //Config file
  require_once 'settings/config.php';

  //MVC SYSTEM
  require_once 'mvc/model.php';
  require_once 'mvc/view.php';
  require_once 'mvc/controller.php';

  //Web brain of our MVC
  require_once 'mvc/web.php';

  //Begin MVC

  Web::begin();

?>
