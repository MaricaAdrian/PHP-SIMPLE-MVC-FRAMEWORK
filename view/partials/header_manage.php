<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta Tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="MVC Framework">
<meta name="author" content="Marica Adrian">
<?php if(isset($data)) if (array_key_exists('title', $data)) { echo "<title>". $data['title'] ."</title>";  } else { ?><title>MVC</title> <?php } ?>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/add_products_style.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>


</head>

<body>
  <nav class="navbar navbar-default navbar-fixed-top">
  		<div class="container">
  			<div class="navbar-header">
  			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
  				<span class="sr-only">Meniu</span>
  				<span class="icon-bar"></span>
  				<span class="icon-bar"></span>
  				<span class="icon-bar"></span>
  			  </button>
  			  <a class="navbar-brand" href="#">Product management</a>
  			</div>
  			<div id="navbar" class="navbar-collapse collapse">
  			  <ul class="nav navbar-nav">
  				<li class="active"><a href="#top">Top</a></li>
          <li><a href="<?php echo BASE_URL . "home" ?>">Home</a></li>
          <?php if (!isset($_SESSION['user_id'])) { ?>
                  <li><a href="<?php echo BASE_URL . "login" ?>">Login</a></li>
          <?php } ?>
          <li><a href="<?php echo BASE_URL . "products"?>">Products</a></li>
          <?php if (isset($_SESSION['user_id'])) { ?>
                  <li><a href="<?php echo BASE_URL . "add_products" ?>">Add products</a></li>
                  <li><a href="<?php echo BASE_URL . "add_category" ?>">Add category</a></li>
                  <li class="last"><a href="<?php echo BASE_URL . "logout" ?>">Logout</a></li>
          <?php } ?>
  			  </ul>
  			  <ul id="navbarUL" class="nav navbar-nav navbar-right">
  				<li><a href="#productClass">View products</a></li>
  				<li><a href="#productAdd">Add products</a></li>
  			  </ul>
  			</div>
  		</div>
  	</nav>
  	<div class="fixed">

  		<div class="container-fluid">
  			<div class="row">

  				<div class="col-md-6 col-md-offset-3 text-center">
  					<div class="alert fade in" id="statusDiv">
  						<span id="statusInfo"></span>
  					</div>
  				</div>
  		  </div>
  		</div>

  	</div>
