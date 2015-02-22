<?php 
	defined('PANEL_ACCESS') or die('No direct script access.'); 
	$dir = Panel::Request_get('g');
?>

	<ul class="breadcrumbs">
	  <li><a href="#"><i class="fa fa-home"></i></a></li>
	  <li class="unavailable"><a href="#">Content</a></li>
	  <li class="current"><a href="#"><?php echo ucfirst($dir);?></a></li>
	</ul>

	<?php 
		Morfy::factory()->runAction('dp');
    	return Panel::ReadFolder('../content/'.$dir,'md');
	 ?>