<?php defined('PANEL_ACCESS') or die('No direct script access.'); ?>


	<ul class="breadcrumbs">
	  <li><a href="#"><i class="fa fa-home"></i></a></li>
	  <li class="unavailable"><a href="#">Images</a></li>
	  <li class="current"><a href="#">All Images</a></li>
	</ul>


<div class="row">
	<div class="small-12 mediun-12 large-12 columns">
	    <?php Morfy::factory()->runAction('Images'); ?>		
	</div>
</div>


<!-- lightModal -->
<div class="lightModal">
	<div class="lightModal-inner">
		<button class="lightModal-close" role="button">&times;</button>
		<h3 class="lightModal-title">&nbsp;</h3>
		<img class="lightModal-image" src="http://placehold.it/350x150" alt="Title here">
		<p><pre class="lightModal-code text-center"></pre></p>
	</div>
</div>
<!-- / lightModal -->
