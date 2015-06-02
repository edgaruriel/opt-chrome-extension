$(function(){
	getFeeds();
}); 
 
function getFeeds(){
	$.getJSON('http://localhost/chromeExtensionRss/start.php', function(data) {
			$.each(data, function(key, val) {
			var feedRss = '';
				feedRss += '<article><header>';
				feedRss += '<h1>';
				feedRss += '<a href="' + val.link + '" target="_blank">' + val.title + '</a>';
				feedRss += '</h1>';
				feedRss += '<p>Author: ' + val.author + '</p>';
				feedRss += '<p>Date: ' + val.date +'</p>';
				feedRss += '<p>' + val.description + '</p>';
				feedRss += '</header></article>';

			   $('#feed').append(feedRss);
			});
		});
}
 