<?php
if (empty($max_length)) {
	$max_length = 30;
}
if (empty($suffix)) {
	$suffix = '...';
}
if (empty($feeds)) {
	$feeds = array();
}
?>
<ul id="user_feeds" class="nav nav-list">
	<li class="nav-header">Feeds</li>
	<?php
		if (!empty($feeds)) {
			foreach ($feeds as $feed) {
				$feedTitle = (strlen($feed['Feed']['title']) > $max_length) ? substr($feed['Feed']['title'], 0, $max_length - strlen($suffix)) . $suffix : $feed['Feed']['title'];
				print "<li>";
				print $this->Html->link($feedTitle, '/feeds/view/' . $feed['Feed']['id'], array('title'=>$feed['Feed']['url']));
				print "</li>";
			}
		}
	?>

</ul>
