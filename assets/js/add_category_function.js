var next_value;
var timer_update;
var under_edit = new Array();
var under_edit_info = new Array();
var ajax_error;

$(document).ready(function(){


	$.ajax({
  method: "POST",
  url: "/add_category/populate",
  data: { initialize: "1"}
	})
  .done(function( msg ) {
		var jsonData = JSON.parse(msg);
		for (var i = 0; i < jsonData.length; i++) {
	    var id = jsonData[i].id;
			var name = jsonData[i].name;
			add_category(name, 1);
		}
  });


	var init = number_of_categories(); // Initializam numarul de categorii


	$("#category_submit").click(function(){

		var category_name;
		var ok = 1;
		var iterator = 0;

		category_name = $("input#category_name").val();

		if(category_name.length < 3){
			status_add(0);
			return;
		}

		$("ul#category_list li span:first-of-type").each(function(){ // Verific daca categoria cu numele dorit mai exista

			if($(this).attr('id') === "category_"+category_name){ //Daca da ies din functie

				status_add(1);
				ok = 0;
				return;
			}

		});
		for(iterator = 0; iterator < under_edit.length; iterator += 2){ //Verific daca categoria pe care vreau sa o introduc exista si este supusa editarii

			if (under_edit[iterator] === category_name) {
				status_add(1)
				ok = 0;
				return;

			}

		}
		if(!ok)
			return;


		ajax_error = $.ajax({
			method: "POST",
			url: "/add_category/add",
			data: { name: category_name},
			global: false,
			async: false,
			success: function (data) {
				return data;
				}
			}).responseText;

		if (parseInt(ajax_error) != 0)
			add_category(category_name); // Adaug categoria
		else
      status_add(1);
	});

	$(document).on('click', 'span[id^="delete_"]', function(){


		var category_name;
		var id = $(this).attr('id');

		id = id.replace("delete_", "");
		id = parseInt(id);

		category_name = $("ul#category_list li[id='"+id+"'] span:first-of-type").html();



		ajax_error = $.ajax({
			method: "POST",
			url: "/add_category/delete",
			data: { delete: category_name },
			global: false,
			async: false,
			success: function (data) {
				return data;
				}
		}).responseText;

		if (ajax_error !== 0)
			delete_product(id);
		else
			status_add(6);

		number_of_categories();


	});

	$(document).on('click', 'span[id^="edit_"]', function(){


		var category_name;
		var id = $(this).attr('id');

		id = id.replace("edit_", "");
		id = parseInt(id);




		category_name = $("ul#category_list li[id='"+id+"'] span:first-of-type").html();

		under_edit.push(category_name); //Semnalez elementul curent ca fiind supus unei editari.
		under_edit.push(id); //Salvez informatiile in caz ca se doreste anularea editarii.



		$("ul#category_list li[id='"+id+"']").empty();
		$("ul#category_list li[id='"+id+"']").append("Name: <input class=\"form-control\" type=\"text\" id=\"editName_"+category_name+"\" value=\""+category_name+"\"> <br\> <div class=\"row\"><span class=\"glyphicon glyphicon-ok\" id=\"editAccept_"+id+"\">Save</span><span id=\"editDeny_"+id+"\" class=\"glyphicon glyphicon-remove\">Cancel</span></div>");





	});

	$(document).on('click', 'span[id^="editAccept_"]', function(){

		var ok = 1;
		var index;
		var category_name;
		var id = $(this).attr('id');
		id = id.replace("editAccept_", "");
		id = parseInt(id);

		category_name = $("ul#category_list li[id='"+id+"'] input:first-of-type").val();

		if(category_name.length < 3){
			status_add(0);
			return;
		}


		$("ul#category_list li span:first-of-type").each(function(){ // Verific daca produsul cu numele dorit mai exista

			if($(this).attr('id') === "category_"+category_name){ //Daca da ies din functie

				status_add(1);
				ok = 0;
				return;
			}

		});

		if(!ok)
			return;

		index = under_edit.indexOf(id);

		ajax_error = $.ajax({
			method: "POST",
			url: "/add_category/edit",
			data: { edit_name: category_name, unmodified_name: under_edit[index - 1] },
			global: false,
			async: false,
			success: function (data) {
				return data;
				}
		}).responseText;


		if (ajax_error !== 0) {

			$("ul#category_list li[id='"+id+"']").empty();
			$("ul#category_list li[id='"+id+"']").append(" Name: <span id=\"category_"+category_name+"\">"+category_name+"</span> <br\> <div class=\"row\"><span class=\"glyphicon glyphicon-edit\" id=\"edit_"+id+"\">Edit</span><span id=\"delete_"+id+"\" class=\"glyphicon glyphicon-trash\">Delete</span></div>");

			under_edit.splice(index - 1, 2);

			status_add(4);

		} else {
			status_add(7);
		}

	});

	$(document).on('click', 'span[id^="editDeny_"]', function(){

		var ok = 1;
		var index;
		var category_name;
		var id = $(this).attr('id');
		id = id.replace("editDeny_", "");
		id = parseInt(id);

		category_name = under_edit[under_edit.indexOf(id) - 1];

		index = under_edit.indexOf(category_name);

		$("ul#category_list li[id='"+id+"']").empty();
		$("ul#category_list li[id='"+id+"']").append(" Name: <span id=\"category_"+category_name+"\">"+category_name+"</span> <br\> <div class=\"row\"><span class=\"glyphicon glyphicon-edit\" id=\"edit_"+id+"\">Edit</span><span id=\"delete_"+id+"\" class=\"glyphicon glyphicon-trash\">Delete</span></div>");

		under_edit.splice(index, 2);

		status_add(5);


	});





});

function delete_product(id){

	$("ul#category_list li[id='"+id+"']").remove();
	status_add(3);

}

function add_category(name, start){


	next_value = $("ul#category_list li").last().attr('id'); // Aflu urmatoarul id al categoriei

	if(!$.isNumeric(next_value)) //Verific exista prima categorie plasata
		next_value = 1;
	else
		next_value++;

	//Adaug categoria in lista
	$("ul#category_list").append("<li class=\"list-group-item col-sm-6\" id=\""+next_value+"\"> Name: <span id=\"category_"+name+"\">"+name+"</span> <br\><div class=\"row\"><span class=\"glyphicon glyphicon-edit\" id=\"edit_"+next_value+"\">Edit</span><span id=\"delete_"+next_value+"\" class=\"glyphicon glyphicon-trash\">Delete</span></div></li>");

	if(typeof start === 'undefined')
		status_add(2);
	status_text(next_value);

}

function status_add(status_number){

	var text = "";
	var label = "";

	switch(status_number) {
		case 0:
			text = "Name of the category must exceed 3 letters.";
			label = "danger";
			break;
		case 1:
			text = "Category already exists.";
			label = "danger";
			break;
		case 2:
			text = "Category added successfully.";
			label = "success";
			break;
		case 3:
			text = "Category deleted successfully.";
			label = "success";
			break;
		case 4:
			text = "Category edited successfully.";
			label = "success";
			break;
		case 5:
			text = "You've canceled category editing.";
			label = "danger";
			break;
		case 6:
			text = "Wanted category couldn't be deleted. It may have been already deleted or given category name does not exist";
			label = "danger";
			break;
		case 7:
			text = "Category could not be edited. It may have been already edited or given category name does not exist";
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

function status_text(categories){

	var text = "";

	if(categories == 0){

		text = "No categories have been added yet.";

	} else if (categories == 1) {

		text = "Only 1 category added yet.";

	} else {

		text = "There are " + categories + " added categories."

	}

	$("#status").html(text);

}

function number_of_categories(){

	var counter = 0;

	$("ul#category_list li").each(function(){
		counter++;
	});
	status_text(counter);
	return counter;
}
