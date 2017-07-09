<?php
  //Explode given SERVER URI, E.G.: /home/index/param1/param2
  $route = explode('/', $_SERVER['REQUEST_URI']);

  // Get controller name
  if (isset($route[1]) && !empty($route[1])) {
    $controller_name = $route[1];
  }

  // Get action name
  if (isset($route[2]) && !empty($route[2])) {
    $action_name = $route[2];
  }


  $counter = 0;

  for($i = 3; $i < count($route); $i++) {
    if (isset($route[$i]) && !empty($route[$i])) {
      $params[$counter] = $route[$i];
      $counter++;
    }
  }


?>
