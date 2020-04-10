function StartRegistration() {
  document.getElementById("login_form").style.display = "none";
  document.getElementById("reg_form").style.display = "block";
  document.getElementById("button_to_reg").style.display = "none";
  document.getElementById("button_to_log").style.display = "block";
  document.getElementById("error").innerHTML = "";
}

function StartLogin() {
  document.getElementById("login_form").style.display = "block";
  document.getElementById("reg_form").style.display = "none";
  document.getElementById("button_to_reg").style.display = "block";
  document.getElementById("button_to_log").style.display = "none";
  document.getElementById("error").innerHTML = "";
}

$(document).ready(function() {
    $("#log").click(
		function(e){
			if (login_form.checkValidity())
			{
			sendAjaxForm('result_form', 'login_form', 'php/login.php');
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

				sendAjaxForm('result_form', 'reg_form', 'php/registration.php');
				return false;
			}
			else {
                              $('#error').html('entered passwords do not match'); 
				return false;         
                        }
		    }
		}
	);
});
 
function sendAjaxForm(result_form, ajax_form, url) {
    $.ajax({
        url:      url,
        type:     "POST", 
        dataType: "html", 
        data: $("#"+ajax_form).serialize(), 
        success: function(response) { 
        	result = $.parseJSON(response);
		if (result.status == "OK")
		{
			window.alert(result.url);
			//window.location.href = result.url;
		}
        	else
		{
			$('#error').html(result.msg);
		}
    	},
    	error: function(response) { 
            $('#error').html('Ошибка. Данные не отправлены.');
    	}
 	});
}
