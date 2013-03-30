$(document).ready(function() {
	enableKeyboard();
	getFeeds();
});

/**
 * Enable keyboard navigation
 * 
 * 'j' and 'k' keys move up and down vi-style
 */
function enableKeyboard() {
	$('.media-body').jknavigable();
}

/**
 * Fetch the list of user feeds
 */
function getFeeds() {
	$.ajax({
		url: baseURL + '/users/get_feeds',
		success: function(msg) {
			$("#user_feeds").replaceWith(msg);
		}
	});
}

