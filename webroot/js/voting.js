/**
 * @author Borko
 */

$(document).ready(function(){
	$('div.voting a').click(function(event){
		var selector = $(this).attr('id');
		var id = parseInt(selector);
		
		if($(this).hasClass('voting-up-number')){
			$.get(
				'http://localhost/agdeima/comments/vote/up/' + id,
				false,
				updateVoteCount
			);
		} else {			
			$.get(
				'http://localhost/agdeima/comments/vote/down/' + id,
				false,
				updateVoteCount
			);			
		}
		function updateVoteCount(error){
			var num = parseInt(error);
			if(!isNaN(num)){
				$('a#'+selector).text(num);
			} else {
			alert(error);				
			}
		}
		event.preventDefault();
	});
});
