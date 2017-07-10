  <div class="container">



  		<div id="top" class="jumbotron text-center">
  			<h1>Category management</h1>
  		</div>

  		<div class="page">

  			<div id="productClass" class="panel panel-primary">
  				<div class="panel-heading text-center">
  					<h3 class="panel-title">View categories</h3>
  				</div>
  				<div class="panel-body">
  				  <h2 class="text-center"> <p id="status"></p> </h2>
  					<div class="col-sm-12">
  						<ul class="list-group" id="category_list">
  						</ul>
  					</div>
  				</div>
  			</div>

  			<div id="productAdd" class="panel panel-primary">
  				<div class="panel-heading text-center">
  					<h2 class="panel-title">Add category</h2>
  				</div>
  				<div class="panel-body">
  					<form class="form-horizontal">
  						<div class="form-group">
  							<label class="control-label col-sm-2" for="category_name">Category name:</label>
  							<div class="col-sm-4">
  							         <input type="text" class="form-control" id="category_name">
  							</div>
  					  </div>
  					  <div class="col-sm-offset-2 col-sm-10">
  						  <button type="button" class="btn btn-default btn-lg" id="category_submit">
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

<script src="/assets/js/add_category_function.js"></script>
