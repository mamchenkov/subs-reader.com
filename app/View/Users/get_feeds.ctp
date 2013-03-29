<ul id="user_feeds" class="nav nav-list">
	<li class="nav-header">Feeds</li>
	<?php
		$max_length = 30;
		$suffix = '...';
		
		if (!empty($feeds)) {
			foreach ($feeds as $feed) {
				$feedTitle = (strlen($feed['Feed']['title']) > $max_length) ? substr($feed['Feed']['title'], 0, $max_length - strlen($suffix)) . $suffix : $feed['Feed']['title'];
				print "<li><a title='" . $feed['Feed']['title'] . "' href='#'>" . $feedTitle . "</a></li>";
			}
		}
	?>
</ul>

