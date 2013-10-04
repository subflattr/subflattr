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