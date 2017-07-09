var next_value;
var timer_update;
var under_edit = new Array();
var under_edit_info = new Array();

$(document).ready(function(){

	var init = number_of_products(); // Initializam numarul de produse


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
	});


	$("#productSubmit").click(function(){

		var product_name;
		var product_quantity;
		var product_quantity_attr;
		var ok = 1;
		var iterator = 0;

		product_name = $("input#productName").val();
		product_quantity = $("input#productQuantity").val();
		product_quantity_attr = $("select#productQuantityAttr option:selected").text();

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
		for(iterator = 0; iterator < under_edit.length; iterator += 4){ //Verific daca produsul pe care vreau sa il introduc exista si este supus editarii

			if(under_edit[iterator] === product_name){
				console.log("aici");
				status_add(1)
				ok = 0;
				return;

			}

		}
		if(!ok)
			return;
		if(!$.isNumeric(product_quantity)){ //Verific daca in campul Cantitate sunt trecute doar numere
			status_add(2);
			return;
		}
		if($("#input#product").val() === ""){ //Verific daca campul Cantitate este gol
			status_add(3);
			return;
		}




		add_product(product_name, product_quantity, product_quantity_attr); // Adaug produsul


	});

	$(document).on('click', 'span[id^="delete_"]', function(){

		var id = $(this).attr('id');

		id = id.replace("delete_", "");
		id = parseInt(id);

		delete_product(id);

		number_of_products();


	});

	$(document).on('click', 'span[id^="edit_"]', function(){


		var product_name;
		var product_quantity;
		var product_quantity_attr;
		var id = $(this).attr('id');
		var select_atr = "<select class=\"form-control\" id=\"editQuantityAtr_"+id+"\"><option>Bucăți</option><option>Kilograme</option><option>Grame</option><option>Bax-uri</option></select>";

		id = id.replace("edit_", "");
		id = parseInt(id);




		product_name = $("ul#productList li[id='"+id+"'] span:first-of-type").html();
		product_quantity = $("ul#productList li[id='"+id+"'] span:nth-of-type(2)").html();
		product_quantity_attr = $("ul#productList li[id='"+id+"'] span:nth-of-type(3)").html();

		under_edit.push(product_name); //Semnalez elementul curent ca fiind supus unei editari.
		under_edit.push(product_quantity); //Salvez informatiile in caz ca nu se doreste anularea editarii.
		under_edit.push(product_quantity_attr); //Salvez informatiile in caz ca se doreste anularea editarii.
		under_edit.push(id); //Salvez informatiile in caz ca se doreste anularea editarii.



		$("ul#productList li[id='"+id+"']").empty();
		$("ul#productList li[id='"+id+"']").append("Name: <input class=\"form-control\" type=\"text\" id=\"editName_"+product_name+"\" value="+product_name+"> <br\> Quantity: <input class=\"form-control\" type=\"text\" id=\"editQuantity_"+product_quantity+"\" value=\""+product_quantity+"\"> "+select_atr+" <div class=\"row\"><span class=\"glyphicon glyphicon-ok\" id=\"editAccept_"+id+"\">Save</span><span id=\"editDeny_"+id+"\" class=\"glyphicon glyphicon-remove\">Cancel</span></div>");





	});

	$(document).on('click', 'span[id^="editAccept_"]', function(){

		var ok = 1;
		var index;
		var product_name;
		var product_quantity;
		var product_quantity_attr;
		var id = $(this).attr('id');
		id = id.replace("editAccept_", "");
		id = parseInt(id);

		product_name = $("ul#productList li[id='"+id+"'] input:first-of-type").val();
		product_quantity = $("ul#productList li[id='"+id+"'] input:nth-of-type(2)").val();
		product_quantity_attr = $("ul#productList li[id='"+id+"'] select:first-of-type option:selected").text();

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

		if(!ok)
			return;

		if(!$.isNumeric(product_quantity)){ //Verific daca in campul Quantity sunt trecute doar numere
			status_add(2);
			return;
		}

		index = under_edit.indexOf(id);
		console.log(index);

		$("ul#productList li[id='"+id+"']").empty();
		$("ul#productList li[id='"+id+"']").append(" Name: <span id=\"product_"+product_name+"\">"+product_name+"</span> <br\> Quantity: <span>"+product_quantity+"</span> <span>"+product_quantity_attr+"</span> <div class=\"row\"><span class=\"glyphicon glyphicon-edit\" id=\"edit_"+id+"\">Edit</span><span id=\"delete_"+id+"\" class=\"glyphicon glyphicon-trash\">Delete</span></div>");

		under_edit.splice(index - 3, 4);

		status_add(6);

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

		product_name = under_edit[under_edit.indexOf(id) - 3];
		product_quantity = under_edit[under_edit.indexOf(id) - 2];
		product_quantity_attr = under_edit[under_edit.indexOf(id) - 1];

		index = under_edit.indexOf(product_name);

		$("ul#productList li[id='"+id+"']").empty();
		$("ul#productList li[id='"+id+"']").append(" Name: <span id=\"product_"+product_name+"\">"+product_name+"</span> <br\> Quantity: <span>"+product_quantity+"</span> <span>"+product_quantity_attr+"</span> <div class=\"row\"><span class=\"glyphicon glyphicon-edit\" id=\"edit_"+id+"\">Edit</span><span id=\"delete_"+id+"\" class=\"glyphicon glyphicon-trash\">Delete</span></div>");

		under_edit.splice(index, 4);

		status_add(7);


	});





});

function delete_product(id){

	$("ul#productList li[id='"+id+"']").remove();
	status_add(5);

}

function add_product(name, quantity, quantity_attr){



	next_value = $("ul#productList li").last().attr('id'); // Aflu urmatoarul id al produsului

	if(!$.isNumeric(next_value)) //Verific daca este primul produs plasat
		next_value = 1;
	else
		next_value++;

	console.log(next_value + " ");

	//Adaug produsul in lista, id item = next_value, id denumire = product_+name+
	$("ul#productList").append("<li class=\"list-group-item col-sm-6\" id=\""+next_value+"\"> Name: <span id=\"product_"+name+"\">"+name+"</span> <br\> Quantity: <span>"+quantity+"</span> <span>"+quantity_attr+"</span> <div class=\"row\"><span class=\"glyphicon glyphicon-edit\" id=\"edit_"+next_value+"\">Edit</span><span id=\"delete_"+next_value+"\" class=\"glyphicon glyphicon-trash\">Delete</span></div></li>");


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
