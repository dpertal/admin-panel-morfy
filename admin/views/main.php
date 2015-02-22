<?php defined('PANEL_ACCESS') or die('No direct script access.'); ?>

	<ul class="breadcrumbs">
	  <li><a href="#"><i class="fa fa-home"></i></a></li>
	  <li class="unavailable"><a href="#">Content</a></li>
	  <li class="current"><a href="#">Pages</a></li>
	  <li class="pull-right"><a href="#" onclick="return makeFolder('Please enter the name of folder')">New Folder</a></li>
	</ul>

	<?php Morfy::factory()->runAction('Pages'); ?>