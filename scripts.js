$(document).ready(function(){
	$('#submit').click(subscribe);
	$('#close').click(resetForm);
	
	$('.mlist').click(
		function(event){
			if($(event.target).hasClass('icon-ok')){
				$(event.target).parent().parent().toggleClass('btn-success');
				$(event.target).parent().toggle();
			}
			else if($(event.target).hasClass('listname')){
				$(event.target).parent().toggleClass('btn-success');
				$(event.target).parent().children('.icons').toggle();
			}
			else{
				$(event.target).toggleClass('btn-success');
				$(this).children('.icons').toggle();
			}
		}
	);
});

function resetForm(){
	$('#email').val('');
	$('#fullname').val('');
	selectedLists = $('.mlist.active');
	selectedLists.each(function(){
		$(this).removeClass('btn-success');
		$(this).removeClass('active');
		
		$(this).children('.icons').toggle();
	});
}


function subscribe () {

	var email = $('#email').val();
	var fullname = $('#fullname').val();		
			
	var paramsArray = { 
		"email" : email,
		"fullname":fullname
	};
	
	$.ajax({
		type: "POST",
		url: "backup.php",
		data: "params="+JSON.stringify(paramsArray),
		dataType: 'json',
		success: function(data){
			//win with great success
		},
		//fail silently.
		error: function(data){
			//alert("/cry");
		}
	});

			
	var lists = [];
	selectedLists = $('.mlist.active');
	if (selectedLists.length < 1) { 
		alert("Sign up for at leaset one list!");
	} 
	else 
	{
		selectedLists.each(function(){lists.push($(this).children('.listname').html());});
	}
	for (var i in lists) {
		listName = lists[i].toLowerCase();
		console.log(listName);
		var url = "https://lists.hcs.harvard.edu/mailman/subscribe/hcs-"+listName;
		var data = "email="+email+"&fullname="+fullname;
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: 'json',
			success: function(data){
				// alert("nomnom");
				// alert(data);
			},
			//this fails by default
			error: function(data){
				//alert("/cry");
			}
		});
	}
	
	$('#myModal').modal('toggle');
	resetForm();
};