// Take it easy, I'm a designer, not a developer. :)

// Setting some baseline variables
var quantityOfQuestions = $('.question').length;
var questionHeight = 200;
var stepHeight = ($('#form-wrap').height() - $('.completed').height()) / quantityOfQuestions;

// On page ready remove tabbability on future questions, set focus, set container height based on question height
$('input:not(:first), button:not(:first)').attr('tabindex', '-1');
$('.question:first input').focus();
$('.container').css({"height": questionHeight});

// Create question index "question 1 / 5"
$( '.question' ).each(function( index ) {
	$(this).append('<p>Прогресс: ' + (index + 1) + ' / ' + quantityOfQuestions + '</p>' )
});

// Alternative transition for Inputs when button is focused - create spillover effect
$("button").focus(function() {
  $(this).siblings('input').css({"background-position":"-1% 100%","transition-delay":"0"})
});

// Remove the alternative transition set above on button focusout
$("button").focusout(function() {
  $(this).siblings('input').css("background-position","")
});

// On button click do the following
$('.buttons').click(function() {
	
	//set variables in context of current & next question
	var currentQuestion = $(this).parent();
	var nextQuestion = $(this).parent().next('.question');
	var nextInput = $(nextQuestion).children('input');
	var nextButton = $(nextQuestion).children('button');

	//Move the question container down
	$('#form-wrap').css({"marginTop": '-=' + stepHeight});
	
	//Add animations to controls, and set tab index for next question
	$('input, button, h1, p').addClass('animation');
	$('input, button').attr('tabindex', '-1');
	$(nextInput).attr('tabindex', '1');
	$(nextButton).attr('tabindex', '2');
	$(currentQuestion).css({"opacity": '0'});
	$(nextQuestion).css({"opacity": '1'});
	
	//After animation, set focus and remove animations classes set above 
	setTimeout(function(){ 
		$(nextInput).focus();
		$('input, button, h1, p').removeClass('animation');
	}, 1100);
});