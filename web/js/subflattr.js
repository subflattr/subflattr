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

	submitform.submit(function() {
		submitform.find('.error').addClass('hide');
	});

	submitform.ajaxForm(function(data) {
		if(!data.success) {

			if(data.status == 407)
				submitform.find('.error.noimage').removeClass('hide');
			if(data.status == 408)
				submitform.find('.error.supportimage').removeClass('hide');
			if(data.status == 406)
				submitform.find('.error.smallimage').removeClass('hide');
			if(data.status == 500)
				submitform.find('.error.badrequest').removeClass('hide');
			if(data.status == 501)
				submitform.find('.error.badrequesttext').text('Flattr responded with: ' + data.message).removeClass('hide');
			return;
		}

		window.location = '/';
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