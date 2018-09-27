//jQuery to change navbar when scrolling and to add back-to-top button
//$('body').prepend('<a href="#" class="back-to-top">Back to Top</a>');

$(window).scroll(function() {
    if($(this).scrollTop() > 300) {
        $('div.navbar').removeClass('navbar-default').addClass('navbar-inverse');
        $('a.home__container__btt-btn').fadeIn();
    } else {
        $('div.navbar').removeClass('navbar-inverse').addClass('navbar-default');
        $('a.home__container__btt-btn').fadeOut(200);
    }
});


// Animate the back-to-top button
$('a.home__container__btt-btn').click(function() {
	$('html, body').animate({
		scrollTop: 0
	}, 200);
	return false;
});

//jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1200, 'easeInOutExpo');
        event.preventDefault();
    });
});

    


//Slow Fade out of content
$(document).ready(function() {
    $(window).scroll( function(){
        $('.hideme').each( function(i){
            // var bottom_of_object = $(this).offset().top + $(this).outerHeight();
            var top_of_object = $(this).offset().top;
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            if( bottom_of_window > top_of_object ){
                $(this).addClass('showme');
            }
            if( bottom_of_window < top_of_object ){
                $(this).removeClass('showme');
            }
        });
    });
});