<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MVC Framework">
    <meta name="author" content="Marica Adrian">
    <?php if(isset($data)) if (array_key_exists('title', $data)) { echo "<title>". $data['title'] ."</title>";  } else { ?><title>MVC</title> <?php } ?>
    <link href="/assets/css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
  <div class="wrapper row1">
      <header id="header" class="clear">
          <div id="hgroup">
              <h1><a href="#">Roweb</a></h1>
              <h2>Internship</h2>
          </div>
          <nav class="custom-menu">
              <ul>
                  <li><a class="target" href="<?php echo BASE_URL . "home" ?>">Home</a></li>
                  <?php if (!isset($_SESSION['user_id'])) { ?>
                          <li><a class="target" href="<?php echo BASE_URL . "login" ?>">Login</a></li>
                  <?php } ?>
                  <li><a class="target" href="<?php echo BASE_URL . "products"?>">Products</a></li>
                  <?php if (isset($_SESSION['user_id'])) { ?>
                          <li><a class="target" href="<?php echo BASE_URL . "add_products" ?>">Add products</a></li>
                          <li class="last"><a class="target" href="<?php echo BASE_URL . "logout" ?>">Logout</a></li>
                  <?php } ?>
              </ul>
          </nav>

      </header>
  </div>
