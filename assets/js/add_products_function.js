var next_value;
var timer_update;
var under_edit = new Array();
var under_edit_info = new Array();
var ajax_error;
var ajax_error_image;

$(document).ready(function(){


	$.ajax({
  method: "POST",
  url: "/add_products/populate",
  data: { initialize: "1"}
	})
  .done(function( msg ) {
		var jsonData = JSON.parse(msg);
		for (var i = 0; i < jsonData.length; i++) {
	    var id = jsonData[i].id;
			var name = jsonData[i].name;
			var quantity = jsonData[i].quantity;
			var quantity_type = jsonData[i].quantity_type;
			var image = jsonData[i].image;
			add_product(id, name, quantity, quantity_type, image, 1);
		}
  });


	var init = number_of_products(); // Initializam numarul de produse

  /*
	var aChildren = $("#navbar li").children();
	var aArray = [];
	for (var i=0; i < aChildren.length; i++) {
		var aChild = aChildren[i];
		var ahref = $(aChild).attr('href');
		aArray.push(ahref);
	}


	$(window).scroll(function(){
		var windowPos = $(window).scrollTop(); //Pozitia actuala
		var windowHeight = $(window).height(); //Inaltime tab
		var docHeight = $(document).height(); //Inaltime document

		for (var i=0; i < aArray.length; i++) {
			var theID = aArray[i];
			var divPos = $(theID).offset().top;  //Pozitie TAG html
			var divHeight = $(theID).height();  //Inaltime TAG html
			if (windowPos >= divPos - 20 && windowPos < (divPos + divHeight)) {
				$("a[href='" + theID + "']").parent('li').addClass("active");
			} else {
				$("a[href='" + theID + "']").parent('li').removeClass("active");
			}
		}
	}); */


	$("#productSubmit").click(function(){

		var product_name;
		var product_quantity;
		var product_quantity_attr;
		var product_image;
		var product_image_form = new FormData();
		var product_image_name;
		var product_image_input;
		var ok = 1;
		var iterator = 0;

		product_name = $("input#productName").val();
		product_quantity = $("input#productQuantity").val();
		product_quantity_attr = $("select#productQuantityAttr option:selected").text();
		product_image = $("#productImage").prop('files')[0];
		product_image_form.append('file', product_image);
		product_image_name = $("#productImage").prop('files')[0].name;
		product_image_input = $("#productImage").val();

		if (product_image_input != "") {
			image_edited = 1;
			product_image_name = $("#productImage").prop('files')[0].name;
			prodict_image_name = product_image_name.replace(/\s/g, '_');
			if (product_image_name.length < 3 || typeof product_image === "undefined") {
				status_add(11);
				return;
			}
		}


		if(product_image.length < 3 || typeof product_image === "undefined") {
			status_add(11);
			return;
		}

		if(product_name.length < 3){
			status_add(0);
			return;
		}

		$("ul#productList li span:first-of-type").each(function(){ // Verific daca produsul cu numele dorit mai exista

			if($(this).attr('id') === "product_"+product_name){ //Daca da ies din functie

				status_add(1);
				ok = 0;
				return;
			}

		});
		for(iterator = 0; iterator < under_edit.length; iterator += 5){ //Verific daca produsul pe care vreau sa il introduc exista si este supus editarii

			if (under_edit[iterator] === product_name) {
				status_add(1)
				ok = 0;
				return;

			}

		}
		if(!ok)
			return;
		if (!$.isNumeric(product_quantity)){ //Verific daca in campul Cantitate sunt trecute doar numere
			status_add(2);
			return;
		}
		if ($("#input#product").val() === ""){ //Verific daca campul Cantitate este gol
			status_add(3);
			return;
		}


		//Send FORM through ajax
		ajax_error = $.ajax({
			method: "POST",
			url: "/add_products/add",
			data: { name: product_name, quantity: product_quantity, type: product_quantity_attr},
			global: false,
			async: false,
			success: function (data) {
				return data;
				}
			}).responseText;

			if (ajax_error != 0) {
				var id_image = ajax_error;
				var upload_dir = product_quantity_attr.replace(" ", "_");
				//Send image through ajax
				ajax_error_image = $.ajax({
	                url: '/add_products/add_image/' + ajax_error + '/' + upload_dir + '/' + product_name + '/', // point to server-side PHP script
	                dataType: 'text',
	                cache: false,
	                contentType: false,
	                processData: false,
	                data: product_image_form,
	                type: 'post',
	                success: function(php_script_response){
	                    return php_script_response;
	                }
	     	}).responseText;

				if(ajax_error_image == 0){
					status_add(10);
					return;
				}

			}


			status_add(12);
			setTimeout(function() {

				if (parseInt(ajax_error) != 0)
					add_product(ajax_error, product_name, product_quantity, product_quantity_attr, product_image_name); // Adaug produsul
				else
		      status_add(1);

			}, 3000);


	});

	$(document).on('click', 'span[id^="delete_"]', function(){


		var product_name;
		var id = $(this).attr('id');

		id = id.replace("delete_", "");
		id = parseInt(id);

		product_name = $("ul#productList li[id='"+id+"'] span:first-of-type").html();



		ajax_error = $.ajax({
			method: "POST",
			url: "/add_products/delete",
			data: { delete: product_name },
			global: false,
			async: false,
			success: function (data) {
				return data;
				}
		}).responseText;

		if (ajax_error !== 0)
			delete_product(id);
		else
			status_add(8);

		number_of_products();


	});

	$(document).on('click', 'span[id^="edit_"]', function(){


		var product_name;
		var product_quantity;
		var product_quantity_attr;
		var product_image;
		var id = $(this).attr('id');
		var select_atr = "<select class=\"form-control\" id=\"editQuantityAtr_"+id+"\">";


		id = id.replace("edit_", "");
		id = parseInt(id);


		var select_image = "<label class=\"btn btn-primary\" style=\"margin-top: 5px;\" for=\"productImageEdit"+id+"\"> <input id=\"productImageEdit"+id+"\" name=\"productImageEdit"+id+"\" type=\"file\" style=\"display:none\" onchange=\"$('#upload-file-infoEdit"+id+"').html(this.files[0].name)\"> Upload </label>";
		select_image += "<span class='label label-info' id=\"upload-file-infoEdit"+id+"\"></span>"

		product_name = $("ul#productList li[id='"+id+"'] span:first-of-type").html();
		product_quantity = $("ul#productList li[id='"+id+"'] span:nth-of-type(2)").html();
		product_quantity_attr = $("ul#productList li[id='"+id+"'] span:nth-of-type(3)").html();
		product_image = $("ul#productList li[id='"+id+"'] img").attr('src');

		$("#productQuantityAttr option").each(function(){

			if ($(this).val() === product_quantity_attr)
				select_atr += "<option selected=\"selected\">" + $(this).val() + "</option>";
			else
				select_atr += "<option>" + $(this).val() + "</option>";

		});

		select_atr += "</select>";



		under_edit.push(product_name); //Semnalez elementul curent ca fiind supus unei editari.
		under_edit.push(product_image); //Semnalez imaginea curenta ca fiind supusa unei editari.
		under_edit.push(product_quantity); //Salvez informatiile in caz ca se doreste anularea editarii.
		under_edit.push(product_quantity_attr); //Salvez informatiile in caz ca se doreste anularea editarii.
		under_edit.push(id); //Salvez informatiile in caz ca se doreste anularea editarii.





		$("ul#productList li[id='"+id+"']").empty();
		$("ul#productList li[id='"+id+"']").append("Warning: Uploading new image will overwrite current one, leave it blank if you want the image to be the same " + select_image + "<br\>");
		$("ul#productList li[id='"+id+"']").append("Name: <input class=\"form-control\" type=\"text\" id=\"editName_"+ id +"\" value=\""+product_name+"\"> <br\> Quantity: <input class=\"form-control\" type=\"text\" id=\"editQuantity_"+ id +"\" value=\""+product_quantity+"\"> "+select_atr+" <div class=\"row\"><span class=\"glyphicon glyphicon-ok\" id=\"editAccept_"+id+"\">Save</span><span id=\"editDeny_"+id+"\" class=\"glyphicon glyphicon-remove\">Cancel</span></div>");





	});

	$(document).on('click', 'span[id^="editAccept_"]', function(){

		var ok = 1;
		var index;
		var product_name;
		var product_quantity;
		var product_quantity_attr;
		var product_image;
		var product_image_form = new FormData();
		var product_image_input;
		var product_image_name;
		var image;
		var image_edited = 0;
		var id = $(this).attr('id');
		id = id.replace("editAccept_", "");
		id = parseInt(id);

		product_name = $("ul#productList li[id='"+id+"'] input[type='text']:first-of-type").val();
		product_quantity = $("ul#productList li[id='"+id+"'] input:nth-of-type(2)").val();
		product_quantity_attr = $("ul#productList li[id='"+id+"'] select:first-of-type option:selected").text();
		product_image = $("#productImageEdit" + id).prop('files')[0];
		product_image_form.append('file', product_image);
		product_image_input = $("#productImageEdit" + id).val();

		if (product_image_input != "") {
			image_edited = 1;
			product_image_name = $("#productImageEdit" + id).prop('files')[0].name;
			prodict_image_name = product_image_name.replace(/\s/g, '_');
			if (product_image_name.length < 3 || typeof product_image === "undefined") {
				status_add(11);
				return;
			}
		}


		if (product_name.length < 3){
			status_add(0);
			return;
		}


		$("ul#productList li span:first-of-type").each(function(){ // Verific daca produsul cu numele dorit mai exista

			if($(this).attr('id') === "product_"+product_name){ //Daca da ies din functie

				status_add(1);
				ok = 0;
				return;
			}

		});

		if(!ok)
			return;

		if(!$.isNumeric(product_quantity)){ //Verific daca in campul Quantity sunt trecute doar numere
			status_add(2);
			return;
		}

		index = under_edit.indexOf(id);

		ajax_error = $.ajax({
			method: "POST",
			url: "/add_products/edit",
			data: { edit_name: product_name, edit_quantity: product_quantity, edit_type: product_quantity_attr, unmodified_name: under_edit[index - 4], edit_image: image_edited},
			global: false,
			async: false,
			success: function (data) {
				return data;
				}
		}).responseText;


		if (ajax_error != 0 && product_image_input != "") {
			var id_image = ajax_error;
			var upload_dir = product_quantity_attr.replace(" ", "_");
			var delete_dir = under_edit[index - 1].replace(" ", "_")
			//Send image through ajax
			ajax_error_image = $.ajax({
								url: '/add_products/edit_image/' + ajax_error + '/' + upload_dir + '/' + product_name + '/' + delete_dir + '/' + under_edit[index - 4] + '/', // point to server-side PHP script
								dataType: 'text',
								cache: false,
								contentType: false,
								processData: false,
								data: product_image_form,
								type: 'post',
								success: function(php_script_response){
										return php_script_response;
								}
			}).responseText;

			if(ajax_error_image == 0){
				status_add(10);
				return;
			}

		}

		if(product_image_input != "")
			image = "/images/uploads/" + product_quantity_attr.replace(" ", "_") + "/" + product_quantity_attr.replace(" ", "_") + "_" + ajax_error + "_" + product_image_name;
		else
			image = under_edit[index - 3];

		if (ajax_error !== 0) {

			status_add(12);
			setTimeout(function() {

				$("ul#productList li[id='"+id+"']").empty();
				$("ul#productList li[id='"+id+"']").append("Image: <img data-img=\""+ image +"\" style=\"width: 80px;\" src=\""+ image +"\"> <br> Name: <span id=\"product_"+product_name+"\">"+product_name+"</span> <br\> Quantity: <span>"+product_quantity+"</span> <span>"+product_quantity_attr+"</span> <div class=\"row\"><span class=\"glyphicon glyphicon-edit\" id=\"edit_"+id+"\">Edit</span><span id=\"delete_"+id+"\" class=\"glyphicon glyphicon-trash\">Delete</span></div>");

				under_edit.splice(index - 4, 5);

				status_add(6);

			}, 3000);

		} else {
			status_add(9);
		}

	});

	$(document).on('click', 'span[id^="editDeny_"]', function(){

		var ok = 1;
		var index;
		var product_name;
		var product_quantity;
		var product_quantity_attr;
		var id = $(this).attr('id');
		id = id.replace("editDeny_", "");
		id = parseInt(id);


		product_name = under_edit[under_edit.indexOf(id) - 4];
		product_image = under_edit[under_edit.indexOf(id) - 3];
		product_quantity = under_edit[under_edit.indexOf(id) - 2];
		product_quantity_attr = under_edit[under_edit.indexOf(id) - 1];

		index = under_edit.indexOf(product_name);

		$("ul#productList li[id='"+id+"']").empty();
		$("ul#productList li[id='"+id+"']").append("Image: <img data-img=\""+ product_image +"\" style=\"width: 80px;\" src=\""+product_image+"\"> <br> Name: <span id=\"product_"+product_name+"\">"+product_name+"</span> <br\> Quantity: <span>"+product_quantity+"</span> <span>"+product_quantity_attr+"</span> <div class=\"row\"><span class=\"glyphicon glyphicon-edit\" id=\"edit_"+id+"\">Edit</span><span id=\"delete_"+id+"\" class=\"glyphicon glyphicon-trash\">Delete</span></div>");

		under_edit.splice(index, 5);

		status_add(7);


	});





});

function delete_product(id){

	$("ul#productList li[id='"+id+"']").remove();
	status_add(5);

}

function add_product(id, name, quantity, quantity_attr, image, start){

	image = image.replace(/\s/g, '_');

	if(typeof start !== "undefined")
		image_path = "/images/uploads/" + quantity_attr.replace(" ", "_") +"/" + image;
	else
		image_path = "/images/uploads/" + quantity_attr.replace(" ", "_") + "/" + quantity_attr.replace(" ", "_") + "_" + id + "_" + image;

	next_value = $("ul#productList li").last().attr('id'); // Aflu urmatoarul id al produsului

	if(!$.isNumeric(next_value)) //Verific daca este primul produs plasat
		next_value = 1;
	else
		next_value++;

	console.log(next_value + " ");

	//Adaug produsul in lista, id item = next_value, id denumire = product_+name+
	$("ul#productList").append("<li class=\"list-group-item col-sm-6\" id=\""+next_value+"\">Image: <img data-img=\""+ image +"\" style=\"width: 80px;\" src=\""+image_path+"\"> <br> Name: <span id=\"product_"+name+"\">"+name+"</span> <br\> Quantity: <span>"+quantity+"</span> <span>"+quantity_attr+"</span> <div class=\"row\"><span class=\"glyphicon glyphicon-edit\" id=\"edit_"+next_value+"\">Edit</span><span id=\"delete_"+next_value+"\" class=\"glyphicon glyphicon-trash\">Delete</span></div></li>");

	if(typeof start === 'undefined')
		status_add(4);
	status_text(next_value);

}

function status_add(status_number){

	var text = "";
	var label = "";

	switch(status_number) {
		case 0:
			text = "Name of the product must exceed 3 letters.";
			label = "danger";
			break;
		case 1:
			text = "Product already exists.";
			label = "danger";
			break;
		case 2:
			text = "Quantity must be a integer.";
			label = "danger";
			break;
		case 3:
			text = "Quantity must be completed.";
			label = "danger";
			break;
		case 4:
			text = "Product added successfully.";
			label = "success";
			break;
		case 5:
			text = "Product deleted successfully.";
			label = "success";
			break;
		case 6:
			text = "Product edited successfully.";
			label = "success";
			break;
		case 7:
			text = "You've canceled product editing.";
			label = "danger";
			break;
		case 8:
			text = "Wanted product couldn't be deleted. It may have been already deleted or given product name does not exist.";
			label = "danger";
			break;
		case 9:
			text = "Product could not be edited. It may have been already edited or given product name does not exist.";
			label = "danger";
			break;
		case 10:
			text = "Image could not be uploaded. Please try again or contact the administrator if the problem presist.";
			label = "danger";
			break;
		case 11:
			text = "No image uploaded or image name is too short.";
			label = "danger";
			break;
		case 12:
			text = "Proccesing your request.";
			label = "warning";
			break;
		default:
			text = "An error was occured, please try again later. If this problem persist contact the administrator.";
			label = "warning";
	}
	$("#statusDiv").removeClass();
	$("#statusDiv").addClass("alert alert-"+label+" alert-dismissable fade in");

	$("#statusInfo").removeClass();
	$("#statusInfo").html(text);

	clearTimeout(timer_update);

	$(".fixed").slideDown("slow", function(){

		timer_update = setTimeout(function(){
		$('.fixed').fadeOut();}, 4000);



	});


}

function status_text(products){

	var text = "";

	if(products == 0){

		text = "No products have been added yet.";

	} else if (products == 1) {

		text = "Only 1 product added yet.";

	} else {

		text = "There are " + products + " added products."

	}

	$("#status").html(text);

}

function number_of_products(){

	var counter = 0;

	$("ul#productList li").each(function(){
		counter++;
	});
	status_text(counter);
	return counter;
}
