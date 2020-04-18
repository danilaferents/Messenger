
$(document).ready(function() {
    $("#log").click(
		function(e){
			if (login_form.checkValidity())
			{
			sendAjaxForm('error', 'login_form', 'php/login.php');
			return false; 
			}
		}
	);
    $("#reg").click(
		function(e)
                {
		    if (reg_form.checkValidity())
		    {
			if (document.forms["reg_form"].elements["password"].value == document.forms["reg_form"].elements["rep_password"].value){

				sendAjaxForm('error', 'reg_form', 'php/registration.php');
				return false;
			}
			else {
                              $('#error').html('entered passwords do not match'); 
				return false;         
                        }
		    }
		}
	);
  $("#createchanel").click(
			function(e){
				if (new_chanel_from.checkValidity())
		    		{
					CreateChanel();
				}
				return false;
			}
	);
  $("#safe_user_data_changes").click(
			function(e){
				if (user_data_changes_form.checkValidity())
		    		{
					ChangeUserData();
				}
				return false;
			}
	);
});
 
function sendAjaxForm(error_form, ajax_form, url) {
    $.ajax({
        url:      url,
        type:     "POST", 
        dataType: "html", 
        data: $("#"+ajax_form).serialize(), 
        success: function(response) { 
        	result = $.parseJSON(response);
		if (result.status == "OK")
		{
			//window.alert(result.url);
			user = result.id;
			LoadUserData(user);
			LoadChanels();
			StartRenovating();
			setTimeout(RenovateUsersData, 60 * 1000, true);
		}
        	else
		{
			$('#error_form').html(result.msg);
		}
    	},
    	error: function(response) { 
            $('#error_form').html('Ошибка. Данные не отправлены.');
    	}
 	});
}

function sendAjaxForm_with_id(error_form, ajax_form, url) {
    $.ajax({
        url:      url,
        type:     "POST", 
        dataType: "html", 
        data: $("#"+ajax_form).serialize() + "&id=" + user, 
        success: function(response) { 
        	result = $.parseJSON(response);
		if (result.status == "OK")
		{
			//window.alert(result.url);

		}
        	else
		{
			$('#error_form').html(result.msg);
		}
    	},
    	error: function(response) { 
            $('#error_form').html('Ошибка. Данные не отправлены.');
    	}
 	});
}



