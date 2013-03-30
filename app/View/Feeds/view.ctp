<?php
App::uses('CakeTime', 'Utility');
?>
<div class="row">
	<div class="span3">
		<?php echo $this->element('menu_side'); ?>
	</div>
	<div class="span9">
		<h3><?php echo $this->Html->link($feed['Feed']['title'], $feed['Feed']['link'], array('target' => '_blank')); ?></h3>
		<div class="media">
		<?php
			if (empty($posts)) {
				print "<div class='media-body'>There are no posts in this feed.</div>";
			}
			else {
				foreach ($posts as $post) {
					print "<div class='media-body'>";
					
					print "<h4 class='media-heading'>" . $this->Html->link($post['Post']['title'], $post['Post']['url'], array('target' => '_blank')) . "</h4>";
					if (!empty($post['Post']['author'])) {
						print "<p class='muted'>";
						print "By " . $post['Post']['author'];
						if (!empty($post['Post']['published'])) {
							print " on " . CakeTime::niceShort($post['Post']['published']);
						}
						print "</p>";
					}
					print $post['Post']['content'];
					
					print "</div>";
					print "<br />";
				}
			}
		?>
		</div>
	</div>
</div>
