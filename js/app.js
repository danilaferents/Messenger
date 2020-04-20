$(document).ready(function() {
    $.ajax({
        url:      "php/isloged.php",
        type:     "GET", 
        dataType: "html", 
        success: function(response) { 
        	result = $.parseJSON(response);
		if (result.status == "OK")
		{
			user = result.id;
			LoadUserData(user);
			LoadChanels();
			StartRenovating();
			setTimeout(RenovateUsersData, 60 * 1000, true);
		}
        	else
		{
			$('#login-modal').bPopup({
				modalClose: false, opacity: 0.90
			});
		}
    	}
 	});
});


function Exit(){
   user = "";
   $('#my-modal').bPopup().close();
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
	   users_info = {};
	   all_messages = {};
	   chanels_list = [];
	   CleanMessages();
	   CleanChanels();
         $('#login-modal').bPopup({
				modalClose: false, opacity: 0.90
			});
    }
  };
  xhttp.open("GET", "php/exit.php?&id="+user, true);
  xhttp.send();
}


$(document).ready(function() {
	var my_modal = $('#my-modal');
	var new_chat_modal = $('#new-chat-modal');
	$('#chat_avatar').on('change',  function() {
		var reader = new FileReader();
		reader.onload = function (e) {
	    	$(".new-chat-img")[0].src = e.target.result;
		};
		reader.readAsDataURL(this.files[0]);
	});
	$('#avatar').on('change',  function() {
		var reader = new FileReader();
		reader.onload = function (e) {
	    	$(".my-img")[0].src = e.target.result;
		};
		reader.readAsDataURL(this.files[0]);
	});
	//$('#login-modal').bPopup();
	$('.form-change span').on('click', function() {
		$(this).parent().parent().prev().hide();
		$(this).parent().parent().hide();
		let form = $('#'+$(this).attr('data-form-id'));
		form.slideDown(300);
		form.next().slideDown(300);
		setTimeout(function() {
			console.log(form.find('input'));
			form.find('input')[0].focus();
			let h = $('#login-modal').height();
			$('#login-modal').css('top', ($(window).height() - h - 100) / 2 + 'px');
		}, 300);
	});
	$('.header-profile .profile-name').on('click', function() {
		my_modal.bPopup();
	});
	$('.my-name').keyup(function(event){
	    if(event.keyCode == 13) {
	    	my_modal.close();
			var s = $(this).text();
			$('.header-profile .profile-name').text(s);
			$(this).text(s);
		}
	});
	$('.new-chat-btn').on('click', function() {
		new_chat_modal.bPopup();
	});
	$('.new-chat-img, .new-chat-img-btn').on('click', function() {
		$('#chat_avatar').trigger('click');
	});
	$('.my-img, .my-img-btn').on('click', function() {
		$('#avatar').trigger('click');
	});
});
