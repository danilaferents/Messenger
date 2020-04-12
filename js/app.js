$(document).ready(function () {
	var my_modal = $('#my-modal');
	$('#login-modal').bPopup();
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
});