jQuery(document).ready(function ($) {
    //make section height of window
	$(function(){
		$('#intro').css({'height':($(window).height())+'px'});
		$(window).resize(function(){
		$('#intro').css({'height':($(window).height())+'px'});
		});
	});

    $('.nav a').click(function() {
        $(".nav-collapse").collapse("hide")
    });
});