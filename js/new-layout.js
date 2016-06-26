$(document).ready(ready);
$(document).on('page:load', ready);

function ready() {
	// content pill switching
	$('.nav-justified li').click( function() {
		$('.nav-justified li').removeClass('active');
		$('.content-container [class*="content-"]').removeClass('active');
		var className = $(this).attr('class');
		$(this).addClass('active');
		$('.content-'+className).addClass('active');
	})

	$('.selectpicker').selectpicker({
		style: 'jumbo-box',
	});

	$('#nav-affix').affix({
		offset: {
			top: 60
		}
	});
	// map trigger
	$('.map.btn').on('click', function(){
		$('.map-wrapper').toggleClass('active');
	});
	$('.map-wrapper').on('touchstart', function(e){
		e.preventDefault();
	});

	// overlay trigger
	$('.overlay-wrapper').on('touchstart', function(e){
		e.stopPropagation();
	});

	$('.close-button').on('click', function(){
		$('.overlay-wrapper').removeClass('active');
	});
	$('.note-button').on('click', function(){
		$('.overlay-wrapper.important-note').addClass('active');
	});
	$('.return-condition-button').on('click', function(){
		$('.overlay-wrapper.return-condition').addClass('active');
	});
	$('#paypal').on('click', function(){
		$('#submit_customer').trigger('click');
	});

	$('.roundedOne').on('click', function(){
		$('label#roundedOne').toggleClass('active');
		var checkbox = document.getElementById('agree-term');
		checkbox.checked = !checkbox.checked;
		checkbox.value = checkbox.checked ? 'ON' : 'OFF';
	})
	// booking form
	$('.booking-input').on('blur', inputCheck);
	$('#booking-form').submit(function() {
		console.log( 'check', ['customer', 'contactemail', 'phone'].reduce( checkAll, true ) );
		return ['customer', 'contactemail', 'phone'].reduce( checkAll, true );
	});
};

var inputCheck = function(e) {
	$('.error-message.'+e.target.name).text( validate(e.target.name, e.target.value) );
}
var errorMessage = function(noError) {
	return noError ? '' : 'Invalid value'; 
}
var validate = function(type, input) {
	return errorMessage( formatCheck(type, input) );
}
var formatCheck = function(type, input) {
	var re;
	switch (type) {
		case 'customer':
			re = /\w*/gi
		break;
		case 'contactemail':
			re = /^[\w.+-]+@[\w]+?\.[a-zA-Z]{2,3}$/;
		break;
		case 'phone':
			re = /^[0-9]{8}$/;
		break;
		default:
			re = false;
		break;
	}
	console.log('type', type, 'check', 'value', input, re.test(input));
	return re.test(input);
}
var checkAll = function(init, type) {
	return init && formatCheck( type, $('#'+type).val() );
}






