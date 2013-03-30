$(document).ready(function() {
	enableKeyboard();
	getFeeds();
});

function enableKeyboard() {
	$('.media-body').jknavigable();
}

function getFeeds() {
	$.ajax({
		url: baseURL + '/users/get_feeds',
		success: function(msg) {
			if (msg == 0) {
				// query returned empty
			}
			else {
				$("#user_feeds").replaceWith(msg);
			}
		}
	});
}

