/**
 * @author Borko
 */
$(document).ready(function(){
	//validation of post title
	$('input#title').blur(function(event){
		$.post(
			'http://localhost/agdeima/posts/validate_form',
			{ 'data[field]': $(this).attr('id'), 'data[value]': $(this).val() },			
			handleTitleValidation
		);
	});
	
	function handleTitleValidation(error){
		if(error.length > 0){
			if($('#title-notEmpty').length === 0){
				$('input#title').after('<div id="title-notEmpty" class="error-message" style="display: none;">' + error + "</div>");
				$('#title-notEmpty').fadeIn('slow');
			} 
		} else {
			$('#title-notEmpty').remove();
		}
	}
	
	//validation of username
	$('input#username').blur(function(event){
		$.post(
			'http://localhost/agdeima/users/validate_form',
			{ 'data[field]': $(this).attr('id'), 'data[value]': $(this).val() },			
			handleUsernameValidation
		);
	});
	
	function handleUsernameValidation(error){
		if(error.length > 0){
			if($('#username-notEmpty').length === 0){
				$('input#username').after('<div id="username-notEmpty" class="error-message" style="display: none;">' + error + "</div>");
				$('#username-notEmpty').fadeIn('slow');
			} 
		} else {
			$('#username-notEmpty').remove();
		}
	}
	
	//validation of user email
	$('input#email').blur(function(event){
		$.post(
			'http://localhost/agdeima/users/validate_form',
			{ 'data[field]': $(this).attr('id'), 'data[value]': $(this).val() },			
			handleEmailValidation
		);
	});
	
	function handleEmailValidation(error){
		if(error.length > 0){
			if($('#email-valid').length === 0){
				$('input#email').after('<div id="email-valid" class="error-message" style="display: none;">' + error + "</div>");
				$('#email-valid').fadeIn('slow');
			} 
		} else {
			$('#email-valid').remove();
		}
	}		
});
