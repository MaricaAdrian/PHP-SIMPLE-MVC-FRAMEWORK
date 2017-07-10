  <div class="container">



  		<div id="top" class="jumbotron text-center">
  			<h1>Product management</h1>
  		</div>

  		<div class="page">

  			<div id="productClass" class="panel panel-primary">
  				<div class="panel-heading text-center">
  					<h3 class="panel-title">View products</h3>
  				</div>
  				<div class="panel-body">
  				  <h2 class="text-center"> <p id="status"></p> </h2>
  					<div class="col-sm-12">
  						<ul class="list-group" id="productList">
  						</ul>
  					</div>
  				</div>
  			</div>

  			<div id="productAdd" class="panel panel-primary">
  				<div class="panel-heading text-center">
  					<h2 class="panel-title">Add products</h2>
  				</div>
  				<div class="panel-body">
  					<form class="form-horizontal">
  						<div class="form-group">
  							<label class="control-label col-sm-2" for="productName">Product name:</label>
  							<div class="col-sm-4">
  							<input type="text" class="form-control" id="productName">
  							</div>
  					    </div>
  					    <div class="form-group">
  							<label class="control-label col-sm-2" for="productQuantity">Quantity:</label>
  							<div class="col-sm-2">
  							<input type="text" class="form-control" id ="productQuantity">
  							</div>
  							<div class="col-sm-2">
  							<select class="form-control" id="productQuantityAttr">
  								<?php
                    for ($cnt = 0; $cnt < count($data) - 1; $cnt++) {
                      echo "<option>".$data[$cnt]['name']."</option>";
                    }
                  ?>
  							</select>
  							</div>
  					    </div>
  					  <div class="col-sm-offset-2 col-sm-10">
  						  <button type="button" class="btn btn-default btn-lg" id="productSubmit">
  							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
  						  </button>
  					  </div>
  					</form>
  				</div>
  				<div class="panel-footer text-center">
  					<h3><span class="glyphicon glyphicon-info"></span></h3>
  				</div>
  			</div>

  	  </div>

  </div>

<script src="/assets/js/add_products_function.js"></script>
