(function(exports, $ ) {
	var app = (function() {

		var randomQuote = function() {
			$.getJSON( bootcampBaseUrl +'/quote/random', function(result) {
				var $quote = $('<div />', {
					html: 'Famous quote by <a href="/bootcamp-author-details?author_id=' + result['author']['id'] + '"><strong>' + result['author']['firstName'] + ' ' + result['author']['lastName'] + '</strong></a> - ' + result['content']
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