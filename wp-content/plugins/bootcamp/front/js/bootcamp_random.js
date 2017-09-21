(function(exports, $ ) {
	var app = (function() {

		var randomQuote = function() {
			$.getJSON( bootcampBaseUrl +'/quote/random', function(result) {
				var html = 'Famous quote by <a href="/bootcamp-author-details?author_id=' + result['author']['id'] + '">';
				html += '<strong>' + result['author']['firstName'] + ' ' + result['author']['lastName'] + '</strong></a>';
				html += '<br />' + result['content'];
				var $quote = $('<div />', {
					html: html
				});
				$('footer .wrap').append($quote);
			});
		}

		var init = function(){
            randomQuote();
        };

        return {
            init: init
        };
    }());

	app.init();

}(window, jQuery));