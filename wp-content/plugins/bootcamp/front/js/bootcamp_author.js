(function(exports, $ ) {
	var app = (function() {
		var $article = $('#main article .entry-content');
		var getDetails = function() {
			var authorId = location.search.split('author_id=')[1];
			if (!authorId) return;

			$.getJSON( bootcampBaseUrl +'/author/' + authorId + '/quotes', function(result) {
				
				$intro = $('<h2 />', {
					text: 'Author Quotes'
				});

				$author = $('<h3 />', {
					text: result['firstName'] + ' ' + result['lastName']
				});

				$article.append($intro);
				$article.append($author);

				for (var i = result['quotes'].length - 1; i >= 0; i--) {
					$quote = $('<p />', {
						text: result['quotes'][i]['content']
					});
					$article.append($quote);
				}
			});
		}

		var init = function(){
            getDetails();
        };

        return {
            init: init
        };
    }());

	app.init();

}(window, jQuery));