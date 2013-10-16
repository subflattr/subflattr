$(document).ready(function(){
	var profileform = $('#profileform');

	profileform.ajaxForm(function(data) {
		if(!data.success) {
			profileform.find('.error').removeClass('hide');
			profileform.find('.success').addClass('hide');
			return;
		}
		profileform.find('.error').addClass('hide');
		profileform.find('.success').removeClass('hide');
	});

	var submitform = $('#submitform');

	submitform.ajaxForm(function(data) {
		if(!data.success) {
			submitform.find('.error').removeClass('hide');
			submitform.find('.success').addClass('hide');
			return;
		}
		submitform.find('.error').addClass('hide');
		submitform.find('.success').removeClass('hide');
	});


	var subscribeForm = $('#subscribe');

	subscribeForm.submit(function(e) {
		e.preventDefault();

		$.ajax(subscribeForm.attr('action'),{
			method: 'POST',
			data: subscribeForm.serialize(),
			success: function(data) {
				console.log(data);
			}
		})
	});
});